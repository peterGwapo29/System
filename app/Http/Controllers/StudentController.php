<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function student() {
        $students = DB::select('SELECT * FROM students');
        return view('Student.studentList', ['studentList' => $students]);
    }

    public function student_dataTables(Request $request){
        $status = $request->input('status');

        $query = DB::table('students');

        if ($status === 'active') {
            $query->where('status', 'Active');
        } elseif ($status === 'inactive') {
            $query->where('status', 'Inactive');
        }

        return DataTables::of($query)->make(true);
    }

    // public function insertStudent(Request $request) {
    //     $request->validate([
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'middle_name' => 'required',
    //         'course' => 'required',
    //         'year_level' => 'required',
    //     ]);

    //     $exists = DB::table('students')
    //         ->where('first_name', $request->input('first_name'))
    //         ->where('middle_name', $request->input('middle_name'))
    //         ->where('last_name', $request->input('last_name'))
    //         ->exists();

    //     if ($exists) {
    //         return redirect()->back()->with('student_exists', true);
    //     }

    //     // Insert new student if not exists
    //     $query = DB::table('students')->insert([
    //         'first_name' => $request->input('first_name'),
    //         'last_name' => $request->input('last_name'),
    //         'middle_name' => $request->input('middle_name'),
    //         'course' => $request->input('course'),
    //         'year_level' => $request->input('year_level'),
    //         'status' => 'Active',
    //     ]);

    //     if ($query) {
    //         return back()->with('success', 'Student created successfully.');
    //     } else {
    //         return back()->with('fail', 'Something went wrong.');
    //     }
    // }


    public function store(Request $request)
{
    try {
        // Retrieve input
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $middle_name = $request->input('middle_name');
        $course = $request->input('course');
        $year_level = $request->input('year_level');

        // Optional: Check if the student already exists by some unique combination (e.g., first+last+middle)
        $studentExists = DB::select("SELECT * FROM students WHERE first_name = ? AND last_name = ? AND middle_name = ?", [
            $first_name,
            $last_name,
            $middle_name
        ]);

        if (!empty($studentExists)) {
            return response()->json([
                'success' => false,
                'message' => 'Student already exists.'
            ]);
        }

        // Insert student
        DB::insert("INSERT INTO students (first_name, last_name, middle_name, course, year_level, status) VALUES (?, ?, ?, ?, ?, ?)", [
            $first_name,
            $last_name,
            $middle_name,
            $course,
            $year_level,
            'Active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student added successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}


    public function update(Request $request, $id){
        try {
            // Check if another student already has the same name
            $exists = DB::table('students')
                ->where('first_name', $request->input('first_name'))
                ->where('last_name', $request->input('last_name'))
                ->where('middle_name', $request->input('middle_name'))
                ->where('student_id', '!=', $id) // Exclude current student
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'A student with the same name already exists.'
                ]);
            }

            // Proceed with update
            DB::table('students')
                ->where('student_id', $id)
                ->update([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'middle_name' => $request->input('middle_name'),
                    'course' => $request->input('course'),
                    'year_level' => $request->input('year_level'),
                ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteStudent(Request $request){
        $id = $request->input('student_id');
        $updated = DB::table('students')
            ->where('student_id', $id)
            ->update(['status' => 'Inactive']);

        if ($updated) {
            return response()->json(['status' => 'success', 'message' => 'Account deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete account.'], 400);
        }
    }

    public function restoreStudent(Request $request){
        $id = $request->input('student_id');

        $updated = DB::table('students')
            ->where('student_id', $id)
            ->update(['status' => 'Active']);

        if ($updated) {
            return response()->json([
                'status' => 'success',
                'message' => 'Student successfully restored.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to restore the student. Please try again.'
            ], 400);
        }
    }
}