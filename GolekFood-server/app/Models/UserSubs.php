<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription',
        'subscription_start',
        'subscription_end'
    ];
}
