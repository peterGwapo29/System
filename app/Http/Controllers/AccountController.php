<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function account()
    {
        $accounts = DB::select('SELECT * FROM student_account');
        return view('Account.accountList', ['accounts' => $accounts]);
    }


    public function destroy($id){
        $updated = DB::table('student_account')
            ->where('account_id', $id)
            ->update(['account_status' => 'inactive']);

        if ($updated) {
            return redirect()->route('account')->with('success', 'Account marked as inactive.');
        } else {
            return redirect()->route('account')->with('fail', 'Failed to update account status.');
        }
    }


    function insert(Request $request){
        $request -> validate([
            'student_id' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:student_account',
        ]);

        $query = DB::table('student_account') ->insert([
            'student_id' => $request->input('student_id'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email'),
            'created_at' => now()->format('Y-m-d h:i:s A'),
            'account_status' => 'active',
        ]);

        if($query){
            return back()->with('success', 'Account created successfully.');
        }else{
            return back()->with('fail', 'Something went wrong.');
        }


    }

}
