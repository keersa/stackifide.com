<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'answer',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * Category slugs and labels for dropdowns and public page.
     *
     * @return array<int, array{slug: string, label: string}>
     */
    public static function getCategories(): array
    {
        return [
            ['slug' => 'getting-started', 'label' => 'Getting Started'],
            ['slug' => 'plans-pricing', 'label' => 'Plans & Pricing'],
            ['slug' => 'features-support', 'label' => 'Features & Support'],
            ['slug' => 'technical', 'label' => 'Technical'],
        ];
    }

    /**
     * Scope: order by sort_order for public display (categories ordered via getCategories() in view).
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
