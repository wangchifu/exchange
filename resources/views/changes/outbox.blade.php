@extends('layouts.master')

@section('page-title',"學校交換寄件匣 | 彰化縣學校文件交換系統")

@section('content')
    <h1>學校交換寄件匣</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            慎選學校
        </div>
        <div class="card-body">
            <table class="table table-light">
                <thead>
                <th width="300">
                    收件者<i class="text-danger">★</i>：
                </th>
                <th colspan="2">
                    說明<i class="text-danger">★</i>：
                </th>
                </thead>
                <tbody>
                {{ Form::open(['route'=>'outbox_store','files'=>true,'method'=>'post','id'=>'store','onsubmit'=>'return false;']) }}
                <tr>
                    <td>
                        {{ Form::select('for', $user_menu, null, ['id' => 'for', 'class' => 'form-control', 'placeholder' => '請選擇收件者','required'=>'required','onchange'=>'change()']) }}
                    </td>
                    <td>
                        {{ Form::text('title',null,['id'=>'title','class' => 'form-control', 'placeholder' => '檔案說明','required'=>'required']) }}
                    </td>
                    <td>

                    </td>
                </tr>
                </tbody>
                <thead>
                <th width="200">
                    確認收件者
                </th>
                <th colspan="2">
                    附檔<i class="text-danger">★</i>：( < 2MB )
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
                        <a href="#" class="btn btn-success" onclick="bbconfirm3('store','確定寄出？')">寄出</a>
                    </td>
                </tr>
                {{ Form::close() }}
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            寄件記錄( 半年內自動移除檔案 )
        </div>
        <div class="card-body">
            <table class="table table-light">
                <thead>
                <tr>
                    <th width="180">
                        寄件時間
                    </th>
                    <th width="120">
                        收件人
                    </th>
                    <th>
                        說明
                    </th>
                    <th>
                        狀態
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($changes as $change)
                    <tr>
                        <td nowrap>
                            {{ $change->created_at }}
                        </td>
                        <td nowrap>
                            <?php
                            $user = \App\User::where('id','=',$change->for)->first();
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
                    </tr>
                @endforeach
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