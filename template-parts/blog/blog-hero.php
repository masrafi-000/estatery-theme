<?php
/**
 * Component: Blog Hero Section
 */

$hero = t('pages.blog.hero');
$banner_title    = $hero['title'] ?? 'Blog & News';
$banner_bg_text  = $hero['bg_text'] ?? 'Journal';
$banner_subtitle = $hero['subtitle'] ?? '';
$banner_image    = "https://images.pexels.com/photos/3944454/pexels-photo-3944454.jpeg?auto=compress&cs=tinysrgb&w=1600";

$shared_banner_path = get_template_directory() . '/shared/dynamic-banner.php';

if (file_exists($shared_banner_path)) {
    include $shared_banner_path;
}
