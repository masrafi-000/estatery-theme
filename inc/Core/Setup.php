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
        $this->create_inquiry_table();
    }

    /**
     * Create the inquiries table using dbDelta
     */
    private function create_inquiry_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_inquiries';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            property_id varchar(100) NOT NULL,
            property_title varchar(255) NOT NULL,
            property_price varchar(100) NOT NULL,
            property_area varchar(100) NOT NULL,
            property_image text NOT NULL,
            property_beds varchar(10) NOT NULL,
            property_baths varchar(10) NOT NULL,
            property_pool varchar(10) NOT NULL,
            property_type varchar(100) NOT NULL,
            property_location text NOT NULL,
            property_lat varchar(50) NOT NULL,
            property_lng varchar(50) NOT NULL,
            user_name varchar(255) NOT NULL,
            user_email varchar(255) NOT NULL,
            user_phone varchar(100) NOT NULL,
            user_message text NOT NULL,
            status varchar(20) DEFAULT 'unread' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
