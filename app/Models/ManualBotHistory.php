<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
