<section class="home-testimonials" aria-labelledby="testimonials-title">
    <div class="section-heading reveal">
        <span></span>
        <h2 id="testimonials-title">Testimonials</h2>
        <span></span>
    </div>
    <div class="testimonial-layout">
        <div class="testimonial-art reveal">
            <h3>What <em>Clients</em><br>say about Us!</h3>
            <img src="/images/luxury-homes/landing-testimonial-building-v2.png" alt="Luxury Homes residential project">
        </div>
        <div class="testimonial-track reveal" aria-label="Client testimonials">
            @foreach (require resource_path('data/testimonials.php') as $testimonial)
                <article class="testimonial-card">
                    @if ($testimonial['name'] === 'Mrs Kalpana Sharma')
                        <img class="testimonial-avatar" src="/images/luxury-homes/landing-client.png" alt="">
                    @else
                        <div class="testimonial-avatar testimonial-initials" aria-hidden="true">{{ $testimonial['initials'] }}</div>
                    @endif
                    <span>“</span>
                    <p>{{ $testimonial['quote'] }}</p>
                    <strong>{{ $testimonial['name'] }}</strong>
                    <small>{{ $testimonial['property'] }}</small>
                </article>
            @endforeach
        </div>
    </div>
</section>
