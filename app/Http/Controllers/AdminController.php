<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectMedia;
use App\Models\Service;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'serviceCount' => Service::count(),
            'leadCount' => Lead::count(),
            'newLeadCount' => Lead::where('status', 'New')->count(),
            'latestLeads' => Lead::latest()->take(5)->get(),
        ]);
    }

    public function categories(): View
    {
        return view('admin.categories.index', [
            'categories' => ProjectCategory::withCount('projects')->orderBy('sort_order')->latest()->get(),
        ]);
    }

    public function createCategory(): View
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        ProjectCategory::create($this->categoryData($request));

        return redirect()->route('admin.categories')->with('success', 'Project category added.');
    }

    public function editCategory(ProjectCategory $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, ProjectCategory $category): RedirectResponse
    {
        $category->update($this->categoryData($request, $category));

        return redirect()->route('admin.categories')->with('success', 'Project category updated.');
    }

    public function destroyCategory(ProjectCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Project category deleted.');
    }

    public function projects(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::with(['category', 'media'])->orderBy('sort_order')->latest()->get(),
        ]);
    }

    public function createProject(): View
    {
        return view('admin.projects.create', [
            'categories' => ProjectCategory::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $project = Project::create($this->projectData($request));
        $this->saveProjectUploads($request, $project);

        return redirect()->route('admin.projects')->with('success', 'Project added.');
    }

    public function editProject(Project $project): View
    {
        $project->load('media');

        return view('admin.projects.edit', [
            'project' => $project,
            'categories' => ProjectCategory::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function updateProject(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->projectData($request, $project));
        $this->saveProjectUploads($request, $project);

        return redirect()->route('admin.projects')->with('success', 'Project updated.');
    }

    public function destroyProject(Project $project): RedirectResponse
    {
        $this->deleteManagedFile($project->image_path);
        $this->deleteManagedFile($project->hero_image_path);
        foreach ($project->media as $media) {
            $this->deleteManagedFile($media->path);
        }
        $project->delete();

        return back()->with('success', 'Project deleted.');
    }

    public function services(): View
    {
        return view('admin.services.index', [
            'services' => Service::orderBy('sort_order')->latest()->get(),
        ]);
    }

    public function createService(): View
    {
        return view('admin.services.create');
    }

    public function storeService(Request $request): RedirectResponse
    {
        Service::create($this->serviceData($request));

        return redirect()->route('admin.services')->with('success', 'Service added.');
    }

    public function editService(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function updateService(Request $request, Service $service): RedirectResponse
    {
        $service->update($this->serviceData($request, $service));

        return redirect()->route('admin.services')->with('success', 'Service updated.');
    }

    public function destroyService(Service $service): RedirectResponse
    {
        $service->delete();

        return back()->with('success', 'Service deleted.');
    }

    public function contents(): View
    {
        return view('admin.contents.index', [
            'contents' => SiteContent::orderBy('label')->get(),
        ]);
    }

    public function createContent(): View
    {
        return view('admin.contents.create');
    }

    public function storeContent(Request $request): RedirectResponse
    {
        SiteContent::create($this->contentData($request));

        return redirect()->route('admin.contents')->with('success', 'Content block added.');
    }

    public function editContent(SiteContent $content): View
    {
        return view('admin.contents.edit', compact('content'));
    }

    public function updateContent(Request $request, SiteContent $content): RedirectResponse
    {
        $content->update($this->contentData($request, $content));

        return redirect()->route('admin.contents')->with('success', 'Content updated.');
    }

    public function destroyContent(SiteContent $content): RedirectResponse
    {
        $content->delete();

        return back()->with('success', 'Content deleted.');
    }

    public function leads(): View
    {
        return view('admin.leads.index', [
            'leads' => Lead::latest()->paginate(25),
        ]);
    }

    public function editLead(Lead $lead): View
    {
        return view('admin.leads.edit', compact('lead'));
    }

    public function updateLead(Request $request, Lead $lead): RedirectResponse
    {
        $lead->update($request->validate([
            'status' => ['required', 'string', 'max:255'],
            'admin_notes' => ['nullable', 'string'],
        ]));

        return redirect()->route('admin.leads')->with('success', 'Lead updated.');
    }

    public function destroyLead(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return back()->with('success', 'Lead deleted.');
    }

    private function categoryData(Request $request, ?ProjectCategory $category = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $this->uniqueSlug(ProjectCategory::class, $data['slug'] ?: $data['name'], $category?->id);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function projectData(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'project_category_id' => ['nullable', 'exists:project_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'years' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'hero_image_path' => ['nullable', 'string', 'max:255'],
            'card_image_upload' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,webp,avif', 'max:20480'],
            'hero_image_upload' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,webp,avif', 'max:20480'],
            'popup_media' => ['nullable', 'array', 'max:30'],
            'popup_media.*' => ['file', 'mimes:jpg,jpeg,png,gif,bmp,webp,avif,mp4,mov,m4v,webm', 'max:102400'],
            'remove_media' => ['nullable', 'array'],
            'remove_media.*' => ['integer'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['facts'] = array_merge($project?->facts ?? [], ['address' => $data['address'] ?? null, 'years' => $data['years'] ?? data_get($project?->facts, 'years')]);
        unset($data['address'], $data['years']);
        $data['slug'] = $this->uniqueSlug(Project::class, $data['slug'] ?: $data['title'], $project?->id);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        unset(
            $data['card_image_upload'],
            $data['hero_image_upload'],
            $data['popup_media'],
            $data['remove_media'],
        );

        return $data;
    }

    private function saveProjectUploads(Request $request, Project $project): void
    {
        $updates = [];

        if ($request->hasFile('card_image_upload')) {
            $newPath = $this->storeImageAsWebp($request->file('card_image_upload'), $project, 'card');
            $this->deleteManagedFile($project->image_path);
            $updates['image_path'] = $newPath;
        }

        if ($request->hasFile('hero_image_upload')) {
            $newPath = $this->storeImageAsWebp($request->file('hero_image_upload'), $project, 'hero');
            $this->deleteManagedFile($project->hero_image_path);
            $updates['hero_image_path'] = $newPath;
        }

        if ($updates) {
            $project->update($updates);
        }

        $removeIds = collect($request->input('remove_media', []))->map(fn ($id) => (int) $id);
        $project->media()->whereIn('id', $removeIds)->get()->each(function (ProjectMedia $media): void {
            $this->deleteManagedFile($media->path);
            $media->delete();
        });

        $sortOrder = ((int) $project->media()->max('sort_order')) + 1;
        foreach ($request->file('popup_media', []) as $file) {
            $isVideo = str_starts_with((string) $file->getMimeType(), 'video/')
                || in_array(Str::lower($file->getClientOriginalExtension()), ['mp4', 'mov', 'm4v', 'webm'], true);
            $path = $isVideo
                ? $this->storeVideo($file, $project, 'popup-video')
                : $this->storeImageAsWebp($file, $project, 'popup-image');

            $project->media()->create([
                'type' => $isVideo ? 'video' : 'image',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $isVideo ? $file->getMimeType() : 'image/webp',
                'sort_order' => $sortOrder++,
            ]);
        }
    }

    private function storeImageAsWebp(UploadedFile $file, Project $project, string $prefix): string
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            throw ValidationException::withMessages([
                'image' => 'WebP conversion is not enabled on this server. Enable the PHP GD extension with WebP support.',
            ]);
        }

        $contents = @file_get_contents($file->getRealPath());
        $image = $contents === false ? false : @imagecreatefromstring($contents);

        if ($image === false) {
            throw ValidationException::withMessages([
                $file->getClientOriginalName() => 'This image format could not be converted. Please upload JPG, PNG, GIF, BMP, WebP, or AVIF.',
            ]);
        }

        if (function_exists('exif_read_data') && in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg'], true)) {
            $orientation = @exif_read_data($file->getRealPath())['Orientation'] ?? null;
            $image = match ($orientation) {
                3 => imagerotate($image, 180, 0),
                6 => imagerotate($image, -90, 0),
                8 => imagerotate($image, 90, 0),
                default => $image,
            };
        }

        // Remove solid/near-white canvas margins commonly exported with project
        // photography. This keeps object-fit: cover focused on the photograph.
        if (function_exists('imagecropauto')) {
            $cropped = @imagecropauto($image, IMG_CROP_THRESHOLD, 0.08, 0xFFFFFF);
            if ($cropped !== false) {
                imagedestroy($image);
                $image = $cropped;
            }
        }

        if (! imageistruecolor($image)) {
            imagepalettetotruecolor($image);
        }
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $directory = $this->projectUploadDirectory($project);
        $filename = $prefix.'-'.now()->format('YmdHis').'-'.Str::lower(Str::random(8)).'.webp';
        $absolutePath = $directory.DIRECTORY_SEPARATOR.$filename;

        if (! imagewebp($image, $absolutePath, 86)) {
            imagedestroy($image);
            throw ValidationException::withMessages(['image' => 'The image could not be saved as WebP.']);
        }

        imagedestroy($image);

        return "/uploads/projects/{$project->id}/{$filename}";
    }

    private function storeVideo(UploadedFile $file, Project $project, string $prefix): string
    {
        $directory = $this->projectUploadDirectory($project);
        $extension = Str::lower($file->getClientOriginalExtension() ?: 'mp4');
        $filename = $prefix.'-'.now()->format('YmdHis').'-'.Str::lower(Str::random(8)).'.'.$extension;
        $file->move($directory, $filename);

        return "/uploads/projects/{$project->id}/{$filename}";
    }

    private function projectUploadDirectory(Project $project): string
    {
        $directory = public_path("uploads/projects/{$project->id}");
        File::ensureDirectoryExists($directory, 0755, true);

        return $directory;
    }

    private function deleteManagedFile(?string $path): void
    {
        if (! $path || ! str_starts_with($path, '/uploads/projects/')) {
            return;
        }

        File::delete(public_path(ltrim($path, '/')));
    }

    private function serviceData(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $this->uniqueSlug(Service::class, $data['slug'] ?: $data['title'], $service?->id);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function contentData(Request $request, ?SiteContent $content = null): array
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
        ]);

        $data['key'] = $this->uniqueContentKey($data['key'], $content?->id);

        return $data;
    }

    private function uniqueContentKey(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value, '_') ?: Str::random(8);
        $key = $base;
        $count = 2;

        while (SiteContent::where('key', $key)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $key = "{$base}_{$count}";
            $count++;
        }

        return $key;
    }

    private function uniqueSlug(string $model, string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: Str::random(8);
        $slug = $base;
        $count = 2;

        while ($model::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }
}
