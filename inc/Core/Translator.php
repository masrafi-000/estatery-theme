<?php
namespace Estatery\Core;

/**
 * Translator Controller
 * Handles JSON-based i18n dictionary loading and retrieval.
 */
class Translator {
    private static $instance = null;
    private $data = [];
    private $lang = 'en';

    public function __construct() {
        $this->init();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function init() {
        // Detect language via Polylang
        if ( function_exists('pll_current_language') ) {
            $this->lang = pll_current_language();
        }

        $this->loadLocale($this->lang);
    }

    private function loadLocale($lang) {
        $path = get_template_directory() . '/languages/' . $lang . '.json';
        
        if ( file_exists($path) ) {
            $json = file_get_contents($path);
            $this->data = json_decode($json, true);
        } else {
            // Fallback to English
            $fallback_path = get_template_directory() . '/languages/en.json';
            if ( file_exists($fallback_path) ) {
                $json = file_get_contents($fallback_path);
                $this->data = json_decode($json, true);
            }
        }
    }

    /**
     * Translate function (t method)
     * Supports dot notation: home.hero.title
     */
    public function t($key) {
        $keys = explode('.', $key);
        $temp = $this->data;

        foreach ($keys as $k) {
            if (isset($temp[$k])) {
                $temp = $temp[$k];
            } else {
                return $key; // Return key name if not found
            }
        }

        return is_string($temp) ? $temp : $key;
    }
}
