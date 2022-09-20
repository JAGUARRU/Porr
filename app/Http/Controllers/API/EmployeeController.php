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
            ->select('users.id', 'users.empId', 'users.name', 'positions.title')
            ->leftJoin('position_user', 'position_user.user_id', '=', 'users.id')
            ->leftJoin('positions', 'positions.id', '=', 'position_user.position_id')
            ->where(fn($query) => $query->where("empId","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%"))
            ->where('positions.title', 'LIKE', 'Driver')->orWhere("positions.title","LIKE","คนขับรถ")
            ->get();

        return response()->json($res);
    }
}
