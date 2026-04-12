<?php
/**
 * Nuclear Language Switcher Component
 * Bypasses all standard Polylang filters to show every configured language.
 */

if ( ! function_exists( 'PLL' ) ) {
    return;
}

// 1. Get ALL languages directly from the internal model
$pll_model = PLL()->model;
$all_languages = $pll_model->get_languages_list();

if ( empty( $all_languages ) ) {
    return;
}

$languages = array();
$current_lang_slug = pll_current_language('slug');

// 2. Look up queried object for specific translation links
$queried_object_id = get_queried_object_id();
$queried_post_type = get_post_type($queried_object_id);

foreach ( $all_languages as $lang_obj ) {
    $slug = $lang_obj->slug;
    
    // Default URL is the Home page of the language
    $link = pll_home_url( $slug );
    
    // Try to get the specific translation for the current post/page
    if ( $queried_object_id && $queried_post_type ) {
        $translated_id = pll_get_post( $queried_object_id, $slug );
        if ( $translated_id ) {
            $link = get_permalink( $translated_id );
        }
    }

    $languages[$slug] = array(
        'slug'         => $slug,
        'name'         => $lang_obj->name,
        'url'          => $link,
        'current_lang' => ( $slug === $current_lang_slug )
    );
}

// Identify current language for the toggle button
$current_lang = isset($languages[$current_lang_slug]) ? $languages[$current_lang_slug] : reset($languages);
?>

<div class="next-lang-switcher relative z-[1001]" id="language-routing-wrapper">
    <!-- Trigger Button -->
    <button type="button" 
            class="flex items-center gap-3 bg-white/80 backdrop-blur-md border border-gray-100 pl-4 pr-3 py-2 rounded-xl shadow-sm hover:border-primary/50 hover:shadow-lg transition-all duration-500 group"
            id="lang-select-trigger"
            aria-haspopup="true" 
            aria-expanded="false">
        <span class="text-[10px] font-black uppercase tracking-[0.25em] text-foreground/90 group-hover:text-primary transition-colors">
            <?php echo esc_html( $current_lang['slug'] ); ?>
        </span>
        <div class="w-[1px] h-3 bg-gray-200"></div>
        <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition-transform duration-500" 
             id="lang-select-chevron"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Options Menu -->
    <div class="lang-options-menu absolute right-0 mt-3 w-44 bg-white border border-gray-100 rounded-2xl shadow-2xl flex flex-col overflow-hidden opacity-0 invisible translate-y-6 pointer-events-none transition-all duration-500 ease-[cubic-bezier(0.19,1,0.22,1)]"
         id="lang-options-list">
        <ul class="py-1">
            <?php foreach ( $languages as $lang ) : ?>
                <li class="border-b border-gray-50 last:border-0">
                    <button data-url="<?php echo esc_url( $lang['url'] ); ?>" 
                            data-slug="<?php echo esc_attr( $lang['slug'] ); ?>"
                            class="lang-option-btn w-full flex items-center justify-between px-4 py-3.5 text-xs font-black transition-all duration-300 <?php echo $lang['current_lang'] ? 'text-primary bg-primary/5 active-lang' : 'text-gray-500 hover:bg-gray-50 hover:text-foreground'; ?>">
                        <span class="uppercase tracking-widest text-[11px]"><?php echo esc_html( $lang['name'] ); ?></span>
                        <?php if ( $lang['current_lang'] ) : ?>
                            <div class="w-1.5 h-1.5 rounded-full bg-primary shadow-sm shadow-primary/50"></div>
                        <?php endif; ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
