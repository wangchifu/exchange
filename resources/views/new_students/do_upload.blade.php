@extends('layouts.master2')

@section('page-title',"新生名單 | 彰化縣學校文件交換系統")

@section('content')
    <h1>{{ $action->study_year }} {{ $action->name }}</h1>
            <h2>{{ $new_stu_data[0]['入學資格'] }}</h2>
    <h3>(共上傳 {{ $num }} 位學生，{{ $boy_num }} 男 {{ $girl_num }} 女。{{ $out_num }} 位學生超過生日區間)</h3>
    <span class="btn btn-dark disabled">步驟 (1)：上傳新生資料</span>　　<span class="btn btn-dark">步驟 (2)：修改姓名亂碼及填寫超出生日區間原因</span>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th nowrap>
                        序
                    </th>
                    <th nowrap>
                        學號
                    </th>
                    <th width="150" nowrap>
                        姓名
                    </th>
                    <th nowrap>
                        身份證號碼
                    </th>
                    <th nowrap>
                        生日
                    </th>
                    <th nowrap>
                        住址
                    </th>
                    <th width="250" nowrap>
                        原因
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                {{ Form::open(['route'=>'new_student.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
                @foreach($new_stu_data as $new_stu)
                    <?php $bgcolor = (empty($out[$new_stu['學號']]))?"":"#FFE8E8"; ?>
                <tr bgcolor="{{ $bgcolor }}">
                    <td>
                        {{ $i }}
                    </td>
                    <td nowrap>
                        {{ $new_stu['學號'] }}
                        <input type="hidden" name="stu_sn[{{ $new_stu['學號'] }}]" value="{{ $new_stu['學號'] }}">
                        @if($new_stu['性別']=="男")
                            <img src="{{ asset('img/boy.gif') }}">
                        @elseif($new_stu['性別']=="女")
                            <img src="{{ asset('img/girl.gif') }}">
                        @endif
                    </td>
                    <td nowrap>
                        @if($new_stu['性別']=="男")
                            {{ Form::text('stu_name['.$new_stu['學號'].']',$new_stu['姓名'], ['class' => 'form-control text-primary','required'=>'required']) }}
                        @elseif($new_stu['性別']=="女")

                            {{ Form::text('stu_name['.$new_stu['學號'].']',$new_stu['姓名'], ['class' => 'form-control text-danger','required'=>'required']) }}
                        @endif
                            <input type="hidden" name="stu_sex[{{ $new_stu['學號'] }}]" value="{{ $new_stu['性別'] }}">
                    </td>
                    <td>
                        {{ $new_stu['身分證字號'] }}
                        <input type="hidden" name="stu_id[{{ $new_stu['學號'] }}]" value="{{ $new_stu['身分證字號'] }}">
                    </td>
                    <td>
                        {{ $new_stu['生日'] }}
                        <input type="hidden" name="stu_birthday[{{ $new_stu['學號'] }}]" value="{{ $new_stu['生日'] }}">
                        <input type="hidden" name="stu_date[{{ $new_stu['學號'] }}]" value="{{ $new_stu['入學時間'] }}">
                        <input type="hidden" name="stu_school[{{ $new_stu['學號'] }}]" value="{{ $new_stu['入學資格'] }}">
                    </td>
                    <td>
                        {{ $new_stu['戶籍地址'] }}
                        <input type="hidden" name="stu_address[{{ $new_stu['學號'] }}]" value="{{ $new_stu['戶籍地址'] }}">
                    </td>
                    <td>
                        @if(!empty($out[$new_stu['學號']]))
                            {{ Form::text('stu_ps['.$new_stu['學號'].']',null, ['class' => 'form-control','placeholder'=>'填寫原因','required'=>'required']) }}
                        @endif
                    </td>
                </tr>
                    <?php $i++ ?>
                @endforeach
                </tbody>
            </table>
            <a href="#" class="btn btn-success" id="b_submit" onclick="bbconfirm3('store','確定姓名，原因都好了？')">步驟 (3)：確定寫入資料</a>
            <input type="hidden" name="action_id" value="{{ $action->id }}">
            {{ Form::close() }}
            <a href="#" class="btn btn-secondary" onclick="history.back();">返回放棄</a>
@endsection