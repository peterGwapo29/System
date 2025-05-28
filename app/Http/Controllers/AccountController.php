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
        // $accounts = DB::select('SELECT * FROM student_account');
        $accounts = DB::table('student_account')
                  ->where('account_status', 'Active')
                  ->get();

        return DataTables::of($accounts)->make(true);
    }

    public function insert(Request $request){
        $request->validate([
            'student_id' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email',
        ]);

        // Check if student_id already exists
        $exists = DB::table('student_account')
                    ->where('student_id', $request->input('student_id'))
                    ->exists();

        if ($exists) {
            return redirect()->back()->with('student_exists', true);
        }


        $query = DB::table('student_account')->insert([
            'student_id' => $request->input('student_id'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email'),
            'created_at' => now()->format('Y-m-d h:i:s A'),
            'account_status' => 'Active',
        ]);

        if ($query) {
            return back()->with('success', 'Account created successfully.');
        } else {
            return back()->with('fail', 'Something went wrong.');
        }
    }



    public function update_account(Request $request){
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

    public function deleteAccount(Request $request){
        $id = $request->input('account_id');
        $updated = DB::table('student_account')
            ->where('account_id', $id)
            ->update(['account_status' => 'Inactive']);

        if ($updated) {
            return response()->json(['status' => 'success', 'message' => 'Account deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete account.'], 400);
        }
    }

}
