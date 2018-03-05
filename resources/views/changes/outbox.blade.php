@extends('layouts.master')

@section('page-title',"學校交換寄件匣 | 彰化縣學校文件交換系統")

@section('content')
    <h1>學校交換寄件匣</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Change InBox
        </div>
        <div class="card-body">
            <table class="table table-light">
                <thead>
                <th width="300">
                    收件者：
                </th>
                <th colspan="2">
                    說明：
                </th>
                </thead>
                <tbody>
                {{ Form::open(['route'=>'inbox_store','method'=>'post','id'=>'store','onsubmit'=>'return false;']) }}
                <tr>
                    <td>
                        {{ Form::select('for', $user_menu, null, ['id' => 'for', 'class' => 'form-control', 'placeholder' => '請選擇收件者','required'=>'required','onchange'=>'change()']) }}
                    </td>
                    <td>
                        {{ Form::text('title',null,['id'=>'title','class' => 'form-control', 'placeholder' => '檔案說明','required'=>'required']) }}
                    </td>
                </tr>
                </tbody>
                <thead>
                <th colspan="3" width="200">
                    附檔：
                </th>
                </thead>
                <tbody>
                <tr>
                    <td nowrap>
                        <h3 class="text-danger" id="school"></h3>
                    </td>
                    <td>
                        <input type="file" name="file" class="form-control" required="required">
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm('store','確定寄出？')">寄出</a>
                    </td>
                </tr>
                {{ Form::close() }}
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function change() {
            var x=document.getElementById('for');
            document.getElementById('school').innerText = '給 '+ x.options[x.selectedIndex].text;
        }
    </script>
@endsection