@extends('layouts.master')

@section('page-title',"新增任務 | 彰化縣學校文件交換系統")

@section('content')
    <?php
    $active = [
        'action'=>'',
        'user'=>'',
        'group'=>''
    ];
    $page_at = explode('/',$_SERVER['REQUEST_URI']);
    $active[$page_at[2]] = "active";
    ?>
    <h1>系統管理 / 新增任務</h1>
    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            System / Action
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $active['action'] }}" href="{{ route('system.action') }}">新增任務</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['user'] }}" href="{{ route('system.user') }}">帳號管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active['group'] }}" href="{{ route('system.group') }}">群組管理</a>
                </li>
            </ul>
        </div>
    </div>
@endsection