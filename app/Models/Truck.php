<?php

namespace App\Models;
use App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'truck_id';

    protected $table = 'truck';
    protected $fillable = [
        'truck_id',
        'employee_emp_id',
        'plateNumber'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
