@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Filtered Tasks</h1>

        @if ($tasks->isEmpty())
            <p>No tasks found.</p>
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Task List</a>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->due_date }}</td>
                                <td>{{ $task->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Task List</a>
        @endif
    </div>
@endsection
