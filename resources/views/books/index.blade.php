@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
        @endsession
        <div class="card">
            <div class="card-header">Book List</div>
            <div class="card-body">
                <a href="{{ route('books.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New
                    Book</a>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author->name }}</td>
                            <td>
                                <form action="{{ route('books.destroy', $book->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-warning btn-sm"><i class="bi bieye"></i> Show</a>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm"><i class="bi bipencil-square"></i> Edit</a>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this book?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <td colspan="6">
                            <span class="text-danger">
                                <strong>No Book Found!</strong>
                            </span>
                        </td>
                        @endforelse
                    </tbody>
                </table>
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection