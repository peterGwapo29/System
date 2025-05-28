<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function student() {
        $students = DB::select('SELECT * FROM students');
        return view('Student.studentList', ['studentList' => $students]);
    }

    public function student_dataTables() {
        $students = DB::select('SELECT * FROM students');
        return DataTables::of($students)->make(true);
    }

    public function insertStudent(Request $request) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'course' => 'required',
            'year_level' => 'required',
        ]);

        // Check if a student with the same full name exists
        $exists = DB::table('students')
            ->where('first_name', $request->input('first_name'))
            ->where('middle_name', $request->input('middle_name'))
            ->where('last_name', $request->input('last_name'))
            ->exists();

        if ($exists) {
            return redirect()->back()->with('student_exists', true);
        }

        // Insert new student if not exists
        $query = DB::table('students')->insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_name' => $request->input('middle_name'),
            'course' => $request->input('course'),
            'year_level' => $request->input('year_level'),
        ]);

        if ($query) {
            return back()->with('success', 'Student created successfully.');
        } else {
            return back()->with('fail', 'Something went wrong.');
        }
    }


}