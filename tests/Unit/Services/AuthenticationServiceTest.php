<?php
// Tests de AuthenticationService
use App\Services\AuthenticationService;
use App\Models\User;

it('test method createToken', function () {
    /*$user = User::query()->create([
        'name' => 'John Doe',
        'email' => 'test@example.com']);*/
    $user = User::factory()->create();
    $authenticationService = new AuthenticationService($user);
    $token = $authenticationService->createToken();
    expect($token)->toBeString();
    expect(strlen($token))->toBe(20);
    expect($user->authentication_token)->toBe($token);
    // expect($user->authentication_token_generated_at->diffInHours(now()))->toBe(0);
});

// Un test qui vérifiera que la méthode retourne « false » si la date de validité du token dépasse 24h.
it('test date de validité checkToken', function () {
    /*$user = User::query()->create([
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'authentication_token' => 'test',
        'authentication_token_generated_at' => now()->subHours(25)
    ]);*/
    $user = User::factory()->expiredToken()->create();
    $authenticationService = new AuthenticationService($user);
    expect($authenticationService->checkToken('test'))->toBeFalse();
});
// Un test qui vérifiera que la méthode retourne « false » si le token à tester n'est pas identique à celui stocké dans le model User
it('test token identique checkToken', function () {
    /*$user = User::query()->create([
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'authentication_token' => 'test1',
        'authentication_token_generated_at' => now()
    ]);*/
    $user = User::factory()->createValidToken()->create();
    $authenticationService = new AuthenticationService($user);
    expect($authenticationService->checkToken('test2'))->toBeFalse();
});
// Un test qui vérifiera que la méthode retourne « true » si le token et la date de validité sont corrects.
it('test token et date de validité checkToken', function () {
    /*$user = User::query()->create([
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'authentication_token' => 'test1',
        'authentication_token_generated_at' => now()
    ]);*/
    $user = User::factory()->createValidToken()->create();
    $authenticationService = new AuthenticationService($user);
    expect($authenticationService->checkToken('test1'))->toBeTrue();
});
