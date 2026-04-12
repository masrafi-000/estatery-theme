<?php
/**
 * Template Name: About Page
 * MVC Pattern: Controller for About view
 */

get_header();

// Load the about view component
get_template_part( 'template-parts/pages/about', 'content' );

get_footer();
