@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Categories</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($categories as $category)
                                <li class="list-group-item">{{ $category->name }}</li>
                            @empty
                                <li class="list-group-item">No categories found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Create Another Category</a>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Task List</a>
        </div>
    </div>
@endsection
