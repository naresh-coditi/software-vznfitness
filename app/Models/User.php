<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\LiabilityRange;
use App\Enum\UserRoleEnum;
use App\Enum\UserType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

use function PHPUnit\Framework\returnArgument;
use function Symfony\Component\String\b;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const Admin = 1;
    const Staff = 2;
    const User = 3;
    const Trainer = 4;

    const EXIT_STATUS_TRUE = 1;
    const EXIT_STATUS_FALSE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'user_type',
        'branch_id',
        'role_id',
        'phone',
        'member_id',
        'exit_status',
    ];

    protected $table = "users";
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['liability', 'packageAmount'];

    /***************************** Accessor **************************/
    public function getLiabilityAttribute()
    {
        // Logic to calculate liability
        return $this->liabilityData()['liability'];
    }

    // Accessor for package amount
    public function getPackageAmountAttribute()
    {
        // Logic to calculate package amount
        return $this->liabilityData()['packageAmount'];
    }

    /***************************** Scopes **************************/
    public function scopeIsNotAdmin($query)
    {
        return $query->where('role_id', self::Admin);
    }

    public function scopeIsNotStaff($query)
    {
        return $query->where('role_id', self::Staff);
    }
    public function scopeIsNotUser($query)
    {
        return $query->where('role_id', '!=', $this::User);
    }

    public function scopeIsStaff($query)
    {
        return $query->whereNotIn('role_id', [$this::User, $this::Admin, $this::Trainer]);
    }

    public function scopeIsUser($query)
    {
        return $query->where('role_id', $this::User);
    }

    public function scopeExpiredPlan($query)
    {
        return $query;
    }

    public function scopeFilter($query, Request $request)
    {
        if (!empty($request->all())) {
            if ($request->search) {
                $query->when($request->search ?? false, function ($query, $search) {
                    $query->where('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('member_id', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('userProfile', function ($query) use ($search) {
                            $query->where('first_name', 'LIKE', '%' . $search . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                        });
                });
            }
        }
        return $query;
    }

    public function scopeUnifiedFilter($query, Request $request)
    {
        if (!empty($request->all())) {
            if ($request->search) {
                $query->when($request->search ?? false, function ($query, $search) {
                    $query->filterByName($search)
                        ->orWhereHas('userProfile', function ($query) use ($search) {
                            $query->filterUserProfile($search);
                        });
                });
            }
        }
        return $query;
    }

    public function scopeFilterByName($query, $search)
    {
        return $query->where('phone', 'LIKE', '%' . $search . '%')
            ->orWhere('member_id', 'LIKE', '%' . $search . '%');
    }

    public function scopeLiability($query)
    {
        $query->with('userProfile', 'membershipDetails')
            ->isUser()
            ->filter(request())
            ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
            ->where('user_membership_details.end_date', '>=', today())
            ->select('users.*', 'user_membership_details.start_date', 'user_membership_details.end_date', 'user_membership_details.name', 'user_membership_details.amount', 'user_membership_details.remaining_amount')->distinct('user_membership_details.user_id')
            ->orderBy('id', 'desc');
    }
    public function scopeActiveMemberCount($query)
    {
        return  $query->whereHas('membershipDetails', function ($query) {
            $query->where('end_date', '>=', today());
        })->with('userProfile')->get()
            ->filter(fn($member) => $member->userProfile)
            ->groupBy(fn($member) => $member->userProfile->gender)
            ->map(fn($group) => $group->count());
    }

    public function scopeMonthMembershipCount($query)
    {
        $durations = [
            '1 month' => ['1 month (gym)', '1 month (gym+Cardio)'],
            '3 months' => ['3 months (gym)', '3 months (gym+Cardio)'],
            '6 months' => ['6 months (gym)', '6 months (gym+Cardio)'],
            '12 months' => ['12 months (gym)', '12 months (gym+Cardio)'],
        ];

        return collect($durations)->map(function ($names) use ($query) {
            return (clone $query)->whereHas('membershipDetails', function ($query) use ($names) {
                $query->where('end_date', '>=', today())
                    ->whereIn('name', $names);
            })->count();
        })->values()->toArray();
    }

    public function scopeIndexArrangedData($query, $id)
    {
        switch ($id) {
            case 1:
                $query->with('userProfile', 'membershipDetails', 'createdBy', 'personalTrainer', 'memberNotes')
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->orderBy('remaining_amount', 'desc')
                    ->where('remaining_amount', '!=', '0.00')->where('user_membership_details.end_date', '>=', today())
                    ->select('users.*', 'user_membership_details.start_date', 'user_membership_details.end_date', 'user_membership_details.name', 'user_membership_details.amount', 'user_membership_details.remaining_amount');
                break;
            case 2:
                $planOrders = MembershipPlan::orderBy('validity')->pluck('name')->toArray();
                // $planOrders = array_reverse($planOrders);
                $caseStatement = '';
                foreach ($planOrders as $index => $planName) {
                    $caseStatement .= "WHEN user_membership_details.name = '{$planName}' THEN {$index} ";
                }
                $query->with('userProfile', 'membershipDetails', 'createdBy', 'personalTrainer', 'memberNotes')
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->whereIn('user_membership_details.end_date', function ($query) {
                        $query->select(DB::raw('MAX(end_date)'))
                            ->from('user_membership_details as umd')
                            ->whereColumn('umd.user_id', 'users.id');
                    })
                    ->where('user_membership_details.end_date', '>=', today())
                    ->orderByRaw("CASE {$caseStatement} ELSE {$index} END") // Add custom ordering
                    ->select(
                        'users.*',
                        'user_membership_details.start_date',
                        'user_membership_details.end_date',
                        'user_membership_details.name',
                        'user_membership_details.amount',
                        'user_membership_details.remaining_amount'
                    );

                break;
            case 3:
                $query->with('userProfile', 'membershipDetails', 'createdBy', 'personalTrainer', 'memberNotes')
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->whereIn('user_membership_details.end_date', function ($query) {
                        $query->select(DB::raw('MAX(end_date)'))
                            ->from('user_membership_details as umd')
                            ->whereColumn('umd.user_id', 'users.id');
                    })
                    ->orderBy('user_membership_details.end_date')
                    ->select('users.*', 'user_membership_details.start_date', 'user_membership_details.end_date', 'user_membership_details.name', 'user_membership_details.amount', 'user_membership_details.remaining_amount');
                break;
            // Nested dropdown for order by particular membership plan
            case 4:
                $mp = request('mp');
                $planOrders = MembershipPlan::orderBy('validity')->pluck('name')->toArray();
                $caseStatement = '';
                foreach ($planOrders as $index => $planName) {
                    $caseStatement .= "WHEN user_membership_details.name = '{$planName}' THEN {$index} ";
                }
                $query->with('userProfile', 'membershipDetails', 'createdBy', 'personalTrainer', 'memberNotes')
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->where('user_membership_details.name', $mp)
                    ->whereIn('user_membership_details.end_date', function ($query) {
                        $query->select(DB::raw('MAX(end_date)'))
                            ->from('user_membership_details as umd')
                            ->whereColumn('umd.user_id', 'users.id');
                    })
                    ->where('user_membership_details.end_date', '>=', today())
                    ->orderByRaw("CASE {$caseStatement} ELSE {$index} END") // Add custom ordering
                    ->select(
                        'users.*',
                        'user_membership_details.start_date',
                        'user_membership_details.end_date',
                        'user_membership_details.name',
                        'user_membership_details.amount',
                        'user_membership_details.remaining_amount'
                    );
                break;
            default:
                $query->with('userProfile', 'membershipDetails', 'createdBy', 'personalTrainer', 'memberNotes')
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->where('user_membership_details.end_date', '>=', today())
                    ->select('users.*', 'user_membership_details.start_date', 'user_membership_details.end_date', 'user_membership_details.name', 'user_membership_details.amount', 'user_membership_details.remaining_amount')->distinct('user_membership_details.user_id')
                    ->orderBy('id', 'desc');
                break;
        }
    }

    public function scopeRemainingBalanceIndexOrderByData($query, $id)
    {
        switch ($id) {
            case 1:
                $query->with(['createdBy', 'personalTrainer', 'remainingBalanceNotes'])
                    ->with('userProfile')
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->where('remaining_amount', '!=', '0.00')
                    ->leftJoin('user_notes', function ($join) {
                        $join->on('user_notes.user_id', '=', 'users.id')
                            ->on('user_notes.created_at', '=', DB::raw('(SELECT MAX(created_at) FROM user_notes WHERE user_notes.user_id = users.id AND user_notes.note_type = ' . UserNote::REMIANINGBALANCE . ')'));
                    })
                    ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                    ->orderBy('user_profiles.first_name')
                    ->orderBy('user_profiles.last_name')
                    ->select(
                        'users.*',
                        'user_membership_details.start_date',
                        'user_membership_details.end_date',
                        'user_membership_details.name',
                        'user_membership_details.amount',
                        'user_membership_details.remaining_amount',
                        'user_notes.next_follow_up_date'
                    );
                break;
            case 2:
                $query->with(['createdBy', 'personalTrainer', 'remainingBalanceNotes'])
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->orderBy('user_membership_details.remaining_amount', 'desc')
                    ->where('remaining_amount', '!=', '0.00')
                    ->leftJoin('user_notes', function ($join) {
                        $join->on('user_notes.user_id', '=', 'users.id')
                            ->on('user_notes.created_at', '=', DB::raw('(SELECT MAX(created_at) FROM user_notes WHERE user_notes.user_id = users.id AND user_notes.note_type = ' . UserNote::REMIANINGBALANCE . ')'));
                    })
                    ->select('users.*', 'user_membership_details.start_date', 'user_membership_details.end_date', 'user_membership_details.name', 'user_membership_details.amount', 'user_membership_details.remaining_amount', 'user_notes.next_follow_up_date');
                break;
            case 3:
                $query->with(['createdBy', 'personalTrainer', 'remainingBalanceNotes'])
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->orderBy('user_membership_details.end_date')
                    ->Where('user_membership_details.end_date', '>=', today())
                    ->where('remaining_amount', '!=', '0.00')
                    ->leftJoin('user_notes', function ($join) {
                        $join->on('user_notes.user_id', '=', 'users.id')
                            ->on('user_notes.created_at', '=', DB::raw('(SELECT MAX(created_at) FROM user_notes WHERE user_notes.user_id = users.id AND user_notes.note_type = ' . UserNote::REMIANINGBALANCE . ')'));
                    })
                    ->select('users.*', 'user_membership_details.start_date', 'user_membership_details.end_date', 'user_membership_details.name', 'user_membership_details.amount', 'user_membership_details.remaining_amount', 'user_notes.next_follow_up_date');
                break;
            case 4:
                $query->with(['createdBy', 'personalTrainer', 'userProfile', 'remainingBalanceNotes'])
                    // ->whereHas('remainingBalanceNotes', function ($query) {
                    //     $query->whereNotNull('next_follow_up_date');
                    // })
                    ->isUser()
                    ->filter(request())
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->where('user_membership_details.remaining_amount', '!=', '0.00')
                    ->leftJoin('user_notes', 'user_notes.user_id', '=', 'users.id')
                    // ->whereNotNull('user_notes.next_follow_up_date')
                    // ->where('user_notes.note_type', UserNote::REMIANINGBALANCE) // Filter directly in the main query
                    ->whereIn('user_notes.next_follow_up_date', function ($query) {
                        $query->select(DB::raw('MAX(next_follow_up_date)'))
                            ->from('user_notes as umd')
                            ->where('umd.note_type', UserNote::REMIANINGBALANCE) // Filter by note_type in the subquery
                            ->whereColumn('umd.user_id', 'users.id');
                    })
                    ->orderBy('user_notes.next_follow_up_date')
                    ->select(
                        'users.*',
                        'user_membership_details.start_date',
                        'user_membership_details.end_date',
                        'user_membership_details.name',
                        'user_membership_details.amount',
                        'user_membership_details.remaining_amount',
                        'user_notes.next_follow_up_date'
                    );
                break;
            default:
                $query->with(['userProfile', 'createdBy', 'personalTrainer', 'remainingBalanceNotes'])
                    ->isUser()
                    ->filter(request())
                    // ->whereHas('membershipDetails', function ($query) {
                    //     $query->pendingRemainingBalance();
                    // })
                    ->leftJoin('user_membership_details', 'users.id', '=', 'user_membership_details.user_id')
                    ->orderBy('user_membership_details.start_date', 'asc')
                    ->where('remaining_amount', '!=', '0.00')
                    ->leftJoin('user_notes', function ($join) {
                        $join->on('user_notes.user_id', '=', 'users.id')
                            ->on('user_notes.created_at', '=', DB::raw('(SELECT MAX(created_at) FROM user_notes WHERE user_notes.user_id = users.id AND user_notes.note_type = ' . UserNote::REMIANINGBALANCE . ')'));
                    })
                    ->select(
                        'users.*',
                        'user_membership_details.start_date',
                        'user_membership_details.end_date',
                        'user_membership_details.name',
                        'user_membership_details.amount',
                        'user_membership_details.remaining_amount',
                        'user_notes.next_follow_up_date'
                    );
                break;
        }
    }

    // Attributes
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? ucfirst($value) : null,
            set: fn($value) => $value ? strtolower($value) : null,
        );
    }


    public function liabilityData()
    {
        $plan = MembershipPlan::where('name', $this->membershipDetails->name)->first();

        // Check if the plan exists to avoid errors
        if (!$plan) {
            return ['liability' => 0, 'packageAmount' => 0]; // or handle as needed
        }

        // Calculate months based on plan validity
        $months = $plan->validity >= 30 ? round($plan->validity / 30) : 1;

        // Calculate package amount
        $packageAmount = $this->membershipDetails->amount + $this->membershipDetails->remaining_amount;

        // Calculate liability
        $liability = round($packageAmount / $months);

        return ['liability' => $liability, 'packageAmount' => $packageAmount];
    }

    public static function filterByLiabilityRange()
    {
        $lr = request('lr');
        $range = LiabilityRange::getLiabilityRange();

        if ($lr && isset($range[$lr])) {
            $minMax = parseLiabilityRange($range[$lr]);
            $min = $minMax['min'];
            $max = $minMax['max'];

            return self::liability()
                ->get()
                ->filter(function ($user) use ($min, $max) {
                    return $user->liability > $min && ($max === null || $user->liability < $max);
                })
                ->sortBy('liability')
                ->values();
        }

        // Return all data if no filter is applied
        return self::liability()->get()->sortBy('liability')->values();
    }


    protected function userRoleType(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->role->id == $this::Admin) {
                    return [
                        'label' => UserRoleEnum::ADMIN['name'],
                        'color' => UserRoleEnum::ADMIN['color']
                    ];
                } elseif ($this->role->id == $this::Staff) {
                    return [
                        'label' => UserRoleEnum::STAFF['name'],
                        'color' => UserRoleEnum::STAFF['color']
                    ];
                } elseif ($this->role->id == $this::User) {
                    foreach (UserType::getUserType() as $type) {
                        if ($this->userProfile->user_type == $type['value']) {
                            return [
                                'label' => $type['name'],
                                'color' => $type['color']
                            ];
                        }
                    }
                    return '';
                }
            }
        );
    }

    // Return role of the user
    protected function roleName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->role->id === $this::Admin) {
                    return 'admin.';
                } elseif ($this->role->id === $this::User) {
                    return 'user.';
                } elseif ($this->role->id === $this::Trainer) {
                    return 'trainer.';
                } else {
                    return 'staff.';
                }
            }
        );
    }

    protected function liabilityArr()
    {
        $ranges = [
            'range1' => [500, 1000],
            'range2' => [1000, 1200],
            'range3' => [1200, 1500],
            'range4' => [1500, 1800],
            'range5' => [1800, 2000],
            'range6' => [2000, null],
        ];

        $liabilities = User::liability()->get()->map(function ($user) {
            return $user->liabilityData()['liability'];
        });

        return collect($ranges)->mapWithKeys(function ($range, $key) use ($liabilities) {
            [$min, $max] = $range;
            $count = $liabilities->filter(function ($liability) use ($min, $max) {
                return $liability >= $min && ($max === null || $liability < $max);
            })->count();
            return [$key => $count];
        })->toArray();
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->role->id == $this::Admin) {
                    return true;
                }
                return false;
            }
        );
    }

    protected function isUser(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->role->id == $this::User) {
                    return true;
                }
                return false;
            }
        );
    }

    //  Latest Plan
    protected function latestPlan(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->membershipDetails;
            }
        );
    }

    protected function isStaffOrNot(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->role->id != $this::Admin && $this->role->id != $this::User) {
                    return true;
                }
                return false;
            }
        );
    }

    public function getUserType(): Attribute
    {
        return Attribute::make(function () {
            if ($this->userProfile->user_type == UserType::LEAD['value']) {
                return true;
            }
            return false;
        });
    }

    // Get Branch id
    public function getBranchId(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->branch_id) {
                    return $this->branch->branch_id;
                }
                return '';
            }
        );
    }

    // Get Total amount
    public function totalAmountPaid(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->transactions->pluck('amount')->sum() . '.00' ?? '0.00';
            }
        );
    }

    /***************************** Relations **************************/
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault();
    }

    // public function userProfile()
    // {
    //     return $this->hasOne(UserProfile::class, 'user_id')->withTrashed()->withDefault();
    // }
    public function userProfile()
    {
        //with trashed is added for deleted member profiles to be shown
        return $this->hasOne(UserProfile::class)->withTrashed()->withDefault();
    }
    public function assignedProfile()
    {
        return $this->hasOne(UserProfile::class, 'user_id')->withDefault();
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'imageable')->withDefault();
    }

    public function membershipDetails()
    {
        return $this->hasOne(UserMembershipDetail::class, 'user_id')->withDefault()->orderBy('id', 'desc');
    }

    public function membershipPlans()
    {
        return $this->hasMany(UserMembershipDetail::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }
    public function countTransaction()
    {
        return $this->hasMany(Transaction::class, 'user_id')->count();
    }
    public function latestTransactions()
    {
        return $this->hasMany(Transaction::class, 'user_id')->latest();
    }

    public function createdBy()
    {
        return $this->hasOneThrough(User::class, UserProfile::class, 'user_id', 'id', 'id', 'created_by')->withTrashedParents()->withDefault()->with('userProfile');
    }

    public function personalTrainer()
    {
        return $this->hasOne(PersonalTrainer::class, 'member_id')->where('end_date', '>', today()->format('Y-m-d'));
    }

    public function latestPersonalTrainerPlan()
    {
        return $this->hasOne(PersonalTrainer::class, 'member_id')->latest();
    }

    public function personalTrainerPlans()
    {
        return $this->hasMany(PersonalTrainer::class, 'member_id');
    }


    public function memberNotes()
    {
        return $this->hasMany(UserNote::class, 'user_id')->where('note_type', UserNote::MEMBERNOTE)->with(['createdBy']);
    }

    public function upcomingRenewalNotes()
    {
        return $this->hasMany(UserNote::class, 'user_id')->where('note_type', UserNote::UPCOMINGRENEWALNOTE)->with(['createdBy'])->latest();
    }
    public function allNotes()
    {
        return $this->hasMany(UserNote::class, 'user_id')->whereIn('note_type', [UserNote::MEMBERNOTE, UserNote::UPCOMINGRENEWALNOTE, UserNote::REMIANINGBALANCE, UserNote::EXPIREDPLANNOTE])->with(['createdBy'])->latest();
    }

    public function expiredPlanNotes()
    {
        return $this->hasMany(UserNote::class, 'user_id')->where('note_type', UserNote::EXPIREDPLANNOTE)->with(['createdBy'])->latest();
    }
    public function remainingBalanceNotes()
    {
        return $this->hasMany(UserNote::class, 'user_id')->where('note_type', UserNote::REMIANINGBALANCE)->with(['createdBy'])->latest();
    }
    public function personalTrainerNotes()
    {
        return $this->hasMany(UserNote::class, 'user_id')->where('note_type', UserNote::PERSONALTRAINERNOTES)->with(['createdBy']);
    }
    public function nextFollowUpDate()
    {
        return $this->hasMany(UserNote::class, 'user_id')->where('note_type', UserNote::UPCOMINGRENEWALNOTE)->with(['createdBy'])->latest('created_at')->first();
    }
    public function checkAttendance(){
        return $this->hasMany(Attendance::class, 'member_id');
    }
}
