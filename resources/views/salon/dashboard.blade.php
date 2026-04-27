@extends('salon.layout')
@section('title', 'Dashboard')
@section('content')

{{-- Stats Row --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-5 fw-bold">{{ $totalServices }}</div>
                    <div class="small opacity-75">Total Services</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-5 fw-bold">{{ $totalBookings }}</div>
                    <div class="small opacity-75">Total Bookings</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-5 fw-bold">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="small opacity-75">Total Revenue</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-5 fw-bold">{{ $pendingBookings }}</div>
                    <div class="small opacity-75">Pending Bookings</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tables Row --}}
<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Bookings</span>
                <a href="{{ route('bookings.create') }}" class="btn btn-sm btn-light">+ New</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $b)
                        <tr>
                            <td>{{ $b->customer_name }}</td>
                            <td>{{ $b->service->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->appointment_date)->format('M d, Y') }}</td>
                            <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No bookings yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Services Overview</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>₱{{ number_format($s->price, 2) }}</td>
                            <td>{{ $s->duration }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">No services yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection