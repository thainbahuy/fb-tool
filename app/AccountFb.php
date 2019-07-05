<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountFb extends Model
{
    public static function getTotalUser()
    {
        return DB::select('select count(*) as total from account_fb ');
    }

    public static function getAllToken()
    {
        return DB::select('select access_token from account_fb ');
    }

    public static function addToken($name,$token)
    {
        return DB::insert('insert into account_fb (access_token,name_account) values (?,?)', [$token ,$name]);
    }

    public static function deleteTokenInvalid($token)
    {
        return DB::delete('delete from account_fb where access_token = ?', [$token]);
    }
}
