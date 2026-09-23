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
