<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'total_amount',
        'delivery_cost',
        'status',
        'payment_status',
        'payment_method',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address() :BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function search($query)
    {
        $relations = ['products'];

        return empty($query) ? static::query()//    ->with($relations)
            : static::with($relations)
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('slug', 'like', '%'.$query.'%');
    }
}


