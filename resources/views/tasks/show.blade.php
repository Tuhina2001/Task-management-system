@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $task->title }}</div>

                <div class="card-body">
                    <p><strong>Description:</strong> {{ $task->description }}</p>
                    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
                    <p><strong>Status:</strong> {{ $task->status }}</p>
                    <p><strong>Attached Files:</strong>
                        @if ($task->attachment)
                        <a href="{{ Storage::url($task->file_path) }}">{{ basename($task->attachment) }}</a>
                        @else
                        None
                        @endif
                    </p>
                    <p><strong>Created By:</strong> {{ $task->user->name }}</p>
                    <p><strong>Created At:</strong> {{ $task->created_at }}</p>

                    <!-- Display categories -->
                    <h4>Categories</h4>
                    <ul class="list-group">
                        @forelse ($task->categories as $category)
                        <li class="list-group-item">{{ $category->name }}</li>
                        @empty
                        <li class="list-group-item">No categories assigned.</li>
                        @endforelse
                    </ul>

                    <!-- Buttons for edit and delete -->
                    <div class="btn-group" role="group" aria-label="Task Actions">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>

                    <!-- Display comments -->
                    <h4>Comments</h4>
                    <ul class="list-group">
                        @forelse ($task->comments as $comment)
                        <li class="list-group-item">{{ $comment->content }}</li>
                        @empty
                        <li class="list-group-item">No comments yet.</li>
                        @endforelse
                    </ul>

                    <!-- Form to submit new comment -->
                    <form action="{{ route('comments.store', $task) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="content">Add Comment</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Task List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection