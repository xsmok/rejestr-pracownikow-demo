<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class MyTimeController extends Controller
{
    /**
     * The logged-in employee's own days in a month.
     */
    public function index(Request $request): View
    {
        // Optional filter ?month=YYYY-MM.
        $request->validate([
            'month' => ['nullable', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
        ]);

        // First day of the chosen month, or of the current month.
        $month = $request->filled('month')
            ? Carbon::parse($request->input('month').'-01')
            : now()->startOfMonth();

        $employee = $request->user();

        return view('work-days.index', [
            'employee' => $employee,
            'month' => $month,
            'workDays' => $employee->workDaysInMonth($month),
        ]);
    }
}
