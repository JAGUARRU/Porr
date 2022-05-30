<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'prod_id';

    protected $table = 'products';
    protected $fillable = [
        'prod_id',
        'prod_name',
        'prod_price',
        'prod_type_name',
        'prod_detail',
        'stock'
    ];

}
