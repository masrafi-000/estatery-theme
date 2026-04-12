<?php
namespace Estatery\Core;

/**
 * Controller for Theme Setup and Features
 */
class Setup {
    public function __construct() {
        add_action( 'after_setup_theme', [ $this, 'theme_setup' ] );
    }

    public function theme_setup() {
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );

        register_nav_menus([
            'menu-1' => esc_html__( 'Primary', 'estatery' ),
        ]);

        add_theme_support( 'html5', [
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
        ]);

        load_theme_textdomain( 'estatery', get_template_directory() . '/languages' );
    }
}
