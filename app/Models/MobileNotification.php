<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileNotification extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notification_type_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }

    /**
     * Get all of the post's notifications.
     */
    public function notificationErrors()
    {
        return $this->morphMany(NotificationError::class, 'notifiable');
    }
}
