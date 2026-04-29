/**
 * Animations Module (Framer Motion / Motion library)
 * Professional Text & UI reveal system
 */
import { animate, inView, stagger, scroll } from 'https://cdn.jsdelivr.net/npm/motion@11.11.17/+esm';

export default class Animations {
    constructor() {
        this.init();
    }

    init() {
        this.initTextAnimations();
        this.initSectionReveals();
        this.initGlobalTransitions();
        console.log('Animations Module Initialized (Professional Mode)');
    }

    /**
     * Smooth text splitting and reveal
     */
    initTextAnimations() {
        const textElements = document.querySelectorAll('.js-reveal-text');
        
        textElements.forEach(el => {
            const html = el.innerHTML.trim();
            if (!html) return;

            // Split by words but preserve HTML tags as atomic units
            // This regex matches either an HTML tag or a sequence of non-whitespace characters
            const tokens = html.match(/(<[^>]+>|[^<>\s]+|\s+)/g);
            if (!tokens) return;

            el.innerHTML = tokens.map(token => {
                // If it's a tag (like <br> or <span>) or just whitespace, return as is
                if (token.startsWith('<') || token.trim() === '') {
                    return token;
                }
                
                // If it's a word, wrap it for animation. No initial hidden state to ensure visibility.
                return `<span class="inline-block overflow-hidden"><span class="inline-block transition-opacity duration-300">${token}</span></span>`;
            }).join('');
            
            inView(el, ({ target }) => {
                const spans = target.querySelectorAll('span > span');
                // Set initial state for animation
                animate(spans, { opacity: 0, y: "100%" }, { duration: 0 });
                
                // Animate to visible
                animate(
                    spans,
                    { opacity: 1, y: 0 },
                    { 
                        delay: stagger(0.04), 
                        duration: 0.8, 
                        easing: [0.22, 1, 0.36, 1] 
                    }
                );
            }, { margin: "0px 0px -50px 0px" });
        });
    }

    /**
     * General section/element reveals
     */
    initSectionReveals() {
        // Generic fade-up reveal
        inView('.js-reveal-fade', ({ target }) => {
            animate(
                target,
                { opacity: [0, 1], y: [30, 0] },
                { duration: 0.8, easing: [0.22, 1, 0.36, 1] }
            );
        }, { margin: "0px 0px -50px 0px" });

        // Staggered children reveal
        const staggerContainers = document.querySelectorAll('.js-reveal-stagger');
        staggerContainers.forEach(container => {
            inView(container, ({ target }) => {
                // Filter out children that already have their own reveal classes to prevent double-animation
                const children = Array.from(target.children).filter(child => {
                    return !child.classList.contains('js-reveal-fade') && 
                           !child.classList.contains('js-reveal-text');
                });
                
                if (children.length > 0) {
                    animate(
                        children,
                        { opacity: [0, 1], y: [20, 0] },
                        { delay: stagger(0.1), duration: 0.6, easing: "ease-out" }
                    );
                }
            });
        });

        // Global Footer Animations
        const footer = document.querySelector(".js-footer-section");
        if (footer) {
            inView(footer, ({ target }) => {
                const items = target.querySelectorAll(".container > *");
                animate(
                    items,
                    { opacity: [0, 1], y: [20, 0] },
                    { delay: stagger(0.1), duration: 0.8, easing: "ease-out" }
                );
            });
        }
    }

    /**
     * Add smooth transitions to links and buttons
     */
    initGlobalTransitions() {
        // 404 Page Parallax
        const parallax404 = document.getElementById('js-404-parallax');
        if (parallax404) {
            scroll(
                animate(parallax404, { y: [-100, 100] }),
                { target: document.querySelector('.error-404-section') }
            );
        }

        const buttons = document.querySelectorAll('button, .btn, .button, a');
        buttons.forEach(btn => {
            btn.style.transition = 'all 0.4s cubic-bezier(0.22, 1, 0.36, 1)';
        });
    }
}
