<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasWebsiteScope;

class Page extends Model
{
    use SoftDeletes, HasWebsiteScope;

    protected $fillable = [
        'website_id',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Get the website that owns this page.
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
