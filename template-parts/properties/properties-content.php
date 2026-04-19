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
                            $price = $prop['price'][0] ?? '';
                            $currency = $prop['currency'][0] ?? '';
                            $currency_symbol = $currency === 'EUR' ? '€' : ($currency === 'USD' ? '$' : $currency);
                            
                            $formatted_price = number_format((float)$price, 0, '.', ',') . ' ' . $currency_symbol;

                            // Use dynamic language description, or stay empty if missing
                            $desc_data = $prop['desc'][0] ?? [];
                            $description = $desc_data[$current_lang][0] ?? '';

                            $all_properties[] = [
                                'id' => $prop['id'][0] ?? '',
                                'title' => ucfirst($prop['type'][0] ?? 'Property') . ' ' . ($prop['town'][0] ?? ''),
                                'price' => $formatted_price,
                                'location' => ($prop['town'][0] ?? '') . ', ' . ($prop['province'][0] ?? ''),
                                'description' => $description,
                                'type' => ($prop['price_freq'][0] ?? '') === 'sale' ? 'buy' : 'rent',
                                'category' => $prop['type'][0] ?? '',
                                'beds' => $prop['beds'][0] ?? '0',
                                'baths' => $prop['baths'][0] ?? '0',
                                'pool' => $prop['pool'][0] ?? '0',
                                'image' => $prop['images'][0]['image'][0]['url'][0] ?? ''
                            ];
                        }
                    }
                    
                    // 1.5 Apply Filters
                    $search    = strtolower($_GET['search'] ?? '');
                    $status    = $_GET['status']   ?? 'all';
                    $types     = isset($_GET['types']) ? explode(',', $_GET['types']) : [];
                    $min_price = (float)($_GET['min_price'] ?? 0);
                    $max_price = (float)($_GET['max_price'] ?? 0);
                    $beds      = (int)($_GET['beds'] ?? 0);
                    $baths     = (int)($_GET['baths'] ?? 0);

                    $all_properties = array_filter($all_properties, function($item) use ($search, $status, $types, $min_price, $max_price, $beds, $baths) {
                        // Search text (Title, Location, or Description)
                        if ($search && 
                            stripos($item['title'], $search) === false && 
                            stripos($item['location'], $search) === false &&
                            stripos($item['description'], $search) === false) {
                            return false;
                        }

                        // Status (Buy/Rent)
                        if ($status !== 'all' && strtolower($item['type']) !== strtolower($status)) {
                            return false;
                        }

                        // Property Types (Category)
                        if (!empty($types) && !in_array(strtolower($item['category'] ?? ''), array_map('strtolower', $types))) {
                            return false;
                        }

                        // Price
                        $price = (float)str_replace(['$',',','€',' ','/mo'], '', $item['price']);
                        if ($min_price > 0 && $price < $min_price) return false;
                        if ($max_price > 0 && $price > $max_price) return false;

                        // Beds & Baths
                        if ($beds > 0 && ($item['beds'] ?? 0) < $beds) return false;
                        if ($baths > 0 && ($item['baths'] ?? 0) < $baths) return false;

                        return true;
                    });
                    
                    // 2. State management
                    $per_page      = 6; 
                    $total_results = count($all_properties);
                    
                    // Standard WordPress way to get the current page (works for /page/2/ and ?paged=2)
                    $paged         = get_query_var('paged') ?: (get_query_var('page') ?: 1);
                    $total_pages   = ceil($total_results / $per_page);
                    
                    // Clamp page between 1 and max pages
                    $current_page  = max(1, min(max(1, $total_pages), (int)$paged));
                    
                    $current_sort  = $_GET['sort'] ?? 'newest';
                    $current_view  = $_GET['view'] ?? 'grid';

                    // 3. Sorting logic
                    if ($current_sort === 'price_asc') {
                        usort($all_properties, fn($a, $b) => (float)str_replace(['$',',','€',' '], '', $a['price']) <=> (float)str_replace(['$',',','€',' '], '', $b['price']));
                    } elseif ($current_sort === 'price_desc') {
                        usort($all_properties, fn($a, $b) => (float)str_replace(['$',',','€',' '], '', $b['price']) <=> (float)str_replace(['$',',','€',' '], '', $a['price']));
                    }

                    // 4. Pagination slicing
                    $offset = ($current_page - 1) * $per_page;
                    $paged_properties = array_slice($all_properties, $offset, $per_page);

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
                </main>

            </div>
        </div>
    </div>

    <!-- Section 5: Call to Action -->
    <?php get_template_part('template-parts/properties/cta', 'block'); ?>
</section>
