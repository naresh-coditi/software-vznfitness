<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon for date handling

class AttendanceController extends Controller
{
    public function index()
    {
        return view('CheckInMember.attendance.index', [
            'attendance' => Attendance::filter()
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($query) {
                    return Carbon::parse($query->created_at)->format('Y-m-d'); // Group by date
                })
                ->map(function ($items) {
                    return $items->groupBy('member_id'); // Further group by member_id
                }),
            'request' => request(),
            'attendenceCount' => Attendance::whereDate('created_at', request('date') ?? today())
                ->count(),
        ]);
    }
}
