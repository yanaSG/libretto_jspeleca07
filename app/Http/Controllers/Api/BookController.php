<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    //
    
    public function index()
    {
        $books = Book::with(['author', 'genres', 'reviews'])->get();
        return response()->json($books);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'author_id'  => 'required|exists:authors,id',
            'genre_ids'  => 'array',
            'genre_ids.*'=> 'exists:genres,id'
        ]);

        $book = Book::create([
            'title'     => $validated['title'],
            'author_id' => $validated['author_id'],
        ]);

        // Attach genres if provided
        if (isset($validated['genre_ids'])) {
            $book->genres()->attach($validated['genre_ids']);
        }

        return response()->json([
            'message' => 'Book created successfully',
            'book'    => $book->load(['author', 'genres', 'reviews']),
        ], 201);
    }

    public function show($id)
    {
        $book = Book::with(['author', 'genres', 'reviews'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'author_id'  => 'required|exists:authors,id',
            'genre_ids'  => 'array',
            'genre_ids.*'=> 'exists:genres,id'
        ]);

        $book->update([
            'title'     => $validated['title'],
            'author_id' => $validated['author_id'],
        ]);

        // Sync genres if provided
        if (isset($validated['genre_ids'])) {
            $book->genres()->sync($validated['genre_ids']);
        }

        return response()->json([
            'message' => 'Book updated successfully',
            'book'    => $book->load(['author', 'genres', 'reviews']),
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}