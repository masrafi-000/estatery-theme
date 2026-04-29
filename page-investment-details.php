<?php
/**
 * Template Name: Investment Details
 * MVC Pattern: Controller for Investment Details view
 */

get_header();

$property_id = $_GET['id'] ?? '';
$property_data = null;

if ( $property_id ) {
    $handler = new \Estatery\Core\InvestPortfolioHandler();
    // Try to get from DB first
    $property_data = $handler->get_by_external_id( $property_id );
    
    // Fallback to JSON if not in DB yet (for legacy support during transition)
    if ( !$property_data ) {
        $invest_file = get_template_directory() . '/data/investments.json';
        if ( file_exists( $invest_file ) ) {
            $json_data = file_get_contents( $invest_file );
            $parsed_data = json_decode( $json_data, true );
            $raw_properties = $parsed_data['root']['property'] ?? [];
            
            foreach ( $raw_properties as $prop ) {
                if ( ( $prop['id'][0] ?? '' ) == $property_id ) {
                    $property_data = $prop;
                    break;
                }
            }
        }
    }
}

// Pass the data down to the component
set_query_var( 'property_data', $property_data );
set_query_var( 'is_investment', true );

// Reusing the same design layout as requested
get_template_part( 'template-parts/details/details-content' );

get_footer();
