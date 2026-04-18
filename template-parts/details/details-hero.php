<?php

/**
 * Dynamic Banner logic for Details/Single page
 */

// 1. Get Dynamic Data from the current post/property
$banner_title    = get_the_title();
$banner_bg_text   = "Details";
$banner_subtitle  = "Explore the premium details and investment potential of this property";

// 2. Get Featured Image (Fallback to a default image if no featured image is set)
if (has_post_thumbnail()) {
    $banner_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
} else {

    $banner_image = "https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1600";
}

$shared_banner_path = get_template_directory() . '/shared/dynamic-banner.php';

// 4. Include with Safety Check
if (file_exists($shared_banner_path)) {
    include $shared_banner_path;
} else {

    if (is_user_logged_in() && current_user_can('manage_options')) {
        echo "<div style='padding:20px; background:#fff1f1; border:1px solid #d41313; color:#d41313; font-family:sans-serif;'>";
        echo "<strong>Missing File!</strong> Please move <strong>dynamic-banner.php</strong> to: <br>";
        echo "<code style='background:#eee; padding:2px 5px;'>" . esc_html($shared_banner_path) . "</code>";
        echo "</div>";
    }
}