<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Symfony\Component\HttpFoundation\Response;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use Illuminate\Validation\Rule;

use DB;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $config = [
            'table' => 'users',
            'length' => 8,
            'prefix' => 'EMP-',
            'field' => 'empId'
        ];
        
        $empId = IdGenerator::generate($config);
        
        $roles = Role::pluck('title', 'id');

        return view('users.create', compact('roles', 'empId'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $user->load('roles');

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if (!$request->password || !strlen($request->password)) {
            unset($request['password']);
        }

        $validatedData = $request->validate([
            'empId' => [
                'required',
                Rule::unique('users')->where(function ($query) use($request, $user) {
                    return $query->where('empId', $request->empId);
                })->ignore($user->empId, 'empId')
            ]
        ], [
            'empId.unique' => 'รหัสพนักงานซ้ำ'
        ]);

        $user->fill($request->all());
        $user->update();

        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index');
    }


    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return redirect()->route('users.index');
    }

}
