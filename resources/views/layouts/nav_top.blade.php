<a class="navbar-brand" href="{{ url('/') }}">彰化縣學校文件交換系統</a>
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
            <a class="nav-link" href="#">上傳公鑰</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('change_pass') }}">更改密碼</a>
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
@endif