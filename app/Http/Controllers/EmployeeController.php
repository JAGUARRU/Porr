<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Redirect;
class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('truck')->paginate(5);
        return view('employees.employees', ["employees"=>$employees]);
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $employee = new Employee;
        $employee->emp_id = $request->input('emp_id');
        $employee->idcard = $request->input('idcard');
        $employee->title_name = $request->input('title_name');
        $employee->emp_firstname = $request->input('emp_firstname');
        $employee->emp_lastname = $request->input('emp_lastname');
        $employee->position = $request->input('position');
        $employee->emp_phone = $request->input('emp_phone');
        $employee->emp_contact = $request->input('emp_contact');
        $employee->emp_address = $request->input('emp_address');
        $employee->email = $request->input('email');
        $employee->username = $request->input('username');
        $employee->password = $request->input('password');
        $employee->emp_status = $request->input('emp_status');
        $employee->save();
        return Redirect::route('employees')->with('status','Employee Added Successfully');
    }

    public function edit($emp_id)
    {
        $employee = Employee::find($emp_id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $emp_id)
    {
        $employee = Employee::find($emp_id);
        $employee->idcard = $request->input('idcard');
        $employee->title_name = $request->input('title_name');
        $employee->emp_firstname = $request->input('emp_firstname');
        $employee->emp_lastname = $request->input('emp_lastname');
        $employee->position = $request->input('position');
        $employee->emp_phone = $request->input('emp_phone');
        $employee->emp_contact = $request->input('emp_contact');
        $employee->emp_address = $request->input('emp_address');
        $employee->email = $request->input('email');
        $employee->username = $request->input('username');
        $employee->password = $request->input('password');
        $employee->emp_status = $request->input('emp_status');
        $employee->update();
        return Redirect::route('employees')->with('status','Employee Updated Successfully');
    }

    public function destroy(Employee $emp_id)
    {
        $emp_id->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
