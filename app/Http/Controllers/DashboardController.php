<?php
namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Payment;

class DashboardController extends Controller {
    public function index() {
        return view('salon.dashboard', [
            'totalServices' => Service::count(),
            'totalBookings' => Booking::count(),
            'totalRevenue' => Payment::where('payment_status','paid')->sum('amount'),
            'pendingBookings' => Booking::where('status','pending')->count(),
            'recentBookings' => Booking::with('service')->latest()->take(5)->get(),
            'services' => Service::latest()->take(6)->get(),
        ]);
    }
}
