<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\OrderRoute;

class Truck extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'trucks';
    protected $fillable = [
        'id',
        'plateNumber',
        'status',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function routes()
    {
        return $this->hasMany(OrderRoute::class);
    }
}
