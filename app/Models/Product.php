<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'author',
        'description',
        'content',
        'url',
        'image',
        'source',
        'category_id' 
    ];

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public static function search($query)
    {
        $relations = ['comments', 'category'];

        return empty($query) ? static::query()->with($relations)
            : static::with($relations)
                ->where('title', 'like', '%'.$query.'%')
                ->orWhere('source', 'like', '%'.$query.'%')
                ->orWhere('author', 'like', '%'.$query.'%');
    }
}
