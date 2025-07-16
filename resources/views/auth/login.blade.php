@extends('layouts.app')

@section('content')
<div class="container w-50 p-5">
    <h2>Login</h2>
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
</div>
@endsection