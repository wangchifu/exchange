@extends('layouts.master')

@section('page-title',"密碼重設管理 | 彰化縣學校文件交換系統")

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
    <h1>系統管理 / 密碼重設管理</h1>
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
            <h5 class="text-danger">請務必核對「申請者代號」和「申請書」是否一致！</h5>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="110" nowrap>
                        申請時間
                    </th>
                    <th nowrap>
                        申請者代號
                    </th>
                    <th nowrap>
                        申請書
                    </th>
                    <th nowrap>
                        ip
                    </th>
                    <th nowrap>
                        處理者
                    </th>
                    <th width="140" nowrap>
                        狀態
                    </th>
                    <th width="140" nowrap>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($applications as $application)
                    {{ Form::open(['route' => 'system.application_update', 'method' => 'POST','id'=>'update'.$application->id,'onsubmit'=>'return false;']) }}
                    <tr>
                        <td>
                            {{ $application->created_at }}
                        </td>
                        <td>
                            {{ $application->username }}
                            <input type="hidden" name="username" value="{{ $application->username }}">
                        </td>
                        <td>
                            <a href="#" class="btn btn-info" onclick="openwindow('{{ route('system.application_view',$application->pic) }}')">檢視</a>
                        </td>
                        <td>
                            {{ $application->ip }}
                        </td>
                        <td>
                            @if(!empty($application->user_id))
                            {{ $application->user->name }}
                            @endif
                        </td>
                        <td>
                            <?php
                            $action = ['1'=>'申請中','2'=>'退回申請','3'=>'處理完畢'];
                            ?>
                            @if($application->action == "1")
                                {{ Form::select('action', $action, $application->action, ['id' => 'action', 'class' => 'form-control']) }}
                            @elseif($application->action == "2")
                                <img src="{{ asset('img/cross.png') }}" width="16">退回申請
                            @elseif($application->action == "3")
                                <img src="{{ asset('img/ok.png') }}" width="16">處理完畢
                            @endif
                        </td>
                        <td nowrap>
                            @if($application->action == "1")
                            <a href="#" class="btn btn-success" onclick="bbconfirm('update{{ $application->id }}','確定嗎？')">執行</a>
                            @endif
                            <!---
                            <a href="{{ route('system.application_delete',$application->id) }}" id="del{{ $application->id }}" class="btn btn-danger" onclick="bbconfirm2('del{{ $application->id }}','確定刪除？')">刪除</a>
                            --->
                        </td>
                    </tr>
                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                    {{ Form::close() }}
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function openwindow(url_str){
            window.open (url_str,"檢視","menubar=0,status=0,directories=0,location=0,top=20,left=20,toolbar=0,scrollbars=1,resizable=1,Width=800,Height=400");
        }

    </script>
@endsection