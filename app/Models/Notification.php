<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
  use HasFactory;

  protected $fillable = [
    'type',
    'notifiable_type',
    'notifiable_id',
    'messages',
    'read_at',
    'sender_id',
    'sender_role'
  ];

  protected $casts = [
    'messages' => 'string',
    'read_at' => 'datetime',
  ];

  /**
   * Relasi ke tabel notification_recipients
   */
  public function recipients(): HasMany
  {
    return $this->hasMany(NotificationRecipient::class, 'notification_id');
  }

  /**
   * Relasi polymorphic ke notifiable (bisa ke user atau entitas lain)
   */
  public function notifiable(): MorphTo
  {
    return $this->morphTo();
  }

  /**
   * Relasi ke User yang mengirim notifikasi
   */
  public function sender(): BelongsTo
  {
    return $this->belongsTo(User::class, 'sender_id');
  }

  /**
   * Scope untuk mengambil notifikasi berdasarkan user penerima.
   */
  public function scopeForUser($query, $userId)
  {
    return $query->whereHas('recipients', function ($q) use ($userId) {
      $q->where('user_id', $userId);
    });
  }
}
