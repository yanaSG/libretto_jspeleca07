<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        return response()->json(Genre::with('books')->get());
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre = Genre::create($validated);

        return response()->json([
            'message' => 'Genre created successfully',
            'genre'   => $genre,
        ], 201);
    }
    public function show($id)
    {
        $genre = Genre::with('books')->find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        return response()->json($genre);
    }
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre->update($validated);

        return response()->json([
            'message' => 'Genre updated successfully',
            'genre'   => $genre,
        ]);
    }
    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->delete();

        return response()->json(['message' => 'Genre deleted successfully']);
    }
}