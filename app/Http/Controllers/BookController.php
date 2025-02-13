<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'LIKE', "%{$search}%");
            $query->orWhere('author', 'LIKE', "%{$search}%");
        }

        return view('index.home', ['books' => $query->paginate(2)]);
    }

    public function store(BookRequest $request): JsonResponse
    {
        // if (!$request->ajax()) {
        //     abort(404);
        // }

        $book = new Book;
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->published = $request->input('published');

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

        $book->image = $imagePath;
        $book->save();

        return response()->json(['success' => true]);
    }

    public function update(BookRequest $request, Book $book): JsonResponse
    {
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->published = $request->input('published');

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

        $book->image = $imagePath;

        $book->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json(['success' => true]);
    }
}
