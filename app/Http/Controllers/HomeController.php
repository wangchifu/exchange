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

    public function upload_publickey()
    {
        return view('upload_publickey');
    }

    public function store_publickey(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $folder = 'uploads/public_key';

            $info = [
                //'mime-type' => $file->getMimeType(),
                'original_filename' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getClientSize(),
            ];

            //公鑰附檔名
            $file_type = "png";

            if ($info['size'] > 2100000) {
                $words = "檔案大小超過2MB ！？";
                return view('layouts.error', compact('words'));
            }elseif($info['extension'] != $file_type){
                $words = "檔案格式不是指定的 ".$file_type;
                return view('layouts.error', compact('words'));
            } else {
                $filename = auth()->user()->username.".".$file_type;
                $file->storeAs('public/' . $folder, $filename);

                $att['public_key'] = $filename;
                $att['upload_time'] = date("Y/m/d H:i:s");
                $user = User::where('id','=',auth()->user()->id)->first();
                $user->update($att);
            }
        }else{
            $words = "沒有檔案 ？？";
            return view('layouts.error',compact('words'));
        }
        return redirect()->route('upload_publickey');
    }

    public function delete_publickey(User $user)
    {
        if($user->id != auth()->user()->id){
            $words = "你要做什麼 ？？";
            return view('layouts.error',compact('words'));
        }

        $file_name = $user->public_key;
        $realFile = "../storage/app/public/uploads/public_key/".$file_name;
        if(file_exists($realFile)) {
            unlink($realFile);
        }
        $att['public_key'] = "";
        $att['upload_time'] = "";
        $user->update($att);
        return redirect()->route('upload_publickey');

    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
