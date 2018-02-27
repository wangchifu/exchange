@extends('layouts.master')

@section('page-title',"帳號管理 | 彰化縣學校文件交換系統")

@section('content')
    <?php
    $active = [
        'action'=>'',
        'user'=>'',
        'group'=>''
    ];
    $page_at = explode('/',$_SERVER['REQUEST_URI']);
    $active[$page_at[2]] = "active";
    ?>
    <h1>系統管理 / 群組管理</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            System / Group
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $active['action'] }}" href="{{ route('system.action') }}">任務管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['user'] }}" href="{{ route('system.user') }}">帳號管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['group'] }}" href="{{ route('system.group') }}">群組管理</a>
                </li>
            </ul>
            <br>
            <table class="table table-light">
                <thead>
                <tr>
                    <th>
                        id
                    </th>
                    <th>
                        名稱
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    {{ Form::open(['route'=>'system.group_store', 'method' => 'POST','id'=>'group_store','onsubmit'=>'return false;']) }}
                    <td>
                    </td>
                    <td>
                        {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => '群組名稱','required'=>'required']) }}
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm('group_store','你確定要新增群組嗎？')">新增群組</a>
                    </td>
                    {{ Form::close() }}
                </tr>
                @foreach($groups as $group)
                {{ Form::open(['route'=>['system.group_update',$group->id], 'method' => 'PATCH','id'=>'group_update'.$group->id,'onsubmit'=>'return false;']) }}
                <tr>
                    <td>
                        {{ $group->id }}
                    </td>
                    <td>
                        @if($group->id != "1" and $group->id != "99")
                        {{ Form::text('name', $group->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => '群組名稱','required'=>'required']) }}
                        @else
                            {{ $group->name }}
                        @endif
                    </td>
                    <td>
                        @if($group->id != "1" and $group->id != "99")
                            <a href="#" class="btn btn-primary" onclick="bbconfirm('group_update{{ $group->id }}','你確定要儲存嗎？')">儲存修改</a>
                            <a href="{{ route('system.group_delete',$group->id) }}" class="btn btn-danger" id="delete{{ $group->id }}" onclick="bbconfirm2('delete{{ $group->id }}','確定要刪除？')">刪除群組</a>
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