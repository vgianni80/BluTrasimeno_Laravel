<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'incomplete' => Booking::incomplete()->count(),
            'complete' => Booking::complete()->count(),
            'checked_in' => Booking::checkedIn()->count(),
            'sent' => Booking::sent()->count(),
            'failed' => Booking::failed()->count(),
        ];

        $todayBookings = Booking::with(['guests', 'icalSource'])
            ->today()
            ->orderBy('created_at', 'desc')
            ->get();

        $incompleteBookings = Booking::incomplete()
            ->orderBy('check_in')
            ->limit(10)
            ->get();

        $upcomingBookings = Booking::with('guests')
            ->where('check_in', '>', today())
            ->where('check_in', '<=', today()->addDays(7))
            ->orderBy('check_in')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'todayBookings',
            'incompleteBookings',
            'upcomingBookings'
        ));
    }
}
