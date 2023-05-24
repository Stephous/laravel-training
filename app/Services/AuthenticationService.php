<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class AuthenticationService
{
    public function __construct(private readonly User $user) {
    
    }
    public function createToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $token .= $characters[$index];
        }
        $this->user->authentication_token = $token;
        $this->user->authentication_token_generated_at = now();
        $this->user->save();
        return $token;
    }
    public function checkToken(string $token): bool
    {
        if($this->user->authentication_token === $token){
            return false;
        }
        else if($this->user->authentication_token_generated_at->diffInHours(now()) >= 24){
            return false;
        }
        else{
            return true;
        }
    }
}