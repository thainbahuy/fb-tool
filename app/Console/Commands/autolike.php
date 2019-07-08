<?php

namespace App\Console\Commands;

use App\AccountFb;
use App\Post;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class autolike extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'like:autolike';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto like every 15 minute';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->executeLike();
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
}
