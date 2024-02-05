<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'startDate', 'endDate', 'question', 'code', 'public', 'published', 'user_id',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'startDate', 'endDate'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accountPolls(): HasMany
    {
        return $this->hasMany(AccountPoll::class);
    }

    public function invitations(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'account_invitations')
            ->withPivot('user_id', 'poll_id', 'accepted')
            ->withTimestamps();
    }
}
