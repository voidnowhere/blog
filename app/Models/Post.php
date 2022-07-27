<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'body',
    ];

    protected $with = ['category', 'author', 'comments'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(fn($query) => $query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
            );
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('category', fn($query) => $query->where('slug', $category));
        });

        $query->when($filters['author'] ?? false, function ($query, $author) {
            $query->whereHas('author', fn($query) => $query->where('username', $author));
        });
    }
}
