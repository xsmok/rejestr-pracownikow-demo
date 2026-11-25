<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class EmployeeWorkDayController extends Controller
{
    /**
     * One employee's days in a month, with the form for adding a day.
     */
    public function index(Request $request, User $employee): View
    {
        // Only employees have work days; any other account gives 404.
        abort_unless($employee->role === Role::Employee, 404);

        // Optional filter ?month=YYYY-MM.
        $request->validate([
            'month' => ['nullable', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
        ]);

        // First day of the chosen month, or of the current month.
        $month = $request->filled('month')
            ? Carbon::parse($request->input('month').'-01')
            : now()->startOfMonth();

        return view('work-days.index', [
            'employee' => $employee,
            'month' => $month,
            'workDays' => $employee->workDaysInMonth($month),
        ]);
    }
}
