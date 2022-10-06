<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderList extends Model
{
    use HasFactory;

    protected $table = 'order_lists';

    protected $fillable = [
        'qty'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
