<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'message',
        'manual_bot_history_id',
    ];

    public function manualBotHistory(): BelongsTo
    {
        return $this->belongsTo(ManualBotHistory::class, 'manual_bot_history_id');
    }
}
