<?php
namespace Estatery\Core;

/**
 * Theme Setup & Bootstrapping
 * Handles automatic page creation and permalink flushing.
 */
class ThemeSetup {
    public static function init() {
        add_action('after_switch_theme', [__CLASS__, 'bootstrap']);
        // Removed 'ensure_pages_exist' from 'init' to prevent infinite page creation.
        // This is handled by 'after_switch_theme' or can be triggered manually if needed.
        add_action('init', [__CLASS__, 'fix_permalinks']);
    }

    /**
     * Ensure "Post Name" permalinks are active for routing
     */
    public static function fix_permalinks() {
        if ( get_option('permalink_structure') !== '/%postname%/' ) {
            update_option('permalink_structure', '/%postname%/');
            flush_rewrite_rules();
        }
    }

    /**
     * Bootstrap required pages
     */
    public static function bootstrap() {
        self::ensure_pages_exist();
        flush_rewrite_rules();
    }

    public static function ensure_pages_exist() {
        if (!function_exists('pll_languages_list')) return;

        $pages_to_create = [
            'properties' => [
                'title'    => 'Properties',
                'template' => 'page-properties.php'
            ],
            'about' => [
                'title'    => 'About',
                'template' => 'page-about.php'
            ],
            'contact' => [
                'title'    => 'Contact',
                'template' => 'page-contact.php'
            ],
            'invest' => [
                'title'    => 'Invest',
                'template' => 'page-invest.php'
            ]
        ];

        $languages = pll_languages_list();
        $created_pages = [];

        // 1. First, ensure all pages exist
        foreach ($languages as $lang) {
            foreach ($pages_to_create as $slug => $data) {
                $lang_page_id = pll_get_post(get_page_by_path($slug) ? get_page_by_path($slug)->ID : 0, $lang);

                if (!$lang_page_id) {
                    $post_id = wp_insert_post([
                        'post_title'  => $data['title'] . ' (' . strtoupper($lang) . ')',
                        'post_name'   => $slug,
                        'post_status' => 'publish',
                        'post_type'   => 'page',
                    ]);

                    if ($post_id) {
                        pll_set_post_language($post_id, $lang);
                        update_post_meta($post_id, '_wp_page_template', $data['template']);
                        $lang_page_id = $post_id;
                    }
                }
                
                // Store ID for mapping
                if ($lang_page_id) {
                    $created_pages[$slug][$lang] = $lang_page_id;
                }
            }
        }

        // 2. Link translations together syncronously
        foreach ($created_pages as $slug => $translations) {
            if (count($translations) > 1) {
                pll_save_post_translations($translations);
            }
        }

        // Mark as bootstrapped to prevent re-running
        update_option('estatery_pages_bootstrapped', true);
    }
}
