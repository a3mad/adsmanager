<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationError extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'user_id',
        'message'
    ];

    /**
     * Get all of the models that own notifications.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
