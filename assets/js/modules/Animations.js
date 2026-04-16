/**
 * Animations Module (GSAP)
 */
export default class Animations {
    constructor() {
        this.init();
    }

    init() {
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
        }
        // Scroll animations for cards - only run if cards and trigger exist
        const cards = document.querySelectorAll('.gsap-card');
        const cardTrigger = document.querySelector('.animation-demo');
        
        if (cards.length > 0 && cardTrigger) {
            gsap.from(cards, {
                scrollTrigger: {
                    trigger: cardTrigger,
                    start: 'top 85%',
                },
                y: 40,
                opacity: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power4.out'
            });
        }

        // Scroll animations for reveal elements
        const reveals = document.querySelectorAll('.gsap-reveal');
        if (reveals.length > 0) {
            reveals.forEach(reveal => {
                gsap.from(reveal, {
                    scrollTrigger: {
                        trigger: reveal,
                        start: 'top 90%',
                    },
                    scale: 0.95,
                    opacity: 0,
                    duration: 0.6,
                    ease: 'power4.out'
                });
            });
        }

        console.log('Animations Module Initialized');
    }
}
