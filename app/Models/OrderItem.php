<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    public function order() :BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function search($query)
    {
        $relations = ['order', 'product'];

        return empty($query) ? static::query()//    ->with($relations)
            : static::with($relations)
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('slug', 'like', '%'.$query.'%');
    }
}
