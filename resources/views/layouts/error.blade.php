@extends('layouts.master')

@section('page-title',"有東西錯了 | 彰化縣學校文件交換系統")

@section('content')
  <h1>有東西錯了</h1>
  <div class="card card-outline-secondary my-4">
    <div class="card-header">
      Something is wrong...
    </div>
    <div class="card-body">
      <p class="text-danger">{{ $words }}</p>
      <a href="#" class="btn btn-secondary" onclick="history.back();">返回</a>
    </div>
  </div>
@endsection