<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'street',
        'city',
        'state',
        'country',
        'postal_code',
        'is_default',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function search($query)
    {
        $relations = ['user'];

        return empty($query) ? static::query()//    ->with($relations)
            : static::with($relations)
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('slug', 'like', '%'.$query.'%');
    }

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }
}
