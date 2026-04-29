/**
 * About Page Animations (Framer Motion / Motion library)
 */
import { animate, inView, stagger } from 'https://cdn.jsdelivr.net/npm/motion@11.11.17/+esm';

document.addEventListener('DOMContentLoaded', () => {
    initAboutAnimations();
});

function initAboutAnimations() {
    // 2. Our Story Section
    inView('.js-about-story', ({ target }) => {
        const images = target.querySelectorAll('.js-story-images img');
        const thumbnails = target.querySelectorAll('.js-story-thumbnails > *');

        if (images.length) {
            animate(
                images,
                { opacity: [0, 1], y: [25, 0], scale: [1.02, 1] },
                { delay: stagger(0.1), duration: 0.8, easing: "ease-out" }
            );
        }

        if (thumbnails.length) {
            animate(
                thumbnails,
                { opacity: [0, 1], scale: [0.92, 1] },
                { delay: stagger(0.1, { startDelay: 0.5 }), duration: 0.5, easing: [0.34, 1.56, 0.64, 1] }
            );
        }
    });

    // 4. Leadership Section
    inView('.js-leadership-section', ({ target }) => {
        const card = target.querySelector('.js-leadership-card');
        const counter = target.querySelector('.js-count-up');

        if (card) {
            animate(
                card,
                { opacity: [0, 1], scale: [0.85, 1] },
                { delay: 0.6, duration: 0.6, easing: [0.34, 1.56, 0.64, 1] }
            );
        }

        if (counter) {
            const targetVal = parseInt(counter.dataset.target, 10) || 0;
            animate(0, targetVal, {
                duration: 2,
                delay: 0.8,
                onUpdate: latest => counter.textContent = Math.round(latest)
            });
        }
    });

    // 5. How We Work (Process)
    inView('.js-how-we-work', ({ target }) => {
        const line = target.querySelector('.js-process-line');

        if (line) {
            animate(line, { width: ["0%", "100%"] }, { delay: 0.4, duration: 0.8, easing: "ease-in-out" });
        }
    });

    console.log('About Page Animations Initialized (Motion)');
}
