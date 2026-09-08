@extends('admin.layout')
@section('title', 'Services')
@section('heading', 'Services')
@section('subheading', 'Control the services shown on the public Services page and lead form.')
@section('content')
<div class="admin-card">
    <div class="list-head">
        <div>
            <h3>All Services</h3>
            <p class="muted">Service offerings shown on the website.</p>
        </div>
        <a class="btn gold" href="{{ route('admin.services.create') }}">+ Add New</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Service</th><th>Marker</th><th>Sort</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($services as $service)
                <tr>
                    <td><strong>{{ $service->title }}</strong><br><span class="muted">{{ $service->summary }}</span></td>
                    <td>{{ $service->icon ?: '-' }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td><span class="status-pill {{ $service->is_active ? 'is-active' : '' }}">{{ $service->is_active ? 'Active' : 'Hidden' }}</span></td>
                    <td>
                        <div class="row-actions">
                            <a class="btn small" href="{{ route('admin.services.edit', $service) }}">Edit</a>
                            <form method="post" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">@csrf @method('delete')<button class="btn small danger">Delete</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="admin-empty">No services yet. Click Add New to create one.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
