<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestedReport extends Model
{
    use HasFactory,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','description','report_file', 'item_date'
    ];
    protected $casts = [
        'item_date' => 'date'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];
    protected $appends=['file_url'];

    public function getFileUrlAttribute()
    {
        return asset($this->attributes['report_file']);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
