<?php
/**
 * Component: Investment Sidebar Filters
 */
?>

<h2 class="sr-only"><?php echo esc_html( t('pages.properties.filters.sidebar_sr_description') ?? 'Investment search filter sidebar' ); ?></h2>

<aside class="lg:w-[380px] flex-shrink-0 lg:sticky lg:top-24 lg:self-start">
    <!-- Mobile Filter Toggle -->
    <button id="mobile-filter-toggle" class="lg:hidden w-full flex items-center justify-between bg-white border border-slate-100 rounded-2xl p-4 mb-6 active:scale-[0.98] transition-all shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m12 12a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </div>
            <div class="text-left">
                <span class="block text-[13px] font-bold text-slate-900 uppercase tracking-tight"><?php echo esc_html( t('pages.properties.filters.filter_results') ); ?></span>
                <span id="mobile-active-badge" class="text-[11px] text-slate-400 font-medium hidden"><?php echo esc_html( t('pages.properties.filters.filters_active') ); ?>: <span class="count">0</span></span>
                <span id="mobile-no-active" class="text-[11px] text-slate-400 font-medium"><?php echo esc_html( t('pages.properties.filters.refine_search') ); ?></span>
            </div>
        </div>
        <svg id="toggle-chevron" class="w-5 h-5 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div id="sidebar-collapsible" class="hidden lg:block transition-all duration-300 overflow-hidden">
        <div data-aos="fade-right">
            <div class="sidebar bg-white border-[0.5px] border-slate-100 overflow-hidden rounded-2xl lg:rounded-none">
                
                <!-- Sidebar Header (Desktop) -->
                <div class="hidden lg:block px-6 pt-6 pb-5 border-b border-slate-100">
                <div class="flex items-center gap-2.5 mb-1.5">
                    <div class="w-9 h-9 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0 text-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[15px] font-medium text-slate-900 tracking-[-0.01em]">
                            <?php echo esc_html( t('pages.properties.filters.filter_results') ); ?> 
                            <span id="active-badge" class="active-badge hidden items-center justify-center min-width-[18px] h-[18px] px-1.5 bg-primary/10 text-primary rounded-[20px] text-[10px] font-medium ml-1.5">0</span>
                        </div>
                        <div class="text-[12px] text-slate-400 mt-0.5"><?php echo esc_html( t('pages.properties.filters.refine_search') ); ?></div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Body -->
            <div class="px-6 py-5 flex flex-col gap-6">

                <!-- Search Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5"><?php echo esc_html( t('pages.properties.filters.location') ); ?></div>
                    <div class="relative">
                        <svg class="absolute left-[11px] top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" id="search-input" placeholder="<?php echo esc_attr( t('pages.properties.filters.location_placeholder') ); ?>" 
                               class="w-full pl-9 pr-3.5 py-[9px] text-[13px] bg-slate-50 border-[0.5px] border-slate-100 rounded-2xl text-slate-900 outline-none transition-all focus:border-primary/50">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5"><?php echo esc_html( t('pages.properties.filters.status') ); ?></div>
                    <div class="flex flex-wrap gap-1 bg-slate-50 rounded-2xl p-[3px]" id="status-tabs">
                        <button class="tab-btn active flex-1 py-[7px] px-1 text-[11px] font-medium rounded-[6px] transition-all bg-transparent text-slate-600 [&.active]:bg-white [&.active]:text-slate-900 [&.active]:border-[0.5px] [&.active]:border-slate-100" data-val="all"><?php echo esc_html( t('pages.properties.filters.all_tabs') ); ?></button>
                        <button class="tab-btn flex-1 py-[7px] px-1 text-[11px] font-medium rounded-[6px] transition-all bg-transparent text-slate-600 [&.active]:bg-white [&.active]:text-slate-900 [&.active]:border-[0.5px] [&.active]:border-slate-100" data-val="new_build"><?php echo esc_html( t('pages.properties.filters.new_build') ); ?></button>
                        <button class="tab-btn flex-1 py-[7px] px-1 text-[11px] font-medium rounded-[6px] transition-all bg-transparent text-slate-600 [&.active]:bg-white [&.active]:text-slate-900 [&.active]:border-[0.5px] [&.active]:border-slate-100" data-val="resale"><?php echo esc_html( t('pages.properties.filters.resale') ); ?></button>
                    </div>
                </div>

                <!-- Investment Property Type Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5">Property Type</div>
                    <div class="flex flex-col gap-1.5" id="type-list">
                        <?php
                        $portfolio_handler = new \Estatery\Core\InvestPortfolioHandler();
                        $db_items = $portfolio_handler->get_all();
                        $dynamic_types = [];

                        foreach ($db_items as $row) {
                            if (!empty($row['type'])) {
                                $slug = strtolower(trim($row['type']));
                                $dynamic_types[$slug] = $row['type'];
                            }
                        }

                        $json_file = get_template_directory() . '/data/investments.json';
                        if (file_exists($json_file)) {
                            $json_data = json_decode(file_get_contents($json_file), true);
                            $raw_properties = $json_data['root']['property'] ?? [];
                            foreach ($raw_properties as $prop) {
                                if (!empty($prop['type'][0])) {
                                    $slug = strtolower(trim($prop['type'][0]));
                                    $dynamic_types[$slug] = $prop['type'][0];
                                }
                            }
                        }

                        // Map slugs to display names and SVG path icons
                        $type_labels = [
                            'villa'      => 'Villas',
                            'apartment'  => 'Apartments',
                            'penthouse'  => 'Penthouses',
                            'townhouse'  => 'Townhouses',
                            'bungalow'   => 'Bungalows',
                            'plot'       => 'Plots / Land',
                            'land'       => 'Land Plots',
                            'hotel'      => 'Hotels',
                            'commercial' => 'Commercial Properties',
                        ];

                        $type_icons = [
                            'villa'      => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            'apartment'  => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                            'penthouse'  => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                            'townhouse'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            'bungalow'   => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            'plot'       => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064',
                            'land'       => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064',
                            'hotel'      => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                            'commercial' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        ];

                        $default_icon = 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6';

                        foreach ($dynamic_types as $slug => $original_name) :
                            $name = isset($type_labels[$slug]) ? $type_labels[$slug] : ucfirst($original_name);
                            $icon = isset($type_icons[$slug]) ? $type_icons[$slug] : $default_icon;
                        ?>
                            <div class="type-item group flex items-center px-2.5 py-2.5 rounded-2xl cursor-pointer border-[0.5px] border-transparent transition-all hover:bg-slate-50 [&.selected]:bg-primary/5 [&.selected]:border-primary/20" data-type="<?php echo esc_attr($slug); ?>">
                                <div class="w-5 h-5 border-[1.5px] border-slate-200 rounded-[5px] flex-shrink-0 flex items-center justify-center transition-all group-[.selected]:bg-primary group-[.selected]:border-primary">
                                    <svg class="w-3 h-3 text-white opacity-0 transition-opacity group-[.selected]:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="w-7 h-7 rounded-xl bg-slate-50 group-[.selected]:bg-primary/10 flex items-center justify-center ml-2.5 flex-shrink-0 transition-all">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-[.selected]:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="<?php echo esc_attr($icon); ?>"/>
                                    </svg>
                                </div>
                                <span class="text-[13px] text-slate-900 ml-2 flex-1 font-medium"><?php echo esc_html($name); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="h-[0.5px] bg-slate-100"></div>

                <!-- Budget Range Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5">Investment Budget</div>
                    <div class="flex flex-col gap-1.5" id="budget-list">
                        <div class="budget-item group flex items-center justify-between px-3 py-3 rounded-2xl cursor-pointer border-[0.5px] border-transparent transition-all hover:bg-slate-50 [&.selected]:bg-primary/5 [&.selected]:border-primary/20"
                             data-min="1000000" data-max="10000000" data-label="range_1">
                            <div class="flex items-center gap-2.5">
                                <div class="w-5 h-5 border-[1.5px] border-slate-200 rounded-full flex-shrink-0 flex items-center justify-center transition-all group-[.selected]:bg-primary group-[.selected]:border-primary">
                                    <div class="w-2 h-2 rounded-full bg-white opacity-0 group-[.selected]:opacity-100 transition-opacity"></div>
                                </div>
                                <div>
                                    <span class="text-[13px] font-semibold text-slate-900 block">€1M – €10M</span>
                                    <span class="text-[11px] text-slate-400">Mid-range investment</span>
                                </div>
                            </div>
                        </div>
                        <div class="budget-item group flex items-center justify-between px-3 py-3 rounded-2xl cursor-pointer border-[0.5px] border-transparent transition-all hover:bg-slate-50 [&.selected]:bg-primary/5 [&.selected]:border-primary/20"
                             data-min="10000000" data-max="50000000" data-label="range_2">
                            <div class="flex items-center gap-2.5">
                                <div class="w-5 h-5 border-[1.5px] border-slate-200 rounded-full flex-shrink-0 flex items-center justify-center transition-all group-[.selected]:bg-primary group-[.selected]:border-primary">
                                    <div class="w-2 h-2 rounded-full bg-white opacity-0 group-[.selected]:opacity-100 transition-opacity"></div>
                                </div>
                                <div>
                                    <span class="text-[13px] font-semibold text-slate-900 block">€10M – €50M</span>
                                    <span class="text-[11px] text-slate-400">Large-scale investment</span>
                                </div>
                            </div>
                        </div>
                        <div class="budget-item group flex items-center justify-between px-3 py-3 rounded-2xl cursor-pointer border-[0.5px] border-transparent transition-all hover:bg-slate-50 [&.selected]:bg-primary/5 [&.selected]:border-primary/20"
                             data-min="50000000" data-max="0" data-label="range_3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-5 h-5 border-[1.5px] border-slate-200 rounded-full flex-shrink-0 flex items-center justify-center transition-all group-[.selected]:bg-primary group-[.selected]:border-primary">
                                    <div class="w-2 h-2 rounded-full bg-white opacity-0 group-[.selected]:opacity-100 transition-opacity"></div>
                                </div>
                                <div>
                                    <span class="text-[13px] font-semibold text-slate-900 block">€50M+</span>
                                    <span class="text-[11px] text-slate-400">Institutional / ultra-premium</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden inputs still carry values for AJAX -->
                    <input type="hidden" id="price-min" value="">
                    <input type="hidden" id="price-max" value="">
                </div>

                <!-- Bedrooms Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5"><?php echo esc_html( t('pages.properties.filters.beds') ); ?></div>
                    <div class="flex gap-[5px] flex-wrap" id="beds-chips">
                        <button class="chip active py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="any"><?php echo esc_html( t('pages.properties.filters.any') ); ?></button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="1">1</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="2">2</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="3">3</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="4">4+</button>
                    </div>
                </div>

                <!-- Bathrooms Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5"><?php echo esc_html( t('pages.properties.filters.baths') ); ?></div>
                    <div class="flex gap-[5px] flex-wrap" id="baths-chips">
                        <button class="chip active py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="any"><?php echo esc_html( t('pages.properties.filters.any') ); ?></button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="1">1</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="2">2</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="3">3</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="4">4+</button>
                    </div>
                </div>

                <div class="h-[0.5px] bg-slate-100"></div>

                <!-- Footer Buttons -->
                <div class="flex flex-col gap-2 pt-1">
                    <button class="w-full p-3.5 text-[13px] font-bold uppercase tracking-widest bg-slate-100 text-slate-500 border-none rounded-2xl transition-all hover:bg-slate-200 hover:text-slate-900 active:scale-[0.98]" onclick="resetFilters()"><?php echo esc_html( t('pages.properties.filters.reset_button') ); ?></button>
                </div>

            </div>
            </div>
        </div>
    </div>
