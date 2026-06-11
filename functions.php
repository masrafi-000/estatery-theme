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

// Filter WordPress dynamic title tag to use localized SEO titles
add_filter( 'document_title_parts', function( $title_parts ) {
    $seo_title = '';
    if ( is_front_page() || is_home() ) {
        $seo_title = t('seo.home.title');
    } elseif ( is_page_template('page-about.php') || is_page('about') ) {
        $seo_title = t('seo.about.title');
    } elseif ( is_page_template('page-privacy-policy.php') || is_page('privacy-policy') ) {
        $seo_title = t('seo.privacy_policy.title');
    } elseif ( is_page_template('page-cookie-policy.php') || is_page('cookie-policy') ) {
        $seo_title = t('seo.cookie_policy.title');
    } elseif ( is_page_template('page-blog.php') || is_page('blog') ) {
        $seo_title = t('seo.blog.title');
    } elseif ( is_page_template('page-contact.php') || is_page('contact') ) {
        $seo_title = t('seo.contact.title');
    } elseif ( is_page_template('page-invest.php') || is_page('invest') ) {
        $seo_title = t('seo.invest.title');
    } elseif ( is_page_template('page-properties.php') || is_page('properties') ) {
        $seo_title = t('seo.properties.title');
    } elseif ( is_page_template('page-terms-of-service.php') || is_page('terms-of-service') ) {
        $seo_title = t('seo.terms_of_service.title');
    } elseif ( is_page_template('page-property-details.php') || is_page('property-details') || is_page_template('page-investment-details.php') || is_page('investment-details') ) {
        $property_id = $_GET['id'] ?? '';
        $property_data = null;
        if ( $property_id ) {
            $json_file = get_template_directory() . '/data/properties.json';
            if ( file_exists( $json_file ) ) {
                $json_data = file_get_contents( $json_file );
                $parsed_data = json_decode( $json_data, true );
                $raw_properties = $parsed_data['root']['property'] ?? [];
                foreach ( $raw_properties as $prop ) {
                    if ( ( $prop['id'][0] ?? '' ) == $property_id ) {
                        $property_data = $prop;
                        break;
                    }
                }
            }
            if ( ! $property_data && is_numeric($property_id) ) {
                $property_data = \Estatery\Core\PropertyCPT::to_kyero_array( intval($property_id) );
            }
        }
        if ( $property_data ) {
            $raw_type = strtolower($property_data['type'][0] ?? 'property');
            $translated_type = t("pages.properties.meta.{$raw_type}") ?: ucfirst($raw_type);
            $seo_title = !empty($property_data['title'][0]) ? $property_data['title'][0] : ($translated_type . ' ' . (!empty($property_data['town'][0]) ? $property_data['town'][0] : ''));
        }
    }
    
    if ( !empty($seo_title) && strpos($seo_title, 'seo.') !== 0 ) {
        $title_parts['title'] = $seo_title;
        unset($title_parts['tagline']);
        unset($title_parts['site']);
    }
    return $title_parts;
}, 100 );

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

/**
 * Returns the effective publish date for a blog post.
 * Checks for a custom override first, falls back to WordPress post date.
 *
 * @param string $format  PHP date format
 * @param int    $post_id Post ID
 * @return string
 */
function get_blog_publish_date($format = 'F j, Y', $post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $custom_date = get_post_meta($post_id, '_publish_date', true);

    if (!empty($custom_date)) {
        return date($format, strtotime($custom_date));
    }

    return get_the_date($format, $post_id);
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

    // Theme Logo Settings Section
    $wp_customize->add_section('theme_logos_section', array(
        'title'    => __('Theme Logo Settings', 'estatery'),
        'priority' => 31,
    ));

    // 2. Header Logo
    $wp_customize->add_setting('header_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', array(
        'label'    => __('Header Logo', 'estatery'),
        'section'  => 'theme_logos_section',
        'settings' => 'header_logo',
    )));

    // 3. Preloader Logo / Header Image
    $wp_customize->add_setting('preloader_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'preloader_logo', array(
        'label'    => __('Preloader Logo / Header Image', 'estatery'),
        'section'  => 'theme_logos_section',
        'settings' => 'preloader_logo',
    )));

    // 4. Footer Logo
    $wp_customize->add_setting('footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
        'label'    => __('Footer Logo', 'estatery'),
        'section'  => 'theme_logos_section',
        'settings' => 'footer_logo',
    )));
}
add_action('customize_register', 'luxury_realestate_customize_register');