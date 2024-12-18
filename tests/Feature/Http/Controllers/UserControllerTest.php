<?php

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
    $otherUser = User::factory()->create();
    actingAs($user);
    get(route('user.index'))
        ->assertForbidden();
    get(route('user.create'))
        ->assertForbidden();
    get(route('user.edit', $otherUser))
        ->assertForbidden();
    post(route('user.store'))
        ->assertForbidden();
    delete(route('user.destroy', $otherUser))
        ->assertForbidden();
});

test('list users', function () {
    $admin = admin();
    $users = User::factory()->count(5)->create();
    actingAs($admin);
    get(route('user.index'))
        ->assertOk()
        ->assertSeeText($users->pluck('name')->toArray());
});

it('create user', function () {
    $admin = admin();
    actingAs($admin);
    $data = User::factory()->make()->toArray();
    post(route('user.store'), $data)
        ->assertRedirect(route('user.index'));
    assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);
});

it('update user', function () {
    $admin = admin();
    actingAs($admin);
    $user = User::factory()->create();
    $data = User::factory()->make()->toArray();
    put(route('user.update', $user), $data)
        ->assertRedirect(route('user.index'));
    assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);
});

it('delete user', function () {
    $admin = admin();
    actingAs($admin);
    $user = User::factory()->create();
    delete(route('user.destroy', $user))
        ->assertNoContent();
    assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});
it('fail on self delete', function () {
    $admin = admin();
    actingAs($admin);
    $user = $admin;
    delete(route('user.destroy', $user))
        ->assertForbidden();
    assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});
