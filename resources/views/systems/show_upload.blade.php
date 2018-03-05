@extends('layouts.master')

@section('page-title',"顯示上傳 | 彰化縣學校文件交換系統")

@section('content')
    <h1>系統管理 / 任務管理 / 顯示上傳</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            System / Action / Show Uploads
        </div>
        <div class="card-body">
            <a href="{{ route('system.action') }}" class="btn btn-secondary">返回管理</a>
            <br>
            <br>
            <h2>{{ $action->study_year }} {{ $action->name }}
                @if($action->uploads->count() != 0)
                <a href="{{ route('system.downloadZip',$action->id) }}" class="btn btn-primary">下載全部</a>
                @endif
            </h2>
            <h5><img src="{{ asset('img/ok.png') }}">已上傳學校名單</h5>
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
                            {{ Form::open(['route'=>'system.show_one_upload', 'method' => 'POST','id'=>'show'.$upload->id,'target'=>'_blank']) }}
                            <a href="#" class="btn btn-info" onclick="document.getElementById('show{{ $upload->id }}').submit();">檢視</a>
                            <input type="hidden" name="upload_id" value="{{ $upload->id }}">
                            {{ Form::close() }}
                        @endif
                    </td>
                    <td>
                            <a href="{{ route('system.download',$upload->id) }}" class="btn btn-primary">下載</a>
                    </td>
                    <td>
                        {{ Form::open(['route'=>['system.delete_upload',$upload->id], 'method' => 'DELETE','id'=>'delete'.$upload->id,'onsubmit'=>'return false;']) }}
                        <a href="#" class="btn btn-danger" onclick="bbconfirm('delete{{ $upload->id }}','你真的要刪除？')">刪除</a>
                        {{ Form::close() }}
                    </td>
                </tr>
                <?php $i++;array_push($has_upload,$upload->user_id); ?>
                @endforeach
                </tbody>
            </table>
            <br>
            <br>
            <h5><img src="{{ asset('img/cross.png') }}">未上傳學校名單</h5>
            <?php
                $no_schools = "";
            foreach($schools as $k=>$v){
                if(!in_array($k,$has_upload)){
                    $no_schools .= $v.",";
                }
            }
            if(empty($no_schools)) $no_schools = "無";
            ?>
            <button class="btn btn-info" data-clipboard-action="copy" data-clipboard-target="#foo">複製未完成學校</button>
            <script src="{{ asset('js/clipboard.min.js') }}"></script>
            <script>
                var clipboard = new ClipboardJS('.btn');

                clipboard.on('success', function(e) {
                    console.log(e);
                    bbalert('複製成功！');
                });

                clipboard.on('error', function(e) {
                    console.log(e);
                });
            </script>
            <div id="foo">{{ $no_schools }}</div>
            <br>
            <br>
            <a href="{{ route('system.action') }}" class="btn btn-secondary">返回管理</a>
        </div>
    </div>
@endsection