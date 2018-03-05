@extends('layouts.master')

@section('page-title',"學校交換收件匣 | 彰化縣學校文件交換系統")

@section('content')
    <h1>學校交換收件匣</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Change InBox
        </div>
        <div class="card-body">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="200">時間</th>
                    <th>寄件人(帳號)</th>
                    <th>標題</th>
                    <th width="50">狀態</th>
                    <th>動作</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <script>
                function openwindow(url_str){
                    window.open (url_str,"閱讀信件","menubar=0,status=0,directories=0,location=0,top=20,left=20,toolbar=0,scrollbars=1,resizable=1,Width=800,Height=600");
                }

            </script>
        </div>
    </div>
@endsection