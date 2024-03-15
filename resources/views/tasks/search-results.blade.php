<!-- resources/views/tasks/search-results.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Search Results</h1>
        @if ($tasks->isEmpty())
            <p>No tasks found.</p>
        @else
            <ul class="list-group">
                @foreach ($tasks as $task)
                    <li class="list-group-item">{{ $task->title }}</li>
                    <!-- Add more task details as needed -->
                @endforeach
            </ul>
        @endif
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary mt-3">Back to Task List</a>
    </div>
@endsection
