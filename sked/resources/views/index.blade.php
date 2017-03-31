
<!doctype html>
<html lang='en'>
<head>

    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='{{asset('css/main.css')}}'>
    <link rel='stylesheet' href='{{asset('css/elements/circle-button.css')}}'>
    <link rel="stylesheet" type="text/css" href="fonts/style.css"/>

    <!--    jQuery-->
    <script src='http://code.jquery.com/jquery-1.12.4.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

    <!-- Buttons -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">

    <title>Sked</title>


    <meta http-equiv="Expires" content="0">

    <meta http-equiv="Last-Modified" content="0">

    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">

    <meta http-equiv="Pragma" content="no-cache">


</head>
<body type="hidden">

<div  id="main-container" class='container-fluid'>
    <div class='row'>

        <div class="col-xs-12">

            <h1 class="logo-text">Sked</h1>

        </div>

    </div>
    <div class='row'>

        <div class="col-xs-12">

            <p class="slogan-text">Efortless Scheduling</p>

        </div>

    </div>

    <div class="col-xs-12" style="height:100px;"></div>


    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div id="main-button" class="btn btn-primary outline" style="width: 100%;">
                <p>Find the best time</p>
            </div>

        </div>


    </div>
</div>



</body>


<script>


    $(window).load(function(){

       $('body').removeAttr('type');
    });

    $(document).ready(function(){


        $('#main-button').click(function () {

            window.location.href ='/create';

        });


    });
</script>


</html>

