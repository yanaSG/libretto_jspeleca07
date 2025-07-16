<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('books.index', [
            'books' => Book::latest()->paginate(7)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::latest()->paginate();
        $genres = Genre::latest()->paginate();
        return view('books.create', compact('authors', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $genreIds = $validated['genre_id'] ?? [];
        $book = Book::create($validated);

        if (!empty($genreIds)) {
            $book->genres()->attach($genreIds);
        }

        return redirect()->route('books.index')->withSuccess('New book is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book): View
    {
        $authors = Author::latest()->paginate();
        $genres = Genre::latest()->paginate();
        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $validated = $request->validated();
        $book->update($validated);
        return redirect()->route('books.index')->withSuccess('Book is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();
        return redirect()->route('books.index')->withSuccess('Book is deleted successfully.');
    }
}
