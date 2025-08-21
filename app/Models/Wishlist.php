<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    /** @use HasFactory<\Database\Factories\WishlistFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'product_id',
        'created_at',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function search($query)
    {
        $relations = ['user', 'product'];

        return empty($query) ? static::query()->with($relations)
            : static::with($relations)
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('slug', 'like', '%'.$query.'%');
    }
}
