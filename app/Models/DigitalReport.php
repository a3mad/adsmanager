<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalReport extends Model
{
    use HasFactory,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url','image','number_of_sponsors','number_of_commercials','note'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];
    protected $appends=['image_url'];

    public function getImageUrlAttribute()
    {
        return asset($this->attributes['image']);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
