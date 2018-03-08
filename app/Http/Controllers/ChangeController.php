<?php

namespace App\Http\Controllers;

use App\Change;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inbox()
    {
        $changes = Change::where('for','=',auth()->user()->id)
            ->orderBy('id','DESC')
            ->paginate(10);
        $data = [
            'changes'=>$changes,
        ];

        return view('changes.inbox',$data);
    }

    public function inbox_download(Change $change)
    {
        if(auth()->user()->id == $change->for) {
            $att['download'] = 1;
            $change->update($att);

            $realFile = storage_path("app/public/changes/" . $change->file);

            return response()->download($realFile);
            header("location: index.php");
        }else{
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }
    }

    public function outbox()
    {
        $user_menu = User::where('public_key','!=','')
            ->orderBy('group_id')
            ->orderBy('username')
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        $changes = Change::where('from','=',auth()->user()->id)
            ->orderBy('id','DESC')
            ->get();

        $data = [
            'user_menu'=>$user_menu,
            'changes'=>$changes,
        ];
        return view('changes.outbox',$data);
    }

    public function outbox_store(Request $request)
    {
        if(empty($request->input('for'))) {
            $words = "沒有收件者 ？？";
            return view('layouts.error', compact('words'));
        }

        if(empty($request->input('title'))) {
            $words = "沒有說明 ？？";
            return view('layouts.error', compact('words'));
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $info = [
                //'mime-type' => $file->getMimeType(),
                'original_filename' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getClientSize(),
            ];


            if ($info['size'] > 2100000) {
                $words = "檔案大小超過2MB ！？";
                return view('layouts.error', compact('words'));
            } else {
                $att['from'] = auth()->user()->id;
                $att['for'] = $request->input('for');
                $att['title'] = $request->input('title');
                $att['file'] = date("YmdHis") .".". $info['extension'];
                $att['download'] = 0;
                $folder = 'changes';

                $file->storeAs('public/' . $folder, $att['file']);
                $change = Change::create($att);

                //$gpg = new gnupg();
                //$info = $gpg -> import($keydata);
                //print_r($info);

                $gpg = '/usr/bin/gpg';

                $user= User::where('id','=',$request->input('for'))->first();
                $recipient = $user->key_id;

                $secret_file = storage_path('app/public/changes/'.$att['file']);

                $process = new Process("$gpg --encrypt --recipient $recipient --trust-model always $secret_file");
                $process->run();
                unlink($secret_file);

                $att2['file'] = $att['file'].".gpg";
                $change->update($att2);
            }
        }else{
            $words = "沒有檔案 ？？";
            return view('layouts.error',compact('words'));
        }
        return redirect()->route('outbox');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
