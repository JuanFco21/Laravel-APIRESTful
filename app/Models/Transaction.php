<?php

namespace App\Models;

use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['delete_at'];
    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id',
    ];

    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
