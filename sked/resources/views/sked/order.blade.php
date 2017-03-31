<!doctype html>
<html lang='en'>
<head>

    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='{{asset('css/main.css')}}'>
    <link rel='stylesheet' href='{{asset('css/elements/circle-button.css')}}'>

    <!--    jQuery-->
    <script src='http://code.jquery.com/jquery-1.12.4.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

    <!-- Spinner -->
    <script src="{{asset('spinner/js/jquery.loading.block.js')}}"></script>
    <!-- Buttons -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">

    <title>Sked</title>


    <meta http-equiv="Expires" content="0">

    <meta http-equiv="Last-Modified" content="0">

    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">

    <meta http-equiv="Pragma" content="no-cache">

    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<div class="col-xs-12">

    <h1 class="logo-text">Sked</h1>

</div>

<div class="get-premium col-xs-12">

    <form method="get" action="/premium">
        <button type="submit" class="btn btn-primary outline pull-right">
            Get Premium</button>
    </form>


</div>

<div id="main-container" class="container">

    <form>
        <input id="eventId" type="hidden" value="{{$event->id}}"/>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <p class="description-text" style="text-align: left"> {{$event->name}} by {{$event->username}}</p>
            </div>
        </div>

        <div class="row divider">

            <div class="col-sm-2">
                <p class="divider-text text">Guests...</p>
            </div>
            <div class="col-sm-9">
                <hr class="line-divider">
            </div>

        </div>

        <div class="row">

            <div class="col-sm-5 col-sm-offset-3">
                <table id="guestsTable" class="table">
                    <thead>
                    <tr>
                        <th class="hidden">Id</th>
                        <th class="table-head">Guest</th>
                        <th class="table-head">Must assist</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($guests as $guest)
                        <tr>
                            <td class="hidden id-field">{{$guest->id}}</td>
                            <td class="table-data">{{$guest->name}}</td>
                            <td class="table-data"><input class="check" type="checkbox"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row divider">

            <div class="col-sm-2">
                <p class="divider-text text">Dates...</p>
            </div>
            <div class="col-sm-9">
                <hr class="line-divider">
            </div>

        </div>

        <div class="row">

            <div class="col-sm-6 col-sm-offset-3">
                <table id="datesTable" class="table">
                    <thead>
                    <tr>
                        <th class="hidden">Id</th>
                        <th class="table-head">Date</th>
                        <th class="table-head">Time</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dates as $date)
                        <tr>
                            <td class="hidden id-field">{{$date->id}}</td>
                            <td class="table-data">{{ Carbon\Carbon::parse($date->date)->format('F jS') }}</td>
                            <td class="table-data">{{$date->time}}</td>
                            <td class="table-data">
                                <button type="button" class="move up">
                                    <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="move down">
                                    <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>


        <div class="row">
            <div class="col-xs-4 col-xs-offset-4" style="padding-bottom: 50px; padding-top: 50px;">

                <div id="button-sked" class="btn btn-primary outline" style="width: 100%">
                    <p>Sked it</p>
                </div>

            </div>
        </div>

    </form>

</div>

<script src="{{asset('js/order.js')}}"></script>

</html>