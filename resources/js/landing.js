const projectFilters = document.querySelectorAll('[data-project-filter]');
const projectCards = document.querySelectorAll('[data-project-status]');

projectFilters.forEach(button => {
    button.addEventListener('click', () => {
        const filter = button.dataset.projectFilter;

        projectFilters.forEach(item => {
            const isActive = item === button;
            item.classList.toggle('active', isActive);
            item.setAttribute('aria-pressed', String(isActive));
        });
        projectCards.forEach(card => {
            const visible = filter === 'all' || card.dataset.projectStatus === filter;
            card.classList.toggle('is-hidden', !visible);
        });
    });
});

const homeProjectModal = document.querySelector('[data-home-project-modal]');
const homeProjectModalPanel = homeProjectModal?.querySelector('.home-project-modal-panel');
const homeProjectTriggers = [...document.querySelectorAll('[data-home-project]')];
const homeProjectSlidesContainer = homeProjectModal?.querySelector('[data-home-modal-slides]');
let homeProjectSlides = [];
let homeProjectActiveSlide = 0;
let homeProjectLastTrigger = null;

const showHomeProjectSlide = index => {
    if (!homeProjectSlides.length) return;
    homeProjectActiveSlide = (index + homeProjectSlides.length) % homeProjectSlides.length;
    homeProjectSlides.forEach((slide, slideIndex) => {
        slide.classList.toggle('is-active', slideIndex === homeProjectActiveSlide);
        if (slide instanceof HTMLVideoElement && slideIndex !== homeProjectActiveSlide) {
            slide.pause();
        }
    });
};

const buildHomeProjectSlides = trigger => {
    if (!homeProjectSlidesContainer) return;

    let media = [];
    try {
        media = JSON.parse(trigger.dataset.projectMedia || '[]');
    } catch {
        media = [];
    }

    homeProjectSlidesContainer.replaceChildren();
    media.forEach((item) => {
        const slide = document.createElement(item.type === 'video' ? 'video' : 'img');
        slide.src = item.path;
        if (slide instanceof HTMLVideoElement) {
            slide.controls = true;
            slide.preload = 'metadata';
            slide.playsInline = true;
        } else {
            slide.alt = `${trigger.dataset.projectTitle || 'Luxury Homes project'} gallery image`;
        }
        homeProjectSlidesContainer.append(slide);
    });
    homeProjectSlides = [...homeProjectSlidesContainer.children];
    const navigation = homeProjectModal?.querySelector('.home-project-modal-navigation');
    if (navigation) navigation.hidden = homeProjectSlides.length < 2;
};

const closeHomeProjectModal = () => {
    if (!homeProjectModal || homeProjectModal.hidden) return;
    homeProjectModal.classList.remove('is-open');
    homeProjectSlides.forEach(slide => {
        if (slide instanceof HTMLVideoElement) slide.pause();
    });
    document.body.classList.remove('home-project-modal-open');
    window.setTimeout(() => {
        homeProjectModal.hidden = true;
        homeProjectLastTrigger?.focus();
    }, 620);
};

const openHomeProjectModal = trigger => {
    if (!homeProjectModal || !homeProjectModalPanel) return;
    homeProjectLastTrigger = trigger;
    homeProjectModal.querySelector('[data-home-modal-years]').textContent = trigger.dataset.projectYears || '—';
    homeProjectModal.querySelector('[data-home-modal-name]').textContent = trigger.dataset.projectTitle || 'House Design';
    homeProjectModal.querySelector('[data-home-modal-location]').textContent = trigger.dataset.projectLocation || 'New Delhi, Delhi';
    homeProjectModal.querySelector('[data-home-modal-address]').textContent = trigger.dataset.projectAddress || '—';
    buildHomeProjectSlides(trigger);
    showHomeProjectSlide(0);
    homeProjectModal.hidden = false;
    document.body.classList.add('home-project-modal-open');
    window.requestAnimationFrame(() => {
        homeProjectModal.classList.add('is-open');
        homeProjectModalPanel.focus({ preventScroll: true });
    });
};

homeProjectTriggers.forEach(trigger => {
    trigger.addEventListener('click', event => {
        event.preventDefault();
        openHomeProjectModal(trigger);
    });
});

homeProjectModal?.querySelectorAll('[data-home-modal-close]').forEach(button => {
    button.addEventListener('click', closeHomeProjectModal);
});
homeProjectModal?.querySelector('[data-home-modal-previous]')?.addEventListener('click', () => showHomeProjectSlide(homeProjectActiveSlide - 1));
homeProjectModal?.querySelector('[data-home-modal-next]')?.addEventListener('click', () => showHomeProjectSlide(homeProjectActiveSlide + 1));

document.addEventListener('keydown', event => {
    if (!homeProjectModal || homeProjectModal.hidden) return;
    if (event.key === 'Escape') closeHomeProjectModal();
    if (event.key === 'ArrowLeft') showHomeProjectSlide(homeProjectActiveSlide - 1);
    if (event.key === 'ArrowRight') showHomeProjectSlide(homeProjectActiveSlide + 1);
});
