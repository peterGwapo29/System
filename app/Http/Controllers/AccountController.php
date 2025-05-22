<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{
    public function account(){
        $accounts = DB::select('SELECT * FROM student_account');
        return view('Account.accountList', ['accounts' => $accounts]);
    }

    public function studentAcc_dataTables(){
        $accounts = DB::select('SELECT * FROM student_account');

        return DataTables::of($accounts)->make(true);
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
public function update_account(Request $request)
{
    $request->validate([
        'editAccountId' => 'required|integer',
        'editStudentId' => 'required',
        'editUsername' => 'required',
        'editEmail' => 'required|email',
        'editStatus' => 'required',
    ]);

    $params = [
        'student_id' => $request->input('editStudentId'),
        'username' => $request->input('editUsername'),
        'email' => $request->input('editEmail'),
        'account_status' => $request->input('editStatus'),
    ];

    // Only update password if a new one was entered
    if (!empty($request->input('editPassword'))) {
        $params['password'] = Hash::make($request->input('editPassword'));
    }

    $updated = DB::table('student_account')
        ->where('account_id', $request->input('editAccountId'))
        ->update($params);

    if ($updated) {
        return response()->json([
            'status' => 'success',
            'message' => 'Account updated successfully',
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Account not found or no changes made',
        ], 404);
    }
}

}
