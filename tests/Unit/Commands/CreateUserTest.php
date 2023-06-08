<?php

use App\Models\User;
use App\Enums\Roles;
use Illuminate\Support\Facades\Event;
use App\Events\CreateUser;

it('test event CreateUser', function () {
    Event::fake([CreateUser::class]);
    $this->artisan('user:create', [
        'name' => 'John Doe',
        'email' => 'john.doe@example.clom',
        '--role' => Roles::Client->value
    ]);
    Event::assertDispatched(CreateUser::class);
});
