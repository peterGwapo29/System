<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;


class MembershipController extends Controller {

    public function membership() {
        $memberships = DB::select('SELECT * FROM memberships');
        $membershipTypes = DB::select('SELECT * FROM membership_type');
        $clubName = DB::select('SELECT * FROM clubs');

        return view('Membership.membershipList', [
            'memberships' => $memberships,
            'membershipTypes' => $membershipTypes,
            'clubName' => $clubName
        ]);
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

    public function insertMembership(Request $request){
        $validator = Validator::make($request->all(), [
            'membership_type' => 'required',
            'student_id' => 'required|integer',
            'club_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $studentExists = DB::table('students')->where('student_id', $request->student_id)->exists();

        if (!$studentExists) {
            return response()->json([
                'success' => false,
                'message' => 'The Student ID does not exist in the database.'
            ]);
        }

        try {
            DB::table('memberships')->insert([
                'membership_type' => $request->membership_type,
                'student_id' => $request->student_id,
                'club_name' => $request->club_name,
                'status' => 'Active'
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving membership: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request){
        $validated = $request->validate([
            'membership_id' => 'required|integer',
            'student_id' => 'required|integer',
            'membership_type' => 'required|string',
            'club_name' => 'required|string',
        ]);

        $studentExists = DB::table('students')->where('student_id', $validated['student_id'])->exists();
        if (!$studentExists) {
            return response()->json([
                'success' => false,
                'message' => 'Student ID does not exist in the database.',
                'errorField' => 'student_id'
            ]);
        }
        
        $membershipExists = DB::table('memberships')
            ->where('student_id', $validated['student_id'])
            ->where('membership_id', '<>', $validated['membership_id'])
            ->exists();

        if ($membershipExists) {
            return response()->json([
                'success' => false,
                'message' => 'This student already has a membership.',
                'errorField' => 'student_id'
            ]);
        }

        $affected = DB::table('memberships')
            ->where('membership_id', $validated['membership_id'])
            ->update([
                'student_id' => $validated['student_id'],
                'membership_type' => $validated['membership_type'],
                'club_name' => $validated['club_name'],
            ]);

        if ($affected) {
            return response()->json(['success' => true, 'message' => 'Membership updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Membership update was unsuccessful, Please try again.']);
        }
    }

}
