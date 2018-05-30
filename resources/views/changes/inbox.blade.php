@extends('layouts.master')

@section('page-title',"學校交換收件匣 | 彰化縣學校文件交換系統")

@section('content')
    <h1>學校交換「收件匣」</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Change InBox  ( 檔案僅保留三個月 )
        </div>
        <div class="card-body">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="100">寄件時間</th>
                    <th width="120">寄件人</th>
                    <th nowrap>文件說明內容</th>
                    <th width="80">狀態</th>
                    <th width="80">動作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $page = explode('=',$_SERVER['REQUEST_URI']);
                if(empty($path[1])) $page[1]=1;
                ?>
                @foreach($changes as $change)
                <tr>
                    <td nowrap>
                        {{ substr($change->created_at,0,10) }}<br>
                        {{ substr($change->created_at,11,8) }}
                    </td>
                    <td nowrap>
                        <?php
                        $user = \App\User::where('id','=',$change->from)->first();
                        ?>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $change->title }}
                    </td>
                    <td nowrap>
                        @if($change->download == 1 or $change->download == 3)
                            <button title="" data-toggle="popover" data-placement="top" data-content="{{ $change->updated_at }} 下載">已下</button>
                        @elseif($change->download == 0 or $change->download == 2)
                            未下
                        @endif
                    </td>
                    <td>
                        @if($change->download < 2)
                        {{ Form::open(['route'=>['inbox_download',$change->id],'method'=>'post','id'=>'download'.$change->id,'onsubmit'=>'return false;']) }}
                        <a href="#" class="btn btn-primary" onclick="bbconfirm('download{{ $change->id }}','下載檔案？個資請妥善保存，勿留個人電腦「下載」資料夾！')">下載</a>
                        <input type="hidden" name="page" value="{{ $page[1] }}">
                        {{ Form::close() }}
                        @else
                            <a href="#" class="btn btn-warning">已失效</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $changes->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection