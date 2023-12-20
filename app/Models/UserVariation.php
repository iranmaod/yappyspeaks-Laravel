<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVariation extends Model
{
    use HasFactory;
    protected $fillable = [
        'cookie_user_id',
        'category_id',
        'bg_id',
        'variation_id',
        'start_time',
        'end_time',
        'status',
    ];
}
