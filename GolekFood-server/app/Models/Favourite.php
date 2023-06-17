<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'foodname',
        'fat',
        'protein',
        'carbohydrate',
        'calories',
        'image'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
