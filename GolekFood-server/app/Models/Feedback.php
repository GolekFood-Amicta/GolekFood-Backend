<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'content'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

