<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\NewUserNotification;
use App\Notifications\OrderDeleteNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendOrderDeleteNotification($order = null)
    {
        return $this->notify(new OrderDeleteNotification($order));
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function name(): Attribute
    {
        return Attribute::get(fn (): string => "$this->first_name $this->last_name");
    }

    public static function search($query)
    {
        $relations = ['products', 'addresses', 'orders'];

        return empty($query) ? static::query()->with($relations)
            : static::with($relations)
                ->where('first_name', 'like', '%'.$query.'%')
                ->where('last_name', 'like', '%'.$query.'%')
                // ->orWhere('source', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%');
    }


    public function generatePin($digits = 4): string
    {
        $i = 0; //counter
        $pin = ''; //our default pin is blank.

        while ($i < $digits) {
            //generate a random number between 0 and 9.
            $pin .= random_int(0, 9);
            $i++;
        }

        return $pin;
    }

    public function sendNewUserNotification($token = null)
    {
        $result = $this->generatePin(5);

        $this['otp'] = $result;

        $this->notify(new NewUserNotification($this));

        OtpCode::where('email', $this->email)->delete();

        OtpCode::create([
            'code' => $result,
            'email' => $this->email,
            'expires_at' => now()->addMinutes(5),
        ]);

        return $result;
    }

    public function sendPasswordResetNotification($token = null)
    {
        $result = $this->generatePin(5);

        $this->notify(new ResetPasswordNotification($result));

        OtpCode::where('email', $this->email)->delete();

        OtpCode::create([
            'code' => $result,
            'email' => $this->email,
            'expires_at' => now()->addMinutes(5),
        ]);

        return $result;
    }
}
