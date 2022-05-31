<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Truck extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'trucks';
    protected $fillable = [
        'plate'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => $this->table, 'length' => 6, 'prefix' =>'T']);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
