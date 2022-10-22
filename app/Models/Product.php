<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'products';
    protected $fillable = [
        'id',
        'prod_name',
        'prod_price',
        'prod_status',
        'prod_type_name',
        'prod_detail'
    ];

    public function getProdStatusAttribute($value)
    {
        return Helper::GetProductStatus($value);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'products', 'length' => 10, 'prefix' =>'PROD-']);
        });
    }
}
