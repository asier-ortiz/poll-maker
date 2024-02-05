<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function authorizeRole($role): bool
    {
        abort_unless($this->hasRole($role), 401);
        return true;
    }

    public function hasRole($role): bool
    {
        if ($this->role == $role) {
            return true;
        }
        return false;
    }

    public function role()
    {
        return $this->role();

    }

    public function polls(): HasMany
    {
        return $this->hasMany(Poll::class);
    }

    public function accountPolls(): HasMany
    {
        return $this->hasMany(AccountPoll::class);
    }

    public function invitations(): BelongsToMany
    {
        return $this->belongsToMany(Poll::class, 'account_invitations')
            ->withPivot('user_id', 'poll_id', 'accepted')
            ->withTimestamps();
    }
}
