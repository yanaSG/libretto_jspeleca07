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
            <div class="card-header d-flex gap-2">
                <p>Review List</p>
            </div>
            <div class="card-body">
                <a href="{{ route('reviews.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New
                    Review</a>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $review->book->title }}</td>
                            <td>{{ $review->content }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-warning btn-sm"><i class="bi bieye"></i> Show</a>
                                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary btn-sm"><i class="bi bipencil-square"></i> Edit</a>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this review?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <td colspan="6">
                            <span class="text-danger">
                                <strong>No Review Found!</strong>
                            </span>
                        </td>
                        @endforelse
                    </tbody>
                </table>
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection