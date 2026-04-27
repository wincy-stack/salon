@extends('salon.layout')
@section('title', 'Process Payment')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Booking Summary --}}
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-receipt me-2"></i>Booking Summary</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="text-muted small">Customer</div>
                        <div class="fw-semibold">{{ $booking->customer_name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Contact</div>
                        <div class="fw-semibold">{{ $booking->customer_contact }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Service</div>
                        <div class="fw-semibold">{{ $booking->service->name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Appointment</div>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}
                            at {{ \Carbon\Carbon::parse($booking->appointment_time)->format('h:i A') }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Booking Status</div>
                        <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Current Payment Status</div>
                        <span class="badge badge-{{ $payment->payment_status }}">
                            <i class="bi bi-{{ $payment->payment_status == 'paid' ? 'check-circle' : 'hourglass-split' }} me-1"></i>
                            {{ ucfirst($payment->payment_status) }}
                        </span>
                    </div>
                    <div class="col-12">
                        <div class="alert mb-0" style="background:var(--primary-light);border:none">
                            <span class="fw-semibold">Total Amount Due:</span>
                            <span class="fs-5 fw-bold ms-2" style="color:var(--primary-color)">
                                ₱{{ number_format($booking->total_price, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Process Payment Form --}}
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-cash-coin me-2"></i>Update Payment</div>
            <div class="card-body">
                <form action="{{ route('payments.update', $payment) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Status <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_status" id="statusUnpaid"
                                    value="unpaid" {{ $payment->payment_status == 'unpaid' ? 'checked' : '' }}
                                    onchange="toggleMethod(this.value)">
                                <label class="form-check-label text-danger fw-semibold" for="statusUnpaid">
                                    <i class="bi bi-hourglass-split me-1"></i>Unpaid
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_status" id="statusPaid"
                                    value="paid" {{ $payment->payment_status == 'paid' ? 'checked' : '' }}
                                    onchange="toggleMethod(this.value)">
                                <label class="form-check-label text-success fw-semibold" for="statusPaid">
                                    <i class="bi bi-check-circle me-1"></i>Paid
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="methodDiv" class="mb-3" style="{{ $payment->payment_status == 'paid' ? '' : 'display:none' }}">
                        <label class="form-label fw-semibold">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="">-- Select Method --</option>
                            @foreach(['Cash','GCash','PayMaya','Credit Card','Debit Card','Bank Transfer'] as $m)
                            <option value="{{ $m }}" {{ $payment->payment_method == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Required when marking as Paid.</div>
                    </div>

                    <div id="amountDiv" class="mb-3">
                        <label class="form-label fw-semibold">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number" name="amount" class="form-control"
                                value="{{ $payment->amount }}" step="0.01" min="0" readonly>
                        </div>
                        <div class="form-text">Amount is based on the service price.</div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-pink">
                            <i class="bi bi-check-lg me-1"></i>Save Payment
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Back to Payments
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Transaction Record --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-clock-history me-2"></i>Transaction Record</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr><th>Field</th><th>Value</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-muted">Transaction ID</td>
                            <td><span class="badge bg-light text-dark border">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Amount</td>
                            <td class="fw-semibold">₱{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Payment Status</td>
                            <td>
                                <span class="badge badge-{{ $payment->payment_status }}">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Payment Method</td>
                            <td>{{ $payment->payment_method ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Paid At</td>
                            <td>
                                @if($payment->paid_at)
                                    {{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}
                                @else
                                    <span class="text-muted">Not yet paid</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Record Created</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Last Updated</td>
                            <td>{{ \Carbon\Carbon::parse($payment->updated_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
function toggleMethod(val) {
    document.getElementById('methodDiv').style.display = val === 'paid' ? 'block' : 'none';
}
// Init on page load
document.addEventListener('DOMContentLoaded', function() {
    const checked = document.querySelector('input[name="payment_status"]:checked');
    if (checked) toggleMethod(checked.value);
});
</script>
@endsection
