<?php
/**
 * Component: Properties Sidebar Filters (Refactored to Tailwind & Modular)
 */
?>

<h2 class="sr-only">Property search filter sidebar with status, type, price, bedrooms, and bathrooms filters</h2>

<aside class="lg:w-[400px]">
    <div data-aos="fade-right">
        <div class="sidebar bg-white border-[0.5px] border-slate-100 overflow-hidden">
            
            <!-- Sidebar Header -->
            <div class="px-6 pt-6 pb-5 border-b border-slate-100">
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

               

                <!-- Location Filter -->
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
                    <div class="flex gap-1 bg-slate-50 rounded-2xl p-[3px]" id="status-tabs">
                        <button class="tab-btn active flex-1 py-[7px] px-1 text-[11px] font-medium rounded-[6px] transition-all bg-transparent text-slate-600 [&.active]:bg-white [&.active]:text-slate-900 [&.active]:border-[0.5px] [&.active]:border-slate-100" data-val="all"><?php echo esc_html( t('pages.properties.filters.all_tabs') ); ?></button>
                        <button class="tab-btn flex-1 py-[7px] px-1 text-[11px] font-medium rounded-[6px] transition-all bg-transparent text-slate-600 [&.active]:bg-white [&.active]:text-slate-900 [&.active]:border-[0.5px] [&.active]:border-slate-100" data-val="buy"><?php echo esc_html( t('pages.properties.filters.buy') ); ?></button>
                        <button class="tab-btn flex-1 py-[7px] px-1 text-[11px] font-medium rounded-[6px] transition-all bg-transparent text-slate-600 [&.active]:bg-white [&.active]:text-slate-900 [&.active]:border-[0.5px] [&.active]:border-slate-100" data-val="rent"><?php echo esc_html( t('pages.properties.filters.rent') ); ?></button>
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
                                <div class="type-item group flex items-center justify-between px-2.5 py-2 rounded-2xl cursor-pointer border-[0.5px] border-transparent transition-all hover:bg-slate-50 [&.selected]:bg-primary/5 [&.selected]:border-primary/20" data-type="<?php echo esc_attr(strtolower($type['name'])); ?>">
                                    <div class="w-4 h-4 border-[1.5px] border-slate-200 rounded-[4px] flex-shrink-0 flex items-center justify-center transition-all group-[.selected]:bg-primary group-[.selected]:border-primary">
                                        <svg class="w-2.5 h-2.5 text-white opacity-0 transition-opacity group-[.selected]:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-[13px] text-slate-900 ml-2.5 flex-1"><?php echo esc_html($type['name']); ?></span>
                                    <span class="text-[11px] text-slate-400"><?php echo (int) $type['count']; ?></span>
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
                            <span class="absolute left-[10px] top-1/2 -translate-y-1/2 text-[12px] text-slate-400">$</span>
                            <input type="number" id="price-min" placeholder="<?php echo esc_attr( t('pages.properties.filters.min_placeholder') ); ?>" 
                                   class="w-full pl-[22px] pr-2.5 py-[9px] text-[13px] bg-slate-50 border-[0.5px] border-slate-100 rounded-2xl text-slate-900 outline-none transition-all focus:border-primary/50">
                        </div>
                        <div class="relative">
                            <span class="absolute left-[10px] top-1/2 -translate-y-1/2 text-[12px] text-slate-400">$</span>
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
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="1">1+</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="2">2+</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="3">3+</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="4">4+</button>
                    </div>
                </div>

                <!-- Bathrooms Filter -->
                <div class="filter-group">
                    <div class="text-[11px] font-medium text-slate-400 tracking-[0.06em] uppercase mb-2.5"><?php echo esc_html( t('pages.properties.filters.baths') ); ?></div>
                    <div class="flex gap-[5px] flex-wrap" id="baths-chips">
                        <button class="chip active py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="any"><?php echo esc_html( t('pages.properties.filters.any') ); ?></button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="1">1+</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="2">2+</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="3">3+</button>
                        <button class="chip py-1.5 px-3 text-[12px] border-[0.5px] border-slate-100 rounded-[20px] transition-all bg-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900 [&.active]:bg-primary/10 [&.active]:border-primary/20 [&.active]:text-primary" data-val="4">4+</button>
                    </div>
                </div>

                <div class="h-[0.5px] bg-slate-100"></div>

                <!-- Footer Buttons -->
                <div class="flex flex-col gap-2 pt-1">
                    <button class="w-full p-[11px] text-[13px] font-medium bg-slate-900 text-white border-none rounded-2xl transition-all hover:opacity-85 active:scale-[0.98] tracking-[0.01em]" onclick="applyFilters()"><?php echo esc_html( t('pages.properties.filters.apply_button') ); ?></button>
                    <button class="w-full p-2.25 text-[12px] font-medium bg-transparent text-slate-400 border-[0.5px] border-slate-100 rounded-2xl transition-all hover:text-slate-900 hover:border-slate-300" onclick="resetFilters()"><?php echo esc_html( t('pages.properties.filters.reset_button') ); ?></button>
                </div>

            </div>
        </div>
    </div>
