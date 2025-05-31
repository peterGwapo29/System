<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        $request->validate([
            'club_name' => 'required|string|max:255',
            'club_description' => 'required|string',
            'adviser_name' => 'required|string|max:255'
        ]);

        try {
            DB::table('clubs')->insert([
                'club_name' => $request->club_name,
                'club_description' => $request->club_description,
                'adviser_name' => $request->adviser_name,
                'status' => 'Active'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Club created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create club',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'club_id' => 'required|exists:clubs,club_id',
            'club_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clubs')->ignore($request->club_id, 'club_id')
            ],
            'description' => 'required|string',
            'adviser_name' => 'required|string|max:255',
        ]);

        try {
            // Update the club
            $updated = DB::table('clubs')
                ->where('club_id', $request->club_id)
                ->update([
                    'club_name' => $request->club_name,
                    'club_description' => $request->description,
                    'adviser_name' => $request->adviser_name,
                ]);

            if ($updated) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Club updated successfully'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Club not found or no changes made'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update club',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteClub(Request $request){
        $id = $request->input('club_id');
        $updated = DB::table('clubs')
            ->where('club_id', $id)
            ->update(['status' => 'Inactive']);

        if ($updated) {
            return response()->json(['status' => 'success', 'message' => 'Club deactivated successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to deactivate club.'], 400);
        }
    }


}
