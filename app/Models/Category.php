<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    //En una categoria puede existit,en varios PRODUCTOS plural
    public function products(){
        return $this->belongsTo(Product::class);
    }
}
