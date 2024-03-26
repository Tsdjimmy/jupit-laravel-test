<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Services\RabbitMQService; // Make sure to import your RabbitMQService

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publish([
            'email' => $this->email,
            'token' => $token,
            'type' => 'password_reset',
            'url' => url(config('app.url').route('password.reset', ['token' => $token], false)),
        ]);
    }
}
