/**
 * Estatery Theme Entry Point
 * Architecture: ES Modules (Modular based)
 */

import SmoothScroll from './modules/SmoothScroll.js';
import Animations from './modules/Animations.js';
import PageTransition from './modules/PageTransition.js';
import LanguageHandler from './modules/LanguageHandler.js';
import LanguageSwitcher from './modules/LanguageSwitcher.js';

import { animate, scroll } from 'https://cdn.jsdelivr.net/npm/motion@11.11.17/+esm';

document.addEventListener('DOMContentLoaded', () => {
    // Controller-like initialization
    new PageTransition();
    new SmoothScroll();
    new Animations();
    new LanguageHandler();
    new LanguageSwitcher();

    // Global Scroll Progress Bar
    const progress = document.getElementById('scroll-progress');
    if (progress) {
        scroll(animate(progress, { scaleX: [0, 1] }));
    }

    console.log('Estatery Theme Engine Started (Module-based)');
});
