<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        return response()->json(Review::with('book')->get());
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        $review = Review::create($validated);

        return response()->json([
            'message' => 'Review created successfully',
            'review'  => $review->load('book'),
        ], 201);
    }

    public function show($id)
    {
        $review = Review::with('book')->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($review);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        $review->update($validated);

        return response()->json([
            'message' => 'Review updated successfully',
            'review'  => $review->load('book'),
        ]);
    }
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}