@extends('layouts.master')

@section('page-title',"任務管理 | 彰化縣學校文件交換系統")

@section('content')
    <?php
    $active = [
        'action'=>'',
        'user'=>'',
        'group'=>''
    ];
    $path = explode('?',$_SERVER['REQUEST_URI']);
    $page_at = explode('/',$path[0]);
    $active[$page_at[2]] = "active";
    ?>
    <h1>系統管理 / 任務管理</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            System / Action
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
                @endif
            </ul>
            <table class="table table-hover">
                <thead>
                <th width="80">
                    學年度
                </th>
                <th width="100">
                    項目
                </th>
                <th>
                    任務名稱
                </th>
                <th width="100">
                    請選檔案
                </th>
                <th width="160">
                    對象(可多選)
                </th>
                <th colspan="2">
                    狀態
                </th>
                </thead>
                <tbody>
                {{ Form::open(['route'=>'system.action_store', 'method' => 'POST','id'=>'action_store','onsubmit'=>'return false;']) }}
                <tr>
                    <td>
                        {{ Form::text('study_year', null, ['id' => 'study_year', 'class' => 'form-control', 'placeholder' => '學年','required'=>'required']) }}
                    </td>
                    <td>
                        {{ Form::select('kind', $kinds, null, ['id' => 'kind', 'class' => 'form-control','required'=>'required','onchange'=>'change_file_type();']) }}
                    </td>
                    <td>
                        {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => '項目名稱','required'=>'required']) }}
                    </td>
                    <td>
                        {{ Form::select('file_type1', $file_types, null, ['id' => 'file_types', 'class' => 'form-control','required'=>'required','style'=>'display:none']) }}
                        {{ Form::text('file_type2','csv', ['id' => 'newstud_file', 'class' => 'form-control','readonly'=>'readonly','required'=>'required']) }}
                    </td>
                    <td>
                        {{ Form::select('groups[]', $groups_menu, null, ['id' => 'groups[]', 'class' => 'form-control','multiple'=>'multiple','required'=>'required']) }}
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm('action_store','確定？')">新增</a>
                    </td>
                </tr>
                {{ Form::close() }}
                <script>
                    function change_file_type() {
                        if(document.getElementById('kind').value=='newstud')
                        {
                            $("#file_types").hide();
                            $("#newstud_file").show();
                        }else{
                            $("#file_types").show();
                            $("#newstud_file").hide();
                        }
                    }
                </script>
                @foreach($actions as $action)
                <tr>
                    <td>
                        {{ $action->study_year }}
                    </td>
                    <td>
                        @if($action->kind == "newstud")
                            <p class="text-info font-weight-bold">新生</p>
                        @else
                            其他
                        @endif
                    </td>
                    <td>
                        {{ $action->name }}
                    </td>
                    <td>
                        @if($action->file_type == "ok")
                            不限
                        @else
                            {{ $action->file_type }}
                        @endif
                    </td>
                    <td>
                        {{ $action->groups }}
                    </td>
                    <td nowrap>
                        @if($action->enable == "1")
                        <a href="#" class="btn btn-info">已啟</a>
                        @else
                            <a href="#" class="btn btn-warning">已停</a>
                        @endif
                    </td>
                    <td>
                        {{ Form::open(['route'=>['system.action_destroy',$action->id], 'method' => 'DELETE','id'=>'action_destroy'.$action->id,'onsubmit'=>'return false;']) }}
                        <a href="#" class="btn btn-danger" onclick="bbconfirm('action_destroy{{ $action->id }}','確定刪除？')">刪</a>
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $actions->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection