<?php
namespace Estatery\Core;

/**
 * Controller for Internationalization and Polylang
 */
class I18n {
    public function __construct() {
        add_action( 'init', [ $this, 'register_strings' ] );
    }

    public function register_strings() {
        if ( function_exists( 'pll_register_string' ) ) {
            $group = 'estatery-theme';
            pll_register_string( 'Estatery Brand', 'Real Estate Excellence', $group );
            pll_register_string( 'Estatery CTAs', 'Explore Properties', $group );
            pll_register_string( 'Estatery Demo Title', 'Premium Features', $group );
            pll_register_string( 'Estatery Footer', 'All rights reserved.', $group );
            
            // Homepage strings
            pll_register_string( 'Home Title', 'Modern Living Reimagined', $group );
            pll_register_string( 'Home Desc', 'Welcome to Estatery, where we combine architectural excellence with premium real estate opportunities.', $group );
        }
    }
}
