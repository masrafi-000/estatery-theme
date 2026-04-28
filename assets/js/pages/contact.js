/**
 * Contact Page Animations (Framer Motion / Motion library)
 */
import { animate, inView, stagger } from 'https://cdn.jsdelivr.net/npm/motion@11.11.17/+esm';

document.addEventListener('DOMContentLoaded', () => {
    initContactAnimations();
});

function initContactAnimations() {
    // 1. Banner/Hero Section (Top of page)
    const bannerItems = document.querySelectorAll('.js-banner-item');
    if (bannerItems.length) {
        animate(
            bannerItems,
            { opacity: [0, 1], y: [40, 0] },
            { delay: stagger(0.15, { startDelay: 0.2 }), duration: 1.2, easing: [0.22, 1, 0.36, 1] }
        );
    }

    // 2. Contact Section (Main content)
    inView('.js-contact-section', ({ target }) => {
        // A. Header Items
        const headerItems = target.querySelectorAll('.js-contact-header > *');
        if (headerItems.length) {
            animate(
                headerItems,
                { opacity: [0, 1], y: [30, 0] },
                { delay: stagger(0.1), duration: 0.8, easing: "ease-out" }
            )
        }

        // B. Form and Info Cards
        const formCard = target.querySelector('.js-contact-form-card');
        const infoCard = target.querySelector('.js-contact-details');
        
        if (formCard) {
            animate(
                formCard,
                { opacity: [0, 1], x: [-40, 0] },
                { duration: 0.9, easing: [0.22, 1, 0.36, 1], delay: 0.2 }
            );
        }

        if (infoCard) {
            animate(
                infoCard,
                { opacity: [0, 1], x: [40, 0] },
                { duration: 0.9, easing: [0.22, 1, 0.36, 1], delay: 0.4 }
            );
        }

        // C. Map Reveal
        const mapArea = target.querySelector('.js-contact-map');
        if (mapArea) {
            animate(
                mapArea,
                { opacity: [0, 1], scale: [0.95, 1], y: [30, 0] },
                { duration: 1, easing: "ease-out", delay: 0.6 }
            );
        }
    });

    console.log('Contact Page Animations Initialized (Motion Module)');
}
