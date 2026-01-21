<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasWebsiteScope;

class MenuItem extends Model
{
    use SoftDeletes, HasWebsiteScope;

    protected $fillable = [
        'website_id',
        'category',
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'dietary_info',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'dietary_info' => 'array',
    ];

    /**
     * Get the website that owns this menu item.
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
