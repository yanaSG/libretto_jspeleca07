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
                <div class="float-start">Edit Book</div>
                <div class="float-end">
                    <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('books.update', $book->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 row">
                        <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $book->title }}">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="author" class="col-md-4 col-form-label text-md-end text-start">Author</label>
                        <div class="col-md-6">
                            <select type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ $book->author->id }}">
                                @foreach ($authors as $author)
                                <option value="{{ $loop->iteration }}" @selected(old('author_id', $book->author->id) == $author->id)>
                                    {{ $author->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('author')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-4">
                            <input type="submit" class="btn btn-primary" value="Update Book">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection