<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class SummaryController extends Controller
{
    /**
     * Employees with the number of days and the sum of hours in a month.
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

        $onlyThisMonth = fn (Builder $query) => $query->inMonth($month);

        $employees = User::query()
            ->where('role', Role::Employee)
            ->withCount(['workDays' => $onlyThisMonth])
            ->withSum(['workDays' => $onlyThisMonth], 'hours')
            ->orderBy('name')
            ->get();

        return view('summary.index', [
            'employees' => $employees,
            'month' => $month,
        ]);
    }
}
