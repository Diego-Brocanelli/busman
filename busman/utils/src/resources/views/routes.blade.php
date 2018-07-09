<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Application routes</title>
    <link rel="shortcut icon" type="image/png" href="/media/images/favicon.png">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">

    <link rel="stylesheet" type="text/css" href="https://datatables.net/media/css/site-examples.css?_=19472395a2969da78c8a4c707e72123a">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">

    <style type="text/css" class="init">

    </style>
    <script type="text/javascript" src="/media/js/site.js?_=862bf6e10ebd2789e945c51a86585caf"></script>
    <script type="text/javascript"
            src="/media/js/dynamic.php?comments-page=examples%2Fbasic_init%2Fzero_configuration.html" async></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script><script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/demo.js"></script>
    <script type="text/javascript" class="init">


        $(document).ready(function () {
            $('#example tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
            } );

            let table = $('#example').DataTable({
                order: [[ 1, "asc" ]],
                //iDisplayLength: 50
            });

            table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        });


    </script>

    <style>
        body {
            font-size: 12px;
        }
        div.fw-container div.fw-body {
            width: 100%;
        }

        div.fw-container div.fw-body div.content {
             margin-top: 2em;
        }

        div.fw-container div.fw-body div.content>h1 {
            position: relative;
            top: 0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="wide comments example">
<a name="top" id="top"></a>
{{--<div class="fw-background">
    <div></div>
</div>--}}
<div class="fw-container" style="max-width: 100%">
    <div class="fw-body">
        <div class="content" style="overflow-x: scroll; max-width: 10000px">
            <h1 class="page_title">Application routes</h1>

            <table id="example" class="table table-responsive table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Method</th>
                    <th>URI</th>
                    <th>Name</th>
                    <th>Action</th>
                    <th>Middleware</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($routes as $route)
                        <tr>
                            <td>{{ implode(' | ', $route->methods) }}</td>
                            <td>{{ $route->uri }}</td>
                            <td>{{ isset($route->action['as']) ? $route->action['as'] : '' }}</td>
                            <td>{{ isset($route->action['controller']) ? $route->action['controller'] : ''}}</td>
                            <td>{{ is_array($route->action['middleware']) ? implode(', ', $route->action['middleware']) : $route->action['middleware']}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Method</th>
                    <th>URI</th>
                    <th>Name</th>
                    <th>Action</th>
                    <th>Middleware</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>
<div class="fw-footer">
    <div class="skew"></div>
    <div class="skew-bg"></div>
    <div class="copyright">
        <h4>Made with DataTables</h4>
        <p>DataTables designed and created by <a href="//sprymedia.co.uk">SpryMedia Ltd</a>.<br>
            © 2007-2018 <a href="/license/mit">MIT licensed</a>. <a href="/privacy">Privacy policy</a>. <a
                    href="/supporters">Supporters</a>.<br>
            SpryMedia Ltd is registered in Scotland, company no. SC456502.</p>
    </div>
</div>
<script type="text/javascript">
    /*var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-365466-5']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();*/
</script>
</body>
</html>
