<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function account()
    {
        $accounts = DB::select('SELECT * FROM student_account');
        return view('Account.accountList', ['accounts' => $accounts]);
    }


    public function destroy($id){
        DB::delete('DELETE FROM student_account WHERE account_id = ?', [$id]);

        return redirect()->route('account')->with('success', 'Account deleted successfully.');
    }

//     public function create()
// {
//     return view('Account.createAccount'); // View form for adding a new account
// }

public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'password' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'account_status' => 'required|string|max:255',
    ]);

    DB::insert('INSERT INTO student_account (student_id, username, password, email, account_status, created_at) VALUES (?, ?, ?, ?, ?, NOW())', [
        $request->student_id,
        $request->username,
        bcrypt($request->password),
        $request->email,
        $request->account_status,
    ]);

    return redirect()->route('account')->with('success', 'Account added successfully.');
}


}
