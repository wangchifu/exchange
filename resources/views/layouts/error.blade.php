@extends('layouts.master2')

@section('page-title',"錯誤 | 彰化縣學校文件交換系統")

@section('content')
  <h1>有東西錯了</h1>
  <div class="card card-outline-secondary my-4">
    <div class="card-header">
      Something is wrong...
    </div>
    <div class="card-body">
      <h2 class="text-danger">{{ $words }}</h2>
      <a href="#" class="btn btn-secondary" onclick="history.back();">返回</a>
    </div>
  </div>
@endsection