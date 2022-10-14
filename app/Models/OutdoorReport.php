<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutdoorReport extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'report_date',
        'frame_status',
        'paint_status',
        'print_status',
        'light_status',
        'note',
        'morning_image',
        'night_image',
        'report_file'
    ];
    protected $casts = [
        'report_date' => 'date',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $appends = ['morning_image_url', 'night_image_url', 'file_url'];

    public function getMorningImageUrlAttribute()
    {
        return asset($this->attributes['morning_image']);
    }

    public function getNightImageUrlAttribute()
    {
        return asset($this->attributes['night_image']);
    }

    public function getFileUrlAttribute()
    {
        return asset($this->attributes['report_file']);
    }

    public function outdoorLocation()
    {
        return $this->belongsTo(OutdoorLocation::class);
    }
}
