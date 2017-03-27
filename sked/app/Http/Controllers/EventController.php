<?php

namespace sked\Http\Controllers;

use Illuminate\Http\Request;
use sked\Date;
use sked\Event;
use sked\Guest;
use Mail;
use Session;

class EventController extends Controller
{


    public function store(Request $request)
    {
        $this->validate($request,
            [
                'guests' => 'required',
                'dates' => 'required',
                'hours' => 'numeric|min:1',
                'email' => 'email'
            ],
            [
                'required' => 'At least one :attribute must be added'
            ]
        );

        if(!$request['guests'] || !!$request['dates']){

        }

        $event = new Event();

        $event->name = $request['eventName'];
        $event->username = $request['userName'];
        $event->email = $request['email'];
        $event->remaining_minutes = $request['hours']; //debug mode in minutes, originally -> *60
        $event->status = 1;

        $event->save();

        foreach ($request['guests'] as $person) {

            $guest = new Guest();

            $guest->event_id = $event->id;
            $guest->name = $person['name'];
            $guest->email = $person['email'];
            $guest->already_sked = 0;

            $guest->save();

        }

        foreach ($request['dates'] as $time) {

            $date = new Date();

            $date->event_id = $event->id;
            $date->date = $time['date'];
            $date->time = $time['time'];
            $date->assistance = 1;

            $date->save();
        }

        $guests = Guest::where('event_id', '=', $event->id)->get();
        $dates = Date::where('event_id', '=', $event->id)->get();


        return view('sked.order', ['guests' => $guests, 'dates' => $dates, 'event' => $event]);

    }

    public function order(Request $request)
    {

        $visit = \sked\Visit::where('date', date('Y-m-d'))->first();

        if($visit == null){

            $visit = new \sked\Visit();
            $visit->date = date('Y-m-d');
            $visit->clicks_in_sked = 1;
            $visit->save();
        }
        else{

            $visit->clicks_in_sked++;
            $visit->update();

        }

        foreach ($request['guests'] as $g) {
            $guest = Guest::findOrFail($g['id']);

            if ($g['isRequired'] == 'true') {

                $guest->required = 1;

            } else {

                $guest->required = 0;

            }
            $guest->already_sked = 0;
            $guest->update();
        }

        $this->updateDateValoration($request['dates']);

        EmailSender::notifyGuests($request['eventId']);

        return response('Store in the server', 200);

    }

    private function updateDateValoration($dates)
    {

        $datesCount = count($dates);

        foreach ($dates as $id_date) {

            $date = Date::findOrFail($id_date);

                $date->valoration = $datesCount;

                $date->update();

                $datesCount--;

        }

    }


}
