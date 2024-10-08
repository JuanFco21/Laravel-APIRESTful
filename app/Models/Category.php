<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['delete_at'];

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
