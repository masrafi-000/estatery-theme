<?php
/**
 * Component: Properties Sidebar Filters (Refactored to Tailwind & Modular)
 */
?>

<h2 class="sr-only"><?php echo esc_html( t('pages.properties.filters.sidebar_sr_description') ?? 'Property search filter sidebar' ); ?></h2>

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

                <!-- Property Type Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5"><?php echo esc_html( t('pages.properties.filters.type') ); ?></div>
                    <div class="flex flex-col gap-1.5" id="type-list">
                        <?php 
                        $types = t('pages.properties.categories.types');
                        if ( is_array($types) ) :
                            foreach ( $types as $type ) :
                                ?>
                                <div class="type-item group flex items-center justify-between px-2.5 py-2 rounded-2xl cursor-pointer border-[0.5px] border-transparent transition-all hover:bg-slate-50 [&.selected]:bg-primary/5 [&.selected]:border-primary/20" data-type="<?php echo esc_attr($type['slug']); ?>">
                                    <div class="w-4 h-4 border-[1.5px] border-slate-200 rounded-[4px] flex-shrink-0 flex items-center justify-center transition-all group-[.selected]:bg-primary group-[.selected]:border-primary">
                                        <svg class="w-2.5 h-2.5 text-white opacity-0 transition-opacity group-[.selected]:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-[13px] text-slate-900 ml-2.5 flex-1"><?php echo esc_html($type['name']); ?></span>
                                    <span class="text-[11px] text-slate-400"><?php echo esc_html($type['count']); ?></span>
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <div class="h-[0.5px] bg-slate-100"></div>

                <!-- Price Range Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5"><?php echo esc_html( t('pages.properties.filters.price') ); ?></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="relative">
                            <span class="absolute left-[10px] top-1/2 -translate-y-1/2 text-[12px] text-slate-400">€</span>
                            <input type="number" id="price-min" placeholder="<?php echo esc_attr( t('pages.properties.filters.min_placeholder') ); ?>" 
                                   class="w-full pl-[22px] pr-2.5 py-[9px] text-[13px] bg-slate-50 border-[0.5px] border-slate-100 rounded-2xl text-slate-900 outline-none transition-all focus:border-primary/50">
                        </div>
                        <div class="relative">
                            <span class="absolute left-[10px] top-1/2 -translate-y-1/2 text-[12px] text-slate-400">€</span>
                            <input type="number" id="price-max" placeholder="<?php echo esc_attr( t('pages.properties.filters.max_placeholder') ); ?>" 
                                   class="w-full pl-[22px] pr-2.5 py-[9px] text-[13px] bg-slate-50 border-[0.5px] border-slate-100 rounded-2xl text-slate-900 outline-none transition-all focus:border-primary/50">
                        </div>
                    </div>
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
    const i18n = <?php echo json_encode( t('pages.properties.js') ); ?>;

    // Debounce Utility
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize state from URL
        const urlParams = new URLSearchParams(window.location.search);
        // Declare state globally so grid-header.php can access it
        window.filterState = {
            search:   urlParams.get('search')    || '',
            status:   urlParams.get('status')    || 'all',
            types:    urlParams.get('types')     ? urlParams.get('types').split(',') : [],
            min_price: urlParams.get('min_price') || '',
            max_price: urlParams.get('max_price') || '',
            beds:     urlParams.get('beds')      || 'any',
            baths:    urlParams.get('baths')     || 'any',
            sort:     urlParams.get('sort')      || 'newest',
            view:     urlParams.get('view')      || 'grid'
        };
        const state = window.filterState;

        const selectors = {
            searchInput:     document.getElementById('search-input'),
            statusTabs:      document.querySelectorAll('#status-tabs .tab-btn'),
            typeItems:       document.querySelectorAll('#type-list .type-item'),
            priceMin:        document.getElementById('price-min'),
            priceMax:        document.getElementById('price-max'),
            activeBadge:     document.getElementById('active-badge'),
            summaryBar:      document.getElementById('summary-bar') || null,
            summaryText:     document.getElementById('summary-text') || null,
            // Mobile Specific
            mobileToggle:    document.getElementById('mobile-filter-toggle'),
            mobileBadge:     document.getElementById('mobile-active-badge'),
            mobileNoActive:  document.getElementById('mobile-no-active'),
            mobileCount:     document.querySelector('#mobile-active-badge .count'),
            sidebarContent:  document.getElementById('sidebar-collapsible'),
            toggleChevron:   document.getElementById('toggle-chevron')
        };

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

        selectors.searchInput.addEventListener('input', e => { 
            state.search = e.target.value; 
            updateUI(); 
            autoUpdateSlow(); 
        });
        selectors.priceMin.addEventListener('input', e => { 
            state.min_price = e.target.value; 
            updateUI(); 
            autoUpdateSlow(); 
        });
        selectors.priceMax.addEventListener('input', e => { 
            state.max_price = e.target.value; 
            updateUI(); 
            autoUpdateSlow(); 
        });

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
            if (state.min_price || state.max_price) n++;
            if (state.beds !== 'any') n++;
            if (state.baths !== 'any') n++;
            return n;
        }

        function updateUI() {
            const count = countActiveFilters();
            
            // Desktop Badge
            if (selectors.activeBadge) {
                if (count > 0) {
                    selectors.activeBadge.classList.replace('hidden', 'inline-flex');
                    selectors.activeBadge.textContent = count;
                } else {
                    selectors.activeBadge.classList.replace('inline-flex', 'hidden');
                }
            }

            // Mobile Badge Sync
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

        // Mobile Toggle Handler
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

        // Auto-Update Functions
        const autoUpdateSlow = debounce(() => updateProperties(1), 300);
        const autoUpdateFast = debounce(() => updateProperties(1), 150);

        /**
         * AJAX: Update properties without reload
         */
        window.updateProperties = function(paged = 1) {
            const container = document.getElementById('properties-results-container');
            const ajaxContent = document.getElementById('properties-content-ajax');
            const loading = document.getElementById('properties-loading');
            
            if (!container || !loading) return;

            // Show loading
            loading.classList.remove('opacity-0', 'pointer-events-none');
            ajaxContent.classList.add('opacity-40');

            const params = new URLSearchParams();
            if (state.search.trim()) params.set('search', state.search.trim());
            if (state.status !== 'all') params.set('status', state.status);
            if (state.types.length) params.set('types', state.types.join(','));
            if (state.min_price) params.set('min_price', state.min_price);
            if (state.max_price) params.set('max_price', state.max_price);
            if (state.beds !== 'any') params.set('beds', state.beds);
            if (state.baths !== 'any') params.set('baths', state.baths);
            
            params.set('sort', state.sort);
            params.set('view', state.view);
            params.set('paged', paged);

            // Update URL without reload
            const newUrl = window.location.pathname + '?' + params.toString();
            window.history.pushState({ path: newUrl }, '', newUrl);

            // Prepare POST data
            const formData = new FormData();
            formData.append('action', 'get_filtered_properties');
            formData.append('lang', '<?php echo \Estatery\Core\Translator::getInstance()->getLang(); ?>');
            formData.append('search', state.search.trim());
            formData.append('status', state.status);
            formData.append('types', state.types.join(','));
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
                    
                    // Update Grid Header if exists (it's inside response.data.html_results but let's be sure)
                    // Actually, the AJAX handler returns grid results + pagination.
                    // We need the Header too. I added it to AjaxHandler.php.
                    
                    // Scroll to top of container
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            })
            .catch(err => console.error('Error fetching properties:', err))
            .finally(() => {
                loading.classList.add('opacity-0', 'pointer-events-none');
                ajaxContent.classList.remove('opacity-40');
                
                // Re-initialize any JS needed for the new elements (like pagination links)
                initPaginationLinks();
            });
        };

        window.applyFilters = function() {
            updateProperties(1);
        };

        window.resetFilters = function() {
            state.search = '';
            state.status = 'all';
            state.types = [];
            state.min_price = '';
            state.max_price = '';
            state.beds = 'any';
            state.baths = 'any';
            
            // Reset UI elements
            if (selectors.searchInput) selectors.searchInput.value = '';
            if (selectors.priceMin)    selectors.priceMin.value = '';
            if (selectors.priceMax)    selectors.priceMax.value = '';
            
            selectors.statusTabs.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.val === 'all') btn.classList.add('active');
            });
            
            selectors.typeItems.forEach(item => item.classList.remove('selected'));
            
            const bedsChips = document.querySelectorAll('#beds-chips .chip');
            bedsChips.forEach(c => {
                c.classList.remove('active');
                if (c.dataset.val === 'any') c.classList.add('active');
            });

            const bathsChips = document.querySelectorAll('#baths-chips .chip');
            bathsChips.forEach(c => {
                c.classList.remove('active');
                if (c.dataset.val === 'any') c.classList.add('active');
            });

            updateUI();
            updateProperties(1);
        };

        function initPaginationLinks() {
            const paginationLinks = document.querySelectorAll('.pagination-ajax-link');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.dataset.page;
                    updateProperties(page);
                });
            });
        }

        // Listen for browser Back/Forward buttons
        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            state.search    = urlParams.get('search')    || '';
            state.status    = urlParams.get('status')    || 'all';
            state.types     = urlParams.get('types')     ? urlParams.get('types').split(',') : [];
            state.min_price = urlParams.get('min_price') || '';
            state.max_price = urlParams.get('max_price') || '';
            state.beds      = urlParams.get('beds')      || 'any';
            state.baths     = urlParams.get('baths')     || 'any';
            state.sort      = urlParams.get('sort')      || 'newest';
            state.view      = urlParams.get('view')      || 'grid';
            
            // Sync UI back
            if (selectors.searchInput) selectors.searchInput.value = state.search;
            if (selectors.priceMin)    selectors.priceMin.value = state.min_price;
            if (selectors.priceMax)    selectors.priceMax.value = state.max_price;
            
            selectors.statusTabs.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.val === state.status) btn.classList.add('active');
            });
            
            selectors.typeItems.forEach(item => {
                if (state.types.includes(item.dataset.type)) item.classList.add('selected');
                else item.classList.remove('selected');
            });

            updateUI();
            
            // Re-fetch without pushing state again
            const container = document.getElementById('properties-results-container');
            const ajaxContent = document.getElementById('properties-content-ajax');
            const loading = document.getElementById('properties-loading');
            if (!container || !loading) return;

            loading.classList.remove('opacity-0', 'pointer-events-none');
            ajaxContent.classList.add('opacity-40');

            const paged = urlParams.get('paged') || 1;
            const sortSelection = urlParams.get('sort') || 'newest';
            const viewSelection = urlParams.get('view') || 'grid';

            const formData = new FormData();
            formData.append('action', 'get_filtered_properties');
            formData.append('lang', '<?php echo \Estatery\Core\Translator::getInstance()->getLang(); ?>');
            formData.append('search', state.search);
            formData.append('status', state.status);
            formData.append('types', state.types.join(','));
            formData.append('min_price', state.min_price);
            formData.append('max_price', state.max_price);
            formData.append('beds', state.beds === 'any' ? 0 : state.beds);
            formData.append('baths', state.baths === 'any' ? 0 : state.baths);
            formData.append('paged', paged);
            formData.append('sort', sortSelection);
            formData.append('view', viewSelection);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    ajaxContent.innerHTML = response.data.html_results + response.data.html_pagination;
                    initPaginationLinks();
                }
            })
            .finally(() => {
                loading.classList.add('opacity-0', 'pointer-events-none');
                ajaxContent.classList.remove('opacity-40');
            });
        });

        // Initial init
        initPaginationLinks();
        updateUI();

        // Trigger search on load if URL params are present
        if (window.location.search) {
            updateProperties(1);
        }
    });
</script>
