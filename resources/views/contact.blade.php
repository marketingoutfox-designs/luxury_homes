@extends('layouts.app')

@section('title', 'Contact Us — Luxury Homes')
@section('bodyClass', 'contact-design landing-page-rebuilt')
@push('styles')
    @vite(['resources/css/landing.css', 'resources/css/contact.css'])
@endpush

@section('content')
    <section class="contact-hero" aria-labelledby="contact-title">
        <div class="contact-hero-shade"></div>
        <div class="contact-hero-copy">
            <h1 id="contact-title"><em>Get</em> in touch</h1>
            <p><strong>From concept to handover.</strong><br>One team. Complete accountability.</p>
        </div>
    </section>

    <section class="contact-workspace" aria-labelledby="contact-form-title">
        <div class="contact-workspace-inner">
            <aside class="contact-office">
                <h2>NEW DELHI OFFICE</h2>
                <p>E-363 Ground Floor,<br>Nirman Vihar, Main Vikas Marg,<br>Delhi-110092</p>
                <a class="contact-office-phone" href="tel:+918340000005">8340000005</a>
                <a class="contact-office-email" href="mailto:Contact@luxuryhomesbyrk.com">Contact@luxuryhomesbyrk.com</a>
                <div class="contact-socials" aria-label="Social media links">
                    <a href="#" aria-label="Facebook">f</a>
                        <a href="https://www.instagram.com/luxuryhomesbyrk" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                                <circle cx="12" cy="12" r="4"></circle>
                                <circle class="instagram-dot" cx="17.4" cy="6.7" r="1"></circle>
                            </svg>
                        </a>
                    <a href="https://www.linkedin.com/company/luxury-homes-by-rk/" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer"><span aria-hidden="true">in</span></a>
                </div>
            </aside>

            <div class="contact-form-column">
                <h2 id="contact-form-title">TELL US ABOUT YOUR DREAM HOME</h2>
                <p>Fill out the form and our manager will contact you for consultation.</p>

                @if (session('success'))
                    <p class="contact-success">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <div class="contact-errors" role="alert">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                <form class="contact-reference-form" method="post" action="{{ route('leads.store') }}">
                    @csrf
                    <input type="hidden" name="source" value="contact_page">

                    <label>
                        <span>FULL NAME*</span>
                        <input name="name" type="text" value="{{ old('name') }}" required>
                    </label>

                    <label>
                        <span>PHONE NO*</span>
                        <input name="phone" type="tel" value="{{ old('phone') }}" required>
                    </label>

                    <label>
                        <span>EMAIL ID*</span>
                        <input name="email" type="email" value="{{ old('email') }}" required>
                    </label>

                    <label>
                        <span>MESSAGE</span>
                        <textarea name="message" rows="2">{{ old('message') }}</textarea>
                    </label>

                    <button type="submit">SEND MESSAGE</button>
                </form>
            </div>
        </div>
    </section>

    <section class="contact-testimonials" aria-labelledby="contact-testimonials-title">
        <h2 id="contact-testimonials-title">TESTIMONIALS</h2>

        <div class="contact-testimonial-window">
            <div class="contact-testimonial-track" data-contact-testimonial-track>
                @foreach (require resource_path('data/testimonials.php') as $testimonial)
                    <article class="contact-testimonial-card">
                        @if ($testimonial['name'] === 'Mrs Kalpana Sharma')
                            <img src="/images/luxury-homes/landing-client.png" alt="">
                        @else
                            <div class="contact-testimonial-avatar testimonial-initials" aria-hidden="true">{{ $testimonial['initials'] }}</div>
                        @endif
                        <span class="contact-quote-mark">“</span>
                        <p>{{ $testimonial['quote'] }}</p>
                        <strong>{{ $testimonial['name'] }}</strong>
                        <small>{{ $testimonial['property'] }}</small>
                    </article>
                @endforeach
            </div>

            <button class="contact-testimonial-arrow contact-testimonial-arrow-prev" type="button" data-contact-slide="-1" aria-label="Previous testimonial">‹</button>
            <button class="contact-testimonial-arrow contact-testimonial-arrow-next" type="button" data-contact-slide="1" aria-label="Next testimonial">›</button>
        </div>

    </section>
@endsection
