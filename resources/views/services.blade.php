@extends('layouts.app')

@section('title', 'Services — Luxury Homes')
@section('bodyClass', 'services-design landing-page-rebuilt')

@push('styles')
    @vite(['resources/css/landing.css', 'resources/css/services.css'])
@endpush

@section('content')
    @php
        $serviceCards = [
            ['Vastu Consultation', 'Integration of Vastu principles to enhance spatial harmony and well-being.'],
            ['Government Approvals', 'End-to-end assistance in obtaining necessary statutory approvals and clearances.'],
            ['Civil Construction', 'Execution of structural and construction work with a focus on quality and durability.'],
            ['MEP', 'Efficient design and implementation of all essential building services systems.'],
            ['Interior Design & Execution', 'Thoughtfully curated interiors with seamless execution aligned to the overall design vision.'],
            ['Material procurement', 'Sourcing and supply of high-quality materials ensuring consistency and cost efficiency.'],
            ['Site Supervision', 'Continuous on-site monitoring to maintain quality standards and project timelines.'],
            ['Final Finishing & Handover', 'Attention to detail in final finishes, ensuring a complete and ready-to-move-in delivery.'],
        ];
    @endphp

    <section class="services-hero" aria-labelledby="services-title">
        <div class="services-hero-overlay"></div>
        <div class="services-hero-copy reveal">
            <p class="services-kicker">WHAT WE DO?</p>
            <h1 id="services-title"><em>End-to-End</em><br>Residential<br>Development</h1>
            <p class="services-hero-tagline"><strong>From concept to handover.</strong><br>One team. Complete accountability.</p>
        </div>
    </section>

    <section class="services-catalogue" aria-label="Our complete residential development services">
        <div class="services-shell">
            <p class="services-introduction reveal">We manage the complete lifecycle of a home — from planning and approvals to construction, interiors, and final delivery.<br>A streamlined process designed for clarity, control, and long-term value.</p>

            <div class="services-card-grid">
                @foreach ($serviceCards as [$title, $description])
                    <article class="services-card reveal" style="--reveal-delay: {{ ($loop->index % 4) * 70 }}ms">
                        <span class="services-card-number">{{ $loop->iteration }}</span>
                        <h2>{{ $title }}</h2>
                        <p>{{ $description }}</p>
                    </article>
                    @if ($loop->iteration === 4)
                        <span class="services-row-divider" aria-hidden="true"></span>
                    @endif
                @endforeach
            </div>

            <div class="development-options">
                <article class="development-card reveal">
                    <div class="development-icon" aria-hidden="true">
                        <svg viewBox="0 0 64 64">
                            <path d="M9 27.5c7-5.3 12.5-4.2 17.5 0l4.2 3.5-10.1 8.4a6.7 6.7 0 0 1-9-.4L4 31.5z"></path>
                            <path d="m55 27.5-11.8-5.8a8.4 8.4 0 0 0-8.7.8l-9 7.2 3.5 3.1a5.8 5.8 0 0 0 7.4.2l4.8-3.5 16.8 13"></path>
                            <path d="m24 42 8.6 7.1a4.2 4.2 0 0 0 6-.6l.9-1.1m-12.2-1.9 7.5 6.2a4.1 4.1 0 0 0 5.8-.6l1-1.2m-18-8.4 8.1 6.6m9.6-14.8 10.1 8.2a4.1 4.1 0 0 1 .5 5.8 4.1 4.1 0 0 1-5.8.5L36 39.6"></path>
                            <path d="M6 21.5h11l5.7 4.6M58 21.5H47l-4.4 2.2"></path>
                        </svg>
                    </div>
                    <div>
                        <h2>Joint Development</h2>
                        <p>We partner with landowners to unlock the full value of their property — managing planning, approvals, construction, and sales with complete transparency.</p>
                    </div>
                </article>

                <article class="development-card reveal">
                    <div class="development-icon" aria-hidden="true">
                        <svg viewBox="0 0 64 64">
                            <path d="M11 31.5 32 12l21 19.5"></path>
                            <path d="M16.5 27.5V52h31V27.5M27 52V37h10v15"></path>
                        </svg>
                    </div>
                    <div>
                        <h2>Self-Managed</h2>
                        <p>Premium builder floors and residences designed for modern living — with a focus on layout, finish, and long-term value.</p>
                    </div>
                </article>
            </div>

            <span class="services-end-dot" aria-hidden="true"></span>
        </div>
    </section>
@endsection
