@extends('layouts.master')

@section('page-title',"系統管理 | 彰化縣學校文件交換系統")

@section('content')
    <?php
    $active = [
        'action'=>'',
        'user'=>'',
        'group'=>'',
        'application'=>''
    ];
    $path = explode('?',$_SERVER['REQUEST_URI']);
    $page_at = explode('/',$path[0]);
    $active[$page_at[2]] = "active";
    ?>
    <h1>系統管理 / 帳號管理</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            System / User
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $active['action'] }}" href="{{ route('system.action') }}">任務管理</a>
                </li>
                @if(auth()->user()->admin == "1")
                <li class="nav-item">
                    <a class="nav-link {{ $active['user'] }}" href="{{ route('system.user') }}">帳號管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['group'] }}" href="{{ route('system.group') }}">群組管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['application'] }}" href="{{ route('system.application') }}">密碼重設管理</a>
                </li>
                @endif
            </ul>
            <br>
            {{ Form::open(['route' => 'system.user', 'method' => 'GET']) }}
            {{ Form::select('group_id', $groups, $group_id, ['id' => 'group_id', 'class' => 'form-control','onchange'=>'if(this.value != 0) { this.form.submit(); }']) }}
            {{ Form::close() }}
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="150">群組</th>
                    <th>單位</th>
                    <th>帳號</th>
                    <th>動作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    {{ Form::open(['route'=>'system.user_store', 'method' => 'POST','id'=>'user_store','onsubmit'=>'return false;']) }}
                    <td>
                        {{ Form::select('group_id', $groups, null, ['id' => 'group_id', 'class' => 'form-control','required'=>'required']) }}
                    </td>
                    <td>
                        {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => '名稱','required'=>'required']) }}
                    </td>
                    <td>
                        {{ Form::text('username', null, ['id' => 'username', 'class' => 'form-control', 'placeholder' => '登入帳號','required'=>'required']) }}
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm('user_store','你確定要新增帳號嗎？')">新增帳號</a>
                    </td>
                    <input type="hidden" name="password" value="{{ bcrypt(env('DEFAULT_USER_PWD')) }}">
                    <input type="hidden" name="group_id" value="{{ $group_id }}">
                    {{ Form::close() }}
                </tr>
                @foreach($users as $user)
                    {{ Form::open(['route'=>['system.user_update',$user->id], 'method' => 'PATCH','id'=>'user_update'.$user->id,'onsubmit'=>'return false;']) }}
                    <tr>
                        <td>
                            {{ Form::select('group_id', $groups, null, ['id' => 'group_id', 'class' => 'form-control','required'=>'required']) }}
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>
                            {{ $user->username }}
                            @if($user->username=="root")
                                [超級使用者]
                            @endif
                            @if($user->group_id=="1" and $user->admin=="1" and $user->username != "root")
                                <a href="{{ route('system.user_disAdmin',$user->id) }}" id="disAdmin{{ $user->id }}" class="btn btn-warning" onclick="bbconfirm2('disAdmin{{ $user->id }}','取消超級使用者')">超級</a>
                            @endif
                            @if($user->group_id=="1" and $user->admin != "1")
                                <a href="{{ route('system.user_setAdmin',$user->id) }}" id="setAdmin{{ $user->id }}" class="btn btn-secondary" onclick="bbconfirm2('setAdmin{{ $user->id }}','確定改為超級使用者嗎？')">普通</a>
                            @endif
                        </td>
                        <td nowrap>
                            <a href="#" class="btn btn-info" onclick="bbconfirm('user_update{{ $user->id }}','儲存變更？')">儲存</a>
                            <?php $default = env('DEFAULT_USER_PWD'); ?>
                            <a href="{{ route('system.user_default',['user'=>$user->id,'pw'=>'demo1234']) }}" class="btn btn-primary" id="default{{ $user->id }}" onclick="bbprompt('default{{ $user->id }}',{{ $user->id }},'改密碼為多少')">還原預設</a>
                            @if($user->admin != "1")
                            <a href="{{ route('system.user_delete',$user->id) }}" class="btn btn-danger" id="delete{{ $user->id }}" onclick="bbconfirm2('delete{{ $user->id }}','真的要刪除！！？')">刪</a>
                            @endif
                        </td>
                    </tr>
                    {{ Form::close() }}
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection