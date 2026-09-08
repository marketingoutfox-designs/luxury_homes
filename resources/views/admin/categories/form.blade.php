<form method="post" action="{{ $action }}" class="admin-grid">
    @csrf
    @if($method === 'put') @method('put') @endif
    <label>Name<input name="name" value="{{ old('name', $category?->name) }}" required></label>
    <label>Slug<input name="slug" value="{{ old('slug', $category?->slug) }}" placeholder="auto generated if blank"></label>
    <label>Sort Order<input name="sort_order" type="number" value="{{ old('sort_order', $category?->sort_order ?? 0) }}" min="0"></label>
    <label class="checkbox"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $category?->is_active ?? true))> Active</label>
    <label class="full">Description<textarea name="description">{{ old('description', $category?->description) }}</textarea></label>
    <div class="full inline-actions"><button class="btn gold">{{ $category ? 'Save Changes' : 'Create Category' }}</button><a class="btn ghost" href="{{ route('admin.categories') }}">Cancel</a></div>
</form>
