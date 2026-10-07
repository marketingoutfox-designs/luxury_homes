@extends('admin.layout')
@section('title', 'Project Categories')
@section('heading', 'Project Categories')
@section('subheading', 'Create and organize portfolio groups such as completed and ongoing.')
@section('content')
<div class="admin-card">
    <div class="list-head">
        <div>
            <h3>All Categories</h3>
            <p class="muted">Manage project category labels and ordering.</p>
        </div>
        <a class="btn gold" href="{{ route('admin.categories.create') }}">+ Add New</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Name</th><th>Slug</th><th>Projects</th><th>Sort</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td><strong>{{ $category->name }}</strong><br><span class="muted">{{ \Illuminate\Support\Str::limit($category->description, 80) }}</span></td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->projects_count }}</td>
                    <td>{{ $category->sort_order }}</td>
                    <td><span class="status-pill {{ $category->is_active ? 'is-active' : '' }}">{{ $category->is_active ? 'Active' : 'Hidden' }}</span></td>
                    <td>
                        <div class="row-actions">
                            <a class="btn small" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                            <form method="post" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('delete')<button class="btn small danger">Delete</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="admin-empty">No categories yet. Click Add New to create one.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
