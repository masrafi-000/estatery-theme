/**
 * Smooth Scroll Module (Lenis)
 */
export default class SmoothScroll {
    constructor() {
        this.lenis = null;
        this.init();
    }

    init() {
        this.lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            smooth: true,
        });

        // Integration with GSAP ScrollTrigger
        this.lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add((time) => {
            this.lenis.raf(time * 1000);
        });

        gsap.ticker.lagSmoothing(0);
        console.log('Lenis Module Initialized');
    }
}
