<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Retail;
use App\Models\OrderList;
use App\Models\OrderRoute;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    
    public $incrementing = false;
    protected $table = 'orders';
    protected $fillable = [
        'id',
        'retail_id',
        'retail_name',
        'retail_province',
        'retail_district',
        'retail_sub_district',
        'retail_postcode',
        
        'truck_id',
        'truck_driver',
        'truck_plate',

        'order_date',
        'order_transportDate',
        'order_status',
        'order_cancelled',
        'order_cancelDateTime',
        'order_total'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        });
    }

    public function retail()
    {
        return $this->belongsTo(Retail::class);
    }

    public function products()
    {
        return $this->hasMany(OrderList::class);
    }

    public function transport()
    {
        return $this->hasOne(TruckRouteList::class);
    }
}
