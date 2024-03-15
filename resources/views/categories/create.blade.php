@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Category</div>

                    <div class="card-body">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Category Name:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                    
                    <div class="card-footer">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Task List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
