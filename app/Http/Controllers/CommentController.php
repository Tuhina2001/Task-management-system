<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        // Create the comment associated with the task
        $task->comments()->create([
            'content' => $validatedData['content'],
            'user_id' => auth()->id(), // Assign the authenticated user's ID
        ]);

        // Redirect back to the task's show page with a success message
        return redirect()->route('tasks.show', $task)->with('success', 'Comment added successfully.');
    }
}

