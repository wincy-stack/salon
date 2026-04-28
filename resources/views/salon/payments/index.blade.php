@extends('salon.layout')
@section('title', 'Payments')
@section('content')

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small mb-1">Total Revenue</div>
            <div class="fs-5 fw-bold" style="color:var(--primary-color)">
                ₱{{ number_format($payments->where('payment_status','paid')->sum('amount'), 2) }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small mb-1">Paid</div>
            <div class="fs-5 fw-bold text-success">{{ $payments->where('payment_status','paid')->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small mb-1">Unpaid</div>
            <div class="fs-5 fw-bold text-danger">{{ $payments->where('payment_status','unpaid')->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small mb-1">Total Transactions</div>
            <div class="fs-5 fw-bold">{{ $payments->count() }}</div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="card mb-3">
    <div class="card-body py-2 px-3">
        <form method="GET" action="{{ route('payments.index') }}" class="d-flex align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 text-muted small fw-semibold">Status:</label>
                <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="paid"   {{ request('status') == 'paid'   ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 text-muted small fw-semibold">Search:</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Customer or service…" value="{{ request('search') }}" style="width:200px">
            </div>
            <button class="btn btn-sm btn-outline-secondary" type="submit">Filter</button>
            @if(request('status') || request('search'))
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-link text-muted p-0">Clear</a>
            @endif
        </form>
    </div>
</div>

{{-- Payment History Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Payment History</span>
        <span class="text-muted small">{{ $payments->count() }} record(s)</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Appointment</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Paid At</th>
                    <th>Booking Status</th>
                    <th>Payment Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($payments as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $p->booking->customer_name }}</strong><br>
                    <small class="text-muted">{{ $p->booking->customer_contact }}</small>
                </td>
                <td>{{ $p->booking->service->name }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($p->booking->appointment_date)->format('M d, Y') }}<br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($p->booking->appointment_time)->format('h:i A') }}</small>
                </td>
                <td class="fw-semibold">₱{{ number_format($p->amount, 2) }}</td>
                <td>
                    @if($p->payment_method)
                        <span class="badge bg-light text-dark border">{{ $p->payment_method }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>
                    @if($p->paid_at)
                        {{ \Carbon\Carbon::parse($p->paid_at)->format('M d, Y') }}<br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($p->paid_at)->format('h:i A') }}</small>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td><span class="badge badge-{{ $p->booking->status }}">{{ ucfirst($p->booking->status) }}</span></td>
                <td>
                    <span class="badge badge-{{ $p->payment_status }}">{{ ucfirst($p->payment_status) }}</span>
                </td>
                <td class="text-center">
                    <a href="{{ route('payments.process', $p->booking) }}"
                       class="btn btn-sm btn-outline-primary" title="Process / Edit Payment">
                        Pay
                    </a>
                </td>
            </tr>Pay
            @empty
            <tr>
                <td colspan="10" class="text-center text-muted py-5">
                    No payment records found.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
