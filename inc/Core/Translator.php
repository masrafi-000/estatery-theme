<?php
namespace Estatery\Core;

/**
 * Translator — JSON-based i18n engine
 *
 * COOKIE STRATEGY:
 *   We use 'estatery_lang' (NOT 'pll_language') as our cookie name.
 *   Polylang owns 'pll_language' and resets it on every page to match
 *   the Polylang URL — using the same name caused our preference to be
 *   overwritten on every navigation. With 'estatery_lang', Polylang
 *   never touches our cookie and the user's choice persists forever.
 *
 * BOOT PRIORITY ORDER:
 *   0. $_GET['set_lang']         ← current switch request (renders immediately)
 *   1. $_COOKIE['estatery_lang'] ← persisted user preference (survives navigation)
 *   2. pll_current_language()   ← Polylang URL detection (first visit, no cookie)
 *   3. 'en'                     ← hard fallback
 */
class Translator {
    private static $instance = null;
    private $data   = [];
    private $lang   = 'en';
    private $loaded = false;

    private function __construct() {}

    public static function getInstance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function boot() {
        if ( $this->loaded ) return;
        $this->loaded = true;

        // ── Priority 0: Explicit switch request (?set_lang=fr) ───────────────
        if ( isset( $_GET['set_lang'] ) ) {
            $req_lang = sanitize_key( $_GET['set_lang'] );
            if ( $this->localeExists( $req_lang ) ) {
                $this->lang = $req_lang;
                $this->loadLocale( $req_lang );
                return;
            }
        }

        // ── Priority 1: User preference cookie — estatery_lang ───────────────
        if ( isset( $_COOKIE['estatery_lang'] ) ) {
            $cookie_lang = sanitize_key( $_COOKIE['estatery_lang'] );
            if ( $this->localeExists( $cookie_lang ) ) {
                $this->lang = $cookie_lang;
                $this->loadLocale( $cookie_lang );
                return;
            }
        }

        // ── Priority 2: Polylang (ONLY if URL slug or hard default needed) ────
        if ( function_exists( 'pll_current_language' ) ) {
            $detected = pll_current_language();
            
            // If the cookie is missing (First Visit), we want English as Primary.
            // We ONLY use the detected language if the URL actually starts with it.
            // This ignores "random" browser header detection for first-timers.
            $uri = $_SERVER['REQUEST_URI'] ?? '';
            $path = trim(parse_url($uri, PHP_URL_PATH), '/');
            $path_segments = explode('/', $path);
            $lang_in_url = $path_segments[0] ?? '';

            if ( $detected && $this->localeExists( $detected ) ) {
                // If it's English, or if it's in the URL, or if we have no choice
                if ( $detected === 'en' || ($lang_in_url === $detected) ) {
                    $this->lang = $detected;
                    $this->loadLocale( $detected );
                    return;
                }
            }
        }

        // ── Priority 3: Primary Language (English) Fallback ──────────────────
        $this->lang = 'en';
        $this->loadLocale( 'en' );
    }

    private function localeExists( $lang ) {
        if ( empty( $lang ) ) return false;
        return file_exists( get_template_directory() . '/languages/' . $lang . '.json' );
    }

    private function loadLocale( $lang ) {
        $path = get_template_directory() . '/languages/' . $lang . '.json';
        if ( file_exists( $path ) ) {
            $json       = file_get_contents( $path );
            $this->data = json_decode( $json, true ) ?: [];
        } else {
            $fallback = get_template_directory() . '/languages/en.json';
            if ( file_exists( $fallback ) ) {
                $this->data = json_decode( file_get_contents( $fallback ), true ) ?: [];
            }
        }
    }

    public function getLang() {
        $this->boot();
        return $this->lang;
    }

    public function t( $key ) {
        $this->boot();
        $keys = explode( '.', $key );
        $temp = $this->data;
        foreach ( $keys as $k ) {
            if ( isset( $temp[$k] ) ) {
                $temp = $temp[$k];
            } else {
                return $key;
            }
        }
        return ( is_string( $temp ) || is_array( $temp ) ) ? $temp : $key;
    }

