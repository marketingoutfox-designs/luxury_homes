<form method="post" action="{{ $action }}" class="admin-grid">
    @csrf
    @if($method === 'put') @method('put') @endif
    <label>Label<input name="label" value="{{ old('label', $content?->label) }}" required></label>
    <label>Key<input name="key" value="{{ old('key', $content?->key) }}" required placeholder="about_intro"></label>
    <label class="full">Title<input name="title" value="{{ old('title', $content?->title) }}"></label>
    <label class="full">Body<textarea name="body">{{ old('body', $content?->body) }}</textarea></label>
    <div class="full inline-actions"><button class="btn gold">{{ $content ? 'Save Changes' : 'Create Content' }}</button><a class="btn ghost" href="{{ route('admin.contents') }}">Cancel</a></div>
</form>
