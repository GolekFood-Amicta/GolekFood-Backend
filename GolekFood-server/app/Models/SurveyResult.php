<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'umur',
        'jenis_kelamin',
        'hasil'
    ];
}
