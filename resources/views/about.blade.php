@extends('layouts.app')

@section('title', 'About Us — Luxury Homes')
@section('bodyClass', 'about-design landing-page-rebuilt')

@push('styles')
    @vite(['resources/css/landing.css', 'resources/css/about.css'])
@endpush

@section('content')
    <section class="about-hero" aria-labelledby="about-title">
        <div class="about-hero-image" data-about-hero-image aria-hidden="true"></div>
        <div class="about-hero-overlay" aria-hidden="true"></div>
        <div class="about-hero-copy">
            <h1 id="about-title">Built on <em>Vision.</em><br>Driven by <em>Values.</em></h1>
            <p><strong>From concept to handover.</strong><br>One team. Complete accountability.</p>
        </div>
    </section>

    <section class="about-story" aria-label="About Luxury Homes">
        <p class="about-introduction about-scroll-reveal">
            Luxury Homes was built on a simple belief — that homes deserve more thought, more care, and greater accountability.<br>
            We focus on fewer developments, ensuring each project is approached with clarity, precision, and long-term value in mind.
        </p>

        <article class="about-profile" data-about-profile>
            <div class="about-profile-photo">
                <img src="/images/luxury-homes/about-founder-portrait.png" alt="Rohit Kapoor, Founder and CEO">
            </div>
            <div class="about-profile-copy">
                <div class="about-profile-heading">
                    <div>
                        <h2>ROHIT KAPOOR</h2>
                        <h3>Founder, CEO</h3>
                    </div>
                    <span aria-hidden="true"></span>
                </div>

                <p>At Luxury Homes, we create more than just residences — we craft thoughtfully designed living spaces that bring comfort, security, and a lasting sense of belonging. Every home is envisioned as a place where memories are made, families grow, and meaningful moments unfold.</p>

                <p>Driven by a commitment to excellence, we combine refined design, superior craftsmanship, and modern construction practices to deliver homes that are both timeless and enduring. From carefully selected materials to meticulous attention to detail, every element is designed to elevate everyday living.</p>

                <p>Our approach is rooted in transparency, integrity, and customer trust. Whether you are purchasing your first home or investing in a luxury property, we ensure a seamless and rewarding experience from concept to completion.</p>

                <p>At Luxury Homes, we believe true luxury lies in thoughtful design, lasting quality, and spaces created with purpose.</p>
            </div>
        </article>

        <article class="about-profile about-profile-reversed" data-about-profile>
            <div class="about-profile-photo">
                <img src="/images/luxury-homes/about-founder-portrait.png" alt="Hitesh Vinod Kapoor, Co-Founder and Design Director">
            </div>
            <div class="about-profile-copy">
                <div class="about-profile-heading">
                    <div>
                        <h2>HITESH VINOD KAPOOR</h2>
                        <h3>Co-Founder &amp; Design Director</h3>
                    </div>
                    <span aria-hidden="true"></span>
                </div>

                <p>As a Co-Founder, Hitesh brings a hospitality-driven perspective to luxury residential design.</p>

                <p>With a deep understanding of how spaces are experienced, his approach focuses on creating homes that feel intuitive, refined, and timeless. He believes great design goes beyond aesthetics — it should enhance everyday living and evolve beautifully over time.</p>

                <p>From spatial planning to material selection, every detail is thoughtfully considered. His ability to balance sophistication with functionality results in homes that feel effortless yet elevated.</p>

                <p>Drawing from his hospitality background, he emphasizes comfort, flow, and a seamless living experience. Each project reflects understated luxury, craftsmanship, and enduring design. With a keen eye for detail and quality, Hitesh helps shape residences that are both elegant and deeply livable.</p>
            </div>
        </article>

        <span class="about-end-dot" aria-hidden="true"></span>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/about.js')
@endpush
