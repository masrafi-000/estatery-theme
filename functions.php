<?php
/**
 * Estatery theme functions and definitions
 * MVC Architecture: Entry point for core controllers
 */

// Include core classes (Manual autoloader for simplicity)
require_once get_template_directory() . '/inc/Core/Setup.php';
require_once get_template_directory() . '/inc/Core/Enqueue.php';
require_once get_template_directory() . '/inc/Core/I18n.php';
require_once get_template_directory() . '/inc/Core/ThemeSetup.php';
require_once get_template_directory() . '/inc/Core/Translator.php';

// Instantiate Core Controllers
new Estatery\Core\Setup();
new Estatery\Core\Enqueue();
new Estatery\Core\I18n();

// Bootstrap pages and settings
\Estatery\Core\ThemeSetup::init();

// Global helper for translations (Like Next.js)
function t($key) {
    return \Estatery\Core\Translator::getInstance()->t($key);
}
