<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrCode extends Model
{
    use HasFactory,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','url','qrcode',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];
  /*  protected $appends=['qrcode_url'];

    public function geQrcodeUrlAttribute()
    {
        return asset($this->attributes['qrcode']);
    }*/

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
