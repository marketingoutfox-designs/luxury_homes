@extends('layouts.app')
@section('title', 'Luxury Homes — Crafting Residences That Define Legacy')
@section('bodyClass', 'landing-page landing-page-rebuilt')
@section('hideCta', true)

@push('styles')
    @vite('resources/css/landing.css')
@endpush

@push('scripts')
    @vite('resources/js/landing.js')
@endpush

@section('content')
    <svg width="0" height="0" class="value-icon-filters" aria-hidden="true" focusable="false">
        <defs>
            <filter id="value-icon-gold" x="-20%" y="-20%" width="140%" height="140%" color-interpolation-filters="sRGB">
                <feColorMatrix type="matrix" values="
                    0 0 0 0 .72
                    0 0 0 0 .58
                    0 0 0 0 .21
                    .6 .6 .6 0 -.65" />
            </filter>
        </defs>
    </svg>
    <section class="home-hero" aria-labelledby="home-hero-title">
        <div class="home-hero-copy reveal">
            <a class="gold-outline-button" href="{{ route('works') }}">View Projects</a>
            <h1 id="home-hero-title">
                Crafting <em>Residences</em><br>
                That Define <em>Legacy</em>
            </h1>
            <p class="home-hero-description">
                <span>We create design-led luxury homes</span>
                <span>where every detail is intentional and every</span>
                <span>promise is delivered with accountability.</span>
            </p>
            <a class="primary-pill" href="{{ route('contact') }}">Let’s Get Started</a>
            <span class="home-hero-tagline">Builders <b>|</b> Collaborators <b>|</b> Design-build experts</span>
        </div>

        <div class="home-hero-visual" aria-label="Contemporary luxury residence">
            <div class="home-hero-building">
                <img src="/images/luxury-homes/landing-hero-building-v2.png" alt="Contemporary luxury residence designed by Luxury Homes">
            </div>
            <svg class="home-hero-lh" viewBox="0 0 1000 1000" preserveAspectRatio="none" aria-hidden="true">
                <g class="home-hero-lh-panels">
                    <rect x="346.3" y="477" width="77.2" height="223"></rect>
                    <rect x="640" y="477" width="76.5" height="223"></rect>
                    <rect x="0" y="700" width="1000" height="77"></rect>
                    <rect x="346.3" y="777" width="77.2" height="223"></rect>
                    <rect x="640" y="777" width="76.5" height="223"></rect>
                </g>
                <g class="home-hero-lh-lines">
                    <path d="M0 0 V777"></path>
                    <path d="M76.5 0 V700"></path>

                    <path d="M346.3 700 V477 H423.5 V700"></path>
                    <path d="M640 700 V477 H716.5 V700"></path>
                    <path d="M346.3 777 V1000 H423.5 V777"></path>
                    <path d="M640 777 V1000 H716.5 V777"></path>

                    <path d="M76.5 700 H346.3 M423.5 700 H640 M716.5 700 H1000"></path>
                    <path d="M0 777 H346.3 M423.5 777 H640 M716.5 777 H1000"></path>
                </g>
            </svg>
        </div>
    </section>

    <section class="home-intro section-shell" aria-labelledby="who-title">
        <div class="section-heading reveal">
            <span></span>
            <h2 id="who-title">Who Are We?</h2>
            <span></span>
        </div>
        <div class="home-intro-copy reveal">
            <p>Founded in <strong>2018 by Rohit Kapoor</strong>, the company has taken a remarkable leap in just eight years, evolving into one of the <strong>most preferred designer builder firms in East Delhi</strong>. With a strong focus on <strong>quality craftsmanship</strong>, <strong>innovative design solutions, and a deeply client-centric approach</strong>, it has consistently earned the trust of homeowners seeking premium, personalised living spaces.</p>
            <p>Today, the company stands as a first choice for clients <strong>who value transparency, attention to detail, and a truly luxury construction experience.</strong></p>
        </div>

        <div class="section-heading values-heading reveal">
            <span></span>
            <h2>Our Values</h2>
            <span></span>
        </div>
        <div class="value-grid">
            @foreach ([
                ['Craftsmanship', 'Precision in every detail'],
                ['Excellence', 'Uncompromising quality'],
                ['Integrity', 'Clear, accountable processes'],
                ['Personalisation', 'Homes shaped around real living'],
                ['Innovation', 'Thoughtful, relevant design'],
                ['Legacy', 'Built to last beyond trends'],
            ] as [$title, $copy])
                <article class="value-card reveal">
                    <img class="value-icon" src="/images/luxury-homes/value-icon-{{ $loop->iteration }}.png" alt="">
                    <h3>{{ $title }}</h3>
                    <p>{{ $copy }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="home-expertise" aria-labelledby="expertise-title">
        <div class="section-heading reveal">
            <span></span>
            <h2 id="expertise-title">Our <em>Expertise</em></h2>
            <span></span>
        </div>
        <div class="expertise-layout">
            <div class="expertise-image reveal">
                <img src="/images/luxury-homes/landing-expertise.png" alt="Luxury interior designed by Luxury Homes">
            </div>
            <div class="expertise-content reveal">
                <div class="expertise-list">
                    @foreach ([
                        'Vastu Consultation',
                        'Government Approvals',
                        'Civil Construction',
                        'MEP',
                        'Interior Design & Execution',
                        'Material procurement',
                        'Site Supervision',
                        'Final Finishing & Handover',
                    ] as $item)
                        <span><i aria-hidden="true"><b></b></i>{{ $item }}</span>
                    @endforeach
                </div>
                <p>We manage the complete lifecycle of a home — from planning and approvals to construction, interiors, and final delivery. A streamlined process designed for clarity, control, and long-term value.</p>
                <a href="{{ route('services') }}">Explore all services <span>→</span></a>
            </div>
        </div>
    </section>

    <section class="home-contact-band" aria-labelledby="contact-band-title">
        <div class="home-contact-intro">
            <p>Contact Us</p>
            <div>
                <h2 id="contact-band-title">Let’s Build Your Vision Together</h2>
                <span>Fill out the form and our manager will contact you for consultation.</span>
            </div>
        </div>
        <form class="home-contact-form" action="{{ route('leads.store') }}" method="POST">
            @csrf
            <input type="hidden" name="source" value="home_page">
            <label>Full Name* <input name="name" required autocomplete="name"></label>
            <label>Phone No.* <input name="phone" required autocomplete="tel"></label>
            <button type="submit">Send</button>
            <label class="privacy-check"><input type="checkbox" required> I agree with the privacy policy</label>
        </form>
    </section>

    <section class="home-projects section-shell" aria-labelledby="projects-title">
        <div class="section-heading reveal">
            <span></span>
            <h2 id="projects-title">Signature <em>Projects</em></h2>
            <span></span>
        </div>

        <div class="featured-project reveal">
            <div class="featured-copy">
                <h3>Making <em>Your Dream Home</em> A<br>Reality</h3>
                <p>We shape spaces where form, function, and emotion come together—creating environments that elevate everyday living and stand as enduring expressions of design, while translating vision into refined realities that blend aesthetics with purpose to craft homes that are intuitive, elegant, and deeply personal.</p>
                <div class="project-toolbar">
                    <button class="active" type="button" data-project-filter="all" aria-pressed="true"><i aria-hidden="true"><b></b></i><span class="filter-accent">All</span></button>
                    <button type="button" data-project-filter="ongoing" aria-pressed="false"><i aria-hidden="true"><b></b></i><span class="filter-accent">Ongoing</span> Projects</button>
                    <button type="button" data-project-filter="completed" aria-pressed="false"><i aria-hidden="true"><b></b></i><span class="filter-accent">Completed</span> Projects</button>
                </div>
            </div>
            <a class="featured-image" href="{{ $projects->first() ? route('project', $projects->first()) : route('works') }}">
                <img src="/images/luxury-homes/landing-project-feature.png" alt="Featured Luxury Homes interior">
                <span class="featured-image-control" aria-hidden="true">‹</span>
            </a>
        </div>

        <div class="home-project-grid">
            @foreach ($projects as $project)
                @php
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
                @endphp
                <a
                    class="home-project-card reveal{{ $project->slug === 'aurum-residences' ? ' project-thumbnail-contain' : '' }}"
                    data-project-status="{{ str_contains(strtolower($project->status ?: ''), 'complet') ? 'completed' : 'ongoing' }}"
                    data-home-project
                    data-project-title="{{ $project->title }}"
                    data-project-years="{{ data_get($project->facts, 'years', '—') }}"
                    data-project-label="{{ $project->title }} ({{ data_get($project->facts, 'years', '—') }}) — {{ $project->status }}"
                    data-project-location="{{ $project->location ?: 'New Delhi, Delhi' }}"
                    data-project-address="{{ data_get($project->facts, 'address') }}"
                    data-project-media="{{ $popupMedia->toJson() }}"
                    href="{{ route('project', $project) }}"
                    style="--card-index: {{ $loop->index }}"
                >
                    <span class="project-number"><b>{{ $loop->iteration }}</b></span>
                    <div class="home-project-image">
                        <img src="{{ $project->thumbnail_path }}" alt="{{ $project->title }}">
                    </div>
                    <div>
                        <span>{{ data_get($project->facts, 'years') }} — {{ $project->status }}</span>
                        <h3>{{ $project->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
        <a class="gold-outline-button projects-link" href="{{ route('works') }}">View All Projects</a>
    </section>

    <div class="home-project-modal" data-home-project-modal hidden>
        <button class="home-project-modal-backdrop" type="button" data-home-modal-close aria-label="Close project gallery"></button>
        <article class="home-project-modal-panel" role="dialog" aria-modal="true" aria-label="Project gallery" tabindex="-1">
            <div class="home-project-modal-slides" data-home-modal-slides>
            </div>

            <div class="home-project-modal-facts">
                <div><small>Year</small><strong data-home-modal-years>—</strong></div>
                <div><small>Name</small><strong data-home-modal-name>House Design</strong></div>
                <div><small>Location</small><strong data-home-modal-location>New Delhi, Delhi</strong></div>
                <div><small>Address</small><strong data-home-modal-address>—</strong></div>
            </div>

            <div class="home-project-modal-navigation">
                <button type="button" data-home-modal-previous aria-label="Previous image">‹</button>
                <button type="button" data-home-modal-next aria-label="Next image">›</button>
            </div>
        </article>
    </div>

    @include('partials.testimonials')

    <a
        class="home-whatsapp"
        href="https://wa.me/918340000005"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Chat with Luxury Homes on WhatsApp"
    >
        <img src="/images/luxury-homes/whatsapp-gold.png" alt="">
        <span>How can I help you</span>
    </a>
@endsection
