<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Models\WorkDay;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WorkDayController extends Controller
{
    /**
     * Record the hours an employee worked on a day.
     */
    public function store(Request $request, User $employee): RedirectResponse
    {
        // Hours are recorded only for employees.
        abort_unless($employee->role === Role::Employee, 404);

        // One entry per employee and day, 0.5–24 hours in half-hour steps.
        $data = $request->validate([
            'date' => [
                'required',
                'date',
                'before_or_equal:today',
                Rule::unique('work_days')->where('user_id', $employee->id),
            ],
            'hours' => ['required', 'numeric', 'min:0.5', 'max:24', 'multiple_of:0.5'],
        ]);

        $data['updated_by'] = $request->user()->id;

        $workDay = $employee->workDays()->create($data);

        return redirect()->route('employees.work-days.index', [
            'employee' => $employee,
            'month' => $workDay->date->format('Y-m'),
        ]);
    }

    /**
     * Show a day with its comments.
     */
    public function show(WorkDay $workDay): View
    {
        $workDay->load(['user', 'updatedBy', 'comments.author']);

        return view('work-days.show', ['workDay' => $workDay]);
    }

    /**
     * Show the form for changing a day.
     */
    public function edit(WorkDay $workDay): View
    {
        $workDay->load('user');

        return view('work-days.edit', ['workDay' => $workDay]);
    }

    /**
     * Save the changed date or hours.
     */
    public function update(Request $request, WorkDay $workDay): RedirectResponse
    {
        // Same rules as when adding a day, but the edited entry does not collide with itself.
        $data = $request->validate([
            'date' => [
                'required',
                'date',
                'before_or_equal:today',
                Rule::unique('work_days')->where('user_id', $workDay->user_id)->ignore($workDay),
            ],
            'hours' => ['required', 'numeric', 'min:0.5', 'max:24', 'multiple_of:0.5'],
        ]);

        $data['updated_by'] = $request->user()->id;

        $workDay->update($data);

        return redirect()->route('work-days.show', $workDay);
    }

    /**
     * Delete a day together with its comments.
     */
    public function destroy(WorkDay $workDay): RedirectResponse
    {
        $workDay->delete();

        return redirect()->route('employees.work-days.index', [
            'employee' => $workDay->user_id,
            'month' => $workDay->date->format('Y-m'),
        ]);
    }
}
