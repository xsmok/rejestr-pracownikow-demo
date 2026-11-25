<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\WorkDay;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Add a comment to a day.
     */
    public function store(Request $request, WorkDay $workDay): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $data['created_by'] = $request->user()->id;

        $workDay->comments()->create($data);

        return redirect()->route('work-days.show', $workDay);
    }

    /**
     * Show the form for changing a comment.
     */
    public function edit(Comment $comment): View
    {
        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Save the changed comment.
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update($data);

        return redirect()->route('work-days.show', $comment->work_day_id);
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('work-days.show', $comment->work_day_id);
    }
}
