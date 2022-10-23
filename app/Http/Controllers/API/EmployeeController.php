<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\User;

class EmployeeController extends Controller
{
    public function getDrivers(Request $request)
    {
        $users = User::query();

        $res = $users
            ->select('users.id', 'users.empId', 'users.name', 'users.positions')
            ->where(fn($query) => $query->where("empId","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%")->orWhere("positions","LIKE","%{$request->term}%"))
            ->get();

        return response()->json($res);
    }
}
