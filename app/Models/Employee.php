<?php

namespace App\Models;
use App\Models\Truck;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'emp_id';
    protected $table = 'employees';
    protected $fillable = [
        'emp_id',
        'idcard',
        'title_name',
        'emp_firstname',
        'emp_lastname',
        'position',
        'emp_phone',
        'emp_contact',
        'emp_address',
        'email',
        'username',
        'password',
        'emp_status'
    ];

    public function truck()
    {
        return $this->hasOne(Truck::class);
    }
}
