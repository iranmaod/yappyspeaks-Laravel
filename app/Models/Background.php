<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use HasFactory;
    protected $fillable = [
        'bg_image',
        'bg_color',
        'category_id',
        'status',
        'bg_type'
    ];
    public function bgCategory(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
