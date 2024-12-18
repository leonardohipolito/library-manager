<?php

use App\Models\Author;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('permissions', function () {
    $admin = admin();
    $user = User::factory()->create();
    $author = Author::factory()->create();
    actingAs($user);
    get(route('author.index'))
        ->assertForbidden();
    get(route('author.create'))
        ->assertForbidden();
    get(route('author.edit', $author))
        ->assertForbidden();
    post(route('author.store'))
        ->assertForbidden();
    delete(route('author.destroy', $author))
        ->assertForbidden();
});

it('list authors', function () {
    $user = admin();
    $authors = Author::factory()->count(5)->create();
    actingAs($user);
    get(route('author.index'))
        ->assertOk()
        ->assertSeeText($authors->pluck('name')->toArray());
});

it('create a new author', function () {
    $user = admin();
    actingAs($user);
    post(route('author.store'))->assertInvalid(['name']);
    post(route('author.store'), [
        'name' => fake()->name,
    ])->assertRedirectToRoute('author.index');
    assertDatabaseCount('authors', 1);
});
it('update author', function () {
    $user = admin();
    $author = Author::factory()->create();
    actingAs($user);
    $newName = fake()->colorName;
    put(route('author.update', $author->id))->assertInvalid(['name']);
    put(route('author.update', $author->id), [
        'name' => $newName,
    ])->assertRedirectToRoute('author.index');
    assertDatabaseHas('authors', [
        'id' => $author->id,
        'name' => $newName,
    ]);
});

it('delete author', function () {
    $user = admin();
    $author = Author::factory()->create();
    actingAs($user);
    delete(route('author.destroy', $author->id))->assertNoContent();
    assertDatabaseCount('authors', 0);
});
