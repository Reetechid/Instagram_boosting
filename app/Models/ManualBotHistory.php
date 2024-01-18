<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ManualBotHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_auto_follow',
        'bot_auto_like',
        'bot_auto_comment',
        'bot_auto_seen_like',
        'input_target',
        'delay',
        'status',
        'start_time',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, 'manual_bot_history_id');
    }
}
