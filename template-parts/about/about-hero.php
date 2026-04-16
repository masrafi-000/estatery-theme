<?php
// 1. Define Banner Data
$hero = t('pages.about.hero');
$banner_title    = $hero['title'];
$banner_bg_text  = $hero['bg_text'];
$banner_subtitle = $hero['subtitle'];
$banner_image    = "https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1600";

// 2. Define the Path using WordPress function
// This assumes your file is in: wp-content/themes/your-theme/shared/dynamic-banner.php
$shared_banner_path = get_template_directory() . '/shared/dynamic-banner.php';

// 3. Include with Safety Check
if (file_exists($shared_banner_path)) {
    include $shared_banner_path;
} else {
    echo "<div style='padding:20px; background:#fff1f1; border:1px solid #d41313; color:#d41313; font-family:sans-serif;'>";
    echo "<strong>Missing File!</strong> Please move <strong>dynamic-banner.php</strong> to this folder:<br>";
    echo "<code style='background:#eee; padding:2px 5px;'>" . get_template_directory() . "/shared/</code>";
    echo "</div>";
}