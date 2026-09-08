<form method="post" action="{{ $action }}" class="admin-grid" enctype="multipart/form-data">
    @csrf
    @if($method === 'put') @method('put') @endif
    <label>Title<input name="title" value="{{ old('title', $project?->title) }}" required></label>
    <label>Slug<input name="slug" value="{{ old('slug', $project?->slug) }}" placeholder="auto generated if blank"></label>
    <label>Category<select name="project_category_id"><option value="">No category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string) old('project_category_id', $project?->project_category_id) === (string) $category->id)>{{ $category->name }}</option>@endforeach</select></label>
    <label>Status<input name="status" value="{{ old('status', $project?->status ?? 'Completed') }}"></label>
    <label>Location<input name="location" value="{{ old('location', $project?->location) }}"></label>
    <label>Address<input name="address" maxlength="500" value="{{ old('address', data_get($project?->facts, 'address')) }}" placeholder="Full property address"></label>
    <label>Sort Order<input name="sort_order" type="number" min="0" value="{{ old('sort_order', $project?->sort_order ?? 0) }}"></label>
    <label class="upload-field">
        Card Image
        <input name="card_image_upload" type="file" accept="image/jpeg,image/png,image/gif,image/bmp,image/webp,image/avif">
        <small>JPG, PNG, GIF, BMP, AVIF, or WebP. Automatically saved as WebP (max 20 MB).</small>
        @if($project?->image_path)
            <span class="upload-preview"><img src="{{ $project->image_path }}" alt="Current card image"><b>Current card image</b></span>
        @endif
        <input name="image_path" type="hidden" value="{{ old('image_path', $project?->image_path) }}">
    </label>
    <label class="upload-field">
        Hero Image
        <input name="hero_image_upload" type="file" accept="image/jpeg,image/png,image/gif,image/bmp,image/webp,image/avif">
        <small>Used on the project banner. Automatically saved as WebP (max 20 MB).</small>
        @if($project?->hero_image_path)
            <span class="upload-preview"><img src="{{ $project->hero_image_path }}" alt="Current hero image"><b>Current hero image</b></span>
        @endif
        <input name="hero_image_path" type="hidden" value="{{ old('hero_image_path', $project?->hero_image_path) }}">
    </label>
    <label class="full upload-field popup-upload">
        Popup Slider Images &amp; Videos
        <input name="popup_media[]" type="file" multiple accept="image/jpeg,image/png,image/gif,image/bmp,image/webp,image/avif,video/mp4,video/quicktime,video/webm,video/x-m4v">
        <small>Select multiple files at once. Images become WebP; MP4, MOV, M4V, and WebM videos remain video files and appear only in the popup slider. Maximum 30 files per save, 100 MB each.</small>
    </label>
    @if($project && $project->media->isNotEmpty())
        <fieldset class="full media-library">
            <legend>Current Popup Slider Media</legend>
            <p>Tick “Remove” and save the project to delete an item.</p>
            <div class="media-library-grid">
                @foreach($project->media as $media)
                    <label class="media-library-item">
                        @if($media->type === 'video')
                            <video src="{{ $media->path }}" muted preload="metadata"></video>
                            <span class="media-type">Video</span>
                        @else
                            <img src="{{ $media->path }}" alt="{{ $media->original_name ?: 'Popup image' }}">
                            <span class="media-type">WebP image</span>
                        @endif
                        <span class="media-remove"><input type="checkbox" name="remove_media[]" value="{{ $media->id }}"> Remove</span>
                    </label>
                @endforeach
            </div>
        </fieldset>
    @endif
    <label class="full">Summary<textarea name="summary">{{ old('summary', $project?->summary) }}</textarea></label>
    <label class="full">Description<textarea name="description">{{ old('description', $project?->description) }}</textarea></label>
    <label class="checkbox"><input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $project?->is_featured))> Featured</label>
    <label class="checkbox"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $project?->is_active ?? true))> Active</label>
    <div class="full"><button class="btn">Save Project</button></div>
</form>
