<?php

namespace App\Http\Controllers;

use App\AccountFb;
use App\Post;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Socialite;


class HomeController extends Controller
{

    public function showHomePage(Request $request){
//        if ($request->session()->has('dataUser')){
//            $data = ['dataUser' => $request->session()->get('dataUser')];
//            return view('ltr/index',$data);
//        }else{
//            return redirect('login');
//        }
        $data = ['dataUser' => $request->session()->get('dataUser')];
        return view('ltr/index',$data);
    }

    public function showAccountPage(Request $request){
//        if ($request->session()->has('dataUser')){
//            $data = ['dataUser' => $request->session()->get('dataUser'),
//                'dataAccount' => Post::getListAccount()];
//            return view('ltr/user',$data);
//        }else{
//            return redirect('login');
//        }
        $data = ['dataUser' => $request->session()->get('dataUser'),
            'dataAccount' => Post::getListAccount()];
        return view('ltr/user',$data);
    }

    public function addNewAccount(Request $request)
    {
        $name = $request->get('name');
        $accessToken = $request->get('accesstoken');
        AccountFb::addToken($name, $accessToken);
        return response()->json(['result' => 'add success',
            'code' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function getTotalUser()
    {
        $totalUser = AccountFb::getTotalUser();
        return response()->json(['total' => $totalUser, 'code' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function getTotalPostLiked()
    {
        $totalPost = Post::getTotalPostLiked();
        return response()->json(['totalPost' => $totalPost, 'code' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function getListRecentAction()
    {
        $listAction = Post::getListRecentAction();
        return response()->json(['listAction' => $listAction, 'code' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function getListAccount()
    {
        dd(Post::getListAccount());
    }

    public function deleteAccountById(Request $request){
        return AccountFb::deleteAccountById($request->get('id'));
    }

    public function executeLike()
    {

        //get all token
        $listTokenAccount = AccountFb::getAllToken();
        foreach ($listTokenAccount as $account) {
            // get all object_id by token
            $listObjectIds = $this->getObjectId($account->access_token);
            Log::info('action like :');
            if (!empty($listObjectIds)) {
                foreach ($listObjectIds['data'] as $itemObjectId) {
                    $post = explode('_', $itemObjectId['id']);
                    Log::info($post[1]);
                    //check if object_id is not exist in DB then return <=0
                    if (Post::checkObjectidIsLiked($post[1], $account->id) <= 0) {
                        $this->likeObjectId($post[1], $account->access_token);
                        Log::info('like object_id : ' . $post[1]);
                        Post::saveObjectidLiked($post[1], $account->id);
                    } else {
                        Log::info('object id :'.$post[1].' was liked');
                    }
                }
            }
        }
    }

    public function getObjectId($token)
    {
        $posts = '';
        try {
            $client = new Client(["base_uri" => "https://graph.facebook.com/v3.2/"]);
            $res = $client->request('GET', 'me/home', [
                'query' => [
                    'access_token' => $token,
                    'limit' => 3
                ],
            ]);
            $posts = json_decode($res->getBody(), true);
        } catch (RequestException $e) {
            $exception = $e->getResponse()->getBody();
            $exception = json_decode($exception);
            AccountFb::deleteTokenInvalid($token);
        }
        return $posts;
    }

    public function likeObjectId($object_id, $token)
    {
        try {
            $client = new Client(["base_uri" => "https://graph.facebook.com/"]);
            $url = $object_id . '/likes';
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

    public function deleteAllPostLiked(){
        Post::truncatePost();
    }

    //get token from facebook
    public function redirect($provider)
    {
        return Socialite::driver($provider)->scopes(['publish_pages','email','public_profile'])->redirect();
    }
    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        $userData = [
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id,
                'token' => $getInfo->token,
        ];
        dd($userData);
    }


}
