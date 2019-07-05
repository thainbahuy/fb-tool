<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public static function saveObjectidLiked($object_id , $access_token){
        return DB::insert('insert into POST (Object_id, Access_Token) values (?, ?)', [$object_id, $access_token]);
    }

//    public static function checkObjectidIsLiked($object_id , $access_token)
//    {
//        return DB::select('select 1 from POST where Object_id = ? and Access_Token = ?', [$object_id, $access_token]);
//    }

    public static function truncatePost()
    {
        return DB::table('POST')->truncate();
    }
}
