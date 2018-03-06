@section('page-title',"新增公告 | 彰化縣學校文件交換系統")

@extends('layouts.master')

@section('content')
    <h1>新增公告</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Create Post
        </div>
        <div class="card-body">
        {{ Form::open(['route'=>'post.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
        <table class="table table-light">
            <tr>
                <th>
                    標題
                </th>
                <td>
                    {{ Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'placeholder' => '必填','required'=>'required']) }}
                </td>
            </tr>
            <tr>
               <th>
                   內容
               </th>
                <td>
                    <textarea name="content" class="form-control" placeholder="必填"></textarea>
                </td>
            </tr>
        </table>
        <a href="#" class="btn btn-success" onclick="bbconfirm('store','確定新增？')">送出</a>
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        {{ Form::close() }}
        </div>
    </div>
@endsection