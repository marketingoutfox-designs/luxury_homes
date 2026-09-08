@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('heading', 'Dashboard')
@section('content')
<div class="stats">
    <div class="admin-card stat"><span>Projects</span><b>{{ $projectCount }}</b></div>
    <div class="admin-card stat"><span>Services</span><b>{{ $serviceCount }}</b></div>
    <div class="admin-card stat"><span>Total Leads</span><b>{{ $leadCount }}</b></div>
    <div class="admin-card stat"><span>New Leads</span><b>{{ $newLeadCount }}</b></div>
</div>
<div class="admin-card">
    <h3>Latest Leads</h3>
    <div class="table-wrap"><table class="table"><thead><tr><th>Name</th><th>Phone</th><th>Interest</th><th>Status</th></tr></thead><tbody>
    @forelse($latestLeads as $lead)<tr><td>{{ $lead->name }}</td><td>{{ $lead->phone }}</td><td>{{ $lead->interest }}</td><td>{{ $lead->status }}</td></tr>@empty<tr><td colspan="4">No leads yet.</td></tr>@endforelse
    </tbody></table></div>
</div>
@endsection
