@extends('salon.layout')
@section('title', 'Booking Details')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>Booking #{{ $booking->id }}</span>
                <span class="badge badge-{{ $booking->status }} fs-6">{{ ucfirst($booking->status) }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-muted small">Customer Name</div>
                        <div class="fw-semibold">{{ $booking->customer_name }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Contact</div>
                        <div class="fw-semibold">{{ $booking->customer_contact }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Service</div>
                        <div class="fw-semibold">{{ $booking->service->name }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Duration</div>
                        <div class="fw-semibold">{{ $booking->service->duration }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Date</div>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->appointment_date)->format('F d, Y') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Time</div>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->appointment_time)->format('h:i A') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Total Price</div>
                        <div class="fw-bold fs-5" style="color:var(--primary-color)">₱{{ number_format($booking->total_price, 2) }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Payment Status</div>
                        @if($booking->payment)
                            <span class="badge badge-{{ $booking->payment->payment_status }} fs-6">{{ ucfirst($booking->payment->payment_status) }}</span>
                        @else <span class="text-muted">No payment record</span> @endif
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('payments.process', $booking) }}" class="btn btn-pink"><i class="bi bi-cash-coin me-1"></i>Process Payment</a>
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
