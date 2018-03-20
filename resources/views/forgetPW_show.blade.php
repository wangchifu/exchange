@extends('layouts.master2')

@section('page-title',"忘記密碼申請中 | 彰化縣學校文件交換系統")

@section('content')
    <?php $URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
    <h2>請記下此頁網址，或加入書籤備查。</h2>
    <h4>{{ $URL }}</h4>
    申請時間：{{ $application->created_at }}<br>
    處理狀況：
    @if($application->action == "1") <button class="btn btn-danger">申請中...</button> @endif
    @if($application->action == "2") <button class="btn btn-warning">退回申請@@</button> @endif
    @if($application->action == "3") <button class="btn btn-success">處理完畢!!!</button> @endif
    <br><br>
    打電話給管理人員了沒？<br>
    <img src="{{ url('pic/'.$application->pic) }}" width="400">
@endsection