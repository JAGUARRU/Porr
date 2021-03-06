<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retail extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $table = 'retails';
    protected $fillable = [
        'retail_name',
        'retail_address',
        'retail_province',
        'retail_district',
        'retail_sub_district',
        'retail_postcode',
        'retail_phone',
        'retail_contact',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        });
    }
}
