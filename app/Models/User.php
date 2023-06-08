<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Providers\RouteServiceProvider;
use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Enums\Roles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'authentication_token',
        'authentication_token_generated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'authentication_token_generated_at' => 'datetime'
    ];

    public function sendAuthenticationMail(?string $redirect_to = null): void
    {
        $authenticationSerive = new AuthenticationService($this);

        $url = route('authentication.callback', [
            'token' => $authenticationSerive->createToken(),
            'email' => $this->email,
            'redirect_to' => $redirect_to ?? url(RouteServiceProvider::HOME),
        ]);

        Mail::raw("Pour vous identifier au site, veuillez cliquer <a href='$url'>ici</a>", function (Message $mail) {
            $mail->to($this->email)
                ->from('no-reply@u-picardie.fr')
                ->subject('Connectez-vous à votre site préféré');
        });
    }
    public function isSuperAdmin(): bool
    {
        return $this->role == Roles::SuperAdmin->value;
    }
    public function isAdmin(): bool
    {
        return $this->role == Roles::Admin->value;
    }
    public function isClient(): bool
    {
        return $this->role == Roles::Client->value;
    }

}
