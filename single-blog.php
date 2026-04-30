<?php
/**
 * Template Name: Single Blog Post
 * Description: Template for individual blog/news posts
 */

get_header();

while (have_posts()) : the_post();
    get_template_part('template-parts/blog/blog-single-content');
endwhile;

get_footer();
