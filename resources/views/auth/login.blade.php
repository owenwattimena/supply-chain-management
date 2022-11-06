<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Supply Chain Management | Log in</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('assets')}}/bower_components/bootstrap/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('assets')}}/bower_components/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('assets')}}/bower_components/Ionicons/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('assets')}}/dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="{{ asset('assets')}}/plugins/iCheck/square/blue.css">


    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script nonce="493e4ae9-5320-46a2-9841-60442ebc0e12">
        (function(w, d) {
            ! function(Z, _, ba, bb) {
                Z.zarazData = Z.zarazData || {};
                Z.zarazData.executed = [];
                Z.zaraz = {
                    deferred: []
                    , listeners: []
                };
                Z.zaraz.q = [];
                Z.zaraz._f = function(bc) {
                    return function() {
                        var bd = Array.prototype.slice.call(arguments);
                        Z.zaraz.q.push({
                            m: bc
                            , a: bd
                        })
                    }
                };
                for (const be of ["track", "set", "debug"]) Z.zaraz[be] = Z.zaraz._f(be);
                Z.zaraz.init = () => {
                    var bf = _.getElementsByTagName(bb)[0]
                        , bg = _.createElement(bb)
                        , bh = _.getElementsByTagName("title")[0];
                    bh && (Z.zarazData.t = _.getElementsByTagName("title")[0].text);
                    Z.zarazData.x = Math.random();
                    Z.zarazData.w = Z.screen.width;
                    Z.zarazData.h = Z.screen.height;
                    Z.zarazData.j = Z.innerHeight;
                    Z.zarazData.e = Z.innerWidth;
                    Z.zarazData.l = Z.location.href;
                    Z.zarazData.r = _.referrer;
                    Z.zarazData.k = Z.screen.colorDepth;
                    Z.zarazData.n = _.characterSet;
                    Z.zarazData.o = (new Date).getTimezoneOffset();
                    Z.zarazData.q = [];
                    for (; Z.zaraz.q.length;) {
                        const bl = Z.zaraz.q.shift();
                        Z.zarazData.q.push(bl)
                    }
                    bg.defer = !0;
                    for (const bm of [localStorage, sessionStorage]) Object.keys(bm || {}).filter((bo => bo.startsWith("_zaraz_"))).forEach((bn => {
                        try {
                            Z.zarazData["z_" + bn.slice(7)] = JSON.parse(bm.getItem(bn))
                        } catch {
                            Z.zarazData["z_" + bn.slice(7)] = bm.getItem(bn)
                        }
                    }));
                    bg.referrerPolicy = "origin";
                    bg.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(Z.zarazData)));
                    bf.parentNode.insertBefore(bg, bf)
                };
                ["complete", "interactive"].includes(_.readyState) ? zaraz.init() : Z.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, 0, "script");
        })(window, document);

    </script>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>SCM</b>Login</a>
        </div>
        @if (session('status'))
        <div class="alert alert-{!! session('status') !!} alert-dismissible" style="border-radius: 0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p> <strong>{!! session('type') !!}.</strong> {!! session('message') !!}</p>
        </div>
        @endif
        <div class="login-box-body">
            <p class="login-box-msg">Masuk untuk memulai sesi.</p>
            <form action="{{ route('login.do') }}" method="post">
                @csrf
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Username" name="username">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> ingat saya
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">MASUK</button>
                    </div>
                </div>
            </form>
        </div>

    </div>


    <script src="{{ asset('assets')}}/bower_components/jquery/dist/jquery.min.js"></script>

    <script src="{{ asset('assets')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="{{ asset('assets')}}/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue'
                , radioClass: 'iradio_square-blue'
                , increaseArea: '20%' /* optional */
            });
        });

    </script>
</body>
</html>
