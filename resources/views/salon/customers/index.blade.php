@extends('salon.layout')
@section('title', 'Customers')
@section('content')
<div class="card">
    <div class="card-header">All Customers</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th class="text-center">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($customers as $c)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $c->name }}</strong></td>
                <td>{{ $c->email ?? '—' }}</td>
                <td>{{ $c->phone }}</td>
                <td>{{ $c->address ?? '—' }}</td>
                <td class="text-center">
                    <a href="{{ route('customers.edit', $c) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                    <form action="{{ route('customers.destroy', $c) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this customer?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No customers yet. Add your first customer!</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection