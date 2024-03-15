@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tasks</h1>
    <!-- Create Category Button -->
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create Category</a><br><br>

    <!-- Create New Task Button -->
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a><br><br>

    <form action="{{ route('tasks.search') }}" method="POST" class="mb-3">
        @csrf
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Search tasks...">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <form action="{{ route('tasks.apply_filters') }}" method="POST" class="mb-3">
        @csrf <!-- CSRF token -->
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="due_date" class="form-label">Filter by Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="category" class="form-label">Filter by Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select Category</option>
                        <!-- Fetch Categories -->
                        @foreach (Auth::user()->categories()->pluck('name', 'id') as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Apply Filters</button>
    </form>

    <div class="list-group">
        @forelse ($tasks as $task)
        <div class="list-group-item">
            <h3 class="mb-1">{{ $task->title }}</h3>
            <p class="mb-1">{{ $task->description }}</p>
            <p class="mb-1">Due Date: {{ $task->due_date }}</p>
            <p class="mb-1">Status: {{ $task->status }}</p>
            <div class="d-flex justify-content-end">
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info me-2">View</a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-secondary me-2">Edit</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <p>No tasks found.</p>
        @endforelse
    </div>
</div>
@endsection