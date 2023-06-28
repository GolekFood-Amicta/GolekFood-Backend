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
        'status',
        'subscription_start',
        'subscription_end'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
