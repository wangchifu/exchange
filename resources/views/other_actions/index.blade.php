@extends('layouts.master')

@section('page-title',"新生名單 | 彰化縣學校文件交換系統")

@section('content')
    <h1>新生名單</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            New Students
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        學年
                    </th>
                    <th>
                        新生上傳任務名稱
                    </th>
                    <th>
                        檔案
                    </th>
                    <th>
                        上傳時間
                    </th>
                    <th>
                        狀態
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($actions as $action)
                <tr>
                    <td>
                        {{ $action->study_year }}
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
                        <?php
                        $upload = \App\Upload::where('action_id','=',$action->id)
                            ->where('user_id','=',auth()->user()->id)->first();
                        ?>
                        @if(!empty($upload))
                        <img src="{{ asset('img/check.png') }}">{{ $upload->upload_time }}
                        @else
                        尚未上傳
                        @endif
                    </td>
                    <td>
                        @if($action->enable == "1")
                            <p class="text-primary">開啟</p>
                        @else
                            關閉
                        @endif
                    </td>
                    <td>
                        @if($action->enable == "1")
                            @if(empty($upload))
                            <a href="#" class="btn btn-success">上傳</a>
                            @else
                            <a href="#" class="btn btn-warning">修改</a>
                            @endif
                        @else
                            <a href="#" class="btn btn-info">檢視</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $actions->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection