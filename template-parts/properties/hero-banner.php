<?php
/**
 * Component: Properties Hero Banner
 * Wraps the shared dynamic banner with property-specific data.
 */
$banner_title = t('pages.properties.title');
$banner_subtitle = t('pages.properties.subtitle');
$banner_image = "https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=2000"; 
$banner_bg_text = "Market";

include get_template_directory() . '/shared/dynamic-banner.php';
?>
