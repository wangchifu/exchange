<?php

namespace App\Http\Controllers;

use App\Action;
use App\NewStuData;
use App\Upload;
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
        $stu_sn = $request->input('stu_sn');
        $stu_name = $request->input('stu_name');
        $stu_sex = $request->input('stu_sex');
        $stu_id = $request->input('stu_id');
        $stu_birthday = $request->input('stu_birthday');
        $stu_date = $request->input('stu_date');
        $stu_school = $request->input('stu_school');
        $stu_address = $request->input('stu_address');
        $stu_ps = $request->input('stu_ps');
        $att['action_id'] = $request->input('action_id');
        $att['user_id'] = auth()->user()->id;
        $att['username'] = auth()->user()->username;
        $att['group_id'] = auth()->user()->group_id;
        $create_all = [];
        $cellData =[['學號','姓名','性別','身分證字號','生日','入學時間','入學資格','戶籍地址','原因']];
        foreach($stu_sn as $k=>$v){
            $att['stu_sn'] = $stu_sn[$k];
            $att['stu_name'] = $stu_name[$k];
            $att['stu_sex'] = $stu_sex[$k];
            $att['stu_id'] = $stu_id[$k];
            $att['stu_birthday'] = $stu_birthday[$k];
            $att['stu_date'] = $stu_date[$k];
            $att['stu_school'] = $stu_school[$k];
            $att['stu_address'] = $stu_address[$k];
            if(empty($stu_ps[$k])){
                $att['stu_ps'] = "";
            }else{
                $att['stu_ps'] = $stu_ps[$k];
            }

            $new_one = [
                'user_id'=>$att['user_id'],
                'username'=>$att['username'],
                'group_id'=>$att['group_id'],
                'action_id'=>$att['action_id'],
                'stu_sn'=>$att['stu_sn'],
                'stu_name'=>$att['stu_name'],
                'stu_sex'=>$att['stu_sex'],
                'stu_id'=>$att['stu_id'],
                'stu_birthday'=>$att['stu_birthday'],
                'stu_date'=>$att['stu_date'],
                'stu_school'=>$att['stu_school'],
                'stu_address'=>$att['stu_address'],
                'stu_ps'=>$att['stu_ps'],
            ];
            array_push($create_all, $new_one);

            //寫入csv檔
            $csv = [$att['stu_sn'],$att['stu_name'],$att['stu_sex'],$att['stu_id'],$att['stu_birthday'],$att['stu_date'],$att['stu_school'],$att['stu_address'],$att['stu_ps']];
            array_push($cellData, $csv);
        }

        NewStuData::insert($create_all);



        $att2['action_id'] = $att['action_id'];
        $att2['user_id'] = $att['user_id'];
        $att2['username'] = $att['username'];
        $att2['file_name'] = $att['action_id']."_".auth()->user()->group_id."_".auth()->user()->username.".csv";
        $att2['upload_time'] = date("Y/m/d H:i:s");
        Upload::create($att2);

        $path = storage_path('app/public/uploads/'.$att['action_id']);
        Excel::create($att['action_id']."_".$att['group_id']."_".$att['username'],function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->store('csv',$path);

        return redirect()->route('new_student.index');
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
        $out = [];
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

            if($new_stu->group_id == "3" or $new_stu->group_id == "4"){
                if($stud_birthday<$birthday1 or $stud_birthday>$birthday2){
                    $out[$new_stu->stu_sn] = 1;
                    $out_num++;
                }
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
            'out'=>$out,
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
        if ($request->hasFile('csv')) {
            $file = $request->file('csv');
            $folder = 'uploads/'.$action->id;

            $info = [
                //'mime-type' => $file->getMimeType(),
                'original_filename' => $file->getClientOriginalName(),
                //'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getClientSize(),
            ];
            if ($info['size'] > 2100000)
            {
                $words = "檔案大小超過2MB ！？";
                return view('layouts.error',compact('words'));
            } else {
                //最後寫入即可
                //$filename = $action->id."_".auth()->user()->group_id."_".auth()->user()->username.".csv";
                //$file->storeAs('public/' . $folder, $filename);
            }
        }else{
            $words = "沒有檔案 ？？";
            return view('layouts.error',compact('words'));
        }

        Upload::where('user_id','=',auth()->user()->id)
            ->where('username','=',auth()->user()->username)
            ->where('action_id','=',$action->id)
            ->delete();

        NewStuData::where('user_id','=',auth()->user()->id)
            ->where('username','=',auth()->user()->username)
            ->where('group_id','=',auth()->user()->group_id)
            ->where('action_id','=',$action->id)
            ->delete();

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
            'file'=>$file,
        ];
        return view('new_students.do_upload',$data);
    }

    public function download_sample()
    {
        $filename = "newstud_sample.csv";
        $realFile = public_path('sample/newstud_sample.csv');
        //header("Content-type:application");
        //header("Content-Length: " .(string)(filesize($realFile)));
        //header("Content-Disposition: attachment; filename=".$filename);
        //readfile($realFile);

        return response()->download($realFile);
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
