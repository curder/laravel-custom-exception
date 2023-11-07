<?php

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('can not checkout when credits is less then price', function () {
    $user = User::factory()->create(['credits' => 10]);
    $ticket = Ticket::factory()->create(['price' => 20]);

    $this->actingAs($user)
        ->postJson('api/checkout', ['ticket' => $ticket->id, 'amount' => 1])
        ->assertStatus(401)
        ->assertJsonPath('message', 'Not enough credits');
});

it('can not checkout when ticket is not available', function () {
    $user = User::factory()->create(['credits' => 40]);
    $ticket = Ticket::factory()->create(['price' => 20, 'quantity' => 1]);

    $this->actingAs($user)
        ->postJson('api/checkout', ['ticket' => $ticket->id, 'amount' => 2])
        ->assertStatus(404)
        ->assertJsonPath('message', 'Not enough tickets');
});

it('can checkout', function () {
    $user = User::factory()->create(['credits' => 40]);
    $ticket = Ticket::factory()->create(['price' => 20, 'quantity' => 2]);

    $this->actingAs($user)
        ->postJson('api/checkout', ['ticket' => $ticket->id, 'amount' => 1])
        ->assertStatus(200)
        ->assertJsonPath('message', 'Ticket purchased successfully.');
});
