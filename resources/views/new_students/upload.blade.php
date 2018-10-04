@extends('layouts.master')

@section('page-title',"上傳新生名單 | 彰化縣學校文件交換系統")

@section('content')
    <h1>{{ $study_year }} {{ $action_name }}</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            <span class="btn btn-dark">步驟 (1)：上傳新生資料</span>　　<span class="btn btn-dark disabled">步驟 (2)：修改姓名亂碼及填寫超出生日區間原因</span>
        </div>
        <div class="card-body">
            <h4>說明：</h4>
            1.使用SFS3可直接下載：
            <a href="{{ asset('img/sfs3.png') }}" target="_blank"><img src="{{ asset('img/sfs3.png') }}" width="400"></a><br><br><br><br>
            2.未使用SFS3：<a href="{{ route('new_student.download_sample') }}" class="btn btn-info" target="_blank">下載範例檔</a>，修改存成csv檔。<br><br>
            3.<strong class="text-danger">切記，可以用 Microsoft Excel 等軟體打開檢視，但切勿存檔，生日及戶籍住址不可空白！姓名可在上傳後再修正！</strong><br><br>

            <br><br>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        新生檔案
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                {{ Form::open(['route'=>['new_student.do_upload',$action_id], 'method' => 'POST','id'=>'upload','files'=>true,'onsubmit'=>'return false;']) }}
                <tr>
                    <td>
                        <input type="file" name="csv">
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm3('upload','確定上傳嗎？會清除已上傳的喔！')">確定上傳</a>
                    </td>
                </tr>
                {{ Form::close() }}
                </tbody>
            </table>
        </div>
    </div>
@endsection