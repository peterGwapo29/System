<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    function event_reg(){
        return view('Event_Registration.eventRegList');
    }
}
