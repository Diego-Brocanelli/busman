<?php //var_dump($errors->isEmpty());  ?>
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <!-- Bootstrap Core Css -->
    <link href="/admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="/admin/css/login.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="login-background">
    <div class="filter-dark">
        <div class="row">
            <div class="col-md-12">
                <div class="login-right pull-right col-md-3 {{!$errors->isEmpty() ? 'collapse in' : ''}}" id="login-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="login-box">
                                <div class="login-logo"><h1>{{ config('app.name') }}</h1></div>
                                @yield('content')
                            </div>
                            <div style="text-align: center; padding-top: 45%;" class="copyright">
                                &copy;{{date('Y')}} Desenvolvido por <a href="https://maxcelos.com" target="_blank">Maxcelos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--div id="collapse-button"><i class="fa fa-bars" data-toggle="collapse" data-target="#login-form"></i></div-->

                <a id="collapse-button" data-toggle="collapse" data-target="#login-form" href="#collapse1" style="text-decoration: none; color: #fff">
                    <i class="pull-right fa fa-bars"></i>
                </a>

                <div class="col-md-9 pull-right login-left">
                    <div class="wrapper">
                        Gerenciador de lançamentos contábeis código aberto
                    </div>

                    <div class="wrapper2">
                        "O mundo pertence a quem se atreve"
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Jquery Core Js -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="/admin/plugins/bootstrap/js/bootstrap.js"></script>

<!-- Select Plugin Js -->
<script src="/admin/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="/admin/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="/admin/plugins/node-waves/waves.js"></script>
<script>
</script>
</body>
</html>
