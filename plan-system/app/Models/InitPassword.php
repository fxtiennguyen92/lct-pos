<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InitPassword extends Model
{
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['email', 'password'];
}
