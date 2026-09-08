@unless(View::hasSection('hideCta'))
<section class="cta reveal">
    <div><h2>LET’S BUILD YOUR VISION TOGETHER</h2><p>Making Your Dream Home A Reality</p></div>
    <a href="{{ route('contact') }}"><span>LET’S GET STARTED</span></a>
</section>
@endunless
<footer id="contact">
    <div class="footer-grid">
        <a class="footer-brand" href="{{ route('home') }}"><span class="footer-logo-crop"><img src="/images/luxury-homes/footer-logo-original.png" alt="Luxury Homes — A Class Apart"></span></a>
        <div class="footer-contact"><h2>CONTACT DETAILS</h2><h3>NEW DELHI OFFICE</h3><p>E-363 Ground Floor,<br>Nirman Vihar, Main Vikas Marg,<br>Delhi-110092</p><a class="phone" href="tel:+918340000005">8340000005</a><a class="footer-email" href="mailto:Contact@luxuryhomesbyrk.com">Contact@luxuryhomesbyrk.com</a><div class="socials"><a href="#" aria-label="Facebook">f</a><a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle class="instagram-dot" cx="17.4" cy="6.7" r="1"></circle></svg></a><a href="#" aria-label="X">𝕏</a></div></div>
        <div class="footer-navigation"><h2>QUICK LINKS</h2><div class="quick-links"><a href="{{ route('about') }}">About Us</a><a href="{{ route('works') }}">Our Works</a><a href="{{ route('services') }}">Services</a><a href="{{ route('contact') }}">Contact Us</a><a href="#">Career</a><a href="#">Terms &amp; Conditions</a></div></div>
    </div>
    <div class="copyright">©luxuryhomesbyrk 2026. All right reserved.</div>
</footer>
