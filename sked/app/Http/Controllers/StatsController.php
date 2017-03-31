<?php

namespace sked\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use sked\Comment;
use sked\Event;
use sked\Guest;
use sked\Visit;

class StatsController extends Controller
{

    public function show() {

        $visits = Visit::all();
        $creators = Event::select(['name', 'email', 'created_at'])->get()->unique('email');
        $guests = Guest::select(['name', 'email', 'response_date'])->get()->unique('email');

        $totalGuest = Guest::all()->count();
        $guestsResponses = Guest::where('already_sked', '1')->count();

        $responseRate = ($guestsResponses/$totalGuest)*100;
        $responseRate = number_format($responseRate, 2);

        $creatorsCount = [];

        foreach ($creators as $creator){

            $repetitions = Event::where('email', $creator['email'])->count();
            $row = ['name' => $creator['name'], 'email' => $creator['email'], 'count' => $repetitions,
            'date' => $creator['created_at']];
            array_push($creatorsCount, $row);

        }

        $premiumEmails = DB::table('premium_emails')->get();
        $premiumClicks = DB::table('premium_clicks')->count();

        return view('admin.stats',
            [
                'visits' => $visits,
                'creators' => $creators,
                'guests' => $guests,
                'responseRate' => $responseRate,
                'creatorsCount' => $creatorsCount,
                'premiumClicks' => $premiumClicks,
                'premiumEmails' => $premiumEmails,
            ]);

    }

    public function store(Request $request){

        $comment = new Comment();
        $comment->email = $request['email'];
        $comment->comment = $request['comment'];
        $comment->date = date('Y-m-d');

        $comment->save();

    }

    public function index(){

        $comments = Comment::all();

        return view('admin.comments', ['comments' => $comments]);

    }


}
