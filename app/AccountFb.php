<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountFb extends Model
{
    public static function getTotalUser()
    {
        return DB::table('account_fb')->count();
    }

    public static function getAllToken()
    {
        return DB::select('select id,access_token from account_fb ');
    }

    public static function addToken($name, $token)
    {
        $today = date('Y-m-d H:i:s');
        return DB::insert('insert into account_fb (access_token,name_account,created_at,updated_at) values (?,?,?,?)'
            , [$token, $name, $today,$today]);
    }

    public static function deleteTokenInvalid($token)
    {
        return DB::delete('delete from account_fb where access_token = ?', [$token]);
    }
}
