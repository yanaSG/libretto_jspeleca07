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
                <form action="{{ route('books.update', $book) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 row">
                        <label for="title" class="col-md-4 col-form-label text-md-end text-start">Book Title</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $book->title }}">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="author_id" class="col-md-4 col-form-label text-md-end text-start">Author</label>
                        <div class="col-md-6">
                            <select type="text" class="form-control @error('author_id') is-invalid @enderror" id="author_id" name="author_id">
                                @foreach ($authors as $author)
                                <option value="{{ $author->id }}" @selected(old('author_id', $book->author->id) == $author->id)>
                                    {{ $author->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('author_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end text-start">Genres</label>
                        <div class="col-md-6">
                            @foreach ($genres as $genre)
                            <div class="form-check">
                                <input class="form-check-input @error('genre_id') is-invalid @enderror"
                                       type="checkbox"
                                       name="genre_id[]"
                                       value="{{ $genre->id }}"
                                       id="genre_{{ $genre->id }}"
                                       {{ (collect(old('genre_id', $book->genres->pluck('id')->toArray()))->contains($genre->id)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="genre_{{ $genre->id }}">
                                    {{ $genre->name }}
                                </label>
                            </div>
                            @endforeach
                            @error('genre_id')
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