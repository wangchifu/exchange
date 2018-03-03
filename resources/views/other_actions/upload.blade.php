@extends('layouts.master2')

@section('page-title',"新生名單 | 彰化縣學校文件交換系統")

@section('content')
    <h1>{{ $action->study_year }} {{ $action->name }}</h1>

    {{ Form::open(['route'=>'other_action.store', 'method' => 'POST','files'=>true,'id'=>'store','onsubmit'=>'return false;']) }}
    <input type="file" name="file">
    <a href="#" class="btn btn-success" onclick="bbconfirm('store','確定上傳檔案？單檔不得超過2MB，格式為 {{ $action->file_type }}')">上傳檔案</a>
    <input type="hidden" name="action_id" value="{{ $action->id }}">
    <input type="hidden" name="file_type" value="{{ $action->file_type }}">
    {{ Form::close() }}
    <a href="#" class="btn btn-secondary" onclick="window.close();">關閉放棄</a>
@endsection