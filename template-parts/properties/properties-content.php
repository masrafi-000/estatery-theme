<?php
/**
 * Component: Properties Content (Refactored to Component System)
 */
?>
<section class="properties-page bg-white min-h-screen">
    <!-- Section 1: Premium Hero Header (Dynamic Banner) -->
    <?php get_template_part('template-parts/properties/hero', 'banner'); ?>

    <div class="py-20 bg-[#f8fafc]">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Sidebar Filters (Left) -->
                <?php get_template_part('template-parts/properties/filters', 'sidebar'); ?>

                <!-- Main Section (Right) -->
                <main class="lg:w-3/4">
                    <?php 
                    // 1. Data Source
                    $json_file = get_template_directory() . '/data/properties.json';
                    $all_properties = [];
                    if (file_exists($json_file)) {
                        $json_data = file_get_contents($json_file);
                        $parsed_data = json_decode($json_data, true);
                        $raw_properties = $parsed_data['root']['property'] ?? [];

                        $current_lang = \Estatery\Core\Translator::getInstance()->getLang();

                        foreach ($raw_properties as $prop) {
                            $all_properties[] = \Estatery\Core\Translator::map_property_data($prop, $current_lang);
                        }
                    }
                    
                    // 1.5 Apply Filters
                    $search    = strtolower($_GET['search'] ?? '');
                    $status    = $_GET['status']   ?? 'all';
                    $types     = isset($_GET['types']) ? array_filter(explode(',', $_GET['types'])) : [];
                    $min_price = (float)($_GET['min_price'] ?? 0);
                    $max_price = (float)($_GET['max_price'] ?? 0);
                    $beds      = (int)($_GET['beds'] ?? 0);
                    $baths     = (int)($_GET['baths'] ?? 0);

                    $all_properties = array_filter($all_properties, function($item) use ($search, $status, $types, $min_price, $max_price, $beds, $baths) {
                        // Search text
                        if ($search && 
                            stripos($item['title'], $search) === false && 
                            stripos($item['location'], $search) === false &&
                            stripos($item['location_detail'], $search) === false &&
                            stripos($item['description'], $search) === false) {
                            return false;
                        }

                        // Status
                        if ($status !== 'all') {
                            if ($status === 'new_build') {
                                if (!$item['new_build']) return false;
                            } elseif (strtolower($item['type']) !== strtolower($status)) {
                                return false;
                            }
                        }

                        // Property Types (Category)
                        if (!empty($types) && !in_array(strtolower($item['category'] ?? ''), array_map('strtolower', $types))) {
                            return false;
                        }

                        // Price
                        if ($min_price > 0 && $item['raw_price'] < $min_price) return false;
                        if ($max_price > 0 && $item['raw_price'] > $max_price) return false;

                        // Beds & Baths logic (at least for others, exact for 1-3)
                        if ($beds > 0) {
                            if ($beds === 4) { if ($item['beds'] < 4) return false; }
                            else { if ((int)$item['beds'] !== $beds) return false; }
                        }
                        if ($baths > 0) {
                            if ($baths === 4) { if ($item['baths'] < 4) return false; }
                            else { if ((int)$item['baths'] !== $baths) return false; }
                        }

                        return true;
                    });
                    
                    $current_sort  = $_GET['sort'] ?? 'newest';
                    $current_view  = $_GET['view'] ?? 'grid';

                    // 3. Sorting logic
                    switch ( $current_sort ) {
                        case 'newest':
                            usort($all_properties, fn($a, $b) => $b['unix_date'] <=> $a['unix_date']);
                            break;
                        case 'oldest':
                            usort($all_properties, fn($a, $b) => $a['unix_date'] <=> $b['unix_date']);
                            break;
                        case 'price_asc':
                            usort($all_properties, fn($a, $b) => $a['raw_price'] <=> $b['raw_price']);
                            break;
                        case 'price_desc':
                            usort($all_properties, fn($a, $b) => $b['raw_price'] <=> $a['raw_price']);
                            break;
                        case 'area_asc':
                            usort($all_properties, fn($a, $b) => $a['raw_sqft'] <=> $b['raw_sqft']);
                            break;
                        case 'area_desc':
                            usort($all_properties, fn($a, $b) => $b['raw_sqft'] <=> $a['raw_sqft']);
                            break;
                    }

                    // 2. State management
                    $per_page      = 12; 
                    $total_results = count($all_properties);
                    
                    $paged         = get_query_var('paged') ?: (get_query_var('page') ?: 1);
                    $total_pages   = ceil($total_results / $per_page);
                    $current_page  = max(1, min(max(1, $total_pages), (int)$paged));

                    // 4. Pagination slicing
                    $offset = ($current_page - 1) * $per_page;
                    $paged_properties = array_slice($all_properties, $offset, $per_page);
                    ?>

                    <!-- AJAX Target Container -->
                    <div id="properties-results-container" class="relative min-h-[400px] transition-all duration-300">
                        
                        <!-- Loading Overlay -->
                        <div id="properties-loading" class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-20 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-10 h-10 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                                <span class="text-[11px] font-bold text-primary uppercase tracking-widest"><?php echo esc_html( t('pages.properties.js.loading') ?? 'Loading...' ); ?></span>
                            </div>
                        </div>

                        <div id="properties-content-ajax">
                            <?php 
                            // Initial Render for SEO
                            // 5. Grid Header Component
                            get_template_part('template-parts/properties/grid', 'header', [
                                'total_results' => $total_results,
                                'current_page'  => $current_page,
                                'per_page'      => $per_page,
                                'current_sort'  => $current_sort,
                                'current_view'  => $current_view
                            ]); 

                            // 6. Main Grid Component
                            get_template_part('template-parts/properties/grid', 'results', [
                                'properties' => $paged_properties,
                                'view'       => $current_view
                            ]); 

                            // 7. Pagination Component
                            get_template_part('template-parts/properties/pagination', null, [
                                'current_page' => $current_page,
                                'total_pages'  => $total_pages
                            ]); 
                            ?>
                        </div>
                    </div>
                </main>

            </div>
        </div>
    </div>

    <!-- Section 5: Call to Action -->
    <?php get_template_part('template-parts/properties/cta', 'block'); ?>
</section>
