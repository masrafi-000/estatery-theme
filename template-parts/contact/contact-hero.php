<?php

/**
 * Contact Page Banner Configuration
 */

// 1. Define Banner Data - Specifically for Contact Page
$hero = t('pages.contact.hero');
$banner_title    = $hero['title'];
$banner_bg_text  = $hero['bg_text'];
$banner_subtitle = $hero['subtitle'];

// A professional workspace/real estate meeting image
$banner_image    = "https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?auto=compress&cs=tinysrgb&w=1600";

// 2. Define the Path using WordPress function
$shared_banner_path = get_template_directory() . '/shared/dynamic-banner.php';

// 3. Include with Safety Check
if (file_exists($shared_banner_path)) {
    include $shared_banner_path;
} else {
    echo "<div style='padding:40px; background:#fff; border:1px solid #eee; border-left:4px solid #f44336; color:#333; font-family:sans-serif; margin: 20px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);'>";
    echo "<h3 style='margin-top:0; color:#f44336;'>System Configuration Notice</h3>";
    echo "The shared component <strong>dynamic-banner.php</strong> was not found in the required directory.<br><br>";
    echo "<p style='font-size: 14px; opacity: 0.8;'>Please ensure the file exists at:</p>";
    echo "<code style='background:#f4f4f4; padding:8px 12px; display:block; margin-top:10px; border-radius:4px; border: 1px solid #ddd;'>" . get_template_directory() . "/shared/dynamic-banner.php</code>";
    echo "</div>";
}