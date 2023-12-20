<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryData extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'category_id'
    ];
    public function Category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
