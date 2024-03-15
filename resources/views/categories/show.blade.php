<!-- resources/views/categories/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $category->name }}</div>

                    <div class="card-body">
                        <p><strong>User:</strong> {{ $category->user->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
