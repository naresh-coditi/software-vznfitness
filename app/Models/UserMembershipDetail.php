<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserMembershipDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'remaining_amount',
        'start_date',
        'end_date',
        'notes',
        'interest_status'
    ];

    const INTERESTED = 1;
    const NOT_INTERESTED = 2;


    // Scope
    public function scopeFilter($query, Request $request)
    {
        $query->when($request->search ?? false, function ($query, $search) {
            $query->orwhere('amount', 'LIKE', '%' . $search . '%')
                ->orwhereHas('user', function ($query) use ($search) {
                    $query->where('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('member_id', 'LIKE', '%' . $search . '%')
                        ->orwhereHas('userProfile', function ($query) use ($search) {
                            $query->where('first_name', 'LIKE', '%' . $search . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                        });
                });
        });
    }

    public function scopeLatestPlan($query)
    {
        return $query->from('user_membership_details')
            ->select('user_id', DB::raw('MAX(created_at) as latest_plan_date'))
            ->groupBy('user_id');
    }

    public function scopeNotDeletedMembers($query)
    {
        return $query->from('users')->where('role_id', User::User)->whereNull('deleted_at');
    }

    public function scopePlanExpiringsoon($query)
    {
        return $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
            $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
        })
            ->whereBetween('end_date', [now()->format('Y-m-d'), now()->addDays(15)->format('Y-m-d')])
            ->orderBy('end_date')
            ->distinct() // Add this line
            ->with(['user', 'userProfile'])
            ->select('user_membership_details.*');
    }

    public function scopeExpiredPlan($query)
    {
        $query->joinSub($this->notDeletedMembers(), 'users_plans', function ($join) {
            $join->on('users_plans.id', '=', 'user_membership_details.user_id')
                ->where('users_plans.role_id', User::User)
                ->whereNull('users_plans.deleted_at');
        })->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
            $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
        })
            ->where('end_date', '<', now())
            ->latest()
            ->with(['user', 'userProfile']);
    }
    public function scopeExpiredPlanWithOrderByCondition($query, $id)
    {
        switch ($id) {
            case 1:
                $data = $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->where('end_date', '<', now())
                    // ->join('users', 'users.id', '=', 'user_membership_details.user_id') // Ensure to join 'users' to use 'userProfile'
                    ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'user_membership_details.user_id') // Join user_profiles table
                    ->orderBy('user_profiles.first_name') // Sort by user_profiles fields
                    ->orderBy('user_profiles.last_name')  // Sort by user_profiles fields
                    ->with('user')
                    ->select('user_membership_details.*', 'user_profiles.first_name', 'user_profiles.last_name') // Adjust fields as needed
                    ->get(); // Retrieve the results

                break;
            case 2:
                $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->where('end_date', '<', now())
                    ->orderBy('remaining_amount', 'desc')
                    ->latest()
                    ->with(['user', 'userProfile']);
                break;
            case 3:
                $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->where('end_date', '<', now())
                    ->orderBy('end_date')
                    ->latest()
                    ->with(['user', 'userProfile']);

                break;
            case 4:
                $data = $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->where('user_membership_details.end_date', '<', now())
                    ->join('user_notes', 'user_notes.user_id', '=', 'user_membership_details.user_id')
                    ->where('user_notes.note_type', UserNote::EXPIREDPLANNOTE)
                    ->whereIn('user_notes.next_follow_up_date', function ($query) {
                        $query->select(DB::raw('MAX(next_follow_up_date)'))
                            ->from('user_notes')
                            ->where('note_type', UserNote::EXPIREDPLANNOTE)
                            ->groupBy('user_id');
                    })
                    ->whereNotNull('user_notes.next_follow_up_date') // Ensure next_follow_up_date is not null
                    ->orderBy('user_notes.next_follow_up_date', 'asc')
                    ->with(['userProfile', 'user'])
                    ->select(
                        'user_membership_details.*',
                        'user_notes.next_follow_up_date'
                    );
                break;
            default:
                $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->where('end_date', '<', now())
                    ->latest()
                    ->with(['user', 'userProfile']);
                break;
        }
    }
    public function scopePlanExpiringsoonWithOrderByCondition($query, $id)
    {
        switch ($id) {
            case 1:
                $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->join('users', 'users.id', '=', 'user_membership_details.user_id')
                    ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id') // Add join to user_profiles table
                    ->whereBetween('end_date', [now()->format('Y-m-d'), now()->addDays(15)->format('Y-m-d')])
                    ->orderBy('user_profiles.first_name') // Order by first_name
                    ->orderBy('user_profiles.last_name') // Order by last_name
                    ->with(['user', 'userProfile'])
                    ->select('user_membership_details.*');
                break;
            case 2:
                $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->orderBy('remaining_amount', 'desc')
                    ->whereBetween('end_date', [now()->format('Y-m-d'), now()->addDays(15)->format('Y-m-d')])
                    ->with(['user', 'userProfile'])
                    ->select('user_membership_details.*');
                break;
            case 3:
                $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->orderBy('end_date')
                    ->whereBetween('end_date', [now()->format('Y-m-d'), now()->addDays(15)->format('Y-m-d')])
                    ->with(['user', 'userProfile'])
                    ->select('user_membership_details.*');
                break;
            case 4:
                $latestDate = DB::table('user_notes')
                    ->select('user_id', DB::raw('MAX(next_follow_up_date) as next_follow_up_date'))
                    ->where('note_type', UserNote::UPCOMINGRENEWALNOTE)
                    ->groupBy('user_id')
                    ->orderBy('next_follow_up_date');

                return $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    //if want only user who have next follow up date and ignore null value then replace leftJoinSub with joinSub
                    ->leftJoinSub($latestDate, 'latest_user_notes_date', function ($join) {
                        $join->on('latest_user_notes_date.user_id', '=', 'user_membership_details.user_id');
                    })
                    ->whereBetween('user_membership_details.end_date', [now()->format('Y-m-d'), now()->addDays(15)->format('Y-m-d')])
                    ->with(['userProfile', 'user'])
                    ->select('user_membership_details.*', 'latest_user_notes_date.next_follow_up_date')
                    ->orderByDesc('latest_user_notes_date.next_follow_up_date');
                break;

            default:
                return $query->joinSub($this->latestPlan(), 'latest_plans', function ($join) {
                    $join->on('user_membership_details.user_id', '=', 'latest_plans.user_id')
                        ->on('user_membership_details.created_at', '=', 'latest_plans.latest_plan_date');
                })
                    ->whereBetween('end_date', [now()->format('Y-m-d'), now()->addDays(15)->format('Y-m-d')])
                    ->orderBy('end_date')
                    ->distinct() // Add this line
                    ->with(['user', 'userProfile'])
                    ->select('user_membership_details.*');
        }
    }

    public function scopePendingRemainingBalance($query)
    {
        $query->where('remaining_amount', '!=', '0.00');
    }
    public function scopeIsPlanExpired($query)
    {
        $query->where('end_date', '<', today());
    }

    public function isPlanExpired(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (Carbon::parse($this->end_date)->format('Y-m-d') < today()->format('Y-m-d')) {
                    return true;
                }
                return false;
            }
        );
    }

    public function totalAmount(): Attribute
    {
        return Attribute::make(
            get: function () {
                return 'Rs ' . $this->amount + $this->remaining_amount . '.00';
            }
        );
    }

    public function invoiceNumber(): Attribute
    {
        return Attribute::make(
            get: function () {
                $memberId = $this->user->member_id;
                $planId = $this->id;
                $invoiceNumber = $memberId . '/' . $planId;

                return $invoiceNumber;
            }
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with(['upcomingRenewalNotes', 'expiredPlanNotes'])->withTrashed()->withDefault();
    }
    public function NonDeletedUser()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function userProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'user_id', 'id')->withTrashed()->withDefault();
    }
}
