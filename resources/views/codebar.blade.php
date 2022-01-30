    <?php  
    
    use Milon\Barcode\DNS1D;
    use Milon\Barcode\DNS2D;

    ?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Algematic</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{asset('css/ticket.css')}}" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>

            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
                <div class="top-right links">
                <a class="btn btn-info" id="print">{{$codebar ?? 'sssssss'}}</a>


                </div>
                <div class="content">
                    <?php
                echo '<img src="data:image/png;base64,' . $codebar . '" alt="barcode"   />';
                    ?>
                </div>
        </div>

        <script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('js/printThis.js')}}"></script>

        <script>
            $(function(){
                $('#print').on('click',function(){
                    $('.content').printThis();
                })
            })
        </script>



    </body>
</html>

