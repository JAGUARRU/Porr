<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Retail extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $table = 'retails';
    protected $fillable = [
        'id',
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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
