@extends('admin.layout')
@section('title', 'Site Content')
@section('heading', 'Site Content')
@section('subheading', 'Edit key text blocks and homepage artwork path without touching code.')
@section('content')
<div class="admin-card">
    <div class="list-head">
        <div>
            <h3>All Content Blocks</h3>
            <p class="muted">Reusable editable copy and settings used by public pages.</p>
        </div>
        <a class="btn gold" href="{{ route('admin.contents.create') }}">+ Add New</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Label</th><th>Key</th><th>Title</th><th>Preview</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($contents as $content)
                <tr>
                    <td><strong>{{ $content->label }}</strong></td>
                    <td>{{ $content->key }}</td>
                    <td>{{ $content->title ?: '-' }}</td>
                    <td><span class="muted">{{ \Illuminate\Support\Str::limit($content->body, 90) }}</span></td>
                    <td>
                        <div class="row-actions">
                            <a class="btn small" href="{{ route('admin.contents.edit', $content) }}">Edit</a>
                            <form method="post" action="{{ route('admin.contents.destroy', $content) }}" onsubmit="return confirm('Delete this content block?')">@csrf @method('delete')<button class="btn small danger">Delete</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="admin-empty">No content blocks yet. Click Add New to create one.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
