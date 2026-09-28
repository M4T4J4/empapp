<?php

use App\Models\User;

it('allows a candidate to send a message to a recruiter and stores a notification', function () {
    $candidate = User::factory()->create(['is_recruiter' => false]);
    $recruiter = User::factory()->create(['is_recruiter' => true]);

    $this->actingAs($candidate);

    $this->post(route('message.store', $recruiter), [
        'message' => 'Bonjour, je suis très intéressé par votre poste.',
    ])->assertRedirect(route('message.show', $recruiter));

    $this->assertDatabaseHas('messages', [
        'sender_id' => $candidate->id,
        'receiver_id' => $recruiter->id,
        'body' => 'Bonjour, je suis très intéressé par votre poste.',
    ]);

    $this->assertDatabaseHas('notifications', [
        'user_id' => $recruiter->id,
        'type' => 'message',
    ]);

    $this->get(route('message.show', $recruiter))->assertSee('Bonjour, je suis très intéressé par votre poste.');
});

it('allows a recruiter to send a message to a candidate', function () {
    $candidate = User::factory()->create(['is_recruiter' => false]);
    $recruiter = User::factory()->create(['is_recruiter' => true]);

    $this->actingAs($recruiter)
        ->post(route('message.store', $candidate), [
            'message' => 'Bonjour, votre profil nous intéresse.',
        ])
        ->assertRedirect(route('message.show', $candidate));

    $this->assertDatabaseHas('messages', [
        'sender_id' => $recruiter->id,
        'receiver_id' => $candidate->id,
        'body' => 'Bonjour, votre profil nous intéresse.',
    ]);

    $this->actingAs($candidate)
        ->get(route('message.show', $recruiter))
        ->assertSee('Bonjour, votre profil nous intéresse.');
});

it('prevents messages between users with the same role and self-messaging', function () {
    $candidate = User::factory()->create(['is_recruiter' => false]);
    $anotherCandidate = User::factory()->create(['is_recruiter' => false]);

    $this->actingAs($candidate)
        ->get(route('message.show', $anotherCandidate))
        ->assertForbidden();

    $this->post(route('message.store', $anotherCandidate), ['message' => 'Bonjour'])
        ->assertForbidden();

    $this->post(route('message.store', $candidate), ['message' => 'Bonjour'])
        ->assertForbidden();

    $this->assertDatabaseCount('messages', 0);
});
