<?php
/**
 * Script to attach sample featured images to blog posts that have none.
 * Run once from: /wp-content/themes/estatery/scratch/
 */

define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');
wp_set_current_user(1);

// Map of post titles to relevant Pexels image URLs
$image_map = [
    'Costa Blanca Property Prices Rise by 5% in Q1 2024'      => 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'New High-Speed Train Link to Alicante Boosting Local Tourism' => 'https://images.pexels.com/photos/1034662/pexels-photo-1034662.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'Top 5 Investment Locations in Spain for 2024'             => 'https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'Alicante Ranked as One of the Best Cities for Remote Work' => 'https://images.pexels.com/photos/4050315/pexels-photo-4050315.jpeg?auto=compress&cs=tinysrgb&w=1200',
    "New Coastal Development 'Marina Sands' Launched in Torrevieja" => 'https://images.pexels.com/photos/261169/pexels-photo-261169.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'How to Choose the Perfect Villa in Costa Blanca'          => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'Understanding Spanish Property Taxes: A Complete Guide'   => 'https://images.pexels.com/photos/209315/pexels-photo-209315.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'The Ultimate Guide to Moving to Spain in 2024'            => 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'Why Foreign Investors are Flocking to Alicante'           => 'https://images.pexels.com/photos/2635038/pexels-photo-2635038.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'Renovating an Old Spanish Finca: What You Need to Know'   => 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'Navigating the Golden Visa Process in Spain'              => 'https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'Costa Blanca vs. Costa del Sol: Which is Right for You?'  => 'https://images.pexels.com/photos/1174732/pexels-photo-1174732.jpeg?auto=compress&cs=tinysrgb&w=1200',
];

/**
 * Download a remote image and attach it to a post as the featured image.
 */
function attach_remote_image_to_post($post_id, $image_url, $title) {
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $tmp = download_url($image_url);
    if (is_wp_error($tmp)) {
        return false;
    }

    $file_array = [
        'name'     => sanitize_title($title) . '.jpg',
        'tmp_name' => $tmp,
    ];

    $attachment_id = media_handle_sideload($file_array, $post_id, $title);
    @unlink($tmp);

    if (is_wp_error($attachment_id)) {
        return false;
    }

    set_post_thumbnail($post_id, $attachment_id);
    return $attachment_id;
}

$posts = get_posts(['post_type' => 'blog', 'posts_per_page' => -1, 'post_status' => 'publish']);

echo "Processing " . count($posts) . " posts...\n";

foreach ($posts as $post) {
    $title = $post->post_title;

    // Skip posts that already have a featured image
    if (has_post_thumbnail($post->ID)) {
        echo "Already has image: {$title}\n";
        continue;
    }

    $url = $image_map[$title] ?? null;
    if (!$url) {
        echo "No image mapped for: {$title}\n";
        continue;
    }

    $result = attach_remote_image_to_post($post->ID, $url, $title);
    if ($result) {
        echo "Attached image to: {$title}\n";
    } else {
        echo "Failed to attach image for: {$title}\n";
    }
}

echo "\nDone.";
