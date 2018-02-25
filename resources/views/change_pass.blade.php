@extends('layouts.master')

@section('page-title',"更改密碼 | 彰化縣學校文件交換系統")

@section('content')
    <h1>更改密碼</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            ChangePassword
        </div>
        <div class="card-body">
            {{ Form::open(['route' => ['update_pass',auth()->user()->id], 'method' => 'PATCH','name'=>'form1','id'=>'update','onsubmit'=>'return false;']) }}
            <table class="table table-light">
                <tbody>
                    <tr>
                        <th>
                            帳號
                        </th>
                        <td>
                            {{ auth()->user()->username }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            舊密碼
                        </th>
                        <td>
                            {{ Form::password('old_password', ['id' => 'old_password', 'class' => 'form-control','required'=>'required','placeholder' => '舊密碼']) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            新密碼
                        </th>
                        <td>
                            {{ Form::password('password1', ['id' => 'password1', 'class' => 'form-control','required'=>'required','placeholder' => '新密碼']) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            再一次新密碼
                        </th>
                        <td>
                            {{ Form::password('password2', ['id' => 'password2', 'class' => 'form-control','required'=>'required','placeholder' => '再一次新密碼','onchange'=>'p_checkpwd()']) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="#" class="btn btn-success" onclick="bbconfirm('update','確定要修改密碼？')">送出</a>
            {{ Form::close() }}
        </div>
    </div>
    <script>
        function p_checkpwd()
        {
            with(document.all){
                if(password1.value!=password2.value)
                {
                    bbalert('兩次密碼不同！');
                    password1.value = "";
                    password2.value = "";
                }
            }
        }
    </script>
@endsection