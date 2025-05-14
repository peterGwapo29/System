<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    function membership(){
        return view('Membership.membershipList');
    }
}
