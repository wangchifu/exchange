<!DOCTYPE html>
<html lang="zh-TW">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>彰化縣學校文件交換系統</title>

    @include('layouts.header')

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        @include('layouts.nav_top')
    </div>
</nav>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-6">
            <div class="card mt-4">
                <div class="card-header">
                    使用者登入
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus placeholder="請輸入帳號">
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="請輸入密碼">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="captcha" class="form-control" type="captcha" name="captcha" value="{{ old('captcha')  }}" required placeholder="請輸入驗證碼(大小寫不同，點一下換圖)">
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>驗證碼輸入錯誤</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <a href="#" alt="按一下換圖">
                                <span class="col-md-1 refereshrecapcha" onclick="refreshCaptcha()">
                                {!! captcha_img('flat')  !!}
                                </span>
                            </a>
                        </div>
                        <script>
                            function refreshCaptcha(){
                                $.ajax({
                                    url: "/login/refereshcapcha",
                                    type: 'get',
                                    dataType: 'html',
                                    success: function(json) {
                                        $('.refereshrecapcha').html(json);
                                    },
                                    error: function(data) {
                                        alert('Try Again.');
                                    }
                                });
                            }
                        </script>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary col-md-12">
                                    登入
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<footer class="py-5 fixed-bottom bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; 彰化縣教育處學管科 2018</p>
    </div>
</footer>

@include('layouts.footer')

</body>

</html>