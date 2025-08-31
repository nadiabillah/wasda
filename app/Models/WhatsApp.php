<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    protected $table = 'whatsapp';
    protected $fillable = [
        'opd_id', 'user_id', 'url_app', 'phone', 'email', 'message', 'imagepath',
        'schedule', 'sent', 'sent_time', 'server'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'opd_id');
    }
}