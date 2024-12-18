<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny',Book::class);
        $books = Book::latest()->with(['author','category'])->paginate(10);
        return view('book.index',['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create',Book::class);
        $book = new Book();
        $authors = Author::pluck('name','id');
        $categories = Category::pluck('name','id');
        return view('book.form',['book'=>$book,'authors'=>$authors,'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $book = Book::make($data);
        $book->author()->associate($data['author_id']);
        $book->category()->associate($data['category_id']);
        $book->save();
        return redirect()->route('book.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        Gate::authorize('update',$book);
        $authors = Author::pluck('name','id');
        $categories = Category::pluck('name','id');
        return view('book.form',['book'=>$book,'authors'=>$authors,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validated();
        $book->fill($data);
        $book->author()->associate($data['author_id']);
        $book->category()->associate($data['category_id']);
        $book->save();
        return redirect()->route('book.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        Gate::authorize('delete',$book);
        $book->delete();
        return response()->noContent();
    }
}
