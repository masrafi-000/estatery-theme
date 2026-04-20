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
require_once get_template_directory() . '/inc/Core/AdminDashboard.php';

// Instantiate Core Controllers
new Estatery\Core\Setup();
new Estatery\Core\Enqueue();
new Estatery\Core\I18n();
new Estatery\Core\AjaxHandler();
new Estatery\Core\InquiryHandler();
new Estatery\Core\AdminDashboard();

// Bootstrap pages and settings
\Estatery\Core\ThemeSetup::init();

// Global helper for translations (Like Next.js)
function t($key) {
    return \Estatery\Core\Translator::getInstance()->t($key);
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


// FAQ Custom Post Type Register
function register_faq_custom_post_type()
{
    $labels = [
        'name' => 'FAQs',
        'singular_name' => 'FAQ',
        'add_new' => 'Add New FAQ',
        'add_new_item' => 'Add New FAQ',
        'menu_name' => 'FAQs',
    ];
    $args = [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => ['title', 'editor'],
        'show_in_rest' => true,
    ];
    register_post_type('faq', $args);
}
add_action('init', 'register_faq_custom_post_type');
 
 
function insert_default_faqs()
{
    if (get_option('default_faqs_inserted')) return;
 
    $defaults = [
        ['q' => 'How do I start searching for a property?', 'a' => 'You can start by using our search bar at the top of the page.'],
        ['q' => 'Are the property listings verified?', 'a' => 'Yes, every listing on Estatery goes through a strict verification process.'],
        ['q' => 'Can I list my own property for sale?', 'a' => 'Absolutely! Click on the Sell Property button and follow the steps.'],
        ['q' => 'Is there any commission fee for buyers?', 'a' => 'We provide transparent pricing. Browsing is free.'],
        ['q' => 'How can I contact a real estate agent?', 'a' => 'Each detail page has a Contact Agent button.']
    ];
 
    foreach ($defaults as $faq) {
        wp_insert_post([
            'post_title'   => $faq['q'],
            'post_content' => $faq['a'],
            'post_status'  => 'publish',
            'post_type'    => 'faq',
        ]);
    }
    update_option('default_faqs_inserted', true);
}
add_action('admin_init', 'insert_default_faqs');



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