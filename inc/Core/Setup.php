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
        $this->create_investment_query_table();
        $this->create_invest_table();
        $this->create_contact_table();
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

    /**
     * Create the investment queries table
     */
    private function create_investment_query_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_investment_queries';
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

    /**
     * Create the investments table using dbDelta
     */
    private function create_invest_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_investments';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            user_name varchar(255) NOT NULL,
            user_email varchar(255) NOT NULL,
            existing_client varchar(10) NOT NULL,
            own_spanish_property varchar(10) NOT NULL,
            tax_resident varchar(10) NOT NULL,
            interests text NOT NULL,
            amount varchar(100) NOT NULL,
            status varchar(20) DEFAULT 'unread' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    /**
     * Create the contacts table using dbDelta
     */
    private function create_contact_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_contacts';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            first_name varchar(255) NOT NULL,
            last_name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(100) NOT NULL,
            property_type varchar(255) NOT NULL,
            zip varchar(20) NOT NULL,
            city varchar(255) NOT NULL,
            bedrooms varchar(10) NOT NULL,
            bathrooms varchar(10) NOT NULL,
            budget varchar(100) NOT NULL,
            status varchar(20) DEFAULT 'unread' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
