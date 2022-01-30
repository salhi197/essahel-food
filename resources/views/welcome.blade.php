<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LsRapide</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>

        .login-container{
            margin-top: 5%;
            margin-bottom: 5%;
        }
        .login-logo{
            position: relative;
            margin-left: -41.5%;
        }
        .login-logo img{
            position: absolute;
            width: 20%;
            margin-top: 19%;
            background: #282726;
            border-radius: 4.5rem;
            padding: 5%;
        }
        .login-form-1{
            padding: 9%;
            background:#282726;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }
        .login-form-1 h3{
            text-align: center;
            margin-bottom:12%;
            color:#fff;
        }
        .login-form-2{
            padding: 9%;
            background: #f05837;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }
        .login-form-2 h3{
            text-align: center;
            margin-bottom:12%;
            color: #fff;
        }
        .btn{
            border : 1px solid #f05837;
            background: #f05837;
        }

        .btn:hover{
            background: #f05837;
        }

        .btnSubmit{
            font-weight: 600;
            width: 50%;
            color: #282726;
            background-color: #fff;
            border: none;
            border-radius: 1.5rem;
            padding:2%;
        }
        .btnForgetPwd{
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }
        .btnForgetPwd:hover{
            text-decoration:none;
            color:#fff;
        }

        </style>
    </head>
    <body>
    <div class="container login-container">
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <h3>
                        <img src="{{asset('img/lsrapide-logo.png')}}" alt="" 
                            width="30%"
                        />
                    </h3>
                    <p class="text-white">
                    LSrapide est une société de transport de fret et de livraison express qui vous propose:
Transfert de toutes les demandes aux propriétaires de magasins et aux magasins en ligne
                    </p>                   
                    <a class="text-white btn btn-info" href="{{ route('login.admin') }}">Admin</a>
                    <a class="text-white btn btn-info" href="{{ route('login.Fournisseur') }}">Fournisseur</a>
                    <a class="text-white btn btn-info" href="{{ route('login.Livreur') }}">Livreur</a>
                </div>
                <div class="col-md-6 login-form-2">
                    <div class="login-logo">
                        <img src="{{asset('img/lsrapide-logo.png')}}" alt="" />
                    </div>
                    <h3>Login</h3>
                        @isset($url)
                            <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                        @else
                            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @endisset
                            @csrf

                            <div class="form-group">
                                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Login"  />
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btnSubmit" value="Login" />
                            </div>
                            <div class="form-group">

                            </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
