/**
 * Invest Page Animations (Framer Motion / Motion library)
 */
import { animate, inView, stagger } from 'https://cdn.jsdelivr.net/npm/motion@11.11.17/+esm';

document.addEventListener('DOMContentLoaded', () => {
    initInvestAnimations();
});

function initInvestAnimations() {
    // 2. Investment Philosophy Section
    inView('.js-philosophy-section', ({ target }) => {
        // Image and Text Column
        const imageWrap = target.querySelector('.js-philosophy-image-wrap');
        const img = target.querySelector('.js-philosophy-img');
        const textItems = target.querySelectorAll('.js-philosophy-text > *');
        
        if (imageWrap) {
            animate(
                imageWrap,
                { opacity: [0, 1], x: [-40, 0] },
                { duration: 1, easing: [0.22, 1, 0.36, 1], delay: 0.2 }
            );
        }

        if (img) {
            animate(
                img,
                { scale: [1.2, 1] },
                { duration: 1.5, easing: "ease-out", delay: 0.2 }
            );
        }

        if (textItems.length) {
            animate(
                textItems,
                { opacity: [0, 1], x: [40, 0] },
                { delay: stagger(0.15), duration: 0.8, easing: [0.22, 1, 0.36, 1], delay: 0.4 }
            );
        }

        // Strategy Grid
        const gridItems = target.querySelectorAll('.js-philosophy-item');
        if (gridItems.length) {
            animate(
                gridItems,
                { opacity: [0, 1], y: [30, 0] },
                { delay: stagger(0.12, { startDelay: 0.6 }), duration: 0.7, easing: "ease-out" }
            );
        }
    });

    // 3. Wealth Growth Section
    inView('.js-wealth-section', ({ target }) => {
        const cta = target.querySelector('.js-wealth-cta');

        if (cta) {
            animate(
                cta,
                { opacity: [0, 1], scale: [0.95, 1], y: [30, 0] },
                { duration: 1, easing: "ease-out", delay: 0.2 }
            );
        }
    });

    // 4. Featured Properties (Invest Page)
    inView('.js-invest-props-section', ({ target }) => {
        // Since properties are loaded via AJAX, we use MutationObserver to animate them when they appear
        const observer = new MutationObserver((mutations) => {
            const cards = target.querySelectorAll('.property-card:not(.js-animated)');
            if (cards.length) {
                cards.forEach(card => card.classList.add('js-animated'));
                animate(
                    cards,
                    { opacity: [0, 1], y: [30, 0] },
                    { delay: stagger(0.1), duration: 0.8, easing: "ease-out" }
                );
            }
        });

        observer.observe(target, { childList: true, subtree: true });
    });

    console.log('Invest Page Animations Initialized (Motion Module)');
}
