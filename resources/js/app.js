const toggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('#primary-nav');
const siteHeader = document.querySelector('.site-header');

let previousScrollY = window.scrollY;
let headerScrollFrame = null;

const updateStickyHeader = () => {
    const currentScrollY = Math.max(window.scrollY, 0);
    const scrollDifference = currentScrollY - previousScrollY;
    const scrollingDown = scrollDifference > 0;

    siteHeader?.classList.toggle('is-scrolled', currentScrollY > 12);

    if (Math.abs(scrollDifference) >= 2) {
        siteHeader?.classList.toggle('is-scrolling-down', currentScrollY > 80 && scrollingDown);
        siteHeader?.classList.toggle('is-scrolling-up', currentScrollY > 12 && !scrollingDown);
    }

    previousScrollY = currentScrollY;
    headerScrollFrame = null;
};

window.addEventListener('scroll', () => {
    if (headerScrollFrame === null) {
        headerScrollFrame = window.requestAnimationFrame(updateStickyHeader);
    }
}, { passive: true });

updateStickyHeader();

const contactTestimonialTrack = document.querySelector('[data-contact-testimonial-track]');
const contactTestimonialCards = contactTestimonialTrack?.querySelectorAll('.contact-testimonial-card');

const centerContactTestimonial = index => {
    const card = contactTestimonialCards?.[index];

    if (!card || !contactTestimonialTrack) {
        return;
    }

    contactTestimonialTrack.scrollTo({
        left: card.offsetLeft - ((contactTestimonialTrack.clientWidth - card.offsetWidth) / 2),
        behavior: 'smooth',
    });
};

if (contactTestimonialCards?.length) {
    window.requestAnimationFrame(() => centerContactTestimonial(Math.min(1, contactTestimonialCards.length - 1)));

    document.querySelectorAll('[data-contact-slide]').forEach(button => {
        button.addEventListener('click', () => {
            const cardWidth = contactTestimonialCards[0].offsetWidth;
            const trackStyles = window.getComputedStyle(contactTestimonialTrack);
            const gap = Number.parseFloat(trackStyles.columnGap || trackStyles.gap) || 0;

            contactTestimonialTrack.scrollBy({
                left: Number(button.dataset.contactSlide) * (cardWidth + gap),
                behavior: 'smooth',
            });
        });
    });
}

toggle?.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    nav?.classList.toggle('open', !open);
});

nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
    toggle?.setAttribute('aria-expanded', 'false');
    nav.classList.remove('open');
}));

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const reveals = document.querySelectorAll('.reveal');

if (reduceMotion) {
    reveals.forEach(element => element.classList.add('visible'));
} else {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    }), { threshold: .13 });
    reveals.forEach(element => observer.observe(element));
}

document.querySelector('.contact-form')?.addEventListener('submit', event => {
    event.preventDefault();
    const button = event.currentTarget.querySelector('button');
    button.textContent = 'THANK YOU — WE’LL BE IN TOUCH';
    button.disabled = true;
});

document.querySelectorAll('.project-filter button').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.project-filter button').forEach(item => item.classList.remove('active'));
        button.classList.add('active');
    });
});