</aside>

<script>
    const i18n = <?php echo json_encode( t('pages.properties.js') ); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const state = {
            search: '',
            status: 'all',
            types: [],
            priceMin: '',
            priceMax: '',
            beds: 'any',
            baths: 'any'
        };

        const selectors = {
            searchInput: document.getElementById('search-input'),
            statusTabs: document.querySelectorAll('#status-tabs .tab-btn'),
            typeItems: document.querySelectorAll('#type-list .type-item'),
            priceMin: document.getElementById('price-min'),
            priceMax: document.getElementById('price-max'),
            activeBadge: document.getElementById('active-badge'),
            summaryBar: document.getElementById('summary-bar'),
            summaryText: document.getElementById('summary-text')
        };

        selectors.searchInput.addEventListener('input', e => {
            state.search = e.target.value;
            updateUI();
        });

        selectors.statusTabs.forEach(btn => {
            btn.addEventListener('click', () => {
                state.status = btn.dataset.val;
                selectors.statusTabs.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                updateUI();
            });
        });

        selectors.typeItems.forEach(item => {
            item.addEventListener('click', () => {
                const t = item.dataset.type;
                if (state.types.includes(t)) {
                    state.types = state.types.filter(x => x !== t);
                    item.classList.remove('selected');
                } else {
                    state.types.push(t);
                    item.classList.add('selected');
                }
                updateUI();
            });
        });

        selectors.priceMin.addEventListener('input', e => { state.priceMin = e.target.value; updateUI(); });
        selectors.priceMax.addEventListener('input', e => { state.priceMax = e.target.value; updateUI(); });

        function setupChips(groupId, stateKey) {
            document.querySelectorAll('#' + groupId + ' .chip').forEach(chip => {
                chip.addEventListener('click', () => {
                    state[stateKey] = chip.dataset.val;
                    document.querySelectorAll('#' + groupId + ' .chip').forEach(c => c.classList.remove('active'));
                    chip.classList.add('active');
                    updateUI();
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
            if (state.priceMin || state.priceMax) n++;
            if (state.beds !== 'any') n++;
            if (state.baths !== 'any') n++;
            return n;
        }

        function updateUI() {
            const count = countActiveFilters();
            if (count > 0) {
                selectors.activeBadge.classList.replace('hidden', 'inline-flex');
                selectors.activeBadge.textContent = count;
            } else {
                selectors.activeBadge.classList.replace('inline-flex', 'hidden');
            }

            const parts = [];
            if (state.search.trim()) parts.push('"' + state.search.trim() + '"');
            if (state.status !== 'all') parts.push(state.status);
            if (state.types.length) parts.push(state.types.join(', '));
            if (state.priceMin && state.priceMax) parts.push('$' + Number(state.priceMin).toLocaleString() + ' – $' + Number(state.priceMax).toLocaleString());
            else if (state.priceMin) parts.push(i18n.from + ' $' + Number(state.priceMin).toLocaleString());
            else if (state.priceMax) parts.push(i18n.up_to + ' $' + Number(state.priceMax).toLocaleString());
            if (state.beds !== 'any') parts.push(state.beds + '+ ' + i18n.beds_label);
            if (state.baths !== 'any') parts.push(state.baths + '+ ' + i18n.baths_label);

            if (parts.length > 0) {
                selectors.summaryBar.classList.add('visible');
                selectors.summaryBar.classList.remove('hidden');
                selectors.summaryText.textContent = parts.join(' · ');
            } else {
                selectors.summaryBar.classList.remove('visible');
                selectors.summaryBar.classList.add('hidden');
            }
        }

        window.applyFilters = function() {
            const data = { ...state };
            console.log('%c[Property Filters] Applied', 'color:#0ea5e9;font-weight:bold', data);
            const btn = document.querySelector('button[onclick="applyFilters()"]');
            const orig = btn.textContent;
            btn.textContent = i18n.applied;
            btn.style.opacity = '0.7';
            setTimeout(() => { btn.textContent = orig; btn.style.opacity = ''; }, 1200);
        };

        window.resetFilters = function() {
            state.search = '';
            state.status = 'all';
            state.types = [];
            state.priceMin = '';
            state.priceMax = '';
            state.beds = 'any';
            state.baths = 'any';

            selectors.searchInput.value = '';
            selectors.priceMin.value = '';
            selectors.priceMax.value = '';
            selectors.statusTabs.forEach(b => b.classList.toggle('active', b.dataset.val === 'all'));
            selectors.typeItems.forEach(i => i.classList.remove('selected'));
            document.querySelectorAll('#beds-chips .chip').forEach(c => c.classList.toggle('active', c.dataset.val === 'any'));
            document.querySelectorAll('#baths-chips .chip').forEach(c => c.classList.toggle('active', c.dataset.val === 'any'));
            updateUI();
            console.log('%c[Property Filters] Reset', 'color:#f97316;font-weight:bold', state);
        };
    });
</script>
