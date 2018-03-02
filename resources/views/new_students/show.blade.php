@extends('layouts.master2')

@section('page-title',"新生名單 | 彰化縣學校文件交換系統")

@section('content')
    <h1>{{ $study_year }} {{ $action_name }}</h1>
            <a href="#" class="btn btn-dark" onclick="window.close();">關閉</a><br><br>
            <h2>{{ $new_stu_data[0]->stu_school }}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th nowrap>
                        序
                    </th>
                    <th nowrap>
                        學號
                    </th>
                    <th nowrap>
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
                    <th width="200" nowrap>
                        備註
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach($new_stu_data as $new_stu)
                <tr>
                    <td>
                        {{ $i }}
                    </td>
                    <td>
                        {{ $new_stu->stu_sn }}
                    </td>
                    <td nowrap>
                        @if($new_stu->stu_sex=="男")
                            <img src="{{ asset('img/boy.gif') }}"><span class="text-primary">{{ $new_stu->stu_name }}</span>
                        @elseif($new_stu->stu_sex=="女")
                            <img src="{{ asset('img/girl.gif') }}"><span class="text-danger">{{ $new_stu->stu_name }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $new_stu->stu_id }}
                    </td>
                    <td>
                        {{ $new_stu->stu_birthday }}
                    </td>
                    <td>
                        {{ $new_stu->stu_address }}
                    </td>
                    <td>
                        {{ $new_stu->stu_ps }}
                    </td>
                </tr>
                    <?php $i++ ?>
                @endforeach
                </tbody>
            </table>
            <a href="#" class="btn btn-dark" onclick="window.close();">關閉</a>
@endsection