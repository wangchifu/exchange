<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->check()){
            return redirect()->route('home');
        }else{
            return view('auth.login');
        }
    }

    public function home()
    {
        return view('home');
    }

    public function change_pass()
    {
        return view('change_pass');
    }

    public function update_pass(Request $request,User $user)
    {
        //處理密碼是否更新
        if (password_verify($request->input('old_password'), $user->password) and !empty($request->input('password1'))){
            $att['password'] = bcrypt($request->input('password1'));
            $user->update($att);
        }else{
            $words = "你的舊密碼似乎不對喔！";
            return view('layouts.error',compact('words'));
        }

        return redirect()->route('index');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function admin()
    {
        return view('admin');
    }
}
