<?php
/**
 * Template Name: Properties Page
 * MVC Pattern: Controller for Properties view
 */

get_header();

// Load the properties view component
get_template_part( 'template-parts/pages/properties', 'listing' );

get_footer();
