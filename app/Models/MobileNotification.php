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
    //N.T this relation doesn't exist in the db only exists for nova/actions
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    //N.T this relation doesn't exist in the db only exists for nova/actions
    public function outdoorLocation()
    {
        return $this->belongsTo(OutdoorLocation::class);
    }

    /**
     * Get all of the post's notifications.
     */
    public function notificationErrors()
    {
        return $this->morphMany(NotificationError::class, 'notifiable');
    }
}
