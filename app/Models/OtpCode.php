<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $table = 'otpcodes';

    protected $fillable = [
        'code',
        'email',
        'expires_at',
    ];
}
