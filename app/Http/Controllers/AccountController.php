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

   public function store(Request $request)
{
    try {
        $student_id = $request->input('student_id');
        $username = $request->input('username');
        $password = $request->input('password');
        $email = $request->input('email');

        $studentExists = DB::select("SELECT * FROM students WHERE student_id = ?", [$student_id]);
        if (empty($studentExists)) {
            return response()->json([
                'success' => false, 
                'message' => 'Student ID not found.'
            ]);
        }

        $accountExists = DB::select("SELECT * FROM student_account WHERE student_id = ?", [$student_id]);
        if (!empty($accountExists)) {
            return response()->json([
                'success' => false, 
                'message' => 'Student already has an account.'
            ]);
        }

        $usernameExist = DB::select("SELECT * FROM student_account WHERE username = ?", [$username]);
        if (!empty($usernameExist)) {
            return response()->json([
                'success' => false, 
                'message' => 'This username is already taken, Please try again.'
            ]);
        }

        $emailExist = DB::select("SELECT * FROM student_account WHERE email = ?", [$email]);
        if (!empty($emailExist)) {
            return response()->json([
                'success' => false, 
                'message' => 'This email is already taken, Please try again.'
            ]);
        }
        

        DB::insert("INSERT INTO student_account (student_id, username, password, email, created_at, account_status) VALUES (?, ?, ?, ?, ?, ?)", [
            $student_id,
            $username,
            Hash::make($password),
            $email,
            now(),
            'Active'
        ]);

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
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
