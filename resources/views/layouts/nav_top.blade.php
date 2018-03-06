<a class="navbar-brand" href="{{ url('/') }}">彰化縣學校文件交換系統</a>
<?php
$active = [
    'upload_public'=>'',
    'change_pass'=>'',
];
$page_at = explode('/',$_SERVER['REQUEST_URI']);
$active[$page_at[1]] = "active";

if(auth()->check()){
    $change_num = \App\Change::where('for','=',auth()->user()->id)
        ->where('download','=','0')
        ->count();
    $actions = \App\Action::where('groups','like',"%,".auth()->user()->group_id.",%")
        ->get();
    $action_num = 0;
    foreach($actions as $action){
        $upload_num = \App\Upload::where('action_id','=',$action->id)
            ->where('user_id','=',auth()->user()->id)
            ->count();
        if($upload_num == "0") $action_num++;
    }
}
?>
@if(auth()->check())
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <a class="nav-item" href="#">
                <span class="sr-only">(current)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="hi();"><img src="{{ asset('img/user.png') }}" width="25"> [ {{ auth()->user()->name }} ]</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><span class="badge badge-pill badge-danger">未傳 {{ $action_num }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><span class="badge badge-pill badge-primary">未載 {{ $change_num }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $active['upload_public'] }}" href="{{ route('upload_publickey') }}">[ 上傳公鑰 ]</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $active['change_pass'] }}" href="{{ route('change_pass') }}">[ 更改密碼 ]</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" onclick="bbconfirm('logout-form','真的要離開了嗎？')">
                [ 登出 ]
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</div>

<script>
    var i=0;
    function hi()
    {
        i++;
        alert('Hi, {{ auth()->user()->name }}, 你按了'+ i +'下');
    }
</script>

@endif