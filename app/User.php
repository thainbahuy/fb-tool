<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Model
{

    public static function getDataLogin($username,$password)
    {
        return DB::table('users')
            ->where('username','=',$username)
            ->where('password','=',$password)
            ->count();
    }
}
