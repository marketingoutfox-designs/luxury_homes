@extends('admin.layout')
@section('title', 'Leads')
@section('heading', 'Leads')
@section('subheading', 'Review enquiries captured from the website and track follow-up status.')
@section('content')
<div class="admin-card">
    <div class="list-head">
        <div>
            <h3>All Leads</h3>
            <p class="muted">Contact form enquiries captured from the website.</p>
        </div>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Lead</th><th>Interest</th><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($leads as $lead)
                <tr>
                    <td><strong>{{ $lead->name }}</strong><br><span class="muted">{{ $lead->phone ?: 'No phone' }}</span><br><span class="muted">{{ $lead->email }}</span></td>
                    <td>{{ $lead->interest ?: '-' }}</td>
                    <td><span class="muted">{{ \Illuminate\Support\Str::limit($lead->message, 80) }}</span></td>
                    <td><span class="status-pill {{ $lead->status === 'New' ? 'is-active' : '' }}">{{ $lead->status }}</span></td>
                    <td>{{ $lead->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="row-actions">
                            <a class="btn small" href="{{ route('admin.leads.edit', $lead) }}">Edit</a>
                            <form method="post" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Delete this lead?')">@csrf @method('delete')<button class="btn small danger">Delete</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="admin-empty">No leads captured yet.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $leads->links() }}
</div>
@endsection
