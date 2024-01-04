<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'category_id'];

    public function scopeCategorySearch(Builder $query, ?int $category_id): void
    {
        if (is_null($category_id)) return;

        $query->where('category_id', $category_id);
    }

    public function scopeKeywordSearch(Builder $query, string $keyword): void
    {
        if (empty($keyword)) return;

        $query->where('content', 'ilike', "%{$keyword}%");
    }
}
