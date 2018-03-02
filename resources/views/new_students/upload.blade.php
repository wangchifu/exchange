@extends('layouts.master')

@section('page-title',"上傳新生名單 | 彰化縣學校文件交換系統")

@section('content')
    <h1>{{ $study_year }} {{ $action_name }}</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            步驟(1/2)：上傳新生資料
        </div>
        <div class="card-body">
            <h4>說明：</h4>
            1.使用SFS3可直接下載：
            <a href="{{ asset('img/sfs3.png') }}" target="_blank"><img src="{{ asset('img/sfs3.png') }}" width="400"></a><br><br><br><br>
            2.未使用SFS3：<a href="{{ route('new_student.download_sample') }}" class="btn btn-info" target="_blank">下載範例檔</a>，修改存成csv檔。
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
                <tr>
                    <td>
                        <input type="file" name="file">
                    </td>
                    <td>
                        <a href="#" class="btn btn-success">確定上傳</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection