<?php

namespace App\Http\Controllers;

use App\Action;
use App\NewStuData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $num = $new_stu_data->count();
        $boy_num = 0;
        $girl_num = 0;
        $out_num = 0;
        foreach($new_stu_data as $new_stu){
            if($new_stu->stu_sex == "男") $boy_num++;
            if($new_stu->stu_sex == "女") $girl_num++;

            //國小生日區間
            if($new_stu->group_id == "3"){
                $birthday1 = ($new_stu->action->study_year - 7)."0902";
                $birthday2 = ($new_stu->action->study_year - 6)."0901";
            }
            //國中生日區間
            if($new_stu->group_id == "4"){
                $birthday1 = ($new_stu->action->study_year - 13)."0902";
                $birthday2 = ($new_stu->action->study_year - 12)."0901";
            }
            $stud_birthday = str_replace('.','',$new_stu->stu_birthday);

            if($stud_birthday<$birthday1 or $stud_birthday>$birthday2){
                $out_num++;
            }
        }

        $data = [
            'new_stu_data'=>$new_stu_data,
            'action_name'=>$action_name,
            'study_year'=>$study_year,
            'num'=>$num,
            'boy_num'=>$boy_num,
            'girl_num'=>$girl_num,
            'out_num'=>$out_num,
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
            'action_id'=>$action_id,
        ];
        return view('new_students.upload',$data);
    }

    public function do_upload(Request $request,Action $action)
    {
        $filePath = $request->file('csv')->getRealPath();
        $new_stu_data = Excel::load($filePath, function ($reader) {
        })->get();

        $num = $new_stu_data->count();
        $boy_num = 0;
        $girl_num = 0;
        $out_num = 0;
        foreach($new_stu_data as $new_stu){
            $birth = explode(".",$new_stu['生日']);
            if(strlen($birth[0]) > 3 or strlen($birth[0]) < 2 or strlen($birth[1])<>2 or strlen($birth[2])<>2) {
                $words = $new_stu['學號'] . " " . $new_stu['姓名'] . "的生日格式不對「" . $new_stu['生日'] . "」！請修改後再上傳！正確格式為：民國年(2-3碼).月(2碼).日(2碼)：如-->96.10.07";
                return view('layouts.error',compact('words'));
            }

            if($new_stu['性別'] == "男") $boy_num++;
            if($new_stu['性別'] == "女") $girl_num++;

            //國小生日區間
            if(auth()->user()->group_id == "3"){
                $birthday1 = ($action->study_year - 7)."0902";
                $birthday2 = ($action->study_year - 6)."0901";
            }
            //國中生日區間
            if(auth()->user()->group_id == "4"){
                $birthday1 = ($action->study_year - 13)."0902";
                $birthday2 = ($action->study_year - 12)."0901";
            }
            $stud_birthday = str_replace('.','',$new_stu['生日']);

            if($stud_birthday<$birthday1 or $stud_birthday>$birthday2){
                $out[$new_stu['學號']] = 1;
                $out_num++;
            }
        }


        $data =[
            'action'=>$action,
            'new_stu_data'=>$new_stu_data,
            'num'=>$num,
            'boy_num'=>$boy_num,
            'girl_num'=>$girl_num,
            'out_num'=>$out_num,
            'out'=>$out,
        ];
        return view('new_students.do_upload',$data);
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
