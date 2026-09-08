@extends('admin.layout')
@section('title', 'Projects')
@section('heading', 'Projects')
@section('subheading', 'Add, update, sort, and publish signature residential projects.')
@section('content')
<div class="admin-card">
    <div class="list-head">
        <div>
            <h3>All Projects</h3>
            <p class="muted">Portfolio items visible on Our Works and project detail pages.</p>
        </div>
        <a class="btn gold" href="{{ route('admin.projects.create') }}">+ Add New</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Project</th><th>Category</th><th>Location</th><th>Status</th><th>Sort</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($projects as $project)
                <tr>
                    <td><strong>{{ $project->title }}</strong><br><span class="muted">{{ $project->slug }}</span></td>
                    <td>{{ $project->category?->name ?: 'No category' }}</td>
                    <td>{{ $project->location ?: '-' }}</td>
                    <td>{{ $project->status }}</td>
                    <td>{{ $project->sort_order }}</td>
                    <td><span class="status-pill {{ $project->is_active ? 'is-active' : '' }}">{{ $project->is_active ? 'Active' : 'Hidden' }}</span></td>
                    <td>
                        <div class="row-actions">
                            <a class="btn small" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                            <form method="post" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">@csrf @method('delete')<button class="btn small danger">Delete</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><div class="admin-empty">No projects yet. Click Add New to create one.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
