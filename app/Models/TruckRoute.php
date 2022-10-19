<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Truck;
use App\Models\TruckRouteList;
use App\Helpers\Helper;

class TruckRoute extends Model
{
    use HasFactory;

    protected $table = 'truck_routes';

    protected $fillable = [
        'route_status',
        'transportDate',
        'confirmDate',
        'truck_id',
        'truck_driver',
        'truck_plateNumber'
    ];

    public function getRouteStatusAttribute($value)
    {
        return Helper::GetRouteStatus($value);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function lists()
    {
        return $this->hasMany(TruckRouteList::class);
    }
}
