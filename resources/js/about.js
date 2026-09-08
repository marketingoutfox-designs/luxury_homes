const aboutPage = document.querySelector('.about-design');

if (aboutPage) {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealItems = document.querySelectorAll('[data-about-profile], .about-scroll-reveal');
    const heroImage = document.querySelector('[data-about-hero-image]');

    if (reduceMotion) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    } else {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: .16, rootMargin: '0px 0px -5% 0px' });

        revealItems.forEach((item) => observer.observe(item));

        let scrollFrame = null;
        const updateHero = () => {
            if (heroImage) {
                const shift = Math.min(window.scrollY * .16, 58);
                heroImage.style.setProperty('--about-hero-shift', `${shift}px`);
            }
            scrollFrame = null;
        };

        window.addEventListener('scroll', () => {
            if (scrollFrame === null) scrollFrame = requestAnimationFrame(updateHero);
        }, { passive: true });
    }
}
