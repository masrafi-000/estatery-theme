<?php

/**
 * Dynamic Banner logic for Details/Single page
 */

// 1. Get Dynamic Data from the current post/property
$property_data = get_query_var( 'property_data' );

if ( $property_data ) {
    $raw_type = strtolower($property_data['type'][0] ?? 'property');
    $translated_type = t("pages.properties.meta.{$raw_type}") ?: ucfirst($raw_type);
    
    $banner_title    = $property_data['title'][0] ?? ($translated_type . ' ' . ($property_data['town'][0] ?? ''));
    $banner_bg_text  = $property_data['town'][0] ?? t('pages.property_details.bg_text');
    $banner_subtitle = ($property_data['location_detail'][0] ?? '') . ' - ' . (t('pages.property_details.subtitle'));
    
    $banner_image = $property_data['images'][0]['image'][0]['url'][0] ?? "https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1600";
    
    $banner_breadcrumbs = [
        ['label' => t('header.navigation.0.label') ?: 'Home', 'url' => home_url(t('header.navigation.0.url'))],
        ['label' => t('header.navigation.1.label') ?: 'Properties', 'url' => home_url(t('header.navigation.1.url'))],
        ['label' => $banner_title, 'url' => '#']
    ];
} else {
    $banner_title    = get_the_title();
    $banner_bg_text   = t('pages.property_details.bg_text');
    $banner_subtitle  = t('pages.property_details.subtitle');

    if (has_post_thumbnail()) {
        $banner_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    } else {
        $banner_image = "https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1600";
    }

    $banner_breadcrumbs = [
        ['label' => t('header.navigation.0.label') ?: 'Home', 'url' => home_url(t('header.navigation.0.url'))],
        ['label' => $banner_title, 'url' => '#']
    ];
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