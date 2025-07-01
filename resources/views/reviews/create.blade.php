@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Add New Review
                </div>
                <div class="float-end">
                    <a href="{{ route('reviews.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('reviews.store') }}"
                    method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="book_id" class="col-md-4 col-formlabel text-md-end text-start">Book Title</label>
                        <div class="col-md-6">
                            <select type="text" class="form-control @error('book_id') is-invalid @enderror" id="book_id" name="book_id" value="{{ old('book_id') }}">
                                @foreach ($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->title }}
                                </option>
                                @endforeach
                            </select>
                            @error('book_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="content" class="col-md-4 col-formlabel text-md-end text-start">Content</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="{{ old('content') }}">
                            @error('content')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="rating" class="col-md-4 col-formlabel text-md-end text-start">Rating</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating') }}">
                            @error('rating')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Add Review</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection