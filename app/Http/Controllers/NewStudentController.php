<?php

namespace App\Http\Controllers;

use App\Action;
use App\NewStuData;
use Illuminate\Http\Request;

class NewStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = Action::where('groups','like',"%,".auth()->user()->group_id.",%")
            ->where('kind','=','newstud')
            ->orderBy('id','DESC')->paginate('10');
        $data = [
            'actions'=>$actions,
        ];
        return view('new_students.index',$data);
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
    public function show(Request $request)
    {
        $action_id = $request->input('action_id');
        $action_name = $request->input('action_name');
        $study_year = $request->input('study_year');
        $new_stu_data = NewStuData::where('username','=',auth()->user()->username)
            ->where('action_id','=',$action_id)
            ->orderby('stu_sn')
            ->get();
        $data = [
            'new_stu_data'=>$new_stu_data,
            'action_name'=>$action_name,
            'study_year'=>$study_year,
        ];
        return view('new_students.show',$data);
    }

    public function upload(Request $request)
    {
        $action_id = $request->input('action_id');
        $action_name = $request->input('action_name');
        $study_year = $request->input('study_year');
        $data = [
            'action_name'=>$action_name,
            'study_year'=>$study_year,
        ];
        return view('new_students.upload',$data);
    }

    public function download_sample()
    {
        $filename = "newstud_sample.csv";
        $realFile = public_path('sample/newstud_sample.csv');
        header("Content-type:application");
        header("Content-Length: " .(string)(filesize($realFile)));
        header("Content-Disposition: attachment; filename=".$filename);
        readfile($realFile);
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
