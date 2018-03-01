<?php

namespace App\Http\Controllers;

use App\Action;
use App\Group;
use App\User;
use App\UserBase;
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
