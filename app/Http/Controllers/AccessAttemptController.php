<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessAttemptRequest;
use App\Models\AccessAttempt;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class AccessAttemptController extends Controller
{
    /**
     * register an access attempt
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attempt(Request $request)
    {
        $request->validate([
            'internal_id' => 'required|string',
        ]);

        $employee = Employee::where('internal_id', $request->internal_id)->first();
        $success = $employee && $employee->has_access;
        if ($employee) {

            AccessAttempt::create([
                'employee_id' => $employee?->id,
                'success' => $success,
            ]);
        }


        if (!$success) {
            return back()->withErrors(['internal_id' => 'Access denied or invalid employee']);
        }

        return back()->with('status', 'Has accessed room911');
    }
    /**
     * Store an access attempt in the database
     * @param AccessAttemptRequest
     * @return JsonResponse
     */
    public function store(AccessAttemptRequest $request): JsonResponse
    {
        $employee = Employee::where('internal_id', $request->internal_id)->first();

        $sucess = $employee && $employee->has_access;

        AccessAttempt::create([
            'employee_id' => $employee->id,
            'success' => $sucess,
        ]);

        return response()->json([
            'success' => $sucess,
            'message' => $sucess ? 'Access granted' : 'Access denied',
        ]);
    }


    /**
     * Show the access history of an employee
     * @param Employee $employee
     * @param Request $request
     * @return Response
     */
    public function showHistory(Employee $employee, Request $request): Response
    {
        $history = $employee->accessAttempts()->with('employee')->latest();

        if ($request->filled('from') || $request->filled('to')) {

            $from = $request->from . ' 00:00:00';
            $to = $request->to . ' 23:59:59';


            $history = $history->whereBetween('created_at', [$from, $to]);
        }

        $history = $history->paginate(10)->withQueryString();
        return inertia('employees/AccessHistory', [
            'history' => $history,
            'employee' => $employee,
        ]);
    }
    /**
     * Download the access history of an employee
     * @param \App\Models\Employee $employee
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Employee $employee, Request $request)
    {
        $history = $employee->accessAttempts()->with('employee')->latest();

        if ($request->filled('from') || $request->filled('to')) {

            $from = $request->from . ' 00:00:00';
            $to = $request->to . ' 23:59:59';


            $history = $history->whereBetween('created_at', [$from, $to]);
        }

        $pdf = Pdf::loadView('pdf.access-history', ['employee' => $employee, 'history' => $history->get()]);

        return $pdf->download("access-history-{$employee->internal_id}.pdf");
    }


}


