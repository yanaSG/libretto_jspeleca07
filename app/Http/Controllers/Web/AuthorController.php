<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('authors.index', [
            'authors' => Author::latest()->paginate(7)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Author::create($validated);
        return redirect()->route('authors.index')->withSuccess('New author is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author): View
    {
        return view('authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author): View
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author): RedirectResponse
    {
        $validated = $request->validated();

        $author->update($validated);
        return redirect()->back()->withSuccess('Author is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();
        return redirect()->route('authors.index')->withSuccess('Author is deleted successfully.');
    }
}
