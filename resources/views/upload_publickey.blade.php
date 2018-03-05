@extends('layouts.master')

@section('page-title',"上傳公鑰 | 彰化縣學校文件交換系統")

@section('content')
    <h1>上傳公鑰</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Upload Public Key
        </div>
        <div class="card-body">
            <table class="table table-light">
                <thead>
                    <tr>
                        <th>
                            檔案
                        </th>
                        <th colspan="2">
                            動作
                        </th>
                    </tr>

                </thead>
                <tbody>
                {{ Form::open(['route' => 'store_publickey', 'method' => 'POST','name'=>'form1','id'=>'upload','files'=>true,'onsubmit'=>'return false;']) }}
                <tr>
                    <td>
                        <input type="file" name="file" class="form-control" required="required">
                    </td>
                    <td colspan="2">
                        <a href="#" class="btn btn-success" onclick="bbconfirm('upload','若曾上傳過，將覆蓋舊的公鑰喔！！')">上傳</a>
                    </td>
                </tr>
                {{ Form::close() }}
                <tr>
                    <td colspan="2">
                @if(auth()->user()->upload_time != "")
                        <img src="{{ asset('img/lock.png') }}">已上傳過公鑰，上傳時間為：{{ auth()->user()->upload_time }}
                    </td>
                    <td>
                        {{ Form::open(['route' => ['delete_publickey',auth()->user()->id], 'method' => 'POST','name'=>'form2','id'=>'delete','onsubmit'=>'return false;']) }}
                        <a href="#" class="btn btn-danger" onclick="bbconfirm('delete','當真要刪除？')">刪除</a>
                        {{ Form::close() }}
                @else
                    目前尚未上傳[公鑰]，無法與其他學校文件交換
                @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection