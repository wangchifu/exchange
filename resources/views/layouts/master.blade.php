<!DOCTYPE html>
<html lang="zh-TW">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('page-title')</title>

    @include('layouts.header')

</head>

<body class="fixed-nav sticky-footer" id="page-top" onselectstart="return false;" ondragstart="return false;" oncontextmenu="return false;">

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
            <h3 class="my-4">你好 Hello</h3>
            @include('layouts.nav')
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div class="card mt-4">
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
            <!-- /.card -->


            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->
<br>
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">
            Copyright &copy; ET Wang 2018 保留一切權利
        </p>
    </div>
    <!-- /.container -->
</footer>

@include('layouts.footer')
@include('layouts.bootbox')
</body>

</html>
