<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Libretto CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrapicons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 shadow">
        <div class="container-fluid">
            <div class="d-flex gap-3">
                <a class="navbar-brand" href="{{ route('books.index') }}">Books</a>
                <a class="navbar-brand" href="{{ route('authors.index') }}">Authors</a>
                <a class="navbar-brand" href="{{ route('genres.index') }}">Genres</a>
                <a class="navbar-brand" href="{{ route('reviews.index') }}">Reviews</a>
            </div>
            <div class="ms-auto">
                @auth
                <form method="POST" action="{{ url('/api/logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Logout</button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <h3 class="mb-3 mx-auto">Libretto CRUD</h3>

        {{-- Flash Messages --}}
        <!-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif -->

        @yield('content')

        <div class="row justify-content-center text-center mt-3">
            <div class="col-md-12">
                <p>
                    Return to Website:
                    <a href="https://www.usjr.edu.ph/"><strong>University of San Jose - Recoletos</strong></a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>