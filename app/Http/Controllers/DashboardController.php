<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get total active clubs
            $totalClubs = DB::table('clubs')
                           ->where('status', 'Active')
                           ->count();

            // Get active events
            $activeEvents = DB::table('events')
                            ->where('status', 'Active')
                            ->where('event_date', '>=', now()->format('Y-m-d'))
                            ->count();

            // Get total members (unique students with active memberships)
            $totalMembers = DB::table('memberships')
                            ->where('status', 'Active')
                            ->distinct('student_id')
                            ->count('student_id');

            // Get upcoming events
            $upcomingEvents = DB::table('events')
                             ->where('status', 'Active')
                             ->where('event_date', '>', now()->format('Y-m-d'))
                             ->count();

            // Calculate club growth (comparing with last month's data)
            $lastMonthClubs = DB::table('clubs')
                               ->where('status', 'Active')
                               ->count();
            
            $clubGrowth = $lastMonthClubs > 0 
                ? round((($totalClubs - $lastMonthClubs) / $lastMonthClubs) * 100, 1)
                : 0;

            // Calculate member growth
            $lastMonthMembers = DB::table('memberships')
                                ->where('status', 'Active')
                                ->distinct('student_id')
                                ->count('student_id');
            
            $memberGrowth = $lastMonthMembers > 0
                ? round((($totalMembers - $lastMonthMembers) / $lastMonthMembers) * 100, 1)
                : 0;

            // Get next upcoming event
            $nextEvent = DB::table('events')
                          ->where('status', 'Active')
                          ->where('event_date', '>', now()->format('Y-m-d'))
                          ->orderBy('event_date', 'asc')
                          ->first();

            $nextEventIn = $nextEvent 
                ? Carbon::parse($nextEvent->event_date)->diffForHumans()
                : 'No upcoming events';

            // Get additional statistics
            $activeStudents = DB::table('students')
                              ->where('status', 'Active')
                              ->count();

            $eventRegistrations = DB::table('event_registration')->count();

            $regularMembers = DB::table('memberships')
                              ->where('membership_type', 'Regular')
                              ->count();

            $premiumMembers = DB::table('memberships')
                              ->where('membership_type', 'Premium')
                              ->count();

            $officerMembers = DB::table('memberships')
                              ->where('membership_type', 'Officer')
                              ->count();

            $guestMembers = DB::table('memberships')
                            ->where('membership_type', 'Guest')
                            ->count();

            $activeAccounts = DB::table('student_account')
                              ->where('account_status', 'Active')
                              ->count();

            $inactiveAccounts = DB::table('student_account')
                                ->where('account_status', 'Inactive')
                                ->count();

            $bsitStudents = DB::table('students')
                            ->where('course', 'BSIT')
                            ->count();

            $bsbaStudents = DB::table('students')
                            ->where('course', 'BSBA')
                            ->count();

            $firstYearStudents = DB::table('students')
                                 ->where('year_level', 1)
                                 ->count();

            $thirdYearStudents = DB::table('students')
                                 ->where('year_level', 3)
                                 ->count();

            // Prepare stats array
            $stats = [
                'total_clubs' => $totalClubs,
                'active_events' => $activeEvents,
                'total_members' => $totalMembers,
                'upcoming_events' => $upcomingEvents,
                'club_growth' => $clubGrowth,
                'member_growth' => $memberGrowth,
                'next_event_in' => $nextEventIn,
                'active_students' => $activeStudents,
                'event_registrations' => $eventRegistrations,
                'regular_members' => $regularMembers,
                'premium_members' => $premiumMembers,
                'officer_members' => $officerMembers,
                'guest_members' => $guestMembers,
                'active_accounts' => $activeAccounts,
                'inactive_accounts' => $inactiveAccounts,
                'bsit_students' => $bsitStudents,
                'bsba_students' => $bsbaStudents,
                'first_year_students' => $firstYearStudents,
                'third_year_students' => $thirdYearStudents
            ];

            // Get upcoming events with details
            $upcoming_events = DB::table('events as e')
                ->join('clubs as c', 'e.club_id', '=', 'c.club_id')
                ->leftJoin('event_registration as er', 'e.event_id', '=', 'er.event_id')
                ->select(
                    'e.event_name as title',
                    'e.event_date as start_time',
                    'e.venue as location',
                    DB::raw('COUNT(DISTINCT er.student_id) as attendees_count'),
                    'c.club_name'
                )
                ->where('e.status', 'Active')
                ->where('e.event_date', '>', now()->format('Y-m-d'))
                ->groupBy('e.event_id', 'e.event_name', 'e.event_date', 'e.venue', 'c.club_name')
                ->orderBy('e.event_date', 'asc')
                ->limit(3)
                ->get()
                ->map(function ($event) {
                    return [
                        'title' => $event->title,
                        'start_time' => Carbon::parse($event->start_time)->format('M d, g:i A'),
                        'location' => $event->location,
                        'attendees_count' => $event->attendees_count,
                        'club_name' => $event->club_name
                    ];
                });

            return view('dashboard', compact('stats', 'upcoming_events'));

        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            // Return empty stats if there's an error
            return view('dashboard', [
                'stats' => [
                    'total_clubs' => 0,
                    'active_events' => 0,
                    'total_members' => 0,
                    'upcoming_events' => 0,
                    'club_growth' => 0,
                    'member_growth' => 0,
                    'next_event_in' => 'N/A',
                    'active_students' => 0,
                    'event_registrations' => 0,
                    'regular_members' => 0,
                    'premium_members' => 0,
                    'officer_members' => 0,
                    'guest_members' => 0,
                    'active_accounts' => 0,
                    'inactive_accounts' => 0,
                    'bsit_students' => 0,
                    'bsba_students' => 0,
                    'first_year_students' => 0,
                    'third_year_students' => 0
                ],
                'upcoming_events' => collect([])
            ]);
        }
    }
} 