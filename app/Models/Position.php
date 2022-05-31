<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function works()
    {
        return $this->belongsToMany(Work::class);
    }
}
