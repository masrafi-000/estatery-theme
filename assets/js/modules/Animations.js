/**
 * Animations Module (GSAP)
 */
export default class Animations {
    constructor() {
        this.init();
    }

    init() {
        // Scroll animations for cards
        gsap.from('.gsap-card', {
            scrollTrigger: {
                trigger: '.animation-demo',
                start: 'top 80%',
            },
            y: 60,
            opacity: 0,
            duration: 1,
            stagger: 0.2,
            ease: 'power3.out'
        });

        gsap.from('.gsap-reveal', {
            scrollTrigger: {
                trigger: '.gsap-reveal',
                start: 'top 90%',
            },
            scale: 0.8,
            opacity: 0,
            duration: 0.8,
            ease: 'back.out(1.7)'
        });

        console.log('Animations Module Initialized');
    }
}
