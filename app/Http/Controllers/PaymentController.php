<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller {

    public function index(Request $request) {
        $query = Payment::with('booking.service')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Search by customer name or service name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking', function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('service', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->get();
        return view('salon.payments.index', compact('payments'));
    }

    public function process(Booking $booking) {
        $payment = $booking->payment;
        if (!$payment) {
            // Auto-create payment record if missing
            $payment = \App\Models\Payment::create([
                'booking_id'     => $booking->id,
                'amount'         => $booking->total_price,
                'payment_status' => 'unpaid',
            ]);
        }
        return view('salon.payments.process', compact('booking', 'payment'));
    }

    public function update(Request $request, Payment $payment) {
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid',
            'payment_method' => 'required_if:payment_status,paid|nullable|string',
        ]);

        $payment->update([
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
            'paid_at'        => $request->payment_status === 'paid' ? now() : null,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment ' . ($request->payment_status === 'paid' ? 'marked as Paid' : 'marked as Unpaid') . ' successfully!');
    }
}
