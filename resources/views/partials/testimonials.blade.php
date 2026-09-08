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
            @foreach ([
                ['This is a really, really lovely house — absolutely brilliant! The first thing you notice is the incredible feeling of space; the bedrooms and bathrooms have been designed so well and feel wonderfully spacious. The balcony is an absolute masterpiece—it creates such a great atmosphere. From the impressive pillars to the high-quality finish you see everywhere you look, the craftsmanship really speaks for itself. Even the small details, like the green patch in the parking area, make a huge difference. I haven’t seen many houses like this; it’s truly superb and a pleasure to experience!', 'Mrs Kalpana Sharma', 'CEO– MKS'],
                ['The entire journey was clear, thoughtful and beautifully managed. Every detail reflects care and accountability.', 'Mr Rohit Mehra', 'Homeowner'],
                ['A refined home that feels personal, timeless and exceptionally well built. The team delivered beyond expectations.', 'Mrs Ananya Kapoor', 'Client'],
            ] as [$quote, $name, $role])
                <article class="testimonial-card">
                    <img class="testimonial-avatar" src="/images/luxury-homes/landing-client.png" alt="">
                    <span>“</span>
                    <p>{{ $quote }}</p>
                    <strong>{{ $name }}</strong>
                    <small>{{ $role }}</small>
                </article>
            @endforeach
        </div>
        <a class="testimonial-video-link" href="#" aria-label="View client testimonial video"><em>Click</em> to view video</a>
    </div>
</section>
