@section('page-title',"公告 | 彰化縣學校文件交換系統")

@extends('layouts.master')

@section('content')
    <h1>觀看公告</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Show Post @if(auth()->user()->group_id==$post->user_id)<a href="{{ route('post.destroy',$post->id) }}" class="btn btn-danger" id="delete" onclick="bbconfirm2('delete','當真要刪除？')">刪除公告</a>@endif
        </div>
        <div class="card-body">
        {{ Form::open(['route'=>'post.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
        <table class="table table-light">
            <tr>
                <th width="100">
                    張貼
                </th>
                <td>
                    {{ $post->user->name }} ({{ $post->created_at }})
                </td>
            </tr>
            <tr>
                </th>
                <th>
                    標題
                </th>
                <td class="text-left">
                    {{ $post->id }}
                </td>
            </tr>
            <tr>
               <th>
                   內容
               </th>
                <td class="text-left">
                    <?php $content = str_replace(chr(13) . chr(10), '<br>', $post->content);?>
                    {!! $content !!}
                </td>
            </tr>
        </table>
        <a href="#" class="btn btn-secondary" onclick="history.go(-1);">返回</a>
        </div>
    </div>
@endsection