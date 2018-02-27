@extends('layouts.master')

@section('page-title',"任務管理 | 彰化縣學校文件交換系統")

@section('content')
    <?php
    $active = [
        'action'=>'',
        'user'=>'',
        'group'=>''
    ];
    $path = explode('?',$_SERVER['REQUEST_URI']);
    $page_at = explode('/',$path[0]);
    $active[$page_at[2]] = "active";
    ?>
    <h1>系統管理 / 任務管理</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            System / Action
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $active['action'] }}" href="{{ route('system.action') }}">任務管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['user'] }}" href="{{ route('system.user') }}">帳號管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['group'] }}" href="{{ route('system.group') }}">群組管理</a>
                </li>
            </ul>
            <table class="table table-hover">
                <thead>
                <th>
                    id
                </th>
                <th>
                    學年度
                </th>
                <th>
                    項目
                </th>
                <th>
                    任務名稱
                </th>
                <th>
                    指定檔案類型
                </th>
                <th>
                    對象
                </th>
                <th>
                    啟用？
                </th>
                <th>
                    動作
                </th>
                </thead>
                <tbody>
                @foreach($actions as $action)
                <tr>
                    <td>
                        {{ $action->id }}
                    </td>
                    <td>
                        {{ $action->study_year }}
                    </td>
                    <td>
                        {{ $action->kind }}
                    </td>
                    <td>
                        {{ $action->name }}
                    </td>
                    <td>
                        {{ $action->file_type }}
                    </td>
                    <td>
                        {{ $action->groups }}
                    </td>
                    <td>
                        {{ $action->enable }}
                    </td>
                    <td>

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $actions->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection