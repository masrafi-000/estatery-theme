<?php
/**
 * Template Name: Property Details
 * MVC Pattern: Controller for Property Details view
 */

get_header();

$property_id = $_GET['id'] ?? '';
$property_data = null;

if ( $property_id ) {
    // 1. Try JSON Source first
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

    // 2. Fallback to Database (Admin Added)
    if ( ! $property_data && is_numeric($property_id) ) {
        $property_data = \Estatery\Core\PropertyCPT::to_kyero_array( intval($property_id) );
    }
}

// Pass the data down to the component
set_query_var( 'property_data', $property_data );

get_template_part( 'template-parts/details/details-content' );

get_footer();
