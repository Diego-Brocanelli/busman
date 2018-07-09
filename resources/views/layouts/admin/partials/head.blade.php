<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" href="/admin/favicon.ico" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/admin/css/pe-icon-7-stroke/css/pe-icon-7-stroke.css">

    <!-- Optional - Adds useful class to manipulate icon font display -->
    <link rel="stylesheet" href="/admin/css/pe-icon-7-stroke/css/helper.css">

    <!-- Bootstrap Core Css -->
    <link href="/admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="/admin/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="/admin/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="/admin/plugins/morrisjs/morris.css" rel="stylesheet" />

    <link href="/admin/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />



    <!-- Sweetalert Css -->
    <link href="/admin/plugins/sweetalert/sweetalert.css" rel="stylesheet" />


    <!-- Custom Css -->
    <link href="/admin/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="/admin/css/themes/all-themes.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

    <script>
        window.axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        };
    </script>
</head>
