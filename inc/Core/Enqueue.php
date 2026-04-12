<?php
namespace Estatery\Core;

/**
 * Controller for Asset Enqueuing
 */
class Enqueue {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    public function enqueue_assets() {
        // Main Stylesheet
        wp_enqueue_style( 'estatery-style', get_stylesheet_uri(), array(), '1.0.0' );

        // Tailwind CSS Output
        if ( file_exists( get_template_directory() . '/src/output.css' ) ) {
            wp_enqueue_style( 'estatery-tailwind', get_template_directory_uri() . '/src/output.css', array(), '1.0.0' );
        }

        // GSAP CDN
        wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
        wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true );

        // Lenis Smooth Scroll CDN
        wp_enqueue_script( 'lenis-cdn', 'https://cdn.jsdelivr.net/npm/lenis@1.1.9/dist/lenis.min.js', array(), '1.1.9', true );

        // Custom Main JS (As Module)
        wp_enqueue_script( 'estatery-main', get_template_directory_uri() . '/assets/js/main.js', array('gsap'), '1.0.0', true );
        
        // Add module type to main.js
        add_filter('script_loader_tag', function($tag, $handle, $src) {
            if ('estatery-main' !== $handle) {
                return $tag;
            }
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }, 10, 3);
    }
}
