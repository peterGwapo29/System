<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function event_reg()
    {
        $e_reg = DB::select('SELECT * FROM event_registration');

        return view('Event_Registration.eventRegList', [
            'eventRegList' => $e_reg,
        ]);
    }

    public function event_regList(Request $request) {
        $status = $request->input('status');

        $query = DB::table('event_registration');

        if ($status === 'pending') {
            $query->where('status', 'pending');
        } elseif ($status === 'approved') {
            $query->where('status', 'approved');
        }elseif ($status === 'rejected') {
            $query->where('status', 'rejected');
        }elseif ($status === 'cancelled') {
            $query->where('status', 'cancelled');
        }elseif ($status === 'completed') {
            $query->where('status', 'completed');
        }

        return DataTables::of($query)->make(true);
    }

    public function updateStatus(Request $request)
{
    $validator = Validator::make($request->all(), [
        'registration_id' => 'required|integer',
        'status' => 'required|in:pending,approved,rejected,cancelled,completed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->errors()->first()
        ], 422);
    }

    try {
        $affected = DB::table('event_registration')
            ->where('registration_id', $request->registration_id)
            ->update(['status' => ucfirst($request->status)]); // capitalize for display

        if ($affected === 0) {
            return response()->json([
                'message' => 'No record was updated. Please check the registration ID.'
            ], 404);
        }

        return response()->json([
            'message' => 'Status updated successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to update registration status.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function getActiveEvents()
    {
        try {
            $events = DB::table('events')
                ->where('status', 'Active')
                ->select('event_id', 'event_name')
                ->get();

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch events.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableStudents()
    {
        try {
            $students = DB::table('students')
                ->where('status', 'Active')
                ->select('student_id', 'first_name', 'last_name')
                ->get()
                ->map(function($student) {
                    return [
                        'student_id' => $student->student_id,
                        'name' => $student->first_name . ' ' . $student->last_name
                    ];
                });

            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch students.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function registerEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,student_id',
            'event_id' => 'required|exists:events,event_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Get student details
            $student = DB::table('students')
                ->where('student_id', $request->student_id)
                ->first();

            if (!$student) {
                return response()->json([
                    'message' => 'Student not found.'
                ], 404);
            }

            // Get event details
            $event = DB::table('events')
                ->where('event_id', $request->event_id)
                ->first();

            if (!$event) {
                return response()->json([
                    'message' => 'Event not found.'
                ], 404);
            }

            // Check if already registered
            $existingRegistration = DB::table('event_registration')
                ->where('student_id', $student->student_id)
                ->where('event_id', $request->event_id)
                ->first();

            if ($existingRegistration) {
                return response()->json([
                    'message' => 'Student is already registered for this event.'
                ], 422);
            }

            // Insert registration
            DB::table('event_registration')->insert([
                'student_id' => $student->student_id,
                'event_id' => $event->event_id,
                'event_name' => $event->event_name,
                'status' => 'Pending',
            ]);

            return response()->json([
                'message' => 'Event registration successful.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to register for event.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
