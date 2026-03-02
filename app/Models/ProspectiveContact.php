<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProspectiveContact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lead_id',
        'user_id',
        'contact_type',
        'notes',
    ];

    public const CONTACT_TYPES = [
        'email' => 'Email',
        'phone_call' => 'Phone Call',
        'facebook' => 'Facebook',
        'in_person_flyer' => 'In-Person Flyer',
        'sms_message' => 'SMS Message',
        'other' => 'Other',
    ];

    /**
     * Get the lead that owns the contact.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Get the user who created this contact entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get human-readable contact type label.
     */
    public function getContactTypeLabelAttribute(): string
    {
        return self::CONTACT_TYPES[$this->contact_type] ?? $this->contact_type;
    }
}
