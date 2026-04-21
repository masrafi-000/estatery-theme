<?php
namespace Estatery\Core;

/**
 * Theme Setup & Bootstrapping
 *
 * HOW IT WORKS:
 *  - On theme activation / switch: immediately creates any missing pages (no gate).
 *  - On every 'init' (FTP upload safety net): guarded by a daily transient so it
 *    only actually checks the DB once per 24 hours, not on every request.
 *  - Per-slug existence check: if a page with that slug already exists in ANY
 *    status (publish, draft, trash, …) it is SKIPPED — no duplicates ever.
 *  - Works with OR without Polylang installed.
 */
class ThemeSetup {

    /** Transient key used to rate-limit the 'init' safety-net check. */
    const TRANSIENT_KEY = 'estatery_page_check_ran';

    public static function init() {
        // Primary trigger: fires after theme switch in WP Admin — no gate, always runs.
        add_action( 'after_switch_theme', [ __CLASS__, 'bootstrap' ], 10, 0 );

        // Safety net for FTP / manual uploads where after_switch_theme never fires.
        // Guarded by a daily transient to keep performance impact minimal.
        add_action( 'init', [ __CLASS__, 'maybe_bootstrap' ], 99 );

        // Always ensure pretty permalinks are active.
        add_action( 'init', [ __CLASS__, 'fix_permalinks' ], 1 );
    }

    /**
     * Throttled safety-net: runs at most once per day via transient.
     * On next day's first request it re-checks whether any page is missing.
     */
    public static function maybe_bootstrap() {
        // Skip on admin AJAX to avoid unnecessary overhead
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return;
        }

        // If the transient is still alive, we already checked recently — bail out.
        if ( get_transient( self::TRANSIENT_KEY ) ) {
            return;
        }

        // Record that we're checking now (24-hour cooldown).
        set_transient( self::TRANSIENT_KEY, true, DAY_IN_SECONDS );

        self::ensure_pages_exist();
        // Note: do NOT flush_rewrite_rules() here on every daily check — only on
        // actual theme switch. flush_rewrite_rules() is expensive.
    }

    /**
     * Full bootstrap: create pages + flush rewrite rules.
     * Called directly on after_switch_theme — always runs, no throttling.
     */
    public static function bootstrap() {
        // Clear the transient so ensure_pages_exist() runs immediately
        // even if maybe_bootstrap() had already set it.
        delete_transient( self::TRANSIENT_KEY );

        self::ensure_pages_exist();
        flush_rewrite_rules();
    }

    /**
     * Ensure "Post Name" permalinks are active for routing.
     */
    public static function fix_permalinks() {
        if ( get_option( 'permalink_structure' ) !== '/%postname%/' ) {
            update_option( 'permalink_structure', '/%postname%/' );
            flush_rewrite_rules();
        }
    }

    /**
     * Truly idempotent page creator.
     *
     * For EACH required page it checks whether a page with that slug already
     * exists (any post status, including trash). Only if it does NOT exist will
     * it create a new one. This guarantees:
     *
     *  ✓ No duplicates on theme update
     *  ✓ No duplicates on repeated activation
     *  ✓ Missing pages are always filled in (e.g. after a new page is added to the list)
     *  ✓ Works with or without Polylang
     */
    public static function ensure_pages_exist() {
        $pages_to_create = [
            'properties' => [
                'title'    => 'Properties',
                'template' => 'page-properties.php',
            ],
            'property-details' => [
                'title'    => 'Property Details',
                'template' => 'page-property-details.php',
            ],
            'about' => [
                'title'    => 'About',
                'template' => 'page-about.php',
            ],
            'contact' => [
                'title'    => 'Contact',
                'template' => 'page-contact.php',
            ],
            'invest' => [
                'title'    => 'Invest',
                'template' => 'page-invest.php',
            ],
            'privacy-policy' => [
                'title'    => 'Privacy Policy',
                'template' => 'page-privacy-policy.php',
            ],
            'terms-of-service' => [
                'title'    => 'Terms of Service',
                'template' => 'page-terms-of-service.php',
            ],
            'cookie-policy' => [
                'title'    => 'Cookie Policy',
                'template' => 'page-cookie-policy.php',
            ],
        ];

        $has_polylang  = function_exists( 'pll_languages_list' ) && function_exists( 'pll_set_post_language' );
        $languages     = $has_polylang ? pll_languages_list() : [ 'en' ];
        $created_pages = [];

        // ── 1. Per-page existence check & conditional creation ───────────────
        foreach ( $languages as $lang ) {
            foreach ( $pages_to_create as $slug => $data ) {

                // Build the query: find any page with this slug for this language.
                // We check ALL statuses (publish, draft, private, trash) so we
                // never create a duplicate of a trashed page either.
                $query = [
                    'post_type'      => 'page',
                    'name'           => $slug,
                    'post_status'    => [ 'publish', 'draft', 'private', 'pending', 'future', 'trash' ],
                    'posts_per_page' => 1,
                    'fields'         => 'ids',
                    'no_found_rows'  => true,
                ];

                if ( $has_polylang ) {
                    $query['lang'] = $lang;
                }

                $existing_ids = get_posts( $query );

                // ── Page already exists → record ID and move on (no creation) ──
                if ( ! empty( $existing_ids ) ) {
                    $created_pages[ $slug ][ $lang ] = (int) $existing_ids[0];
                    continue;
                }

                // ── Page does NOT exist → create it ───────────────────────────
                $title = ( $lang === 'en' )
                    ? $data['title']
                    : $data['title'] . ' (' . strtoupper( $lang ) . ')';

                $new_id = wp_insert_post( [
                    'post_title'  => $title,
                    'post_name'   => $slug,
                    'post_status' => 'publish',
                    'post_type'   => 'page',
                ] );

                if ( $new_id && ! is_wp_error( $new_id ) ) {
                    update_post_meta( $new_id, '_wp_page_template', $data['template'] );

                    if ( $has_polylang ) {
                        pll_set_post_language( $new_id, $lang );
                    }

                    $created_pages[ $slug ][ $lang ] = $new_id;
                }
            }
        }

        // ── 2. Link Polylang translation groups ──────────────────────────────
        if ( $has_polylang && function_exists( 'pll_save_post_translations' ) ) {
            foreach ( $created_pages as $translations ) {
                if ( count( $translations ) > 1 ) {
                    pll_save_post_translations( $translations );
                }
            }
        }

        // ── 3. Ensure a front-page (Home) is set ─────────────────────────────
        $front_page_id = (int) get_option( 'page_on_front' );
        if ( ! $front_page_id ) {
            $existing_home = get_posts( [
                'post_type'      => 'page',
                'name'           => 'home',
                'post_status'    => 'any',
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ] );

            if ( ! empty( $existing_home ) ) {
                $home_id = (int) $existing_home[0];
            } else {
                $home_id = wp_insert_post( [
                    'post_title'  => 'Home',
                    'post_name'   => 'home',
                    'post_status' => 'publish',
                    'post_type'   => 'page',
                ] );
            }

            if ( $home_id && ! is_wp_error( $home_id ) ) {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $home_id );
            }
        }
    }
}
