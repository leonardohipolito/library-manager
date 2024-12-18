<?php

namespace App\Http\Controllers;

use App\Enums\BookStatus;
use App\Enums\LoanStatus;
use App\Http\Requests\LoanRequest;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Loan::class);
        $loans = Loan::latest()->with(['borrower', 'attendant', 'book'])->paginate(10);

        return view('loan.index', ['loans' => $loans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Loan::class);
        $loan = new Loan;
        $users = User::pluck('name', 'id');
        $books = Book::where('status', BookStatus::available)->pluck('name', 'id');

        return view('loan.form', compact('loan', 'users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request)
    {
        Gate::authorize('create', Loan::class);
        $data = $request->validated();
        $loan = Loan::make($data);
        $loan->status = LoanStatus::borrowed;
        $loan->book()->associate($data['book_id']);
        $loan->attendant()->associate(auth()->user());
        $loan->borrower()->associate($data['borrower_id']);
        $loan->save();

        return redirect()->route('loan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        Gate::authorize('update', $loan);
        $users = User::pluck('name', 'id');
        $books = Book::where('status', BookStatus::available)->pluck('name', 'id');

        return view('loan.form', compact('loan', 'users', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanRequest $request, Loan $loan)
    {
        Gate::authorize('update', $loan);
        $data = $request->validated();
        $loan->fill($data);
        $loan->book()->associate($data['book_id']);
        $loan->borrower()->associate($data['borrower_id']);
        $loan->save();

        return redirect()->route('loan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        Gate::authorize('delete', $loan);
        $loan->delete();

        return response()->noContent();
    }
}
