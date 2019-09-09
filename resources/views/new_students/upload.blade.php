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
            方法1.使用cloudschool可直接下載，立即上傳：
            <a href="{{ asset('img/cloudschool.png') }}" target="_blank"><img src="{{ asset('img/cloudschool.png') }}" width="400"></a><br><br><br><br>
            方法2.亦可 <a href="{{ route('new_student.download_sample') }}" class="btn btn-info" target="_blank">下載範例檔</a>，修改後儲存檔案。<br><br>
            ps.<strong class="text-danger">使用方法2，可以用 Microsoft Excel 等軟體打開檢視，但會是亂碼，請參考 [<a href="http://support.kktix.com/knowledgebase/articles/278363-%E7%82%BA%E4%BD%95%E4%BD%BF%E7%94%A8-microsoft-excel-%E6%89%93%E9%96%8B%E5%8C%AF%E5%87%BA%E7%9A%84%E5%A0%B1%E5%90%8D%E4%BA%BA-csv-%E6%AA%94%E6%A1%88%E6%98%AF%E4%BA%82%E7%A2%BC" target="_blank">教學</a>] 後，再動手。</strong><br><br>

            <br><br>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        新生檔案(xlsx檔)
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
                        <input type="file" name="xlsx">
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