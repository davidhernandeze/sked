<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $visit = \sked\Visit::where('date', date('Y-m-d'))->first();

    if($visit == null){

        $visit = new \sked\Visit();
        $visit->date = date('Y-m-d');
        $visit->visits = 1;
        $visit->clicks_on_sked = 0;
        $visit->save();
    }
    else{

        $visit->visits++;
        $visit->update();

    }

    return view('index');

});

Route::get('/premium', function () {

    DB::table('premium_clicks')->insert(
        ['date' => date('Y-m-d')]
    );

    return view('premium.index');

});

Route::post('/premium', function (\Illuminate\Http\Request $request) {

    $email = $request['email'];

    DB::table('premium_emails')->insert(
        ['date' => date('Y-m-d'), 'email' => $email ]

    );

    return view('premium.success');

});


Route::get('/premium/info', function () {

    return view('premium.info');

});


Route::get('/create', function () {

    return view('sked.create');

});

Route::get('/admin/stats', 'StatsController@show');

Route::get('/feedback/{type}/{id}', 'CommentController@show');

Route::get('/comment', function(){

    return view('sked.skedComment');

});

Route::get('/success', function(){

    return view('sked.skedSuccess');

});

Route::post('/comment', 'CommentController@store');

Route::get('/admin/comments', 'CommentController@index');

Route::get('/prueba/{id}', function ($id) {

    $event_dates = sked\Date::where('event_id', '=', $id);

    $possible_dates = $event_dates->where('valoration', '>', '0')
        ->where('assistance', '>', 1)->get();

    if(!$possible_dates->isEmpty()) {
        return 'vacio';
    }
    return $possible_dates;
});

Route::get('dates/{id}', function($event_id){


    $dates = sked\Date::where('event_id', '=', $event_id);
    $event = \sked\Event::findOrFail($event_id);

    $possible_dates = $dates->where('valoration', '>', '0')->get();

    $more_assistance_dates = $possible_dates->sortByDesc('assistance');
    $max_assistance = $more_assistance_dates->max('assistance');
    $more_assistance_dates = $more_assistance_dates->where('assistance', '=', $max_assistance);

    if($possible_dates != []) {

        $best_dates = $more_assistance_dates->sortByDesc('valoration');

        $max_valoration = $best_dates->max('valoration');
        $best_dates = $best_dates->where('valoration', '=', $max_valoration);

        Mail::send('email.finalization', ['event' => $event, 'dates' => $best_dates], function ($ms) use ($event) {

            $ms->subject('Sked is finish');
            $ms->to('davidhernandeze@gmail.com');
        });

        return $best_dates;

    }

    return 'no best dates';

});

Route::post('/order/store', 'EventController@order');

Route::post('/order', 'EventController@store');

Route::get('/clean', function (){

    $events = \sked\Event::all();
    foreach ($events as $e){
        $e->delete();
    }

    $dates = \sked\Date::all();
    foreach ($dates as $d){
        $d->delete();
    }

    $guests = \sked\Guest::all();
    foreach( $guests as $g){
        $g->delete();
    }

});

Route::get('/guest', 'GuestController@order');

Route::post('/guest/store', 'GuestController@store');

Route::get('/prueba/{id}', function($event_id){

    $event_dates = sked\Date::where('event_id', '=', $event_id);
    $event = sked\Event::findOrFail($event_id);

    $possible_dates = $event_dates->where('valoration', '>', '0')
        ->where('assistance', '>', 1)->get();

    $absents_guests_required = sked\Guest::where('event_id', '=', $event_id)
        ->where('required', '=', '1')
        ->where('already_sked', '=', '0')->get();

    if((!$possible_dates->isEmpty()) and $absents_guests_required->isEmpty()) {
        echo 'si';
    }
    else{
        echo 'no';
    }

});

