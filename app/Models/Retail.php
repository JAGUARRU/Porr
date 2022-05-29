<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retail extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'retail_id';

    protected $table = 'retail';
    protected $fillable = [
        'retail_id',
        'retail_name',
        'retail_address',
        'retail_district',
        'retail_sub_district',
        'retail_postcode',
        'retail_phone',
        'retail_contact',
    ];
}
