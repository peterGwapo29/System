<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class EventController extends Controller
{

    public function event()
    {
        $event = DB::select('SELECT * FROM events');

        return view('Events.eventList', [
            'eventList' => $event,
        ]);
    }

    public function eventList(Request $request) {
        $status = $request->input('status');

        $query = DB::table('events');

        if ($status === 'active') {
            $query->where('status', 'Active');
        } elseif ($status === 'inactive') {
            $query->where('status', 'Inactive');
        }

        return DataTables::of($query)->make(true);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'club_id' => 'required',
                'event_name' => 'required',
                'event_date' => 'required|date',
                'venue' => 'required',
                'event_description' => 'required',
            ]);

            DB::table('events')->insert([
                'club_id' => $request->club_id,
                'event_name' => $request->event_name,
                'event_date' => $request->event_date,
                'venue' => $request->venue,
                'event_description' => $request->event_description,
                'status' => 'Active',
            ]);

            return response()->json(['success' => true, 'message' => 'Event added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error adding event: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required',
                'club_id' => 'required',
                'event_name' => 'required',
                'event_date' => 'required|date',
                'venue' => 'required',
                'event_description' => 'required',
            ]);

            DB::table('events')
                ->where('event_id', $request->event_id)
                ->update([
                    'club_id' => $request->club_id,
                    'event_name' => $request->event_name,
                    'event_date' => $request->event_date,
                    'venue' => $request->venue,
                    'event_description' => $request->event_description,
                    'status' => 'Active',
                ]);

            return response()->json(['success' => true, 'message' => 'Event updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating event: ' . $e->getMessage()]);
        }
    }

    public function deleteEvent(Request $request)
    {
        $id = $request->input('event_id');
        $updated = DB::table('events')
            ->where('event_id', $id)
            ->update(['status' => 'Inactive']);

        if ($updated) {
            return response()->json(['status' => 'success', 'message' => 'Event deactivated successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to deactivate event.'], 400);
        }
    }

    public function restoreEvent(Request $request)
    {
        $id = $request->input('event_id');
        $updated = DB::table('events')
            ->where('event_id', $id)
            ->update(['status' => 'Active']);

        if ($updated) {
            return response()->json([
                'status' => 'success',
                'message' => 'Event successfully restored.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to restore the event. Please try again.'
            ], 400);
        }
    }
}
