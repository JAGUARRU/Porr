<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Truck;
use App\Models\OrderRouteLists;

class OrderRoute extends Model
{
    use HasFactory;

    protected $table = 'order_routes';

    protected $fillable = [
        'order_id',
        'transportDate',
        'confirmDate',
        'truck_id',
        'truck_driver',
        'truck_plate'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function lists()
    {
        return $this->hasMany(OrderRouteLists::class);
    }
}
