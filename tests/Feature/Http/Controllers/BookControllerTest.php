<?php

use App\Enums\BookStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
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
    $book = Book::factory()->create();
    actingAs($user);
    get(route('book.index'))
        ->assertForbidden();
    get(route('book.create'))
        ->assertForbidden();
    get(route('book.edit', $book))
        ->assertForbidden();
    post(route('book.store'))
        ->assertForbidden();
    delete(route('book.destroy', $book))
        ->assertForbidden();
});

test('list books', function () {
    $user = admin();
    $books = Book::factory()->count(5)->create();
    actingAs($user);
    get(route('book.index'))
        ->assertSeeText($books->pluck('name')->toArray());
});

test('create a new book', function () {
    $user = admin();
    $author = Author::factory()->create();
    $category = Category::factory()->create();
    $book = [
        'name' => 'New Book',
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => BookStatus::available->name,
    ];
    actingAs($user);
    post(route('book.store'), $book)
        ->assertRedirectToRoute('book.index');
    assertDatabaseHas('books', $book);
});

it('update book', function () {
    $user = admin();
    $book = Book::factory()->create();
    $newData = Book::factory()->make();
    actingAs($user);
    put(route('book.update', $book), $newData->toArray())
        ->assertRedirectToRoute('book.index');
    assertDatabaseHas('books', $newData->toArray());
});

it('delete book',function(){
    $user = admin();
    $book = Book::factory()->create();
    actingAs($user);
    delete(route('book.destroy', $book))
        ->assertNoContent();
    assertDatabaseMissing('books', $book->toArray());
});
