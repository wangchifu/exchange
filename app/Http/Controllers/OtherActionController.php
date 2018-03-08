<?php

namespace App\Http\Controllers;

use App\Action;
use App\Upload;
use Illuminate\Http\Request;

class OtherActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = Action::where('groups','like',"%,".auth()->user()->group_id.",%")
            ->where('kind','=','other')
            ->orderBy('id','DESC')->paginate('10');
        $data = [
            'actions'=>$actions,
        ];
        return view('other_actions.index',$data);
    }

    public function upload(Action $action)
    {
        $data = [
            'action'=>$action,
        ];
        return view('other_actions.upload',$data);
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
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $folder = 'uploads/'.$request->input('action_id');

            $info = [
                //'mime-type' => $file->getMimeType(),
                'original_filename' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getClientSize(),
            ];

            if($request->input('file_type') != "ok"){
                $file_type = $request->input('file_type');
            }else{
                $file_type = $info['extension'];
            }

            if ($info['size'] > 2100000) {
                $words = "檔案大小超過2MB ！？";
                return view('layouts.error', compact('words'));
            }elseif($info['extension'] != $file_type){
                $words = "檔案格式不是指定的 ".$request->input('file_type');
                return view('layouts.error', compact('words'));
            } else {
                $filename = $request->input('action_id')."_".auth()->user()->group_id."_".auth()->user()->username.".".$file_type;
                $file->storeAs('public/' . $folder, $filename);
            }
        }else{
            $words = "沒有檔案 ？？";
            return view('layouts.error',compact('words'));
        }

        $att['action_id'] = $request->input('action_id');
        $att['user_id'] = auth()->user()->id;
        $att['username'] = auth()->user()->username;
        $att['file_name'] = $att['action_id']."_".auth()->user()->group_id."_".auth()->user()->username.".".$file_type;
        $att['upload_time'] = date("Y/m/d H:i:s");

        $upload = Upload::where('user_id','=',auth()->user()->id)
            ->where('username','=',auth()->user()->username)
            ->where('action_id','=',$request->input('action_id'))
            ->first();

        if(!empty($upload)){
            $realFile = storage_path("app/public/uploads/".$upload->action_id."/".$upload->file_name);
            if(file_exists($realFile)) {
                unlink($realFile);
            }
            $upload->update($att);
        }else{
            Upload::create($att);
        }




        echo "<html><body>
			<script>
			opener.location.reload();
            window.close();
			</script>
			</body>
			</html>";
        exit;
    }

    public function download(Upload $upload)
    {
        if($upload->user_id == auth()->user()->id) {
            $file_path = $upload->action_id . "/" . $upload->file_name;
            $realFile = storage_path("app/public/uploads/" . $file_path);
            //header("Content-type:application");
            //header("Content-Length: " . (string)(filesize($realFile)));
            //header("Content-Disposition: attachment; filename=" . $upload->file_name);
            //readfile($realFile);
            return response()->download($realFile);

        }else{
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }
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
