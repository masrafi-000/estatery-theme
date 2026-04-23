<?php
namespace Estatery\Core;

/**
 * Handle AJAX requests for properties
 */
class AjaxHandler {
    public function __construct() {
        add_action('wp_ajax_get_featured_properties', [$this, 'get_featured_properties']);
        add_action('wp_ajax_nopriv_get_featured_properties', [$this, 'get_featured_properties']);
        add_action('wp_ajax_get_filtered_properties', [$this, 'get_filtered_properties']);
        add_action('wp_ajax_nopriv_get_filtered_properties', [$this, 'get_filtered_properties']);
    }

    public function get_featured_properties() {
        $lang = sanitize_key($_POST['lang'] ?? 'en');
        $cache_key = 'estatery_featured_properties_v3_' . $lang;
        
        $featured = get_transient($cache_key);

        if (false === $featured) {
            $json_file = get_template_directory() . '/data/properties.json';
            if (!file_exists($json_file)) {
                wp_send_json_error('Data file not found');
            }

            $raw_json = file_get_contents($json_file);
            $data = json_decode($raw_json, true);
            $raw_properties = $data['root']['property'] ?? [];

            // Filter for New Builds first
            $filtered = array_filter($raw_properties, function($item) {
                return isset($item['new_build'][0]) && $item['new_build'][0] === "1";
            });

            // If we have more than 12 new builds, take 12. If less, supplement with first ones.
            if (count($filtered) < 12) {
                $count_needed = 12 - count($filtered);
                $non_new_builds = array_slice(array_filter($raw_properties, function($item) {
                    return !isset($item['new_build'][0]) || $item['new_build'][0] !== "1";
                }), 0, $count_needed);
                $filtered = array_merge($filtered, $non_new_builds);
            } else {
                $filtered = array_slice($filtered, 0, 12);
            }

            $featured = [];
            foreach ($filtered as $prop) {
                $featured[] = Translator::map_property_data($prop, $lang);
            }

            set_transient($cache_key, $featured, HOUR_IN_SECONDS);
        }

        ob_start();
        if (!empty($featured)) {
            foreach ($featured as $property) {
                include get_template_directory() . '/template-parts/home/card-featured.php';
            }
        }
        $html = ob_get_clean();

        wp_send_json_success(['html' => $html]);
    }

    public function get_filtered_properties() {
        $lang      = sanitize_key($_POST['lang'] ?? 'en');
        $search    = strtolower(sanitize_text_field($_POST['search'] ?? ''));
        $status    = sanitize_text_field($_POST['status'] ?? 'all');
        $types     = isset($_POST['types']) ? array_filter(explode(',', $_POST['types'])) : [];
        $min_price = (float)($_POST['min_price'] ?? 0);
        $max_price = (float)($_POST['max_price'] ?? 0);
        $beds      = (int)($_POST['beds'] ?? 0);
        $baths     = (int)($_POST['baths'] ?? 0);
        $paged     = (int)($_POST['paged'] ?? 1);
        $sort      = sanitize_text_field($_POST['sort'] ?? 'newest');
        $view      = sanitize_text_field($_POST['view'] ?? 'grid');

        // 1. Data Source
        $all_raw = [];
        
        // 1a. Load Admin Added Properties (CPT)
        $admin_posts = get_posts([
            'post_type' => 'property',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ]);
        foreach ($admin_posts as $post) {
            $raw = PropertyCPT::to_kyero_array($post->ID, $lang);
            if ($raw) {
                $raw['is_admin_added'] = true;
                $all_raw[] = $raw;
            }
        }

        // 1b. Load JSON Source
        $json_file = get_template_directory() . '/data/properties.json';
        if (file_exists($json_file)) {
            $json_data = file_get_contents($json_file);
            $parsed_data = json_decode($json_data, true);
            $raw_json_properties = $parsed_data['root']['property'] ?? [];
            foreach ($raw_json_properties as $rp) {
                $rp['is_admin_added'] = false;
                $all_raw[] = $rp;
            }
        }

        // 2. Filter & Map
        $filtered = [];
        foreach ($all_raw as $prop) {
            $item = Translator::map_property_data($prop, $lang);
            $item['is_admin_added'] = $prop['is_admin_added'] ?? false;
            $item['category'] = strtolower($prop['type'][0] ?? '');

            // Search text
            if ($search && 
                stripos($item['title'], $search) === false && 
                stripos($item['location'], $search) === false &&
                stripos($item['location_detail'], $search) === false &&
                stripos($item['description'], $search) === false) {
                continue;
            }

            // Status
            if ($status !== 'all') {
                if ($status === 'new_build') {
                    if (!$item['new_build']) continue;
                } elseif (strtolower($item['type']) !== strtolower($status)) {
                    continue;
                }
            }

            // Property Types
            if (!empty($types) && !in_array($item['category'], array_map('strtolower', $types))) {
                continue;
            }

            // Price
            if ($min_price > 0 && $item['raw_price'] < $min_price) continue;
            if ($max_price > 0 && $item['raw_price'] > $max_price) continue;

            // Beds & Baths Logic
            if ($beds > 0) {
                if ($beds === 4) { if ($item['beds'] < 4) continue; }
                else { if ((int)$item['beds'] !== $beds) continue; }
            }
            if ($baths > 0) {
                if ($baths === 4) { if ($item['baths'] < 4) continue; }
                else { if ((int)$item['baths'] !== $baths) continue; }
            }

            $filtered[] = $item;
        }

        // 3. Sorting
        usort($filtered, function($a, $b) use ($sort) {
            if (($a['is_admin_added'] ?? false) !== ($b['is_admin_added'] ?? false)) {
                return ($b['is_admin_added'] ?? false) <=> ($a['is_admin_added'] ?? false);
            }
            switch ( $sort ) {
                case 'newest':
                    return $b['unix_date'] <=> $a['unix_date'];
                case 'oldest':
                    return $a['unix_date'] <=> $b['unix_date'];
                case 'price_asc':
                    return $a['raw_price'] <=> $b['raw_price'];
                case 'price_desc':
                    return $b['raw_price'] <=> $a['raw_price'];
                case 'area_asc':
                    return $a['raw_sqft'] <=> $b['raw_sqft'];
                case 'area_desc':
                    return $b['raw_sqft'] <=> $a['raw_sqft'];
                default:
                    return $b['unix_date'] <=> $a['unix_date'];
            }
        });

        // 4. Pagination
        $per_page = 12;
        $total_results = count($filtered);
        $total_pages = ceil($total_results / $per_page);
        $current_page = max(1, min($total_pages ?: 1, $paged));
        $offset = ($current_page - 1) * $per_page;
        $paged_properties = array_slice($filtered, $offset, $per_page);

        // 5. Render HTML
        ob_start();
        get_template_part('template-parts/properties/grid', 'header', [
            'total_results' => $total_results,
            'current_page'  => $current_page,
            'per_page'      => $per_page,
            'current_sort'  => $sort,
            'current_view'  => $view
        ]);
        get_template_part('template-parts/properties/grid', 'results', [
            'properties' => $paged_properties,
            'view'       => $view
        ]);
        $html_results = ob_get_clean();

        ob_start();
        get_template_part('template-parts/properties/pagination', null, [
            'current_page' => $current_page,
            'total_pages'  => $total_pages
        ]);
        $html_pagination = ob_get_clean();

        wp_send_json_success([
            'html_results'    => $html_results,
            'html_pagination' => $html_pagination,
            'total_results'   => $total_results,
            'current_page'    => $current_page,
            'total_pages'     => $total_pages
        ]);
    }
}
