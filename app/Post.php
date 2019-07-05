<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    public static function saveObjectidLiked($object_id, $account_id)
    {
        $today = date('Y-m-d H:i:s');
        return DB::insert('insert into post (object_id,status ,account_id,created_at,updated_at) values (?,?,?,?,?)'
            , [$object_id, 'liked', $account_id, $today, $today]);
    }

    public static function checkObjectidIsLiked($object_id, $account_id)
    {
        return DB::select('select 1 from post where object_id = ? and account_id= ?', [$object_id, $account_id]);
    }

    public static function getTotalPostLiked ()
    {
        return DB::table('post')->where('status','=','liked')->count();
    }
    public static function truncatePost()
    {
        return DB::table('post')->truncate();
    }
}
