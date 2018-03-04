@extends('layouts.master')

@section('page-title',"顯示上傳 | 彰化縣學校文件交換系統")

@section('content')
    <h1>系統管理 / 任務管理 / 顯示上傳</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            System / Action / Show Uploads
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-secondary" onclick="history.back();">返回管理</a>
            <br>
            <br>
            <h2>{{ $action->study_year }} {{ $action->name }}</h2>
            <h5>已上傳學校</h5>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        序
                    </th>
                    <th>
                        學校
                    </th>
                    <th>
                        上傳時間
                    </th>
                    <th colspan="3">
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;$has_upload=[]; ?>
                @foreach($uploads as $upload)
                <?php $bgcolor = (empty($upload->user->name))?"#FFE8E8":""; ?>
                <tr bgcolor="{{ $bgcolor }}">
                    <td>
                        {{ $i }}
                    </td>
                    <td>
                        @if(!empty($upload->user->name))
                        {{ $upload->user->name }}
                        @else
                            不明
                        @endif
                    </td>
                    <td>
                        {{ $upload->upload_time }}
                    </td>
                    <td>
                        @if($upload->action->kind == "newstud")
                            檢視
                        @endif
                    </td>
                    <td>
                        刪除
                    </td>
                    <td>
                        下載
                    </td>
                </tr>
                <?php $i++;array_push($has_upload,$upload->user_id); ?>
                @endforeach
                </tbody>
            </table>
            <h5>末上傳學校</h5>
            @foreach($schools as $k=>$v)
                @if(!in_array($k,$has_upload))
                    {{ $v }},
                @endif
            @endforeach
            <br>
            <br>
            <a href="#" class="btn btn-secondary" onclick="history.back();">返回管理</a>
        </div>
    </div>
@endsection