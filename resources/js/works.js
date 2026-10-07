const worksPage = document.querySelector('.works-design');

if (worksPage) {
    const filters = [...document.querySelectorAll('[data-works-filter]')];
    const cards = [...document.querySelectorAll('.works-card')];
    const modal = document.querySelector('[data-works-modal]');
    const panel = modal?.querySelector('.works-modal-panel');
    const slidesContainer = modal?.querySelector('[data-modal-slides]');
    let slides = [];
    let activeSlide = 0;
    let lastTrigger = null;

    filters.forEach((filter) => {
        filter.addEventListener('click', () => {
            const value = filter.dataset.worksFilter;
            filters.forEach((item) => item.classList.toggle('is-active', item === filter));
            cards.forEach((card) => {
                const visible = value === 'all' || card.dataset.projectStatus === value;
                card.classList.toggle('is-hidden', !visible);
            });
        });
    });

    const showSlide = (index) => {
        if (!slides.length) return;
        activeSlide = (index + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === activeSlide);
            if (slide instanceof HTMLVideoElement && slideIndex !== activeSlide) slide.pause();
        });
    };

    const buildSlides = (card) => {
        if (!slidesContainer) return;

        let media = [];
        try {
            media = JSON.parse(card.dataset.projectMedia || '[]');
        } catch {
            media = [];
        }

        slidesContainer.replaceChildren();
        media.forEach((item) => {
            const slide = document.createElement(item.type === 'video' ? 'video' : 'img');
            slide.src = item.path;
            if (slide instanceof HTMLVideoElement) {
                slide.controls = true;
                slide.preload = 'metadata';
                slide.playsInline = true;
            } else {
                slide.alt = `${card.dataset.projectTitle || 'Luxury Homes project'} gallery image`;
            }
            slidesContainer.append(slide);
        });
        slides = [...slidesContainer.children];
        const navigation = modal?.querySelector('.works-modal-navigation');
        if (navigation) navigation.hidden = slides.length < 2;
    };

    const closeModal = () => {
        if (!modal || modal.hidden) return;
        modal.classList.remove('is-open');
        slides.forEach(slide => {
            if (slide instanceof HTMLVideoElement) slide.pause();
        });
        document.body.classList.remove('works-modal-open');
        window.setTimeout(() => {
            modal.hidden = true;
            lastTrigger?.focus();
        }, 360);
    };

    const openModal = (card) => {
        if (!modal || !panel) return;
        lastTrigger = card;
        modal.querySelector('#works-modal-kicker').textContent = `Project ${card.dataset.projectNumber}`;
        modal.querySelector('#works-modal-title').textContent = card.dataset.projectLabel;
        modal.querySelector('#works-modal-years').textContent = card.dataset.projectYears || '—';
        modal.querySelector('#works-modal-name').textContent = card.dataset.projectTitle;
        modal.querySelector('#works-modal-location').textContent = card.dataset.projectLocation;
        modal.querySelector('#works-modal-address').textContent = card.dataset.projectAddress || '—';
        modal.querySelector('#works-modal-summary').textContent = card.dataset.projectSummary;
        modal.querySelector('#works-modal-description').textContent = card.dataset.projectDescription;
        buildSlides(card);
        panel.scrollTop = 0;
        showSlide(0);
        modal.hidden = false;
        document.body.classList.add('works-modal-open');
        requestAnimationFrame(() => {
            modal.classList.add('is-open');
            panel.focus({ preventScroll: true });
        });
    };

    cards.forEach((card) => card.addEventListener('click', () => openModal(card)));
    modal?.querySelectorAll('[data-modal-close]').forEach((button) => button.addEventListener('click', closeModal));
    modal?.querySelector('[data-modal-previous]')?.addEventListener('click', () => showSlide(activeSlide - 1));
    modal?.querySelector('[data-modal-next]')?.addEventListener('click', () => showSlide(activeSlide + 1));

    document.addEventListener('keydown', (event) => {
        if (!modal || modal.hidden) return;
        if (event.key === 'Escape') closeModal();
        if (event.key === 'ArrowLeft') showSlide(activeSlide - 1);
        if (event.key === 'ArrowRight') showSlide(activeSlide + 1);
    });
}
