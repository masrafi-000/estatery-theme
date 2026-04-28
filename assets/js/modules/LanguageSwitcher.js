/**
 * LanguageSwitcher — React-like state + URL-based language routing
 * Pure CSS transition — no Motion dependency.
 */
export default class LanguageSwitcher {

    constructor() {
        this.wrapper      = document.getElementById('language-routing-wrapper');
        this.trigger      = document.getElementById('lang-select-trigger');
        this.triggerLabel = document.querySelector('#lang-select-trigger .lang-label');
        this.chevron      = document.getElementById('lang-select-chevron');
        this.menu         = document.getElementById('lang-options-list');
        this.optionBtns   = document.querySelectorAll('.lang-option-btn');

        if (!this.trigger || !this.menu) return;

        this.state = {
            activeLang: this.readCookie('estatery_lang') || document.documentElement.getAttribute('data-lang') || 'en',
            isOpen: false,
        };

        this.render();
        this.bindEvents();

        console.log(`[LanguageSwitcher] Ready — lang: ${this.state.activeLang}`);
    }

    setState(patch) {
        this.state = { ...this.state, ...patch };
        this.render();
    }

    render() {
        if (this.triggerLabel) {
            this.triggerLabel.textContent = this.state.activeLang.toUpperCase();
        }

        this.optionBtns.forEach(btn => {
            const isActive = btn.getAttribute('data-slug') === this.state.activeLang;
            btn.classList.toggle('active-lang',           isActive);
            btn.classList.toggle('text-primary',          isActive);
            btn.classList.toggle('bg-primary/5',          isActive);
            btn.classList.toggle('text-gray-500',         !isActive);
            btn.classList.toggle('hover:bg-gray-50',      !isActive);
            btn.classList.toggle('hover:text-foreground', !isActive);
        });
    }

    bindEvents() {
        this.trigger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.state.isOpen ? this.closeMenu() : this.openMenu();
        });

        this.optionBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const slug = btn.getAttribute('data-slug');
                const url  = btn.getAttribute('data-url');
                if (!slug || slug === this.state.activeLang) return;
                this.selectLanguage(slug, url);
            });
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.wrapper && !this.wrapper.contains(e.target)) {
                this.closeMenu();
            }
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeMenu();
        });
    }

    selectLanguage(slug, url) {
        this.setState({ activeLang: slug });
        this.closeMenu();

        // Trigger smooth page exit transition
        window.dispatchEvent(new CustomEvent('page-exit', {
            detail: { url: url || window.location.href }
        }));
    }

    openMenu() {
        this.setState({ isOpen: true });
        this.trigger.setAttribute('aria-expanded', 'true');
        if (this.chevron) this.chevron.style.transform = 'rotate(180deg)';

        // CSS transition handles the animation — just set the styles
        this.menu.style.opacity       = '1';
        this.menu.style.visibility    = 'visible';
        this.menu.style.transform     = 'translateY(0)';
        this.menu.style.pointerEvents = 'auto';
    }

    closeMenu() {
        if (!this.state.isOpen && this.menu.style.visibility === 'hidden') return;

        this.setState({ isOpen: false });
        this.trigger.setAttribute('aria-expanded', 'false');
        if (this.chevron) this.chevron.style.transform = 'rotate(0deg)';

        this.menu.style.opacity       = '0';
        this.menu.style.transform     = 'translateY(12px)';
        this.menu.style.pointerEvents = 'none';

        // Hide from accessibility after transition (0.3s)
        setTimeout(() => {
            this.menu.style.visibility = 'hidden';
        }, 300);
    }

    readCookie(name) {
        const match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
    }
}
