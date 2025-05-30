<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MembershipController extends Controller
{
    function membership(){
        $memberships = DB::select('SELECT * FROM memberships');
        return view('Membership.membershipList', ['memberships' => $memberships]);
    }

    public function membership_dataTables(Request $request){
        $status = $request->input('status');

        $query = DB::table('memberships');

        if ($status === 'active') {
            $query->where('status', 'Active');
        } elseif ($status === 'inactive') {
            $query->where('status', 'Inactive');
        }

        return DataTables::of($query)->make(true);
    }
}
