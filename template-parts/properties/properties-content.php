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
                    // 1. Data Source (Initial JSON items)
                    $all_properties = t('pages.properties.items') ?: [];
                    
                    // 2. State management
                    $per_page      = 6; 
                    $total_results = count($all_properties);
                    
                    // Standard WordPress way to get the current page (works for /page/2/ and ?paged=2)
                    $paged         = get_query_var('paged') ?: (get_query_var('page') ?: 1);
                    $total_pages   = ceil($total_results / $per_page);
                    
                    // Clamp page between 1 and max pages
                    $current_page  = max(1, min($total_pages, (int)$paged));
                    
                    $current_sort  = $_GET['sort'] ?? 'newest';
                    $current_view  = $_GET['view'] ?? 'grid';

                    // 3. Sorting logic (Optional, but good for UX)
                    if ($current_sort === 'price_low') {
                        usort($all_properties, fn($a, $b) => (float)str_replace(['$',','], '', $a['price']) <=> (float)str_replace(['$',','], '', $b['price']));
                    } elseif ($current_sort === 'price_high') {
                        usort($all_properties, fn($a, $b) => (float)str_replace(['$',','], '', $b['price']) <=> (float)str_replace(['$',','], '', $a['price']));
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
