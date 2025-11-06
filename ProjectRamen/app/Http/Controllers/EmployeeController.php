<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Attendances;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('todayAttendance')->get();
        return view('employees.index', compact('employees'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        Employee::create($request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee added!');
    }

    public function markAttendance(Employee $employee)
    {
        $today = now()->toDateString();

        Attendances::firstOrCreate(
            ['employee_id' => $employee->id, 'date' => $today],
            ['status' => 'active']
        );

        return redirect()->route('employees.index')->with('success', 'Attendance marked!');
    }
}
