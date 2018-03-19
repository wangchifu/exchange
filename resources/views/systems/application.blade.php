@extends('layouts.master')

@section('page-title',"申請密碼 | 彰化縣學校文件交換系統")

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
    <h1>系統管理 / 申請改密</h1>
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
                    <a class="nav-link {{ $active['application'] }}" href="{{ route('system.application') }}">申請改密</a>
                </li>
                @endif
            </ul>
            <br>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        申請時間
                    </th>
                    <th>
                        申請書
                    </th>
                    <th>
                        ip
                    </th>
                    <th>
                        處理者
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>
                            {{ $application->created_at }}
                        </td>
                        <td>
                            <a href="#" class="btn btn-info" onclick="openwindow('{{ route('system.application_view',$application->pic) }}')">檢視</a>
                        </td>
                        <td>
                            {{ $application->ip }}
                        </td>
                        <td>
                            {{ $application->user_id }}
                        </td>
                        <td>
                            {{ $application->action }}
                        </td>
                    </tr>
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