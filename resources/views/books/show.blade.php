@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="float-start">Book Information</div>
                <div class="float-end">
                    <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-start">
                    <div class="col-md-8">
                        <div class="row mb-2">
                            <label for="title" class="col-md-4 col-form-label text-md-end text-start"><strong>Title:</strong></label>
                            <div class="col-md-8" style="line-height:35px;">
                                {{ $book->title }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="author" class="col-md-4 col-form-label text-md-end text-start"><strong>Author:</strong></label>
                            <div class="col-md-8" style="line-height:35px;">
                                {{ $book->author->name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection