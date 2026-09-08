@extends('admin.layout')
@section('title', 'Edit Lead')
@section('heading', 'Edit Lead')
@section('subheading', 'Update lead status and internal follow-up notes.')
@section('content')
<div class="admin-card">
    <div class="lead-summary">
        <div><span>Name</span><strong>{{ $lead->name }}</strong></div>
        <div><span>Phone</span><strong>{{ $lead->phone ?: '-' }}</strong></div>
        <div><span>Email</span><strong>{{ $lead->email ?: '-' }}</strong></div>
        <div><span>Interest</span><strong>{{ $lead->interest ?: '-' }}</strong></div>
    </div>
    <form method="post" action="{{ route('admin.leads.update', $lead) }}" class="admin-grid">@csrf @method('put')
        <label>Status<select name="status">@foreach(['New','Contacted','Qualified','Closed','Rejected'] as $status)<option @selected($lead->status === $status)>{{ $status }}</option>@endforeach</select></label>
        <label class="full">Message<textarea disabled>{{ $lead->message }}</textarea></label>
        <label class="full">Admin Notes<textarea name="admin_notes">{{ old('admin_notes', $lead->admin_notes) }}</textarea></label>
        <div class="full inline-actions"><button class="btn gold">Save Lead</button><a class="btn ghost" href="{{ route('admin.leads') }}">Cancel</a></div>
    </form>
</div>
@endsection
