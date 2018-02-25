<?php

$active = [
    'home'=>"",
    'freshman'=>"",
    'graduate'=>"",
    'outbox'=>"",
    'inbox'=>"",
    'system'=>"",
];
$page_at = explode('/',$_SERVER['REQUEST_URI']);
$active[$page_at[1]] = "active";
?>
<div class="list-group">
    <a href="{{ route('home') }}" class="list-group-item {{ $active['home'] }}">最新消息</a>
    <a href="#" class="list-group-item {{ $active['freshman'] }}">上傳新生</a>
    <a href="#" class="list-group-item {{ $active['graduate'] }}">上傳畢業生</a>
    <a href="#" class="list-group-item {{ $active['outbox'] }}">寄件匣</a>
    <a href="#" class="list-group-item {{ $active['inbox'] }}">收件匣</a>
    @if(auth()->user()->admin =="1")
        <a href="{{ route('system') }}" class="list-group-item {{ $active['system'] }}">系統管理</a>
    @endif
</div>