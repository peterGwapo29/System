<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    function event(){
        return view('Events.eventList');
    }
}
