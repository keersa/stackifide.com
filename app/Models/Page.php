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

    /**
     * Check if content is structured (row-based) JSON.
     */
    public function hasStructuredContent(): bool
    {
        if (empty($this->content)) {
            return false;
        }
        $trimmed = trim($this->content);
        if ($trimmed === '' || $trimmed[0] !== '{') {
            return false;
        }
        $decoded = json_decode($this->content, true);
        return is_array($decoded) && isset($decoded['rows']) && is_array($decoded['rows']);
    }

    /**
     * Get structured content as array, or null if legacy HTML.
     */
    public function getStructuredContent(): ?array
    {
        if (!$this->hasStructuredContent()) {
            return null;
        }
        return json_decode($this->content, true);
    }
}
