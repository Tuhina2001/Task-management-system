<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\TaskAssigned;
use App\Mail\TaskCreatedNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;



class TaskController extends Controller
{
    public function index()
    {
        // Retrieve tasks owned by the authenticated user
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the list of categories belonging to the authenticated user
        $categories = $user->categories;

        // Return the view for creating a new task, passing the categories
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date',
            'status' => 'required',
            'categories' => 'nullable|array', // Ensure categories is an array
            'categories.*' => 'exists:categories,id', // Ensure each category exists in the database
            'attachment' => 'nullable|file', // Ensure attachment is a file
        ]);

        // Add user_id to the validated data
        $validatedData['user_id'] = auth()->id(); // Assign the authenticated user's ID

        // Create the task
        $task = Task::create($validatedData);

        // Sync the categories for the task
        if (isset($validatedData['categories'])) {
            $task->categories()->sync($validatedData['categories']);
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments');
            $task->update(['attachment' => $attachmentPath]);
        }

        /* Dispatch the event
        $user = User::find($task->user_id);
        if ($user) {
            Mail::to($user->email)->send(new TaskCreatedNotification($task));
        }*/

        // Redirect back to the index page with a success message
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }


    public function edit(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve all categories
        $categories = Category::all();

        // Return the view for editing an existing task along with the categories
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date',
            'status' => 'required',
            'categories' => 'nullable|array', // Ensure categories is an array
            'categories.*' => 'exists:categories,id', // Ensure each category exists in the database
            'attachment' => 'nullable|file', // Ensure attachment is a file
        ]);

        // Update the task
        $task->update($validatedData);

        // Sync categories
        $task->categories()->sync($validatedData['categories'] ?? []);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($task->attachment) {
                Storage::delete($task->attachment);
            }

            $attachmentPath = $request->file('attachment')->store('attachments');
            $task->update(['attachment' => $attachmentPath]);
        }

        // Redirect back to the index page with a success message
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }


    public function show(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.show', compact('task'));
    }

    public function destroy(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the task
        $task->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /*public function search(Request $request)
    {
        $query = $request->input('query');
        $tasks = Task::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->get();
        return $tasks;
    }

    public function filter()
    {
        $query = Task::where('user_id', auth()->id());

        // Filter by due date
        if (Request::has('due_date')) {
            $dueDate = Request::input('due_date');
            $query->whereDate('due_date', $dueDate);
        }

        // Filter by status
        if (Request::has('status')) {
            $status = Request::input('status');
            $query->where('status', $status);
        }

        // Filter by category
        if (Request::has('category')) {
            $category = Request::input('category');
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('id', $category);
            });
        }

        $tasks = $query->get();

        // Return the filtered tasks to the view
        return view('tasks.filter-results', compact('tasks'));
    }*/
}
