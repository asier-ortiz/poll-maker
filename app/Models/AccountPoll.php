<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountPoll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'poll_id', 'answer_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
