@extends('salon.layout')
@section('title', 'Bookings')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('bookings.create') }}" class="btn btn-pink"><i class="bi bi-plus-lg me-1"></i>New Booking</a>
</div>
<div class="card">
    <div class="card-header"><i class="bi bi-calendar-check me-2"></i>All Bookings</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>Customer</th><th>Contact</th><th>Service</th><th>Date & Time</th><th>Price</th><th>Status</th><th>Payment</th><th class="text-center">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($bookings as $b)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $b->customer_name }}</strong></td>
                <td>{{ $b->customer_contact }}</td>
                <td>{{ $b->service->name }}</td>
                <td>{{ \Carbon\Carbon::parse($b->appointment_date)->format('M d, Y') }}<br><small class="text-muted">{{ \Carbon\Carbon::parse($b->appointment_time)->format('h:i A') }}</small></td>
                <td>₱{{ number_format($b->total_price, 2) }}</td>
                <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                <td>
                    @if($b->payment)
                        <span class="badge badge-{{ $b->payment->payment_status }}">{{ ucfirst($b->payment->payment_status) }}</span>
                    @else <span class="text-muted">—</span> @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('bookings.show', $b) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('payments.process', $b) }}" class="btn btn-sm btn-outline-success me-1" title="Process Payment"><i class="bi bi-cash-coin"></i></a>
                    <form action="{{ route('bookings.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this booking?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center text-muted py-4"><i class="bi bi-calendar-x fs-2 d-block mb-2"></i>No bookings yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
