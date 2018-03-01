<?php
$active = [
    'home'=>'',
    'freshman'=>'',
    'graduate'=>'',
    'outbox'=>'',
    'inbox'=>'',
    'system'=>'',
    'about'=>'',
];
$page_at = explode('/',$_SERVER['REQUEST_URI']);
$active[$page_at[1]] = "active";
?>
<div class="list-group">
    <a href="{{ route('home') }}" class="list-group-item {{ $active['home'] }}">最新消息</a>
    <a href="{{ route('new_student.index') }}" class="list-group-item {{ $active['freshman'] }}">上傳縣府新生名單</a>
    <a href="#" class="list-group-item {{ $active['graduate'] }}">其他上傳縣府任務</a>
    <a href="#" class="list-group-item {{ $active['outbox'] }}">學校交換寄件匣</a>
    <a href="#" class="list-group-item {{ $active['inbox'] }}">學校交換收件匣</a>
    @if(auth()->user()->group_id =="1")
        <a href="{{ route('system.action') }}" class="list-group-item {{ $active['system'] }}">系統管理</a>
    @endif
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>