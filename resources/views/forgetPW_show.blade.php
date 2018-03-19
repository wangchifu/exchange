@extends('layouts.master2')

@section('page-title',"忘記密碼申請中 | 彰化縣學校文件交換系統")

@section('content')
    <h2>請記下此頁網址，或加入書籤備查。</h2>
    申請時間：{{ $application->created_at }}<br>
    處理狀況：
    @if($application->action == "1") 申請中... @endif
    @if($application->action == "2") 退回申請@@ @endif
    @if($application->action == "3") 處理完畢!!! @endif
    <br><br>
    打電話給管理人員了沒？<br>
    <img src="{{ url('pic/'.$application->pic) }}" width="400">
@endsection