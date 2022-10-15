<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\SignInRequest;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function index(Request $request)
    {
        $authRequired = $request->authRequired;
        return view('signin.index', compact('authRequired'));
    }

    public function authenticate(SignInRequest $request)
    {
        $validatedRequest = $request->validated();
        Log::info('ログイン時のリクエストパラメータ：', $validatedRequest);


        //ログイン認証
        if(Auth::guard('user')->attempt(['email' => $validatedRequest['email'], 'password' => $validatedRequest['password']])){
            return redirect()->intended('top');
        }

        $signinError = true;
        return view('signin.index', compact('signinError'));
    }

    public function signout()
    {
        Auth::guard('user')->logout();
        return redirect('/signin');
    }


}
