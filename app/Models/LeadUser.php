<?php

namespace App\Models;

use App\Enum\LeadSource;
use App\Enum\LeadStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LeadUser extends Model
{
    const INACTIVE = 0;
    const ACTIVE = 1;

    // Approach Status

    const Pending = 0;
    const Done = 1;
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'gender',
        'membership_interested',
        'note',
        'created_by',
        'updated_by',
        'status',
        'follow_up_date',
        'amount_offer',
        'assigned_to',
        'source',
        'approach_status'
    ];

    // scope
    public function scopeFilter($query, $request)
    {
        $query->when(
            $request->search ?? false,
            fn($query, $search) =>
            $query->where('phone', 'LIKE', '%' . $search . '%')
                ->orwhere('id', 'LIKE', '%' . $search . '%')
                ->orwhere('first_name', 'LIKE', '%' . $search . '%')
                ->orwhere('last_name', 'LIKE', '%' . $search . '%')
        );

        return $query;
    }

    public function scopeUnifiedFilter($query, $request)
    {
        $query->when(
            $request->search ?? false,
            fn($query, $search) =>
            $query->where('id', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->FilterByName($search)
        );

        return $query;
    }
    public function scopeFilterByName($query, $request)
    {
        $query->when(
            $request->search ?? false,
            fn($query, $search) =>
            $query->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
        );

        return $query;
    }
    public function scopeFollowUpLead($query)
    {
        $query->whereBetween('follow_up_date', [Carbon::today()->format('y-m-d'), Carbon::today()->addDay()->format('y-m-d')])->orderBy('created_at','desc');
    }

    public function scopeFollowUpLeadToday($query)
    {
        $query->where('follow_up_date', '=', Carbon::today()->format('y-m-d'));
    }

    // Attributes
    public function getStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->status === LeadStatus::OPEN['value']) {

                    return LeadStatus::OPEN;
                } elseif ($this->status === LeadStatus::CLOSED['value']) {

                    return LeadStatus::CLOSED;
                }
            }
        );
    }

    public function getSource(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->source) {
                    case LeadSource::WALKIN['id']:
                        return LeadSource::WALKIN['name'];
                        break;
                    case LeadSource::REFRENCE['id']:
                        return LeadSource::REFRENCE['name'];
                        break;
                    case LeadSource::PHONECALL['id']:
                        return LeadSource::PHONECALL['name'];
                        break;
                    case LeadSource::SOCIALMEDIA['id']:
                        return LeadSource::SOCIALMEDIA['name'];
                        break;
                    default:
                        return '';
                        break;
                }
            }
        );
    }

    public function amountOffered(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->amount_offer . '.00';
            }
        );
    }

    // relations
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to')->withDefault();
    }

    public function notes()
    {
        return $this->hasMany(LeadNotes::class, 'lead_id')->with('createdBy')->orderBy('created_at','desc');
    }
    public function previousFollowUpDate()
    {
        return $this->hasMany(LeadNotes::class, 'lead_id')->latest('created_at')->skip(1)->first();
    }

    public function createdByProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'created_by', 'id')->withDefault();
    }
    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'imageable')->withDefault();
    }
    
}
