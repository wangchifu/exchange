@extends('layouts.master2')

@section('page-title',"忘記密碼 | 彰化縣學校文件交換系統")

@section('content')
    <h1>忘記密碼</h1>
    <a href="{{ route('home') }}" class="btn btn-secondary">返回</a>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Forget Password
        </div>
        <div class="card-body">
            1.下載「重設密碼」申請書<br>
            <a href="{{ route('download_pdf') }}" class="btn btn-info">按此下載</a>
            <br>
            <br>
            2.上傳核章好之申請書照片(掃瞄圖檔)
            {{ Form::open(['route'=>'upload_pic', 'method' => 'POST','files'=>true,'id'=>'upload','onsubmit'=>'return false;']) }}
            <input type="file" name="file">
            <a href="#" class="btn btn-success" onclick="bbconfirm('upload','確定上傳？')">上傳</a>
            {{ Form::close() }}
            <br>
            3.打電話通知系統管理人員辦理更改密碼作業。
        </div>
    </div>
@endsection