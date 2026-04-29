<?php
namespace Estatery\Core;

/**
 * Property Custom Post Type and Admin Interface
 */
class PropertyCPT {
    public function __construct() {
        add_action('init', [$this, 'register_cpt']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_data']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function register_cpt() {
        $labels = [
            'name'               => 'Properties',
            'singular_name'      => 'Property',
            'menu_name'          => 'Properties',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Property',
            'edit_item'          => 'Edit Property',
            'new_item'           => 'New Property',
            'view_item'          => 'View Property',
            'search_items'       => 'Search Properties',
            'not_found'          => 'No properties found',
            'not_found_in_trash' => 'No properties found in trash'
        ];

        $args = [
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'query_var'           => true,
            'rewrite'             => ['slug' => 'property'],
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'menu_position'       => 26,
            'menu_icon'           => 'dashicons-admin-home',
            'supports'            => ['title', 'editor', 'thumbnail']
        ];

        register_post_type('property', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'estatery_property_details',
            'Property Specifications',
            [$this, 'render_details_metabox'],
            'property',
            'normal',
            'high'
        );

        add_meta_box(
            'estatery_property_media',
            'Property Gallery',
            [$this, 'render_gallery_metabox'],
            'property',
            'normal',
            'high'
        );
        
        add_meta_box(
            'estatery_property_translations',
            'Localized Descriptions',
            [$this, 'render_translations_metabox'],
            'property',
            'normal',
            'high'
        );
    }

    public function enqueue_admin_assets($hook) {
        // Ensure assets load on our custom dashboard page and the standard CPT pages
        if (strpos($hook, 'estatery') === false && !in_array($hook, ['post.php', 'post-new.php'])) return;
        
        wp_enqueue_media();
        ?>
        <style>
            .estatery-meta-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; padding: 10px 0; }
            .estatery-meta-field { margin-bottom: 15px; }
            .estatery-meta-field label { display: block; font-weight: 600; margin-bottom: 8px; color: #475569; font-size: 13px; text-transform: uppercase; }
            .estatery-control-alt { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; font-size: 14px; }
            .estatery-control-alt:focus { border-color: #2563eb; outline: none; background: #fff; }
            .estatery-gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 15px; margin-top: 15px; }
            .estatery-gallery-item { position: relative; aspect-ratio: 1; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; background: #f1f5f9; }
            .estatery-gallery-item img { width: 100%; height: 100%; object-fit: cover; }
            .estatery-gallery-item .remove-img { position: absolute; top: 5px; right: 5px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        </style>
        <script>
            jQuery(document).ready(function($) {
                // Gallery Handling
                var galleryFrame;
                $(document).on('click', '#estatery-add-gallery', function(e) {
                    e.preventDefault();
                    if (galleryFrame) { galleryFrame.open(); return; }
                    galleryFrame = wp.media({
                        title: 'Select Property Images',
                        button: { text: 'Add to Gallery' },
                        multiple: true
                    });
                    galleryFrame.on('select', function() {
                        var attachments = galleryFrame.state().get('selection').toJSON();
                        attachments.forEach(function(attachment) {
                            var html = '<div class="estatery-gallery-item">' +
                                       '<img src="' + attachment.url + '">' +
                                       '<button type="button" class="remove-img">×</button>' +
                                       '<input type="hidden" name="property_gallery[]" value="' + attachment.url + '">' +
                                       '</div>';
                            $('#estatery-gallery-container').append(html);
                        });
                    });
                    galleryFrame.open();
                });

                $(document).on('click', '.remove-img', function(e) {
                    e.preventDefault();
                    $(this).closest('.estatery-gallery-item').remove();
                });

                // Featured Image Handling
                var featuredFrame;
                $(document).on('click', '#estatery-featured-img-container', function(e) {
                    e.preventDefault();
                    if (featuredFrame) { featuredFrame.open(); return; }
                    featuredFrame = wp.media({
                        title: 'Select Featured Image',
                        button: { text: 'Set Featured Image' },
                        multiple: false
                    });
                    featuredFrame.on('select', function() {
                        var attachment = featuredFrame.state().get('selection').first().toJSON();
                        $('#estatery-featured-img-container').html('<img src="' + attachment.url + '" style="max-width:100%; border-radius:8px; margin-bottom:15px;"><br><button type="button" id="estatery-remove-featured" class="button button-link-delete">Remove Image</button><input type="hidden" name="_thumbnail_id" id="estatery-featured-img-id" value="' + attachment.id + '">');
                    });
                    featuredFrame.open();
                });

                $(document).on('click', '#estatery-remove-featured', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('#estatery-featured-img-container').html('<div style="color: #64748b; padding: 40px 0;"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" style="margin-bottom: 10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><p>Click to set featured image</p></div><input type="hidden" name="_thumbnail_id" id="estatery-featured-img-id" value="">');
                });

                // Inner Tab Handling (Multilingual)
                $(document).on('click', '.estatery-inner-tab-btn', function() {
                    var target = $(this).data('target');
                    var container = $(this).closest('.estatery-translations-container');
                    container.find('.estatery-inner-tab-btn').removeClass('active');
                    $(this).addClass('active');
                    container.find('.estatery-inner-tab-content').removeClass('active');
                    container.find('#' + target).addClass('active');
                });
            });
        </script>
        <?php
    }

    public function render_details_metabox($post) {
        wp_nonce_field('estatery_property_nonce', 'property_nonce');
        $this->render_specs_fields($post);
        echo '<hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">';
        $this->render_pricing_fields($post);
        echo '<hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">';
        $this->render_location_fields($post);
        echo '<hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">';
        $this->render_featured_image_section($post);
    }

    public function render_specs_fields($post) {
        $beds       = get_post_meta($post->ID, '_beds', true) ?: '0';
        $baths      = get_post_meta($post->ID, '_baths', true) ?: '0';
        $built      = get_post_meta($post->ID, '_built', true) ?: '0';
        $plot       = get_post_meta($post->ID, '_plot', true) ?: '0';
        $pool       = get_post_meta($post->ID, '_pool', true);
        $new_build  = get_post_meta($post->ID, '_new_build', true);
        $resale     = get_post_meta($post->ID, '_resale', true);
        $features   = get_post_meta($post->ID, '_features', true);
        ?>
        <div class="estatery-meta-grid">
            <div class="estatery-meta-field">
                <label>Bedrooms</label>
                <input type="number" name="property_beds" class="estatery-control-alt" value="<?php echo esc_attr($beds); ?>">
            </div>
            <div class="estatery-meta-field">
                <label>Bathrooms</label>
                <input type="number" name="property_baths" class="estatery-control-alt" value="<?php echo esc_attr($baths); ?>">
            </div>
            <div class="estatery-meta-field">
                <label>Property Status</label>
                <div style="display: flex; gap: 20px; padding-top: 10px;">
                    <label style="font-size: 14px; text-transform: none; color: #1e293b;"><input type="checkbox" name="property_pool" value="1" <?php checked($pool, '1'); ?>> Has Pool</label>
                    <label style="font-size: 14px; text-transform: none; color: #1e293b;"><input type="checkbox" name="property_new_build" value="1" <?php checked($new_build, '1'); ?>> New Build</label>
                    <label style="font-size: 14px; text-transform: none; color: #1e293b;"><input type="checkbox" name="property_resale" value="1" <?php checked($resale, '1'); ?>> Resale</label>
                </div>
            </div>
        </div>
        <div class="estatery-meta-grid">
            <div class="estatery-meta-field">
                <label>Built Area (m²)</label>
                <input type="number" name="property_built" class="estatery-control-alt" value="<?php echo esc_attr($built); ?>">
            </div>
            <div class="estatery-meta-field">
                <label>Plot Size (m²)</label>
                <input type="number" name="property_plot" class="estatery-control-alt" value="<?php echo esc_attr($plot); ?>">
            </div>
        </div>
        <div class="estatery-meta-field">
            <label>Amenities / Features</label>
            <?php
            $available_features = [
                'Terrace', 'Swimming Pool', 'Solarium', 'Garden', 
                'Private pool', 'Private parking', 'Basement', 'Clear Views',
                'Air Conditioning', 'Heating', 'Sea Views', 'Mountain Views',
                'Garage', 'Gym', 'Alarm System', 'Lift', 'Furnished', 
                'Storage Room', 'Utility Room', 'White Goods'
            ];
            
            $saved_features = !empty($features) ? array_map('trim', explode("\n", $features)) : [];
            ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-top: 5px;">
                <?php foreach ($available_features as $feature): ?>
                    <label style="font-size: 13px; font-weight: 500; color: #475569; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="property_features[]" value="<?php echo esc_attr($feature); ?>" 
                               <?php checked(in_array($feature, $saved_features)); ?>>
                        <?php echo esc_html($feature); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    public function render_pricing_fields($post) {
        $price      = get_post_meta($post->ID, '_price', true);
        $currency   = get_post_meta($post->ID, '_currency', true) ?: 'EUR';
        $price_freq = get_post_meta($post->ID, '_price_freq', true) ?: 'sale';
        $type       = get_post_meta($post->ID, '_type', true) ?: 'villa';
        ?>
        <div class="estatery-meta-grid">
            <div class="estatery-meta-field">
                <label>Price</label>
                <input type="number" name="property_price" class="estatery-control-alt" value="<?php echo esc_attr($price); ?>">
            </div>
            <div class="estatery-meta-field">
                <label>Currency</label>
                <select name="property_currency" class="estatery-control-alt">
                    <option value="EUR" <?php selected($currency, 'EUR'); ?>>EUR (€)</option>
                    <option value="USD" <?php selected($currency, 'USD'); ?>>USD ($)</option>
                </select>
            </div>
            <div class="estatery-meta-field">
                <label>Type / Frequency</label>
                <select name="property_price_freq" class="estatery-control-alt">
                    <option value="sale" <?php selected($price_freq, 'sale'); ?>>For Sale</option>
                    <option value="resale" <?php selected($price_freq, 'resale'); ?>>For Resale</option>
                </select>
            </div>
        </div>
        <div class="estatery-meta-field">
            <label>Property Category</label>
            <input type="text" name="property_type" class="estatery-control-alt" value="<?php echo esc_attr($type); ?>" placeholder="e.g. villa, apartment, townhouse">
        </div>
        <?php
    }

    public function render_location_fields($post) {
        $town       = get_post_meta($post->ID, '_town', true);
        $province   = get_post_meta($post->ID, '_province', true) ?: 'Alicante';
        $lat        = get_post_meta($post->ID, '_latitude', true);
        $lng        = get_post_meta($post->ID, '_longitude', true);
        $loc_detail = get_post_meta($post->ID, '_location_detail', true);
        ?>
        <div class="estatery-meta-grid">
            <div class="estatery-meta-field">
                <label>Town</label>
                <input type="text" name="property_town" class="estatery-control-alt" value="<?php echo esc_attr($town); ?>" required>
            </div>
            <div class="estatery-meta-field">
                <label>Province</label>
                <input type="text" name="property_province" class="estatery-control-alt" value="<?php echo esc_attr($province); ?>">
            </div>
            <div class="estatery-meta-field">
                <label>Country</label>
                <input type="text" name="property_country" class="estatery-control-alt" value="<?php echo esc_attr(get_post_meta($post->ID, '_country', true) ?: 'Spain'); ?>">
            </div>
            <div class="estatery-meta-field">
                <label>Zone / Location Detail</label>
                <input type="text" name="property_location_detail" class="estatery-control-alt" value="<?php echo esc_attr($loc_detail); ?>">
            </div>
        </div>
        <div class="estatery-meta-grid">
            <div class="estatery-meta-field">
                <label>Latitude</label>
                <input type="text" name="property_latitude" class="estatery-control-alt" value="<?php echo esc_attr($lat); ?>" placeholder="e.g. 38.3452" required>
            </div>
            <div class="estatery-meta-field">
                <label>Longitude</label>
                <input type="text" name="property_longitude" class="estatery-control-alt" value="<?php echo esc_attr($lng); ?>" placeholder="e.g. -0.4815" required>
            </div>
        </div>
        <?php
    }

    public function render_featured_image_section($post) {
        $thumb_id = get_post_thumbnail_id($post->ID);
        $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'medium') : '';
        ?>
        <div class="estatery-meta-field">
            <label>Featured Image (Main Listing Image)</label>
            <div id="estatery-featured-img-container" style="background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.2s; min-height: 150px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <?php if ($thumb_url): ?>
                    <img src="<?php echo esc_url($thumb_url); ?>" style="max-width: 100%; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <br>
                    <button type="button" id="estatery-remove-featured" class="button button-link-delete" style="color: #ef4444;">Remove Image</button>
                <?php else: ?>
                    <div style="color: #64748b;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" style="margin-bottom: 10px; opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p style="margin: 0; font-weight: 500;">Click to set featured image</p>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="_thumbnail_id" id="estatery-featured-img-id" value="<?php echo esc_attr($thumb_id); ?>">
            </div>
        </div>
        <?php
    }

    public function render_gallery_metabox($post) {
        $gallery = get_post_meta($post->ID, '_gallery', true) ?: [];
        ?>
        <div id="estatery-gallery-container" class="estatery-gallery-grid">
            <?php foreach ($gallery as $url): ?>
                <div class="estatery-gallery-item">
                    <img src="<?php echo esc_url($url); ?>">
                    <button type="button" class="remove-img">×</button>
                    <input type="hidden" name="property_gallery[]" value="<?php echo esc_url($url); ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <div style="margin-top: 30px;">
            <button type="button" id="estatery-add-gallery" class="estatery-btn-primary" style="padding: 12px 24px; font-size: 14px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" style="margin-right: 8px; vertical-align: middle;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Images to Gallery
            </button>
        </div>
        <?php
    }

    public function render_translations_metabox($post) {
        $langs = ['es' => 'Spanish', 'pl' => 'Polish', 'ru' => 'Russian'];
        ?>
        <div class="estatery-translations-container" style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
            <div class="estatery-tabs-nav" style="background: #f8fafc; padding: 10px 10px 0 10px; margin-bottom: 0; display: flex; gap: 5px;">
                <div class="estatery-inner-tab-btn active" data-target="inner-tab-en" style="padding: 10px 20px; cursor: pointer; border-radius: 8px 8px 0 0; font-weight: 600; color: #64748b; border: 1px solid transparent; border-bottom: none; margin-bottom: -1px; transition: all 0.2s;">English</div>
                <?php foreach ($langs as $code => $name): ?>
                    <div class="estatery-inner-tab-btn" data-target="inner-tab-<?php echo $code; ?>" style="padding: 10px 20px; cursor: pointer; border-radius: 8px 8px 0 0; font-weight: 600; color: #64748b; border: 1px solid transparent; border-bottom: none; margin-bottom: -1px; transition: all 0.2s;"><?php echo $name; ?></div>
                <?php endforeach; ?>
            </div>

            <div style="padding: 25px;">
                <div id="inner-tab-en" class="estatery-inner-tab-content active">
                    <p style="color: #64748b; font-size: 14px; margin: 0; padding: 20px; background: #eff6ff; border-radius: 8px; border: 1px solid #dbeafe;">The main English description is managed in the <strong>General</strong> tab.</p>
                </div>

                <?php foreach ($langs as $code => $name): ?>
                    <div id="inner-tab-<?php echo $code; ?>" class="estatery-inner-tab-content" style="display: none;">
                        <label style="display: block; margin-bottom: 12px; font-weight: 700; color: #1e293b;"><?php echo $name; ?> Description</label>
                        <textarea name="property_desc_<?php echo $code; ?>" rows="12" class="estatery-control-alt" placeholder="Enter <?php echo $name; ?> description here..."><?php echo esc_textarea(get_post_meta($post->ID, '_desc_' . $code, true)); ?></textarea>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .estatery-inner-tab-btn.active { background: white !important; color: #2563eb !important; border-color: #e2e8f0 !important; }
            .estatery-inner-tab-content.active { display: block !important; }
        </style>
        <?php
    }

    public function save_meta_data($post_id) {
        if (!isset($_POST['property_nonce']) || !wp_verify_nonce($_POST['property_nonce'], 'estatery_property_nonce')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        $fields = [
            '_price'            => 'property_price',
            '_currency'         => 'property_currency',
            '_price_freq'       => 'property_price_freq',
            '_type'             => 'property_type',
            '_beds'             => 'property_beds',
            '_baths'            => 'property_baths',
            '_built'            => 'property_built',
            '_plot'             => 'property_plot',
            '_pool'             => 'property_pool',
            '_new_build'        => 'property_new_build',
            '_resale'           => 'property_resale',
            '_town'             => 'property_town',
            '_province'         => 'property_province',
            '_country'          => 'property_country',
            '_latitude'         => 'property_latitude',
            '_longitude'        => 'property_longitude',
            '_location_detail'  => 'property_location_detail'
        ];

        foreach ($fields as $meta_key => $post_key) {
            $val = isset($_POST[$post_key]) ? sanitize_text_field($_POST[$post_key]) : '';
            update_post_meta($post_id, $meta_key, $val);
        }

        // Special handling for features (array)
        $features = isset($_POST['property_features']) ? array_map('sanitize_text_field', $_POST['property_features']) : [];
        update_post_meta($post_id, '_features', implode("\n", $features));

        // Thumbnail / Featured Image
        if (isset($_POST['_thumbnail_id'])) {
            set_post_thumbnail($post_id, intval($_POST['_thumbnail_id']));
        }

        // Translations
        foreach (['es', 'pl', 'ru'] as $code) {
            $val = isset($_POST['property_desc_' . $code]) ? sanitize_textarea_field($_POST['property_desc_' . $code]) : '';
            update_post_meta($post_id, '_desc_' . $code, $val);
        }

        // Gallery
        $gallery = isset($_POST['property_gallery']) ? array_map('esc_url_raw', $_POST['property_gallery']) : [];
        update_post_meta($post_id, '_gallery', $gallery);
    }

    /**
     * Map a WP Post ID to the Kyero-style array format
     */
    public static function to_kyero_array($post_id, $lang = 'en') {
        $post = get_post($post_id);
        if (!$post) return null;

        $desc = [];
        $desc['en'] = [$post->post_content];
        foreach (['es', 'pl', 'ru'] as $code) {
            $desc[$code] = [get_post_meta($post_id, '_desc_' . $code, true) ?: $post->post_content];
        }

        $raw_features = array_filter(array_map('trim', explode("\n", get_post_meta($post_id, '_features', true))));
        
        $gallery = get_post_meta($post_id, '_gallery', true) ?: [];
        $images = [];
        foreach ($gallery as $url) {
            $images[] = ['url' => [$url]];
        }
        if (empty($images) && has_post_thumbnail($post_id)) {
            $images[] = ['url' => [get_the_post_thumbnail_url($post_id, 'full')]];
        }

        return [
            'id' => [(string)$post_id],
            'title' => [$post->post_title],
            'date' => [$post->post_date],
            'price' => [get_post_meta($post_id, '_price', true) ?: '0'],
            'currency' => [get_post_meta($post_id, '_currency', true) ?: 'EUR'],
            'price_freq' => [get_post_meta($post_id, '_price_freq', true) ?: 'sale'],
            'new_build' => [get_post_meta($post_id, '_new_build', true) ?: '0'],
            'resale' => [get_post_meta($post_id, '_resale', true) ?: '0'],
            'type' => [get_post_meta($post_id, '_type', true) ?: 'property'],
            'town' => [get_post_meta($post_id, '_town', true) ?: ''],
            'province' => [get_post_meta($post_id, '_province', true) ?: ''],
            'country' => [get_post_meta($post_id, '_country', true) ?: 'Spain'],
            'location_detail' => [get_post_meta($post_id, '_location_detail', true) ?: ''],
            'desc' => [$desc],
            'features' => [['feature' => $raw_features]],
            'images' => [['image' => $images]],
            'surface_area' => [[
                'built' => [get_post_meta($post_id, '_built', true) ?: '0'],
                'plot' => [get_post_meta($post_id, '_plot', true) ?: '0']
            ]],
            'beds' => [get_post_meta($post_id, '_beds', true) ?: '0'],
            'baths' => [get_post_meta($post_id, '_baths', true) ?: '0'],
            'pool' => [get_post_meta($post_id, '_pool', true) ?: '0'],
            'location' => [[
                'latitude' => [get_post_meta($post_id, '_latitude', true) ?: '0'],
                'longitude' => [get_post_meta($post_id, '_longitude', true) ?: '0']
            ]]
        ];
    }
}
