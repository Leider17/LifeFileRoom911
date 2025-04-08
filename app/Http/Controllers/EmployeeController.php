<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Imports\EmployeeImport;
use App\Models\Department;
use App\Models\Employee;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     *return the view of the employees index page
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $employees = Employee::with('department');
        if ($request->internal_id) {
            $employees = $employees->where('internal_id', 'like', '%' . $request->internal_id . '%');
        }
        if ($request->first_name) {
            $employees = $employees->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->last_name) {
            $employees = $employees->where('last_name', 'like', '%' . $request->last_name . '%');
        }
        if ($request->department_id) {
            $employees = $employees->where('department_id', $request->department_id);
        }

        $employees = $employees->paginate(10)->withQueryString();
        $departments = Department::all();
        return Inertia::render('employees/Index', [
            'employees' => $employees,
            'filters' => $request->only(['internal_id', 'first_name', 'last_name', 'department_id']),
            'departments' => $departments,
        ]);
    }

    /**
     * Return the view of the employees create page
     * @param void
     * @return Response
     */
    public function create(): Response
    {
        $departments = Department::all();
        return Inertia::render('employees/Create', [
            'departments' => $departments,
        ]);
    }

    /**
     * Store the employee in the database
     * @param EmployeeRequest $request
     * @return Response
     */
    public function store(EmployeeRequest $request): RedirectResponse
    {

        Employee::create($request->all());
        return redirect()->route('employee.index')->with('success', 'Employee created successfully');
    }

    /**
     * Return the view of the employees edit page
     * @param Employee $employee
     * @return Response
     */
    public function edit(Employee $employee): Response
    {
        $departments = Department::all();
        return Inertia::render('employees/Edit', [
            'employee' => $employee,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the employee in the database
     * @param EmployeeRequest $request
     * @param Employee $employee
     * @return Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {

        $employee->update($request->all());
        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
    }

    /**
     * import employees from a csv file
     * @param Employee $employee
     * @return Response
     */
    public function importCSV(Request $request): RedirectResponse
    {

        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        try {
            $file = $request->file('file');
            Excel::import(new EmployeeImport, $file);
            return redirect()->route('employee.index')->with('success', 'Employees imported successfully');
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return redirect()->back()->withErrors($e->failures())->withInput();
        }


    }
}
