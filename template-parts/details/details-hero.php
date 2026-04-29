<?php

/**
 * Dynamic Banner logic for Details/Single page
 */

// 1. Get Dynamic Data from the current post/property
$property_data = get_query_var( 'property_data' );

if ( $property_data ) {
    $raw_type = strtolower($property_data['type'][0] ?? 'property');
    $translated_type = t("pages.properties.meta.{$raw_type}") ?: ucfirst($raw_type);
    
    $banner_title    = !empty($property_data['title'][0]) ? $property_data['title'][0] : ($translated_type . ' ' . (!empty($property_data['town'][0]) ? $property_data['town'][0] : ''));
    $banner_bg_text  = !empty($property_data['town'][0]) ? $property_data['town'][0] : t('pages.property_details.bg_text');
    $banner_subtitle = (!empty($property_data['location_detail'][0]) ? $property_data['location_detail'][0] : '') . ' - ' . (t('pages.property_details.subtitle'));
    
    $banner_image = !empty($property_data['featured_image'][0]) ? $property_data['featured_image'][0] : ($property_data['images'][0]['image'][0]['url'][0] ?? "https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1600");
    
    $is_investment = get_query_var( 'is_investment' );
    $nav_index     = $is_investment ? 3 : 1;
    $nav_label_def = $is_investment ? 'Invest' : 'Properties';

    $banner_breadcrumbs = [
        ['label' => t('header.navigation.0.label') ?: 'Home', 'url' => home_url(t('header.navigation.0.url'))],
        ['label' => t("header.navigation.{$nav_index}.label") ?: $nav_label_def, 'url' => home_url(t("header.navigation.{$nav_index}.url"))],
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

    $is_investment = get_query_var( 'is_investment' );
    if ( $is_investment ) {
        $banner_breadcrumbs = [
            ['label' => t('header.navigation.0.label') ?: 'Home', 'url' => home_url(t('header.navigation.0.url'))],
            ['label' => t('header.navigation.3.label') ?: 'Invest', 'url' => home_url(t('header.navigation.3.url'))],
            ['label' => $banner_title, 'url' => '#']
        ];
    } else {
        $banner_breadcrumbs = [
            ['label' => t('header.navigation.0.label') ?: 'Home', 'url' => home_url(t('header.navigation.0.url'))],
            ['label' => $banner_title, 'url' => '#']
        ];
    }
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