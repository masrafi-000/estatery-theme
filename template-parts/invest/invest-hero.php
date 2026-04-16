<?php
// 1. Define Banner Data for the Investment Page
$hero = t('pages.invest.hero');
$banner_title    = $hero['title'];
$banner_bg_text  = $hero['bg_text']; 
$banner_subtitle = $hero['subtitle'];

// High-quality image of a modern luxury building (Direct URL)
$banner_image    = "https://images.pexels.com/photos/323705/pexels-photo-323705.jpeg?auto=compress&cs=tinysrgb&w=1600";

// 2. Path logic (Keeping your professional WordPress shared folder structure)
$shared_banner_path = get_template_directory() . '/shared/dynamic-banner.php';

// 3. Include with Safety Check
if (file_exists($shared_banner_path)) {
    include $shared_banner_path;
} else {
    echo "<div style='padding:20px; background:#fff1f1; border:1px solid #d41313; color:#d41313; font-family:sans-serif;'>";
    echo "<strong>Missing File!</strong> Please ensure <strong>dynamic-banner.php</strong> is in your theme's <strong>/shared/</strong> folder.";
    echo "</div>";
}