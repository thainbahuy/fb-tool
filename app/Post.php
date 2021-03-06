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
        return DB::table('post')
            ->where('object_id','=',$object_id)
            ->where('account_id','=',$account_id)
            ->count();
    }

    public static function getTotalPostLiked ()
    {
        return DB::table('post')->where('status','=','liked')->count();
    }
    public static function truncatePost()
    {
        return DB::table('post')->truncate();
    }

    public static function getListRecentAction(){
        return DB::table('post')
            ->select('account_id','name_account','object_id','post.created_at')
            ->join('account_fb','account_fb.id','=','post.account_id')
            ->where(['status' => 'liked'])
            ->orderBy('post.created_at','desc')
            ->get();
    }

    public static function getListAccount()
    {
        return DB::table('post')->select('account_fb.id','name_account',DB::raw('count(object_id) as total'))
            ->join('account_fb','account_fb.id','=','post.account_id')
            ->groupBy('name_account','account_fb.id')
            ->get();
    }
}
