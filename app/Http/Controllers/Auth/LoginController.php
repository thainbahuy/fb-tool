<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

//    use AuthenticatesUsers;
    public function showLoginForm()
    {
        return view('ltr/login');
    }

    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        if (User::checkDataLogin($username, $password) > 0) {
            Log::info('save session');
            $this->saveSession($request,User::getDataLogin($username, $password));
            return redirect('/home');
        } else {
            $request->session()->flash('alert-warning', 'Incorrect Username and Password');
            return view('ltr/login');
        }

    }

    public function logout(Request $request){
        Log::info('delete session');
        $this->forgetSession($request);
        return Redirect('login');
    }

    private function forgetSession(Request $request){
        $request->session()->forget('dataUser');
    }

    private function saveSession(Request $request,$dataLogin){
        $dataUser = ['username' => $dataLogin[0]->username,
            'password' => $dataLogin[0]->password,
            'role' => $dataLogin[0]->role];
        $request->session()->put('dataUser' , $dataUser);
    }


}
