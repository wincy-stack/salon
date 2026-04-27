<?php
namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller {
    public function index() {
        $bookings = Booking::with(['service', 'payment'])->latest()->get();
        return view('salon.booking.index', compact('bookings'));
    }
    public function create() {
        $services = Service::all();
        return view('salon.booking.create', compact('services'));
    }
    public function store(Request $request) {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_contact' => 'required|string|max:50',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);
        $service = Service::findOrFail($request->service_id);
        $booking = Booking::create([
            'service_id' => $request->service_id,
            'customer_name' => $request->customer_name,
            'customer_contact' => $request->customer_contact,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'total_price' => $service->price,
        ]);
        // Auto-create payment record
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $service->price,
            'payment_status' => 'unpaid',
        ]);
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }
    public function show(Booking $booking) {
        $booking->load(['service', 'payment']);
        return view('salon.booking.show', compact('booking'));
    }
    public function destroy(Booking $booking) {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted.');
    }
}
