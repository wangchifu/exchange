@extends('layouts.master')

@section('page-title',"關於 | 彰化縣學校文件交換系統")

@section('content')
    <h1>系統教學</h1>
    <a href="{{ route('home') }}" class="btn btn-secondary">返回</a>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            About
        </div>
        <div class="card-body">
            <p>
                這個系統是由和東國小資訊組長撰寫，願此系統的成立，可以讓本縣各學校完成各項文件交換的任務。
                有系統上的問題可以使用公務電話聯繫；而上傳任務的內容問題，請與該承辦人員聯繫。
            </p>
        </div>
    </div>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            windows 系統 金鑰生成與交換檔案
        </div>
        <div class="card-body">
            <video src="{{ asset('mov/windows-GPG.mp4') }}" controls width="100%">
                沒有支援這個影片播放，請更換瀏覽器
            </video>
        </div>
    </div>
@endsection