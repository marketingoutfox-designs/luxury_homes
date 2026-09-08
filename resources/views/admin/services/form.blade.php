<form method="post" action="{{ $action }}" class="admin-grid">
    @csrf
    @if($method === 'put') @method('put') @endif
    <label>Title<input name="title" value="{{ old('title', $service?->title) }}" required></label>
    <label>Slug<input name="slug" value="{{ old('slug', $service?->slug) }}" placeholder="auto generated if blank"></label>
    <label>Icon/Text Marker<input name="icon" value="{{ old('icon', $service?->icon) }}" placeholder="01 or icon name"></label>
    <label>Sort Order<input name="sort_order" type="number" min="0" value="{{ old('sort_order', $service?->sort_order ?? 0) }}"></label>
    <label class="full">Summary<textarea name="summary">{{ old('summary', $service?->summary) }}</textarea></label>
    <label class="full">Description<textarea name="description">{{ old('description', $service?->description) }}</textarea></label>
    <label class="checkbox"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $service?->is_active ?? true))> Active</label>
    <div class="full"><button class="btn">Save Service</button></div>
</form>
