@section('page-title',"首頁 | 彰化縣學校文件交換系統")

@extends('layouts.master')

@section('content')
    <h1>最新公告</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            News @if(auth()->user()->group_id=="1")<a href="{{ route('post.create') }}" class="btn btn-success">新增公告</a>@endif
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="200">日期</th>
                    <th>公告標題</th>
                    <th width="120">發佈者</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>
                            {{ $post->created_at }}
                        </td>
                        <td>
                            <a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a>
                        </td>
                        <td>
                            {{ $post->user->name }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $posts->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    <a href="{{ route('about') }}" class="btn btn-info">系統教學</a>
@endsection