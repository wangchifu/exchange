<?php
$active = [
    'home'=>'',
    'new_student'=>'',
    'other_action'=>'',
    'outbox'=>'',
    'inbox'=>'',
    'system'=>'',
    'about'=>'',
];
$path = explode('?',$_SERVER['REQUEST_URI']);
$page_at = explode('/',$path[0]);
$active[$page_at[1]] = "active";
if(auth()->check()){
    $change_num = \App\Change::where('for','=',auth()->user()->id)
        ->where('download','=','0')
        ->count();
    $actions = \App\Action::where('groups','like',"%,".auth()->user()->group_id.",%")
        ->get();
    $action1_num = 0;
    $action2_num = 0;
    foreach($actions as $action){
        if($action->kind == "newstud"){
            $has_upload = \App\Upload::where('action_id','=',$action->id)
                ->where('user_id','=',auth()->user()->id)
                ->count();
            if($has_upload == "0") $action1_num++;
        }elseif($action->kind == "other"){
            $has_upload = \App\Upload::where('action_id','=',$action->id)
                ->where('user_id','=',auth()->user()->id)
                ->count();
            if($has_upload == "0") $action2_num++;
        }
    }
}
?>
<div class="list-group">
    <a href="{{ route('home') }}" class="list-group-item {{ $active['home'] }}">最新公告</a>
    <a href="{{ route('new_student.index') }}" class="list-group-item {{ $active['new_student'] }}">
        上傳縣府 [新生名單]
        @if($action1_num > 0)
        <span class="badge badge-pill badge-danger">{{ $action1_num }}</span>
        @endif
    </a>
    <a href="{{ route('other_action.index') }}" class="list-group-item {{ $active['other_action'] }}">
        上傳縣府 [其他任務]
        @if($action2_num > 0)
        <span class="badge badge-pill badge-warning">{{ $action2_num }}</span>
        @endif
    </a>
    <a href="{{ route('outbox') }}" class="list-group-item {{ $active['outbox'] }}">學校交換 [寄件匣]</a>
    <a href="{{ route('inbox') }}" class="list-group-item {{ $active['inbox'] }}">
        學校交換 [收件匣]
        @if($change_num > 0)
        <span class="badge badge-pill badge-info">{{ $change_num }}</span>
        @endif
    </a>
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