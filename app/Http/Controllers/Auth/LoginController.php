<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        if (User::getDataLogin($username, $password) > 0) {
            $this->saveSession($request);
            return response()->json(['status' => 'Login Success', 'code' => Response::HTTP_OK], Response::HTTP_OK);
        } else {
            return response()->json(['status' => 'Login fail', 'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }

    }

    private function saveSession(Request $request){
        $username = $request->get('username');
        $password = $request->get('password');
        $dataUser = ['username' => $username, 'password' => $password];
        Session::put('dataUser', $dataUser);

    }


}
