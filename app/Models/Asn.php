<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asn extends Model
{
    protected $table = 'asn';
    protected $fillable = ['name', 'phone', 'email'];
}