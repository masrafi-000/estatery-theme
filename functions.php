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
require_once get_template_directory() . '/inc/Core/AjaxHandler.php';
require_once get_template_directory() . '/inc/Core/InquiryHandler.php';
require_once get_template_directory() . '/inc/Core/InvestHandler.php';
require_once get_template_directory() . '/inc/Core/ContactHandler.php';
require_once get_template_directory() . '/inc/Core/InvestPortfolioHandler.php';
require_once get_template_directory() . '/inc/Core/AdminDashboard.php';
require_once get_template_directory() . '/inc/Core/PropertyCPT.php';
require_once get_template_directory() . '/inc/Core/BlogCPT.php';

// Instantiate Core Controllers
new Estatery\Core\Setup();
new Estatery\Core\Enqueue();
new Estatery\Core\I18n();
new Estatery\Core\AjaxHandler();
new Estatery\Core\InquiryHandler();
new Estatery\Core\InvestHandler();
new Estatery\Core\ContactHandler();
new Estatery\Core\AdminDashboard();
new Estatery\Core\PropertyCPT();
new Estatery\Core\BlogCPT();

// Bootstrap pages and settings
\Estatery\Core\ThemeSetup::init();

// Global helper for translations (Like Next.js)
function t($key) {
    return \Estatery\Core\Translator::getInstance()->t($key);
}

/**
 * Returns a blog post field in the current language.
 * Falls back to the default WordPress field (English) if no translation is found.
 *
 * @param string $field   'title', 'content', or 'excerpt'
 * @param int    $post_id Post ID (defaults to current post)
 * @return string
 */
function get_blog_field($field, $post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $lang = \Estatery\Core\Translator::getInstance()->getLang();

    // English — always use WordPress native fields
    if ($lang === 'en') {
        if ($field === 'title')   return get_the_title($post_id);
        if ($field === 'excerpt') return get_the_excerpt();
        if ($field === 'content') return get_post_field('post_content', $post_id);
        return '';
    }

    // Non-English: try translated meta, fall back to English
    $meta = get_post_meta($post_id, "_{$field}_{$lang}", true);
    if (!empty(trim($meta))) return $meta;

    // Fallback to English
    if ($field === 'title')   return get_the_title($post_id);
    if ($field === 'excerpt') return get_the_excerpt();
    if ($field === 'content') return get_post_field('post_content', $post_id);
    return '';
}


// ─────────────────────────────────────────────────────────────────────────────
// LANGUAGE SWITCH HANDLER  (replaces AJAX — zero race conditions)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'init', 'estatery_handle_lang_switch', 1 );

function estatery_handle_lang_switch() {
    // Only intercept frontend requests that have ?set_lang
    if ( is_admin() || ! isset( $_GET['set_lang'] ) ) {
        return;
    }

    $lang = sanitize_key( $_GET['set_lang'] );

    // Validate: must have a matching JSON locale file
    if ( ! file_exists( get_template_directory() . '/languages/' . $lang . '.json' ) ) {
        return;
    }

    // Set OUR cookie — 'estatery_lang', NOT 'pll_language'.
    // Polylang owns pll_language and resets it on every response to match
    // the URL language, which would overwrite our choice on every page load.
    // 'estatery_lang' is our own cookie that Polylang never touches.
    setcookie( 'estatery_lang', $lang, time() + 365 * DAY_IN_SECONDS, '/' );

    // Also make it available in $_COOKIE for any code running in THIS request
    $_COOKIE['estatery_lang'] = $lang;

    // Redirect to clean URL (removes ?set_lang parameter)
    $clean_url = remove_query_arg( 'set_lang' );
    wp_redirect( $clean_url, 302 );
    exit;
}

function luxury_realestate_customize_register($wp_customize)
{
    // Hero Section Panel
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section Settings', 'luxury'),
        'priority' => 30,
    ));

    // 1. Background Video
    $wp_customize->add_setting('hero_video_file', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_video_file', array(
        'label'     => __('Background Video', 'luxury'),
        'section'   => 'hero_section',
        'mime_type' => 'video',
    )));
}
add_action('customize_register', 'luxury_realestate_customize_register');