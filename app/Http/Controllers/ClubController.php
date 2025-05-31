<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClubController extends Controller
{
    public function club()
    {
        $clubs = DB::select('SELECT * FROM clubs');

        return view('Club.clubList', [
            'clubList' => $clubs,
        ]);
    }

    public function clubList(Request $request) {
        $status = $request->input('status');

        $query = DB::table('clubs');

        if ($status === 'active') {
            $query->where('status', 'Active');
        } elseif ($status === 'inactive') {
            $query->where('status', 'Inactive');
        }

        return DataTables::of($query)->make(true);
    }

}
