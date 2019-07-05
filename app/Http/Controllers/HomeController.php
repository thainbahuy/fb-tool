<?php

namespace App\Http\Controllers;

use App\AccountFb;
use App\Post;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    public function addNewAccount(Request $request)
    {
        $name = $request->get('name');
        $accessToken = $request->get('accesstoken');
        AccountFb::addToken($name, $accessToken);
        return response()->json(['result' => 'add success',
            'status' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function getTotalUser()
    {
        $totalUser = AccountFb::getTotalUser();
        return response()->json(['total' => $totalUser, 'status' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function getTotalPostLiked()
    {
        $totalPost = Post::getTotalPostLiked();
        return response()->json(['totalPost' => $totalPost, 'status' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function executeLike()
    {
        //get all token
        $listTokenAccount = AccountFb::getAllToken();
        foreach ($listTokenAccount as $account) {
            // get all object_id by token
            $listObjectIds = $this->getObjectId($account->access_token);
            if(!empty($listObjectIds)){
                foreach ($listObjectIds['data'] as $post){
                    $postId = explode('_', $post['id']);
                    Log::info($postId['1']) ;
                    //check if object_id is not exist in DB then return <=0
                    if(sizeof(Post::checkObjectidIsLiked($post['id'] , $account->id)) <= 0){
                        $this->likeObjectId($postId['1'] , $account->access_token);
                        Log::info('like object_id : '.$postId['1']);
                        Post::saveObjectidLiked($postId['1'] , $account->id);
                    }
                }
            }
        }
    }

    public function getObjectId($token)
    {
        $posts ='';
        try {
            $client = new Client(["base_uri"=>"https://graph.facebook.com/v3.2/"]);
            $res = $client->request('GET', 'me/home', [
                'query' => [
                    'access_token' => $token,
                    'limit' => 5
                ],
            ]);
            $posts =  json_decode($res->getBody(),true);
        } catch (RequestException $e) {
            $exception = $e->getResponse()->getBody();
            $exception = json_decode($exception);
            Token::deleteTokenInvalid($token);
        }
        return $posts;
    }
    public function likeObjectId($object_id,$token)
    {
        try {
            $client = new Client(["base_uri"=>"https://graph.facebook.com/"]);
            $url = $object_id.'/likes';
            $res = $client->request('POST', $url, [
                'query' => [
                    'access_token' => $token,
                ],
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0_3 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11B511 Safari/9537.53 [FBAN/FB4A;FBAV/30.0.0.19.17;FBBV/8445410;FBDM/{density=1.5,width=720,height=1280};FBLC/en_US;FBCR/T-Mobile;FBMF/asus;FBBD/asus;FBPN/com.facebook.katana;FBDV/ASUS_T00J;FBSV/4.4.2;FBOP/1;FBCA/armeabi-v7a:armeabi;]'
                ]
            ]);

        } catch (RequestException $e) {
            $exception = $e->getResponse()->getBody();
            $exception = json_decode($exception);
        }
    }
}
