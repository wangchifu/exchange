<?php

namespace App\Http\Controllers;

use App\Action;
use App\Change;
use App\Post;
use App\Upload;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
        $posts = Post::orderBy('id','DESC')->paginate(10);
        $data = [
            'posts'=>$posts,
        ];
        return view('home',$data);
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

        $gpg = '/usr/bin/gpg';

        //查key id
        $filename = auth()->user()->username.".asc";
        $file_path = storage_path('app/public/public_keys/'.$filename);
        if(file_exists($file_path)){
            $e = $gpg." --with-fingerprint ".$file_path." |awk 'BEGIN{FS=\": \"};NR==3{print $2}'";
            $process = new Process($e);
            $process->run();
            $die_date = substr($process->getOutput(),0,10);
        }else{
            $die_date = "";
        }

        return view('upload_publickey',compact('die_date'));
    }

    public function store_publickey(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $folder = 'public_keys';

            $info = [
                //'mime-type' => $file->getMimeType(),
                'original_filename' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getClientSize(),
            ];

            //公鑰附檔名
            $file_type = "asc";

            if ($info['size'] > 2100000) {
                $words = "檔案大小超過2MB ！？";
                return view('layouts.error', compact('words'));
            }elseif($info['extension'] != $file_type){
                $words = "檔案格式不是指定的 ".$file_type;
                return view('layouts.error', compact('words'));
            } else {
                $filename = auth()->user()->username.".".$file_type;
                //先存入
                $file->storeAs('public/' . $folder, $filename);

                $att['public_key'] = $filename;
                //$att['key_id'] = $request->input('key_id');
                $att['upload_time'] = date("Y/m/d H:i:s");
                $user = User::where('id','=',auth()->user()->id)->first();

                $gpg = '/usr/bin/gpg';

                //查key id
                $file_path = storage_path('app/public/public_keys/'.$filename);
                $e = $gpg." --with-fingerprint ".$file_path." |awk 'BEGIN{FS=\"/\"};NR==1{print $2}'|awk '{print $1}'";
                $process = new Process($e);
                $process->run();
                $key_id = $process->getOutput();
                $ary_phase = array("\r\n","\r","\n");
                $att['key_id'] = str_replace($ary_phase,'',$key_id);

                if(strlen($att['key_id']) != "8"){
                    $words = "key id 不對！";
                    return view('layouts.error', compact('words'));
                }

                //先刪之前的公鑰
                if(!empty($user->key_id)){
                    $recipient = $user->key_id;
                    $process = new Process($gpg.' --delete-key '.$recipient);
                    $process->run();
                }

                $user->update($att);

                //匯入公鑰
                $path = storage_path('app/public/public_keys/'.$filename);
                $process = new Process($gpg.' --import '.$path);
                $process->run();

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
        $realFile = storage_path("app/public/uploads/public_key/".$file_name);
        if(file_exists($realFile)) {
            unlink($realFile);
        }
        $att['public_key'] = "";
        $att['key_id'] = "";
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
