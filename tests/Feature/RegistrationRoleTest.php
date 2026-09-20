<?php

it('shows a role choice on the registration form', function () {
    $response = $this->get(route('register'));

    $response->assertOk();

    $html = $response->content();

    expect($html)
        ->toContain('Recruteur')
        ->toContain('Candidat')
        ->toContain('name="is_recruiter"');
});
