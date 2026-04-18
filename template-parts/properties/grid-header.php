<?php
/**
 * Component: Properties Grid Header
 *
 * @var int    $total_results   Total number of properties found
 * @var int    $current_page    Current page number
 * @var int    $per_page        Items per page
 * @var string $current_sort    Active sort key
 * @var string $current_view    'grid' | 'list'
 */

$total_results = isset($total_results) ? (int) $total_results : 0;
$current_page  = isset($current_page)  ? (int) $current_page  : 1;
$per_page      = isset($per_page)      ? (int) $per_page      : 12;
$current_sort  = isset($current_sort)  ? sanitize_key($current_sort) : 'newest';
$current_view  = isset($current_view)  ? sanitize_key($current_view) : 'grid';

// Calculated range: "Showing 13–24 of 86 properties"
$range_from = min( ( ($current_page - 1) * $per_page ) + 1, $total_results );
$range_to   = min( $current_page * $per_page, $total_results );

$sort_options = [
    'newest'     => t('pages.properties.sort.newest')     ?? 'Newest First',
    'oldest'     => t('pages.properties.sort.oldest')     ?? 'Oldest First',
    'price_asc'  => t('pages.properties.sort.price_low')  ?? 'Price: Low to High',
    'price_desc' => t('pages.properties.sort.price_high') ?? 'Price: High to Low',
    'area_asc'   => t('pages.properties.sort.area_low')   ?? 'Area: Smallest First',
    'area_desc'  => t('pages.properties.sort.area_high')  ?? 'Area: Largest First',
];

// Build sort URL preserving existing params
function sort_url( string $sort_key ): string {
    return esc_url( add_query_arg( [
        'sort'  => $sort_key,
        'paged' => 1 // reset to page 1 on sort change
    ] ) );
}

// Build view URL
function view_url( string $view ): string {
    return esc_url( add_query_arg( 'view', $view ) );
}
?>

<div class="flex flex-wrap items-center justify-between gap-y-6 gap-x-4 mb-12" data-aos="fade-up">

    <!-- Left: Result count -->
    <div class="flex flex-col gap-1.5">

        <span class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.25em] text-primary">
            <svg class="w-3 h-3" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <circle cx="6" cy="6" r="2.5"/>
                <circle cx="6" cy="6" r="5.25" fill="none" stroke="currentColor" stroke-width="1"/>
            </svg>
            <?php echo esc_html( t('pages.properties.grid_header.showing_result') ?? 'Search Results' ); ?>
        </span>

        <div class="flex items-baseline gap-2.5 flex-wrap">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-none">
                <?php echo number_format( $total_results ); ?>
            </h2>
            <span class="text-slate-400 text-sm font-semibold">
                <?php echo esc_html( t('pages.properties.grid_header.items_available') ?? 'Properties Found' ); ?>
            </span>

            <?php if ( $total_results > 0 ) : ?>
                <span class="hidden sm:inline-flex items-center gap-1 text-[10px] font-bold text-slate-400 border-l border-slate-200 pl-2.5 ml-0.5">
                    <?php printf(
                        esc_html( t('pages.properties.grid_header.range') ?? 'Showing %1$s–%2$s' ),
                        '<span class="text-slate-600">' . $range_from . '</span>',
                        '<span class="text-slate-600">' . $range_to   . '</span>'
                    ); ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if ( $total_results === 0 ) : ?>
            <p class="text-xs text-slate-400 font-medium mt-0.5">
                <?php echo esc_html( t('pages.properties.grid_header.no_results') ?? 'Try adjusting your filters.' ); ?>
            </p>
        <?php endif; ?>

    </div>

    <!-- Right: View toggle + Sort -->
    <div class="flex items-center gap-3 flex-wrap">

        <!-- View Toggle -->
        <div class="flex items-center border border-slate-200 bg-white overflow-hidden">
            <a href="<?php echo view_url('grid'); ?>"
               class="w-10 h-10 flex items-center justify-center transition-colors duration-150
                      <?php echo $current_view === 'grid' ? 'bg-slate-900 text-white' : 'text-slate-400 hover:text-slate-700 hover:bg-slate-50'; ?>"
               title="<?php echo esc_attr( t('pages.properties.grid_header.view_grid') ?? 'Grid view' ); ?>">
                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="1" width="6" height="6" rx="0.75"/>
                    <rect x="9" y="1" width="6" height="6" rx="0.75"/>
                    <rect x="1" y="9" width="6" height="6" rx="0.75"/>
                    <rect x="9" y="9" width="6" height="6" rx="0.75"/>
                </svg>
            </a>
            <span class="w-px h-5 bg-slate-200"></span>
            <a href="<?php echo view_url('list'); ?>"
               class="w-10 h-10 flex items-center justify-center transition-colors duration-150
                      <?php echo $current_view === 'list' ? 'bg-slate-900 text-white' : 'text-slate-400 hover:text-slate-700 hover:bg-slate-50'; ?>"
               title="<?php echo esc_attr( t('pages.properties.grid_header.view_list') ?? 'List view' ); ?>">
                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1"  y="2.5" width="14" height="1.5" rx="0.75"/>
                    <rect x="1"  y="7"   width="14" height="1.5" rx="0.75"/>
                    <rect x="1"  y="11.5" width="14" height="1.5" rx="0.75"/>
                </svg>
            </a>
        </div>

        <!-- Divider -->
        <span class="hidden sm:block w-px h-6 bg-slate-200"></span>

        <!-- Sort Label (desktop only) -->
        <span class="hidden sm:block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
            <?php echo esc_html( t('pages.properties.grid_header.sort_by') ?? 'Sort by' ); ?>
        </span>

        <!-- Sort Dropdown -->
        <div class="relative">
            <select onchange="window.location.href = this.value"
                    class="appearance-none bg-white border border-slate-200 pl-4 pr-10 h-10 text-[11px] font-black uppercase tracking-[0.15em] text-slate-700 outline-none cursor-pointer hover:border-slate-400 focus:border-slate-900 transition-colors duration-150">
                <?php foreach ( $sort_options as $key => $label ) : ?>
                    <option value="<?php echo sort_url($key); ?>"
                            <?php selected( $current_sort, $key ); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- Custom chevron -->
            <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-3.5 h-3.5" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 5L7 9L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </div>

        <!-- Active filter count pill (optional, shown when filters are active) -->
        <?php
        $active_filters = 0;
        $skip_keys = ['paged', 'sort', 'view'];
        foreach ( $_GET as $key => $val ) {
            if ( ! in_array($key, $skip_keys) && $val !== '' ) $active_filters++;
        }
        if ( $active_filters > 0 ) :
        ?>
            <span class="inline-flex items-center gap-1.5 h-10 px-3.5 border border-primary/30 bg-primary/5 text-primary text-[10px] font-black uppercase tracking-[0.15em]">
                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 2.5h10M3 6h6M5 9.5h2" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"/>
                </svg>
                <?php echo $active_filters; ?>
                <?php echo esc_html( t('pages.properties.grid_header.filters_active') ?? 'Filters Active' ); ?>
            </span>
        <?php endif; ?>

    </div>

</div>