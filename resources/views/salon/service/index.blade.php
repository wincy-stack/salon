@extends('salon.layout')
@section('title', 'Services')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <div></div>
    <a href="{{ route('services.create') }}" class="btn btn-pink"><i class="bi bi-plus-lg me-1"></i>Add Service</a>
</div>
<div class="card">
    <div class="card-header"><i class="bi bi-scissors me-2"></i>All Services</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>Service Name</th><th>Price</th><th>Duration</th><th>Description</th><th class="text-center">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($services as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $s->name }}</strong></td>
                <td>₱{{ number_format($s->price, 2) }}</td>
                <td><span class="badge bg-light text-dark"><i class="bi bi-clock me-1"></i>{{ $s->duration }}</span></td>
                <td>{{ $s->description ?? '—' }}</td>
                <td class="text-center">
                    <a href="{{ route('services.edit', $s) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('services.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-scissors fs-2 d-block mb-2"></i>No services yet. Add your first service!</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
