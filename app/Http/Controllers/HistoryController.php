<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    function history_function(){
        return view('HistoryPage.history');
    }
}
