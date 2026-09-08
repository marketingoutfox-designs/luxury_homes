<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'homeContent' => SiteContent::where('key', 'home_landing')->first(),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'projects' => Project::with(['category', 'media'])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function about(): View
    {
        return view('about', [
            'contents' => SiteContent::whereIn('key', [
                'about_intro',
                'about_rohit',
                'about_hitesh',
            ])->get()->keyBy('key'),
        ]);
    }

    public function works(Request $request): View
    {
        $activeCategory = $request->string('category')->toString();
        $projects = Project::with(['category', 'media'])
            ->where('is_active', true)
            ->when($activeCategory, fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $activeCategory)))
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('works', [
            'categories' => ProjectCategory::where('is_active', true)->orderBy('sort_order')->get(),
            'projects' => $projects,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function project(Project $project): View
    {
        abort_unless($project->is_active, 404);

        $project->load('media');

        return view('project', compact('project'));
    }

    public function services(): View
    {
        return view('services', [
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'content' => SiteContent::where('key', 'services_intro')->first(),
        ]);
    }

    public function contact(): View
    {
        return view('contact', [
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function storeLead(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'interest' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:4000'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        Lead::create($data + ['source' => $data['source'] ?? 'contact_page']);

        return back()->with('success', 'Thank you. Our team will contact you shortly.');
    }
}
