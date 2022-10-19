<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\TruckRoute;

class Truck extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'trucks';
    
    protected $fillable = [
        'id',
        'plateNumber',
        'truck_status',
        'user_id',

        'truck_province',
        'truck_district',
        'truck_sub_district',
        'truck_postcode'
    ];

    public $timestamps = false;
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);
        });
    }

    protected $truckStatus = array(
        '0' => 'ไม่พร้อมใช้งาน',
        '1' => 'พร้อมใช้งาน'
    );

    public function getTruckStatusAttribute($value)
    {
        return $this->truckStatus[$value];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function routes()
    {
        return $this->hasMany(TruckRoute::class);
    }
}
