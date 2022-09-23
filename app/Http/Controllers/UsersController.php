<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->with('positions')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /*$num = DB::table('users')->orderBy('id', 'desc')->first()->id ?? 0;
        $num += 1;

        $len = strlen($num);
        for($i=$len; $i< 4; ++$i) {
            $num = '0'.$num;
        }
        
        $empId = 'EMP-' . $num;*/

        $config = [
            'table' => 'users',
            'length' => 8,
            'prefix' => 'EMP-',
            'field' => 'empId'
        ];
        
        $empId = IdGenerator::generate($config);
        
        $roles = Role::pluck('title', 'id');
        $positions = Position::pluck('title', 'id');

        return view('users.create', compact('roles', 'positions', 'empId'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->roles()->sync($request->input('roles', []));
        $user->positions()->sync($request->input('positions', []));

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');
        $positions = Position::pluck('title', 'id');

        $user->load('roles');
        $user->load('positions');

        return view('users.edit', compact('user', 'roles', 'positions'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->update();

        $user->update($request->validated());
        $user->roles()->sync($request->input('roles', []));
        $user->positions()->sync($request->input('positions', []));

        return redirect()->route('users.index');
    }


    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return redirect()->route('users.index');
    }
}
