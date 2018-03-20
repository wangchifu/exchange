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
            <table class="table table-hover">
                <thead>
                <tr>
                    <th nowrap>
                        學校六碼帳號
                    </th>
                    <th nowrap>
                        新密碼(8碼以上)
                    </th>
                    <th nowrap>
                        重複新密碼
                    </th>
                    <th nowrap>
                        申請書圖檔
                    </th>
                    <th nowrap>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="username" class="form-control" placeholder="六碼帳號" maxlength="6">
                    </td>
                    <td>
                        <input type="password" id="pw1" class="form-control" name="pw1" placeholder="新密碼">
                    </td>
                    <td>
                        <input type="password" id="pw2" class="form-control" name="pw2" placeholder="重複密碼" onchange="p_checkpwd()">
                    </td>
                    <td>
                        <input type="file" name="file">
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm('upload','確定上傳？')">上傳</a>
                    </td>
                </tr>
                </tbody>
            </table>
            {{ Form::close() }}
            3.打電話通知系統管理人員辦理更改密碼作業。<br>
        </div>
    </div>
    <script>
        function p_checkpwd()
        {
            with(document.all){
                if(pw1.value!=pw2.value)
                {
                    bbalert('兩次密碼不同！');
                    pw1.value = "";
                    pw2.value = "";
                }
                if( pw2.value.length < 8 ){
                    bbalert('密碼少於八碼！');
                    pw1.value = "";
                    pw2.value = "";
                }
            }
        }
    </script>
@endsection