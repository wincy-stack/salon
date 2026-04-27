@extends('salon.layout')
@section('title', 'New Booking')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-calendar-plus me-2"></i>Create New Booking</div>
            <div class="card-body">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <h6 class="text-muted mb-3 text-uppercase" style="font-size:.75rem;letter-spacing:1px">Customer Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Customer Name *</label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" placeholder="Full name">
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Contact Number *</label>
                            <input type="text" name="customer_contact" class="form-control @error('customer_contact') is-invalid @enderror" value="{{ old('customer_contact') }}" placeholder="Phone or email">
                            @error('customer_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <h6 class="text-muted mb-3 mt-2 text-uppercase" style="font-size:.75rem;letter-spacing:1px">Appointment Details</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Service *</label>
                        <select name="service_id" id="serviceSelect" class="form-select @error('service_id') is-invalid @enderror" onchange="updatePrice(this)">
                            <option value="">-- Choose a service --</option>
                            @foreach($services as $s)
                            <option value="{{ $s->id }}" data-price="{{ $s->price }}" data-duration="{{ $s->duration }}" {{ old('service_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }} — ₱{{ number_format($s->price,2) }} ({{ $s->duration }})
                            </option>
                            @endforeach
                        </select>
                        @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div id="serviceInfo" class="alert" style="background:var(--pink-light);border:none;display:none">
                        <strong>Selected:</strong> <span id="svcName"></span> &nbsp;|&nbsp; <strong>Price:</strong> ₱<span id="svcPrice"></span> &nbsp;|&nbsp; <strong>Duration:</strong> <span id="svcDuration"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Appointment Date *</label>
                            <input type="date" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}">
                            @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Appointment Time *</label>
                            <input type="time" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" value="{{ old('appointment_time') }}">
                            @error('appointment_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-pink"><i class="bi bi-calendar-check me-1"></i>Create Booking</button>
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function updatePrice(sel) {
    const opt = sel.options[sel.selectedIndex];
    const info = document.getElementById('serviceInfo');
    if (opt.value) {
        document.getElementById('svcName').textContent = opt.text.split(' — ')[0];
        document.getElementById('svcPrice').textContent = parseFloat(opt.dataset.price).toFixed(2);
        document.getElementById('svcDuration').textContent = opt.dataset.duration;
        info.style.display = 'block';
    } else { info.style.display = 'none'; }
}
</script>
@endsection
