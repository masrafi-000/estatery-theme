<?php
/**
 * Script to import sample blog data
 */

// Load WordPress
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');

// Set admin user to avoid permission issues in script
wp_set_current_user(1);

$json_file = 'blog_data.json';
if (!file_exists($json_file)) {
    die("JSON file not found.");
}

$data = json_decode(file_get_contents($json_file), true);
if (!$data) {
    die("Invalid JSON data.");
}

echo "Starting import...\n";

foreach ($data as $item) {
    // Check if post already exists by title to avoid duplicates
    $existing = get_page_by_title($item['title'], OBJECT, 'blog');
    if ($existing) {
        echo "Skipping existing: " . $item['title'] . "\n";
        continue;
    }

    $post_data = [
        'post_title'   => $item['title'],
        'post_content' => $item['content'],
        'post_status'  => 'publish',
        'post_type'    => 'blog',
        'post_author'  => 1,
    ];

    $post_id = wp_insert_post($post_data);

    if (!is_wp_error($post_id)) {
        // Set metadata
        update_post_meta($post_id, '_author_name', $item['author']);
        update_post_meta($post_id, '_author_designation', $item['designation']);

        // Set category (Taxonomy)
        wp_set_object_terms($post_id, $item['type'], 'blog_category');

        echo "Imported: " . $item['title'] . " (Type: " . $item['type'] . ")\n";
    } else {
        echo "Error importing: " . $item['title'] . "\n";
    }
}

echo "Import complete.";
