@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="float-start">Edit Author</div>
                <div class="float-end">
                    <a href="{{ route('authors.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('authors.update', $author->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                            <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $author->name }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-4">
                            <input type="submit" class="btn btn-primary" value="Update Author">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection