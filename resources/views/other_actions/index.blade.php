@extends('layouts.master')

@section('page-title',"其他任務 | 彰化縣學校文件交換系統")

@section('content')
    <h1>其他任務</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Other Actions
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th nowrap>
                        學年
                    </th>
                    <th nowrap>
                        任務名稱
                    </th>
                    <th nowrap>
                        檔案
                    </th>
                    <th nowrap>
                        上傳時間
                    </th>
                    <th nowrap>
                        狀態
                    </th>
                    <th nowrap colspan="2">
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
                            <a href="#" class="btn btn-success" onclick="openwindow('{{ route('other_action.upload',$action->id) }}')">上傳</a>
                        @endif
                    </td>
                    <td>
                        @if(!empty($upload))
                            <a href="{{ route('other_action.download',$upload->id) }}" class="btn btn-primary">下載</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $actions->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    <script>
        function openwindow(url_str){
            window.open (url_str,"上傳檔案","menubar=0,status=0,directories=0,location=0,top=20,left=20,toolbar=0,scrollbars=1,resizable=1,Width=800,Height=400");
        }

    </script>
@endsection