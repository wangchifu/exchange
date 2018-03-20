<?php

namespace App\Http\Controllers\Auth;

use App\Application;
use App\Change;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $dt = Carbon::now();
        $die_date = str_replace('-','',substr($dt->subMonths(3),0,10));
        $changes = Change::where('upload_time','<',$die_date)
            ->where('download','<','2')
            ->get();
        foreach($changes as $change){
            $path = storage_path('app/public/changes/'.$change->file);
            if(file_exists($path)){
                unlink($path);
            }
            if($change->download == 0) $att['download'] = 2;
            if($change->download == 1) $att['download'] = 3;
            $change->update($att);
        }
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'username';
    }
    public function refereshcapcha()
    {
        return captcha_img('flat');
    }
    public function forgetPW()
    {
        return view('forgetPW');
    }

    public function download_pdf()
    {
        $realFile = public_path('sample/reset_password.pdf');
        return response()->download($realFile);
    }

    public function upload_pic(Request $request)
    {
        if(empty($request->input('pw1')) or empty($request->input('pw2'))){
            $words = "密碼空的？";
            return view('layouts.error', compact('words'));
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $info = [
                'mime-type' => $file->getMimeType(),
                'original_filename' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getClientSize(),
            ];
            $type = explode('/',$info['mime-type']);

            if ($type[0] != "image"){
                $words = "不是圖檔？";
                return view('layouts.error', compact('words'));
            }


            if ($info['size'] > 6100000) {
                $words = "檔案大小超過5MB ！？";
                return view('layouts.error', compact('words'));
            } else {
                $att['pic'] = date("YmdHis") .".". $info['extension'];
                $folder = 'applications';
                $file->storeAs('public/' . $folder, $att['pic']);

                $att['action'] = "1";
                $att['page'] = substr(md5(uniqid(rand(),true)),0,6);


                //取ip
                if (!empty($_SERVER["HTTP_CLIENT_IP"])){
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                }else{
                    $ip = $_SERVER["REMOTE_ADDR"];
                }
                $att['ip'] = $ip;
                $att['pw'] = $request->input('pw1');
                $att['username'] = $request->input('username');
                Application::create($att);

                return redirect()->route('forgetPW_show',$att['page']);
            }
        }else{
            $words = "沒有檔案 ？？";
            return view('layouts.error',compact('words'));
        }


    }

    public function forgetPW_show($page)
    {
        $application = Application::where('page','=',$page)->first();
        $data = [
            'application'=>$application,
        ];
        return view('forgetPW_show',$data);
    }
}
