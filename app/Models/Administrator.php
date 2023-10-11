<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Auth;
class Administrator extends Auth
{
    use HasFactory;

    // protected $table = 'administrators';
    protected $fillable = ['email', 'password'];

    protected $hidden = ['password'];
}
