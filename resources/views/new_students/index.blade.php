@extends('layouts.master')

@section('page-title',"新生名單 | 彰化縣學校文件交換系統")

@section('content')
    <h1>新生名單</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            New Students
        </div>
        <div class="card-body">
            <table class="table table-light">
                <thead>
                <tr>
                    <th>
                        學年度
                    </th>
                    <th>
                        新生上傳任務名稱
                    </th>
                    <th>
                        限定檔案格式
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($actions as $action)
                <tr>
                    <td>
                        {{ $action->study_year }}
                    </td>
                    <td>
                        {{ $action->name }}
                    </td>
                    <td>
                        {{ $action->file_type }}
                    </td>
                    <td>

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection