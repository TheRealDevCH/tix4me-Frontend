<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'token',
        'user_agent',
        'ip_address',
        'last_activity',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_activity' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the session is still valid (not expired).
     */
    public function isValid(): bool
    {
        return $this->expires_at && $this->expires_at->isFuture();
    }

    /**
     * Invalidate the session.
     */
    public function invalidate(): void
    {
        $this->delete();
    }
}
