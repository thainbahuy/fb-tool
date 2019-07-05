<?php

namespace App\Http\Controllers;

use App\AccountFb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
}