    public function resolve_nav_url( $path ) {
        $this->boot();
        if ( $path === '/' ) {
            if ( function_exists('pll_home_url') ) {
                return pll_home_url( $this->lang );
            }
            return home_url( '/' );
        }
        
        $slug = ltrim( $path, '/' );
        $template_name = 'page-' . $slug . '.php';
        
        // 1. Direct template match scoped to current language (Most resilient)
        $pages = get_posts([
            'post_type'   => 'page',
            'meta_key'    => '_wp_page_template',
            'meta_value'  => $template_name,
            'lang'        => $this->lang,
            'numberposts' => 1
        ]);

        if ( !empty($pages) ) {
            return get_permalink( $pages[0]->ID );
        }
        
        // 2. Strict slug matching fallback
        $page = get_page_by_path( $slug );
        if (!$page) {
            $page = get_page_by_path( $slug . '-' . $this->lang );
        }

        if ( $page ) {
            if ( function_exists( 'pll_get_post' ) ) {
                $translated_id = pll_get_post( $page->ID, $this->lang );
                if ( $translated_id ) return get_permalink( $translated_id );
            }
            return get_permalink( $page->ID );
        }
        
        return home_url( $path );
    }

    /**
     * Helper to map raw JSON property data to a clean array
     */
    public static function map_property_data($prop, $lang = 'en') {
        $id = $prop['id'][0] ?? '';
        $title = $prop['title'][0] ?? (ucfirst($prop['type'][0] ?? 'Property') . ' ' . ($prop['town'][0] ?? ''));
        // Price formatting for display
        $price_raw = $prop['price'][0] ?? '0';
        // Handle cases where price might be an array within an array or contain ranges
        $price_str = is_array($price_raw) ? ($price_raw[0] ?? '0') : $price_raw;
        $price_clean = preg_replace('/[^0-9]/', '', (string)$price_str);
        
        $currency = $prop['currency'][0] ?? 'EUR';
        $currency_symbol = $currency === 'EUR' ? '€' : ($currency === 'USD' ? '$' : $currency);
        $price = number_format((float)$price_clean, 0, '.', ',') . ' ' . $currency_symbol;
        if (($prop['price_freq'][0] ?? '') === 'rent') $price .= ' /mo';

        $sqft_raw = $prop['surface_area'][0]['built'][0] ?? '0';
        $sqft_str = is_array($sqft_raw) ? ($sqft_raw[0] ?? '0') : $sqft_raw;
        $sqft_clean = preg_replace('/[^0-9]/', '', (string)$sqft_str);
        $sqft = $sqft_clean ? $sqft_clean . ' m²' : '';
        $beds = $prop['beds'][0] ?? '0';
        $baths = $prop['baths'][0] ?? '0';
        
        $type = (strtolower($prop['price_freq'][0] ?? '') === 'sale') ? 'buy' : 'rent';
        
        $image = '';
        if (isset($prop['images'][0]['image'][0]['url'][0])) {
            $image = $prop['images'][0]['image'][0]['url'][0];
        }
        
        return [
            'id' => $id,
            'title' => $title,
            'category' => $prop['type'][0] ?? '',
            'price' => $price,
            'raw_price' => (float)$price_clean,
            'location' => ($prop['town'][0] ?? '') . ', ' . ($prop['province'][0] ?? '') . ', ' . ($prop['country'][0] ?? ''),
            'location_detail' => $prop['location_detail'][0] ?? '',
            'description' => $prop['desc'][0][$lang][0] ?? '',
            'type' => $type,
            'beds' => $beds,
            'baths' => $baths,
            'sqft' => $sqft,
            'raw_sqft' => (float)$sqft_clean,
            'pool' => (int)($prop['pool'][0] ?? 0),
            'image' => $image,
            'new_build' => ($prop['new_build'][0] ?? '0') === '1',
            'resale' => (($prop['resale'][0] ?? '0') === '1') || (($prop['new_build'][0] ?? '0') === '0'),
            'unix_date' => strtotime($prop['date'][0] ?? 'now')
        ];
    }
}
