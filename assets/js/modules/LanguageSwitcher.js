/**
 * Next.js Style Language Switcher Interaction
 * Refined for absolute reliability
 */
export default class LanguageSwitcher {
    constructor() {
        this.wrapper = document.getElementById('language-routing-wrapper');
        this.trigger = document.getElementById('lang-select-trigger');
        this.menu = document.getElementById('lang-options-list');
        this.optionBtns = document.querySelectorAll('.lang-option-btn');
        
        if (this.trigger && this.menu) {
            this.init();
        }
    }

    init() {
        // Toggle Dropdown with Event Prevention
        this.trigger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.toggle();
        });

        // Handle Redirection
        this.optionBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const url = btn.getAttribute('data-url');
                const isCurrent = btn.classList.contains('active-lang');
                
                if (url && !isCurrent) {
                    console.log(`Switching language to: ${url}`);
                    // Close UI before navigating
                    this.close();
                    window.location.assign(url);
                }
            });
        });

        // Close on Click Outside
        document.addEventListener('click', (e) => {
            if (this.wrapper && !this.wrapper.contains(e.target)) {
                this.close();
            }
        });

        // Close on Escape Key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.close();
            }
        });
        
        console.log('Robust Language Switcher Initialized');
    }

    toggle() {
        const isOpen = this.menu.classList.contains('active');
        if (isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    open() {
        this.menu.classList.add('active');
        this.trigger.classList.add('open');
        this.trigger.setAttribute('aria-expanded', 'true');
        
        gsap.to(this.menu, {
            autoAlpha: 1,
            y: 0,
            duration: 0.4,
            ease: 'back.out(1.2)'
        });
    }

    close() {
        if (!this.menu || !this.menu.classList.contains('active')) return;
        
        this.trigger.classList.remove('open');
        this.trigger.setAttribute('aria-expanded', 'false');
        
        gsap.to(this.menu, {
            autoAlpha: 0,
            y: 15,
            duration: 0.3,
            ease: 'power2.in',
            onComplete: () => {
                this.menu.classList.remove('active');
            }
        });
    }
}
