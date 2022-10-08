<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'channel_id',
        'air_date',
        'air_time',
        'location_id',
        'program_id',
        'grid_item',
        'campaign_id',
        'client_id',
        'sponsor_type_id',
        'rerun_id',
        'duration',
        'program_break_id',
        'sponsor_id',
        'match'
    ];

    protected $casts = [
        'air_date' => 'date',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function sponsorType()
    {
        return $this->belongsTo(SponsorType::class);
    }

    public function rerun()
    {
        return $this->belongsTo(Rerun::class);
    }

    public function programBreak()
    {
        return $this->belongsTo(ProgramBreak::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
