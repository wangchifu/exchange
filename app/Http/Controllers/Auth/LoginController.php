<?php

namespace App\Http\Controllers\Auth;

use App\Change;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
}
