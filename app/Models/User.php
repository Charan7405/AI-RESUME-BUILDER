<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;   // add this import
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;   // add HasFactory here

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }
}