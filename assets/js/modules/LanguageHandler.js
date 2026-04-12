/**
 * Language selection handler (Polylang Cookie Persistence)
 */
export default class LanguageHandler {
    constructor() {
        this.init();
    }

    init() {
        const langLinks = document.querySelectorAll('.language-switcher a');
        langLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const langCode = link.textContent.trim().toLowerCase();
                this.setCookie('estatery_selected_lang', langCode, 365);
                console.log(`Language switched to: ${langCode}`);
            });
        });

        const savedLang = this.getCookie('estatery_selected_lang');
        if (savedLang) {
            console.log(`Active Language Preference: ${savedLang}`);
        }
    }

    setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
    }

    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
}
