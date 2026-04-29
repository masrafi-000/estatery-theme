/**
 * Home Page Animations & Logic (Framer Motion / Swiper)
 */
import { animate, inView, stagger } from 'https://cdn.jsdelivr.net/npm/motion@11.11.17/+esm';

document.addEventListener('DOMContentLoaded', () => {
    initHomeLogic();
});

function initHomeLogic() {
    // 1. Featured Properties Swiper
    if (document.querySelector('.propertySlider') && typeof Swiper !== 'undefined') {
        new Swiper('.propertySlider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            speed: 1000,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: {
                el: '.swiper-pagination-premium',
                clickable: true,
                renderBullet: (index, className) => `<span class="${className} custom-dot"></span>`
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    }

    // 2. Why Choose Us - Dynamic Features Reveal
    const featureWrapper = document.getElementById('dynamic-features-wrapper');
    const features = (typeof estateryData !== 'undefined') ? estateryData.why_choose_features : [];

    if (featureWrapper && features.length) {
        featureWrapper.innerHTML = features.map(feature => `
            <div class="feature-box p-10 bg-white rounded-4xl border border-transparent hover:border-primary/20 transition-[border-color,box-shadow] hover:shadow-xl duration-500 flex flex-col items-start shadow-sm group opacity-0 translate-y-10 scale-95">
                <div class="w-16 h-16 ${feature.bgColor} text-primary rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                    ${feature.icon}
                </div>
                <h3 class="text-2xl font-bold text-secondary mb-4">${feature.title}</h3>
                <p class="text-text-gray text-base leading-relaxed">
                    ${feature.description}
                </p>
            </div>
        `).join('');

        inView('#why-choose', () => {
            const reveals = document.querySelectorAll('.reveal');
            if (reveals.length) {
                animate(
                    reveals,
                    { opacity: [0, 1], y: [20, 0] },
                    { delay: stagger(0.08), duration: 0.6, easing: "ease-out" }
                );
            }
        });

        // Custom reveal for the dynamic feature boxes
        inView('#dynamic-features-wrapper', () => {
            const boxes = document.querySelectorAll('.feature-box');
            if (boxes.length) {
                animate(
                    boxes,
                    { opacity: [0, 1], y: [40, 0], scale: [0.95, 1] },
                    { delay: stagger(0.1), duration: 0.7, easing: [0.22, 1, 0.36, 1] }
                );
            }
        });
    }

    // 3. Stats Counter Section
    const statsSection = document.getElementById('stats-counter-section');
    if (statsSection) {
        inView(statsSection, () => {
            const counters = document.querySelectorAll('.counter-value');
            counters.forEach(counter => {
                const target = parseInt(counter.dataset.target, 10) || 0;
                animate(0, target, {
                    duration: 2,
                    easing: "ease-out",
                    onUpdate: latest => counter.textContent = Math.round(latest)
                });
            });
        });
    }

    console.log('Home Page Logic Initialized (Motion)');
}
