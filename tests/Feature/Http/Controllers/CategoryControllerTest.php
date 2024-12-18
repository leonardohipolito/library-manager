<?php

use App\Models\Category;
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
    $category = Category::factory()->create();
    actingAs($user);
    get(route('category.index'))
        ->assertForbidden();
    get(route('category.create'))
        ->assertForbidden();
    get(route('category.edit', $category))
        ->assertForbidden();
    post(route('category.store'))
        ->assertForbidden();
    delete(route('category.destroy', $category))
        ->assertForbidden();
});

it('list categories', function () {
    $user = admin();
    $categories = Category::factory()->count(5)->create();
    actingAs($user);
    get(route('category.index'))
        ->assertOk()
        ->assertSeeText($categories->pluck('name')->toArray());
});

it('create a new category', function () {
    $user = admin();
    actingAs($user);
    post(route('category.store'))->assertInvalid(['name']);
    post(route('category.store'), [
        'name' => fake()->colorName,
    ])->assertRedirectToRoute('category.index');
    assertDatabaseCount('categories', 1);
});
it('update category', function () {
    $user = admin();
    $category = Category::factory()->create();
    actingAs($user);
    $newName = fake()->colorName;
    put(route('category.update', $category->id))->assertInvalid(['name']);
    put(route('category.update', $category->id), [
        'name' => $newName,
    ])->assertRedirectToRoute('category.index');
    assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => $newName,
    ]);
});

it('delete category', function () {
    $user = admin();
    $category = Category::factory()->create();
    actingAs($user);
    delete(route('category.destroy', $category->id))->assertNoContent();
    assertDatabaseCount('categories', 0);
});
