/**
 * Estatery Theme Entry Point
 * Architecture: ES Modules (Modular based)
 */

import SmoothScroll from './modules/SmoothScroll.js';
import Animations from './modules/Animations.js';
import LanguageHandler from './modules/LanguageHandler.js';
import LanguageSwitcher from './modules/LanguageSwitcher.js';

document.addEventListener('DOMContentLoaded', () => {
    // Controller-like initialization
    new SmoothScroll();
    new Animations();
    new LanguageHandler();
    new LanguageSwitcher();

    console.log('Estatery Theme Engine Started (Module-based)');
});
