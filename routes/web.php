<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Models\Task;
use Illuminate\Http\Request; // Import the Request class




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    //Route::post('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
    Route::post('/tasks/search', function (Request $request) {
        // Get the search query from the request
        $query = $request->input('query');

        // Retrieve tasks owned by the authenticated user
        $tasks = Task::where('user_id', auth()->id())
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            })
            ->get();

        // Return the search results view with the tasks
        return view('tasks.search-results', compact('tasks'));
    })->name('tasks.search');
    //Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');
    // Route for filtering tasks
    Route::post('/tasks/apply-filters', function () {
        $query = Task::where('tasks.user_id', auth()->id());

        // Filter by due date
        if (request()->has('due_date')) {
            $dueDate = request()->input('due_date');
            $query->whereDate('tasks.due_date', $dueDate);
        }

        // Filter by status
        if (request()->has('status')) {
            $status = request()->input('status');
            $query->where('tasks.status', $status);
        }

        // Filter by category
        if (request()->has('category')) {
            $category = request()->input('category');
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category);
            });
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            return redirect()->route('tasks.index')->with('status', 'No tasks found.');
        } else {
            return view('tasks.filter-results', compact('tasks'));
        }
    })->name('tasks.apply_filters');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