</aside>

<script>
    <?php
    global $wp_rewrite;
    $using_permalinks = $wp_rewrite && $wp_rewrite->using_permalinks();
    ?>
    const usingPermalinks = <?php echo json_encode( $using_permalinks ); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize state from URL
        const urlParams = new URLSearchParams(window.location.search);
        // Declare state globally
        window.filterState = {
            search:       urlParams.get('search')       || '',
            status:       urlParams.get('status')       || 'all',
            types:        urlParams.get('types')        ? urlParams.get('types').split(',') : [],
            min_price:    urlParams.get('min_price')    || '',
            max_price:    urlParams.get('max_price')    || '',
            budget_range: urlParams.get('budget_range') || '',
            beds:         urlParams.get('beds')         || 'any',
            baths:        urlParams.get('baths')        || 'any',
            sort:         urlParams.get('sort')         || 'newest',
            view:         urlParams.get('view')         || 'grid'
        };
        const state = window.filterState;

        function getCurrentPage() {
            const urlParams = new URLSearchParams(window.location.search);
            let paged = urlParams.get('paged') || urlParams.get('page');
            if (paged && !isNaN(paged)) {
                return parseInt(paged, 10);
            }
            const pathMatch = window.location.pathname.match(/\/page\/(\d+)\/?/);
            if (pathMatch && pathMatch[1]) {
                return parseInt(pathMatch[1], 10);
            }
            return 1;
        }

        const selectors = {
            searchInput:     document.getElementById('search-input'),
            statusTabs:      document.querySelectorAll('#status-tabs .tab-btn'),
            typeItems:       document.querySelectorAll('#type-list .type-item'),
            budgetItems:     document.querySelectorAll('#budget-list .budget-item'),
            priceMin:        document.getElementById('price-min'),
            priceMax:        document.getElementById('price-max'),
            activeBadge:     document.getElementById('active-badge'),
            mobileToggle:    document.getElementById('mobile-filter-toggle'),
            mobileBadge:     document.getElementById('mobile-active-badge'),
            mobileNoActive:  document.getElementById('mobile-no-active'),
            mobileCount:     document.querySelector('#mobile-active-badge .count'),
            sidebarContent:  document.getElementById('sidebar-collapsible'),
            toggleChevron:   document.getElementById('toggle-chevron')
        };

        // Debounce Utility
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // 1. Sync Inputs with Initial State
        if (selectors.searchInput) selectors.searchInput.value = state.search;
        if (selectors.priceMin)    selectors.priceMin.value = state.min_price;
        if (selectors.priceMax)    selectors.priceMax.value = state.max_price;

        selectors.statusTabs.forEach(btn => {
            if (btn.dataset.val === state.status) {
                selectors.statusTabs.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
            btn.addEventListener('click', () => {
                state.status = btn.dataset.val;
                selectors.statusTabs.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                updateUI();
                autoUpdateFast();
            });
        });

        selectors.typeItems.forEach(item => {
            const type = item.dataset.type;
            if (state.types.includes(type)) item.classList.add('selected');
            
            item.addEventListener('click', () => {
                if (state.types.includes(type)) {
                    state.types = state.types.filter(x => x !== type);
                    item.classList.remove('selected');
                } else {
                    state.types.push(type);
                    item.classList.add('selected');
                }
                updateUI();
                autoUpdateFast();
            });
        });

        // Budget Range: single-select radio-style
        selectors.budgetItems.forEach(item => {
            const label = item.dataset.label;
            if (state.budget_range === label) item.classList.add('selected');

            item.addEventListener('click', () => {
                const alreadySelected = item.classList.contains('selected');
                // Deselect all
                selectors.budgetItems.forEach(i => i.classList.remove('selected'));
                if (!alreadySelected) {
                    item.classList.add('selected');
                    state.budget_range = label;
                    state.min_price    = item.dataset.min;
                    state.max_price    = item.dataset.max;
                    if (selectors.priceMin) selectors.priceMin.value = state.min_price;
                    if (selectors.priceMax) selectors.priceMax.value = state.max_price;
                } else {
                    state.budget_range = '';
                    state.min_price    = '';
                    state.max_price    = '';
                    if (selectors.priceMin) selectors.priceMin.value = '';
                    if (selectors.priceMax) selectors.priceMax.value = '';
                }
                updateUI();
                autoUpdateFast();
            });
        });

        selectors.searchInput.addEventListener('input', e => { 
            state.search = e.target.value; 
            updateUI(); 
            autoUpdateSlow(); 
        });
        // Hidden price inputs are driven by budget chips — no direct listener needed.

        function setupChips(groupId, stateKey) {
            const container = document.getElementById(groupId);
            if (!container) return;
            const chips = container.querySelectorAll('.chip');
            chips.forEach(chip => {
                if (chip.dataset.val === state[stateKey]) {
                    chips.forEach(c => c.classList.remove('active'));
                    chip.classList.add('active');
                }
                chip.addEventListener('click', () => {
                    state[stateKey] = chip.dataset.val;
                    chips.forEach(c => c.classList.remove('active'));
                    chip.classList.add('active');
                    updateUI();
                    autoUpdateFast();
                });
            });
        }
        setupChips('beds-chips', 'beds');
        setupChips('baths-chips', 'baths');

        function countActiveFilters() {
            let n = 0;
            if (state.search.trim()) n++;
            if (state.status !== 'all') n++;
            n += state.types.length;
            if (state.budget_range) n++;
            if (state.beds !== 'any') n++;
            if (state.baths !== 'any') n++;
            return n;
        }

        function updateUI() {
            const count = countActiveFilters();
            if (selectors.activeBadge) {
                if (count > 0) {
                    selectors.activeBadge.classList.replace('hidden', 'inline-flex');
                    selectors.activeBadge.textContent = count;
                } else {
                    selectors.activeBadge.classList.replace('inline-flex', 'hidden');
                }
            }
            if (selectors.mobileBadge && selectors.mobileNoActive) {
                if (count > 0) {
                    selectors.mobileBadge.classList.remove('hidden');
                    selectors.mobileNoActive.classList.add('hidden');
                    if (selectors.mobileCount) selectors.mobileCount.textContent = count;
                } else {
                    selectors.mobileBadge.classList.add('hidden');
                    selectors.mobileNoActive.classList.remove('hidden');
                }
            }
        }

        if (selectors.mobileToggle && selectors.sidebarContent) {
            selectors.mobileToggle.addEventListener('click', () => {
                const isHidden = selectors.sidebarContent.classList.contains('hidden');
                if (isHidden) {
                    selectors.sidebarContent.classList.remove('hidden');
                    if (selectors.toggleChevron) selectors.toggleChevron.classList.add('rotate-180');
                } else {
                    selectors.sidebarContent.classList.add('hidden');
                    if (selectors.toggleChevron) selectors.toggleChevron.classList.remove('rotate-180');
                }
            });
        }

        const autoUpdateSlow = debounce(() => updateProperties(1), 300);
        const autoUpdateFast = debounce(() => updateProperties(1), 150);

        window.updateProperties = function(paged = 1) {
            const container = document.getElementById('properties-results-container');
            const ajaxContent = document.getElementById('properties-content-ajax');
            const loading = document.getElementById('properties-loading');
            
            if (!container || !loading) return;

            loading.classList.remove('opacity-0', 'pointer-events-none');
            ajaxContent.classList.add('opacity-40');

            const params = new URLSearchParams();
            if (state.search.trim()) params.set('search', state.search.trim());
            if (state.status !== 'all') params.set('status', state.status);
            if (state.types.length) params.set('types', state.types.join(','));
            if (state.budget_range) params.set('budget_range', state.budget_range);
            if (state.min_price) params.set('min_price', state.min_price);
            if (state.max_price) params.set('max_price', state.max_price);
            if (state.beds !== 'any') params.set('beds', state.beds);
            if (state.baths !== 'any') params.set('baths', state.baths);
            params.set('sort', state.sort);
            params.set('view', state.view);

            // Clean the pathname from existing page numbers
            const cleanPathname = window.location.pathname.replace(/\/page\/\d+\/?$/, '');
            let newUrl = '';

            if (usingPermalinks) {
                let newPath = cleanPathname;
                if (paged > 1) {
                    newPath = newPath.replace(/\/$/, '') + '/page/' + paged + '/';
                } else {
                    newPath = newPath.replace(/\/$/, '') + '/';
                }
                newUrl = newPath + (params.toString() ? '?' + params.toString() : '');
            } else {
                if (paged > 1) {
                    params.set('paged', paged);
                }
                newUrl = cleanPathname + (params.toString() ? '?' + params.toString() : '');
            }

            window.history.pushState({ path: newUrl }, '', newUrl);

            const formData = new FormData();
            formData.append('action', 'get_filtered_investments');
            formData.append('lang', '<?php echo \Estatery\Core\Translator::getInstance()->getLang(); ?>');
            formData.append('search', state.search.trim());
            formData.append('status', state.status);
            formData.append('types', state.types.join(','));
            formData.append('budget_range', state.budget_range || '');
            formData.append('min_price', state.min_price);
            formData.append('max_price', state.max_price);
            formData.append('beds', state.beds === 'any' ? 0 : state.beds);
            formData.append('baths', state.baths === 'any' ? 0 : state.baths);
            formData.append('paged', paged);
            formData.append('sort', state.sort);
            formData.append('view', state.view);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    ajaxContent.innerHTML = response.data.html_results + response.data.html_pagination;
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    initPaginationLinks();
                }
            })
            .finally(() => {
                loading.classList.add('opacity-0', 'pointer-events-none');
                ajaxContent.classList.remove('opacity-40');
            });
        };

        window.resetFilters = function() {
            state.search       = '';
            state.status       = 'all';
            state.types        = [];
            state.budget_range = '';
            state.min_price    = '';
            state.max_price    = '';
            state.beds         = 'any';
            state.baths        = 'any';
            if (selectors.searchInput) selectors.searchInput.value = '';
            if (selectors.priceMin)    selectors.priceMin.value    = '';
            if (selectors.priceMax)    selectors.priceMax.value    = '';
            selectors.statusTabs.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.val === 'all') btn.classList.add('active');
            });
            selectors.typeItems.forEach(item  => item.classList.remove('selected'));
            selectors.budgetItems.forEach(item => item.classList.remove('selected'));
            document.querySelectorAll('#beds-chips .chip').forEach(c => {
                c.classList.remove('active');
                if (c.dataset.val === 'any') c.classList.add('active');
            });
            document.querySelectorAll('#baths-chips .chip').forEach(c => {
                c.classList.remove('active');
                if (c.dataset.val === 'any') c.classList.add('active');
            });
            updateUI();
            updateProperties(1);
        };

        function initPaginationLinks() {
            document.querySelectorAll('.pagination-ajax-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    updateProperties(this.dataset.page);
                });
            });
        }

        initPaginationLinks();
        updateUI();
    });
</script>
