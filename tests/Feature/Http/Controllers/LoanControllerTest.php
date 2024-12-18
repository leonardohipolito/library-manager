<?php

use App\Enums\BookStatus;
use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('permissions', function () {
    $user = User::factory()->create();
    $loan = Loan::factory()->create();
    actingAs($user);
    get(route('loan.index'))
        ->assertForbidden();
    get(route('loan.create'))
        ->assertForbidden();
    get(route('loan.edit', $loan))
        ->assertForbidden();
    post(route('loan.store'))
        ->assertForbidden();
    delete(route('loan.destroy', $loan))
        ->assertForbidden();
});

it('can display a list of loans', function () {
    $user = admin();
    $loans = Loan::factory(5)->create();
    actingAs($user);
    get(route('loan.index'))
        ->assertOk()
        ->assertSeeText($loans->map(fn ($loan) => $loan->expires_at->format('d/m/Y'))->toArray());
});

it('create a loan', function () {
    $attendant = admin();
    $user = User::factory()->create(['email' => 'client@example.com']);
    $book = Book::factory()->create([
        'status' => BookStatus::available,
    ]);
    actingAs($attendant);
    $data = [
        'book_id' => $book->id,
        'borrower_id' => $user->id,
        'expires_at' => now()->addDay(),
        'status' => LoanStatus::overdue->name,
    ];
    post(route('loan.store'), $data)->assertRedirectToRoute('loan.index');
    assertDatabaseHas('loans', [
        ...$data,
        'status' => LoanStatus::borrowed->name,
        'attendant_id' => $attendant->id,
        'returned_at' => null,
    ]);
});

it('not create loan if book is borrowed', function () {
    $attendant = admin();
    $user = User::factory()->create(['email' => 'client@example.com']);
    $book = Book::factory()->create([
        'status' => BookStatus::borrowed,
    ]);
    actingAs($attendant);
    $data = [
        'book_id' => $book->id,
        'borrower_id' => $user->id,
        'expires_at' => now()->addDay(),
    ];
    post(route('loan.store'), $data)->assertInvalid('book_id');
    assertDatabaseMissing('loans', $data);
});

it('update loan', function () {
    $attendant = admin();
    $loan = Loan::factory()->create(['status' => LoanStatus::borrowed]);
    actingAs($attendant);
    $data = [
        ...$loan->toArray(),
        'status' => LoanStatus::returned->name,
    ];
    put(route('loan.update', $loan), $data)
        ->assertRedirectToRoute('loan.index');
    assertDatabaseHas('loans', [
        'id' => $loan->id,
        'status' => LoanStatus::returned->name,
    ]);
    $loan->refresh();
    expect($loan->returned_at)->not->toBeNull();
});

it('delete loan', function () {
    $attendant = admin();
    $loan = Loan::factory()->create();
    actingAs($attendant);
    delete(route('loan.destroy', $loan))
        ->assertNoContent();
    assertDatabaseMissing('loans', ['id' => $loan->id]);
});

it('set returned_at if status is returned', function () {
    $attendant = admin();
    $loan = Loan::factory()->create(['status' => LoanStatus::borrowed]);
    actingAs($attendant);
    $data = [
        ...$loan->toArray(),
        'status' => LoanStatus::returned->name,
    ];
    put(route('loan.update', $loan), $data);
    $loan->refresh();
    expect($loan->returned_at)->not->toBeNull();
    $data['status'] = LoanStatus::overdue->name;
    put(route('loan.update', $loan), $data);
    $loan->refresh();
    expect($loan->returned_at)->toBeNull();
});
