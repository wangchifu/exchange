<?php

namespace App\Http\Controllers;

use App\Action;
use App\Group;
use App\NewStuData;
use App\Post;
use App\Upload;
use App\User;
use App\UserBase;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function action()
    {
        if(auth()->user()->admin == "1") {
            $actions = Action::orderBy('id', 'DESC')->paginate('10');
        }elseif(auth()->user()->group_id == "1"){
            $actions = Action::where('user_id','=',auth()->user()->id)->orderBy('id', 'DESC')->paginate('10');
        }

        $groups = Group::where('id','<>','1')
            ->orderBy('id')
            ->get();
            //->pluck('name', 'id')->toArray();
        foreach($groups as $group){
            $groups_menu[$group->id] = $group->name."(".$group->id.")";
        }

        $kinds = [
            'newstud'=>'新生',
            'other'=>'其他'
        ];

        $file_types = [
            'csv'=>'csv',
            'pdf'=>'pdf',
            'xls'=>'xls',
            'ok'=>'不限'
        ];
        $data = [
            'actions'=>$actions,
            'kinds'=>$kinds,
            'groups_menu'=>$groups_menu,
            'file_types'=>$file_types,
        ];
        return view('systems.action',$data);
    }

    public function action_store(Request $request)
    {
        $att['study_year'] = $request->input('study_year');
        $att['kind'] = $request->input('kind');
        $att['name'] = $request->input('name');
        if($att['kind'] == "newstud") {
            $att['file_type'] = $request->input('file_type2');
        }else{
            $att['file_type'] = $request->input('file_type1');
        }
        $groups = ",";
        foreach($request->input('groups') as $k=>$v){
            $groups .= $v.",";
        }
        //$groups = substr($groups,0,-1);
        $att['groups'] = $groups;
        $att['enable'] = 1;
        $att['user_id'] = auth()->user()->id;
        Action::create($att);
        return redirect()->route('system.action');
    }

    public function action_destroy(Action $action)
    {
        $action->delete();
        return redirect()->route('system.action');
    }

    public function action_update(Request $request,Action $action)
    {
        $att['enable'] = $request->input('enable');
        $action->update($att);
        return redirect()->route('system.action');
    }

    public function show_upload($action_id)
    {
        $action = Action::where('id','=',$action_id)->first();

        if(auth()->user()->admin != "1" and auth()->user()->id != $action->user_id) {
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }

        $group_array = explode(',',$action->groups);
        $groups = [];
        foreach($group_array as $k=>$v){
            if(!empty($v)){
                array_push($groups,$v);
            }
        }

        $users = User::whereIn('group_id',$groups)
            ->orderBy('group_id')
            ->orderBy('username')
            ->get();
        foreach($users as $user){
            $schools[$user->id] = $user->name;
        }
        $uploads = Upload::where('action_id','=',$action->id)
            ->orderBy('username')
            ->get();
        $data = [
            'action'=>$action,
            'uploads'=>$uploads,
            'schools'=>$schools,
        ];
        return view('systems.show_upload',$data);
    }

    public function download(Upload $upload)
    {
        if(auth()->user()->admin == "1" or auth()->user()->id == $upload->action->user_id) {
            $file_path = $upload->action_id . "/" . $upload->file_name;
            $realFile = storage_path("app/public/uploads/" . $file_path);
            return response()->download($realFile);

        }else{
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }
    }

    public function downloadZip(Action $action)
    {
        if(auth()->user()->admin != "1" and auth()->user()->id != $action->user_id) {
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }

        $folder = storage_path('app/public/uploads/'.$action->id);
        //dd($folder);
        $zipper = new Zipper();
        $zipper->make($folder.'.zip')->add($folder)->close();;


        return response()->download(storage_path('app/public/uploads/'.$action->id.'.zip'));
    }


    public function show_one_upload(Request $request)
    {
        $upload_id = $request->input('upload_id');

        $upload = Upload::where('id','=',$upload_id)->first();

        if(auth()->user()->admin != "1" and auth()->user()->id != $upload->action->user_id) {
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }

        $new_stu_data = NewStuData::where('user_id','=',$upload->user_id)
            ->where('action_id','=',$upload->action_id)
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
            }else{
                $out_num = "不知";
            }
        }

        $data = [
            'new_stu_data'=>$new_stu_data,
            'action_name'=>$upload->action->name,
            'study_year'=>$upload->action->study_year,
            'num'=>$num,
            'boy_num'=>$boy_num,
            'girl_num'=>$girl_num,
            'out_num'=>$out_num,
            'out'=>$out,
        ];
        return view('new_students.show',$data);
    }

    public function delete_upload(Upload $upload)
    {
        if(auth()->user()->admin == "1" or auth()->user()->id == $upload->action->user_id) {
            $file_path = $upload->action_id . "/" . $upload->file_name;
            $realFile = storage_path("app/public/uploads/" . $file_path);
            if(file_exists($realFile)){
                unlink($realFile);
            }

            if($upload->action->kind == "newstud") {
                NewStuData::where('user_id', '=', $upload->user_id)
                    ->where('action_id', '=', $upload->action_id)
                    ->delete();
            }

            $upload->delete();


            return redirect()->route('system.show_upload',$upload->action_id);
        }else{
            $words = "你想做什麼？";
            return view('layouts.error',compact('words'));
        }
    }

    public function user(Request $request)
    {
        $groups = Group::all()->pluck('name', 'id')->toArray();
        $group_id = (empty($request->input('group_id')))?"1":$request->input('group_id');
        $users = User::where('group_id','=',$group_id)->get();

        $data = [
            'groups'=>$groups,
            'group_id'=>$group_id,
            'users'=>$users,
        ];
        return view('systems.user',$data);
    }

    public function user_store(Request $request)
    {
        if(empty($request->input('name'))) {
            $words = "名稱沒有填！";
            return view('layouts.error', compact('words'));
        }elseif(empty($request->input('username'))) {
            $words = "帳號沒有填！";
            return view('layouts.error', compact('words'));
        }else{
            $user = User::where('username','=',$request->input('username'))->first();
            if(!empty($user)){
                $words = "這帳號 ".$request->input('username')." 已經被使用了！";
                return view('layouts.error', compact('words'));
            }else{
                User::create($request->all());
                return redirect()->route('system.user',['group_id'=>$request->input('group_id')]);
            }
        }
    }

    public function user_update(Request $request,User $user)
    {
        $user->update($request->all());
        return redirect()->route('system.user',['group_id'=>$user->group_id]);
    }

    public function user_default(User $user)
    {
        $att['password'] = bcrypt(env('DEFAULT_USER_PWD'));
        $user->update($att);
        return redirect()->route('system.user',['group_id'=>$user->group_id]);
    }

    public function user_delete(User $user)
    {
        $user->delete();
        return redirect()->route('system.user',['group_id'=>$user->group_id]);
    }

    public function group()
    {
        $groups = Group::all();
        $data = [
            'groups'=>$groups,
        ];
        return view('systems.group',$data);
    }

    public function group_store(Request $request)
    {
        if(empty($request->input('name'))){
            $words = "群組名稱沒有填！";
            return view('layouts.error',compact('words'));
        }else{
            Group::create($request->all());
            return redirect()->route('system.group');
        }
    }

    public function group_update(Request $request,Group $group)
    {
        $group->update($request->all());
        return redirect()->route('system.group');
    }

    public function group_delete(Group $group)
    {
        $group->delete();
        $att['group_id'] = "99";
        User::where('group_id','=',$group->id)->update($att);
        return redirect()->route('system.group');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function post_create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_store(Request $request)
    {
        if(empty($request->input('title'))) {
            $words = "沒有標題 ？？";
            return view('layouts.error', compact('words'));
        }

        if(empty($request->input('content'))) {
            $words = "沒有內文 ？？";
            return view('layouts.error', compact('words'));
        }
        Post::create($request->all());
        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function post_show(Post $post)
    {
        return view('posts.show',compact('post'));
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
    public function post_destroy(Post $post)
    {
        if($post->user_id != auth()->user()->id) {
            $words = "你想做什麼 ？？";
            return view('layouts.error', compact('words'));
        }
        $post->delete();
        return redirect()->route('home');
    }
}
