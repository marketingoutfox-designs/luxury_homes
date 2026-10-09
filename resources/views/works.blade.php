@extends('layouts.app')

@section('title', 'Our Works — Luxury Homes')
@section('bodyClass', 'works-design landing-page-rebuilt')

@push('styles')
    @vite(['resources/css/landing.css', 'resources/css/works.css'])
@endpush

@section('content')
    <section class="works-banner" aria-labelledby="works-title">
        <div class="works-banner-image" aria-hidden="true"></div>
        <div class="works-banner-shade" aria-hidden="true"></div>
        <div class="works-banner-copy">
            <h1 id="works-title"><span>Signature</span> Projects</h1>
        </div>
    </section>

    <section class="works-catalogue" aria-label="Luxury Homes projects">
        <nav class="works-filters" aria-label="Filter projects">
            <button class="works-filter is-active" type="button" data-works-filter="all">
                <span class="works-arrow" aria-hidden="true">&#8594;</span><span>All</span>
            </button>
            <button class="works-filter" type="button" data-works-filter="ongoing">
                <span class="works-arrow" aria-hidden="true">&#8594;</span><span>Ongoing Projects</span>
            </button>
            <button class="works-filter" type="button" data-works-filter="completed">
                <span class="works-arrow" aria-hidden="true">&#8594;</span><span>Completed Projects</span>
            </button>
        </nav>

        <div class="works-divider" aria-hidden="true"></div>

        <div class="works-grid">
            @forelse ($projects as $project)
                @php
                    $filterStatus = str_contains(strtolower($project->status ?: ''), 'complet') ? 'completed' : 'ongoing';
                    $projectNumber = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                    $popupMedia = $project->media->map(fn ($media) => [
                        'type' => $media->type,
                        'path' => $media->path,
                        'mime' => $media->mime_type,
                    ])->values();
                    if ($popupMedia->isEmpty()) {
                        $popupMedia = collect([$project->hero_image_path, $project->image_path])
                            ->filter()
                            ->unique()
                            ->map(fn ($path) => ['type' => 'image', 'path' => $path, 'mime' => 'image/webp'])
                            ->values();
                        if ($popupMedia->isEmpty()) {
                            $popupMedia = collect([['type' => 'image', 'path' => '/images/luxury-homes/landing-project-card.png', 'mime' => 'image/webp']]);
                        }
                    }
                    $cardImage = $project->thumbnail_path;
                    $hoverImage = $project->hero_image_path
                        ?: optional($project->media->first(fn ($media) => $media->type === 'image' && $media->path !== $cardImage))->path
                        ?: $cardImage;
                    if ($project->slug === 'aurum-residences') {
                        $hoverImage = $cardImage;
                    }
                @endphp
                <button
                    class="works-card"
                    data-project-slug="{{ $project->slug }}"
                    type="button"
                    data-project-status="{{ $filterStatus }}"
                    data-project-number="{{ $projectNumber }}"
                    data-project-title="{{ $project->title }}"
                    data-project-years="{{ data_get($project->facts, 'years', '—') }}"
                    data-project-label="{{ $project->title }} ({{ data_get($project->facts, 'years', '—') }}) — {{ $project->status }}"
                    data-project-location="{{ $project->location ?: 'New Delhi, Delhi' }}"
                    data-project-address="{{ data_get($project->facts, 'address') }}"
                    data-project-summary="{{ $project->summary ?: 'A considered residence shaped around proportion, material, light, and the way its owners live.' }}"
                    data-project-description="{{ $project->description ?: 'Every element of this home was developed as part of one cohesive design vision, from the architecture and planning to its interiors and finishing details.' }}"
                    data-project-media="{{ $popupMedia->toJson() }}"
                    aria-label="Open {{ $project->title }} project"
                >
                    <span class="works-card-media" aria-hidden="true">
                        <span class="works-card-photo">
                        <img class="works-card-image works-card-image-default" src="{{ $cardImage }}" alt="">
                        <img class="works-card-image works-card-image-hover" src="{{ $hoverImage }}" alt="">
                        </span>
                    </span>
                    <span class="works-card-shade" aria-hidden="true"></span>
                    <span class="works-card-caption">
                        <small>{{ data_get($project->facts, 'years') }} — {{ $project->status }}</small>
                        <strong>{{ $project->title }}</strong>
                        <i aria-hidden="true">&#8594;</i>
                    </span>
                </button>
            @empty
                <p class="works-empty">No projects are available yet.</p>
            @endforelse
        </div>
    </section>

    <div class="works-modal" data-works-modal hidden>
        <button class="works-modal-backdrop" type="button" data-modal-close aria-label="Close project"></button>
        <article class="works-modal-panel" role="dialog" aria-modal="true" aria-labelledby="works-modal-title" tabindex="-1">
            <button class="works-modal-close" type="button" data-modal-close aria-label="Close project">&#215;</button>

            <div class="works-modal-feature">
                <div class="works-modal-slides" data-modal-slides>
                </div>

                <div class="works-modal-facts">
                    <div><small>Year</small><strong id="works-modal-years">—</strong></div>
                    <div><small>Name</small><strong id="works-modal-name">House Design</strong></div>
                    <div><small>Location</small><strong id="works-modal-location">New Delhi, Delhi</strong></div>
                    <div><small>Address</small><strong id="works-modal-address">—</strong></div>
                </div>

                <div class="works-modal-navigation">
                    <button type="button" data-modal-previous aria-label="Previous image">&#8592;</button>
                    <button type="button" data-modal-next aria-label="Next image">&#8594;</button>
                </div>
            </div>

            <div class="works-modal-copy">
                <p class="works-modal-kicker" id="works-modal-kicker">Project 01</p>
                <h2 id="works-modal-title">House Design</h2>
                <p id="works-modal-summary"></p>
                <p id="works-modal-description"></p>
            </div>

        </article>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/works.js')
@endpush
