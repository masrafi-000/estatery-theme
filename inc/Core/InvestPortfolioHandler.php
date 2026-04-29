<?php
namespace Estatery\Core;

/**
 * Handler for the custom Investment Portfolio DB table
 */
class InvestPortfolioHandler {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'estatery_investment_portfolio';
    }


    public function save($data) {
        global $wpdb;
        
        $id = isset($data['id']) ? intval($data['id']) : 0;
        
        $row = [
            'external_id'     => sanitize_text_field($data['external_id'] ?? ''),
            'title'           => sanitize_text_field($data['title'] ?? ''),
            'price'           => floatval($data['price'] ?? 0),
            'currency'        => sanitize_text_field($data['currency'] ?? 'EUR'),
            'type'            => sanitize_text_field($data['type'] ?? ''),
            'town'            => sanitize_text_field($data['town'] ?? ''),
            'province'        => sanitize_text_field($data['province'] ?? ''),
            'country'         => sanitize_text_field($data['country'] ?? 'Spain'),
            'location_detail' => sanitize_text_field($data['location_detail'] ?? ''),
            'beds'            => intval($data['beds'] ?? 0),
            'baths'           => intval($data['baths'] ?? 0),
            'built_area'      => intval($data['built_area'] ?? 0),
            'plot_size'       => intval($data['plot_size'] ?? 0),
            'images'          => wp_json_encode($data['images'] ?? []),
            'descriptions'    => wp_json_encode($data['descriptions'] ?? []),
            'features'        => wp_json_encode($data['features'] ?? []),
            'new_build'       => isset($data['new_build']) ? 1 : 0,
            'lat'             => sanitize_text_field($data['lat'] ?? ''),
            'lng'             => sanitize_text_field($data['lng'] ?? ''),
            'featured_image'  => sanitize_text_field($data['featured_image'] ?? '')
        ];

        if ($id > 0) {
            $wpdb->update($this->table_name, $row, ['id' => $id]);
            return $id;
        } else {
            $wpdb->insert($this->table_name, $row);
            return $wpdb->insert_id;
        }
    }

    public function delete($id) {
        global $wpdb;
        return $wpdb->delete($this->table_name, ['id' => intval($id)]);
    }

    public function get_all() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $this->table_name ORDER BY id DESC", ARRAY_A);
    }

    public function get_by_id($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id), ARRAY_A);
    }

    public function get_by_external_id($external_id) {
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE TRIM(external_id) = %s", trim($external_id)), ARRAY_A);
        return $row ? $this->map_to_frontend($row) : null;
    }

    /**
     * Map DB row to the format expected by the frontend (matching JSON structure)
     */
    public function map_to_frontend($row) {
        $images = json_decode($row['images'], true) ?: [];
        $descriptions = json_decode($row['descriptions'], true) ?: [];
        $features = json_decode($row['features'], true) ?: [];

        // Convert to the nested array format the frontend JS expects
        return [
            'id' => [$row['external_id']],
            'title' => [$row['title']],
            'price' => [(string)$row['price']],
            'currency' => [$row['currency']],
            'price_freq' => ['sale'],
            'new_build' => [(string)$row['new_build']],
            'type' => [$row['type']],
            'town' => [$row['town']],
            'province' => [$row['province']],
            'country' => [$row['country']],
            'location_detail' => [$row['location_detail']],
            'lat' => [$row['lat']],
            'lng' => [$row['lng']],
            'featured_image' => [$row['featured_image']],
            'beds' => [(string)$row['beds']],
            'baths' => [(string)$row['baths']],
            'surface_area' => [['built' => [(string)$row['built_area']], 'plot' => [(string)$row['plot_size']]]],
            'images' => [
                [
                    'image' => array_map(function($url) {
                        return ['url' => [$url]];
                    }, $images)
                ]
            ],
            'desc' => [$descriptions],
            'features' => [
                'feature' => $features
            ]
        ];
    }

    /**
     * One-time import from investments.json
     */
    public function import_from_json() {
        global $wpdb;
        
        // Only import if table is empty
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");
        if ($count > 0) return;

        $json_file = get_template_directory() . '/data/investments.json';
        if (!file_exists($json_file)) return;

        $data = json_decode(file_get_contents($json_file), true);
        $properties = $data['root']['property'] ?? [];

        foreach ($properties as $p) {
            $images = [];
            if (isset($p['images'][0]['image'])) {
                foreach ($p['images'][0]['image'] as $img) {
                    $images[] = $img['url'][0] ?? '';
                }
            }

            $this->save([
                'external_id'     => $p['id'][0] ?? '',
                'title'           => $p['title'][0] ?? '',
                'price'           => $p['price'][0] ?? 0,
                'currency'        => $p['currency'][0] ?? 'EUR',
                'type'            => $p['type'][0] ?? '',
                'town'            => $p['town'][0] ?? '',
                'province'        => $p['province'][0] ?? '',
                'country'         => $p['country'][0] ?? 'Spain',
                'location_detail' => $p['location_detail'][0] ?? '',
                'beds'            => $p['beds'][0] ?? 0,
                'baths'           => $p['baths'][0] ?? 0,
                'surface_area'    => $p['surface_area'][0]['built'][0] ?? 0,
                'images'          => $images,
                'descriptions'    => $p['desc'] ?? [],
                'features'        => $p['features']['feature'] ?? [],
                'new_build'       => ($p['new_build'][0] ?? '0') === '1'
            ]);
        }
    }
}
