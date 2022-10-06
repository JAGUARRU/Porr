<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderRoute;

class OrderRouteLists extends Model
{
    use HasFactory;

    protected $table = 'route_lists';

    public function route()
    {
        return $this->belongsTo(OrderRoute::class);
    }
}
