@extends('layouts.master')

@section('page-title',"學校交換收件匣 | 彰化縣學校文件交換系統")

@section('content')
    <h1>學校交換收件匣</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Change InBox ( 1年後自動移除檔案)
        </div>
        <div class="card-body">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="200">時間</th>
                    <th>寄件人</th>
                    <th>標題</th>
                    <th>狀態</th>
                    <th width="50">動作</th>
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
                        {{ $change->created_at }}
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
                        <?php
                        if($change->download == 1){
                            $d = $change->updated_at."已下載";
                        }else{
                            $d = "未曾下載";
                        }
                        ?>
                        {{ $d }}
                    </td>
                    <td>
                        {{ Form::open(['route'=>['inbox_download',$change->id],'method'=>'post','id'=>'download'.$change->id,'onsubmit'=>'return false;']) }}
                        <a href="#" class="btn btn-primary" onclick="bbconfirm('download{{ $change->id }}','下載檔案？個資請妥善保存，勿留個人電腦「下載」資料夾！')">下載</a>
                        <input type="hidden" name="page" value="{{ $page[1] }}">
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $changes->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection