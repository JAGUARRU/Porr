<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TruckRoute;
use App\Models\Order;
use App\Helpers\Helper;

class TruckRouteList extends Model
{
    use HasFactory;

    protected $table = 'truck_route_lists';

    protected $fillable = [
        'order_id',
        'truck_route_id',
        'route_list_status'
    ];

    public function getRouteListStatusAttribute($value)
    {
        return Helper::GetRouteListStatus($value);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function truck_route()
    {
        return $this->belongsTo(TruckRoute::class);
    }
}
