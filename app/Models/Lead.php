<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasWebsiteScope;

class Lead extends Model
{
    use SoftDeletes, HasWebsiteScope;

    protected $fillable = [
        'website_id',
        'restaurant_name',
        'contact_first_name',
        'contact_last_name',
        'email',
        'phone',
        'secondary_phone',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
        'current_url',
        'business_type',
        'cuisine_type',
        'number_of_locations',
        'current_ordering_system',
        'special_requirements',
        'status',
        'source',
        'estimated_value',
        'first_contact_date',
        'last_contact_date',
        'follow_up_date',
        'notes',
        'internal_notes',
        'tags',
        'assigned_to',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'first_contact_date' => 'date',
        'last_contact_date' => 'date',
        'follow_up_date' => 'date',
        'tags' => 'array',
    ];

    /**
     * Get the user assigned to this lead.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the full contact name.
     */
    public function getContactFullNameAttribute(): string
    {
        return trim("{$this->contact_first_name} {$this->contact_last_name}");
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->street_address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by source.
     */
    public function scopeSource($query, string $source)
    {
        return $query->where('source', $source);
    }
}
