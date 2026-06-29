<?php
/**
 * Component: Properties Pagination
 *
 * @var int $current_page   Current active page (default: 1)
 * @var int $total_pages    Total number of pages (default: 10)
 * @var int $window         Pages to show around current (default: 2)
 */

$current_page = $args['current_page'] ?? 1;
$total_pages  = $args['total_pages']  ?? 1;
$window       = $args['window']       ?? 2;

if ( $total_pages <= 1 ) return;

$base_url = strtok( $_SERVER['REQUEST_URI'], '?' );

function pagination_url( string $base, int $page ): string {
    // If we're doing AJAX, use the referrer URL (the frontend URL that initiated the request)
    $request_uri = $_SERVER['REQUEST_URI'];
    if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || wp_doing_ajax() ) {
        $request_uri = wp_get_referer() ?: $_SERVER['HTTP_REFERER'] ?: '';
    }

    if ( ! $request_uri ) {
        return esc_url( get_pagenum_link( $page ) );
    }

    // Parse URL parts
    $url_parts = wp_parse_url( $request_uri );
    $path = $url_parts['path'] ?? '/';
    $query = $url_parts['query'] ?? '';

    // Clean existing page number from path if present (e.g. /page/2/ or /page/2)
    $path = preg_replace( '/\/page\/\d+\/?$/', '', $path );
    
    // Remember if path had a trailing slash
    $had_trailing_slash = ( substr( $path, -1 ) === '/' );
    $path = rtrim( $path, '/' );

    global $wp_rewrite;
    if ( $wp_rewrite && $wp_rewrite->using_permalinks() ) {
        // Pretty permalinks enabled
        if ( $page > 1 ) {
            $path .= '/page/' . $page;
        }
        $path = user_trailingslashit( $path );
    } else {
        // Ugly permalinks: restore trailing slash if it was there originally
        if ( $had_trailing_slash ) {
            $path .= '/';
        }
        
        parse_str( $query, $query_args );
        if ( $page > 1 ) {
            $query_args['paged'] = $page;
        } else {
            unset( $query_args['paged'] );
        }
        $query = http_build_query( $query_args );
    }

    // Reconstruct full URL
    $scheme = is_ssl() ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $port = $_SERVER['SERVER_PORT'] ?? '';

    $port_suffix = '';
    if ( $port && ! strpos( $host, ':' ) ) {
        if ( ( $scheme === 'http' && $port !== '80' ) || ( $scheme === 'https' && $port !== '443' ) ) {
            $port_suffix = ':' . $port;
        }
    }

    $base_domain = $scheme . '://' . $host . $port_suffix;
    $final_url = $base_domain . $path;

    if ( $query ) {
        // Ensure paged parameter is not in both path and query when pretty permalinks are used
        if ( $wp_rewrite && $wp_rewrite->using_permalinks() ) {
            parse_str( $query, $query_args );
            unset( $query_args['paged'] );
            $query = http_build_query( $query_args );
        }
        if ( $query ) {
            $final_url .= '?' . $query;
        }
    }

    return esc_url( $final_url );
}

/**
 * Build page range with ellipsis markers.
 * e.g. [1, '...', 4, 5, 6, '...', 10]
 */
function build_page_range( int $current, int $total, int $window ): array {
    $pages = [];

    $range_start = max( 2, $current - $window );
    $range_end   = min( $total - 1, $current + $window );

    $pages[] = 1;

    if ( $range_start > 2 ) $pages[] = '...';

    for ( $i = $range_start; $i <= $range_end; $i++ ) {
        $pages[] = $i;
    }

    if ( $range_end < $total - 1 ) $pages[] = '...';

    if ( $total > 1 ) $pages[] = $total;

    return $pages;
}

$pages      = build_page_range( $current_page, $total_pages, $window );
$prev_page  = max( 1, $current_page - 1 );
$next_page  = min( $total_pages, $current_page + 1 );
$has_prev   = $current_page > 1;
$has_next   = $current_page < $total_pages;
?>

<nav class="mt-20 flex flex-col items-center gap-6" aria-label="Pagination">

    <div class="flex items-center gap-1.5">

        <!-- Prev Button -->
        <?php if ( $has_prev ) : ?>
            <a href="<?php echo pagination_url( $base_url, $prev_page ); ?>"
               class="pagination-ajax-link group w-11 h-11 flex items-center justify-center border border-slate-200 bg-white text-slate-400 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-200"
               data-page="<?php echo $prev_page; ?>"
               aria-label="<?php echo esc_attr( t('pages.properties.pagination.prev') ?? 'Previous page' ); ?>">
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 3L5.70711 7.29289C5.31658 7.68342 5.31658 8.31658 5.70711 8.70711L10 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </a>
        <?php else : ?>
            <span class="w-11 h-11 flex items-center justify-center border border-slate-100 bg-slate-50 text-slate-300 cursor-not-allowed" aria-disabled="true">
                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 3L5.70711 7.29289C5.31658 7.68342 5.31658 8.31658 5.70711 8.70711L10 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </span>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php foreach ( $pages as $page ) : ?>
            <?php if ( $page === '...' ) : ?>
                <span class="w-11 h-11 flex items-center justify-center text-slate-300 select-none" aria-hidden="true">
                    <svg class="w-4 h-3" viewBox="0 0 20 8" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="4" r="1.5"/>
                        <circle cx="10" cy="4" r="1.5"/>
                        <circle cx="18" cy="4" r="1.5"/>
                    </svg>
                </span>

            <?php elseif ( (int) $page === $current_page ) : ?>
                <span class="w-11 h-11 flex items-center justify-center bg-slate-900 text-white text-sm font-bold border border-slate-900 select-none"
                      aria-current="page">
                    <?php echo (int) $page; ?>
                </span>

            <?php else : ?>
                <a href="<?php echo pagination_url( $base_url, (int) $page ); ?>"
                   class="pagination-ajax-link w-11 h-11 flex items-center justify-center border border-slate-200 bg-white text-slate-500 text-sm font-bold hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-200"
                   data-page="<?php echo (int) $page; ?>"
                   aria-label="<?php echo esc_attr( sprintf( t('pages.properties.pagination.go_to') ?? 'Go to page %s', $page ) ); ?>">
                    <?php echo (int) $page; ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Next Button -->
        <?php if ( $has_next ) : ?>
            <a href="<?php echo pagination_url( $base_url, $next_page ); ?>"
               class="pagination-ajax-link group w-11 h-11 flex items-center justify-center border border-slate-200 bg-white text-slate-400 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-200"
               data-page="<?php echo $next_page; ?>"
               aria-label="<?php echo esc_attr( t('pages.properties.pagination.next') ?? 'Next page' ); ?>">
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 3L10.2929 7.29289C10.6834 7.68342 10.6834 8.31658 10.2929 8.70711L6 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </a>
        <?php else : ?>
            <span class="w-11 h-11 flex items-center justify-center border border-slate-100 bg-slate-50 text-slate-300 cursor-not-allowed" aria-disabled="true">
                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 3L10.2929 7.29289C10.6834 7.68342 10.2929 8.70711L6 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </span>
        <?php endif; ?>

    </div>



</nav>