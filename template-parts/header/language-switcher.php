<?php
/**
 * Premium Language Switcher
 * Features a Globe Icon + Language Code design.
 */

if ( ! function_exists( 'PLL' ) ) {
    return;
}

$pll_model = PLL()->model;
$all_languages = $pll_model->get_languages_list();

if ( empty( $all_languages ) ) {
    return;
}

$languages = array();
$current_lang_slug = pll_current_language('slug');
$queried_object_id = get_queried_object_id();
$queried_post_type = get_post_type($queried_object_id);

foreach ( $all_languages as $lang_obj ) {
    $slug = $lang_obj->slug;
    $link = pll_home_url( $slug );
    
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

$current_lang = isset($languages[$current_lang_slug]) ? $languages[$current_lang_slug] : reset($languages);
?>

<div class="next-lang-switcher relative z-[100]" id="language-routing-wrapper">
    <!-- Trigger Button -->
    <button type="button" 
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl border-2 border-gray-100 hover:border-primary hover:bg-primary/5 transition-all duration-300 group"
            id="lang-select-trigger"
            aria-haspopup="true" 
            aria-expanded="false">
        
        <!-- Premium Globe Icon -->
        <svg class="w-4.5 h-4.5 text-gray-400 group-hover:text-primary transition-colors duration-300" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9-9H3m9 9V3m0 18a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
        </svg>

        <span class="text-[11px] font-black uppercase tracking-widest text-foreground group-hover:text-primary transition-colors duration-300">
            <?php echo esc_html( $current_lang['slug'] ); ?>
        </span>

        <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-primary transition-transform duration-500" 
             id="lang-select-chevron"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Options Menu -->
    <div class="lang-options-menu absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-2xl shadow-2xl flex flex-col overflow-hidden opacity-0 invisible translate-y-6 pointer-events-none transition-all duration-500 ease-[cubic-bezier(0.19,1,0.22,1)]"
         id="lang-options-list">
        <ul class="py-2">
            <?php foreach ( $languages as $lang ) : ?>
                <li>
                    <button data-url="<?php echo esc_url( $lang['url'] ); ?>" 
                            data-slug="<?php echo esc_attr( $lang['slug'] ); ?>"
                            class="lang-option-btn w-full flex items-center justify-between px-5 py-3.5 text-xs font-bold transition-all duration-300 <?php echo $lang['current_lang'] ? 'text-primary bg-primary/5 active-lang' : 'text-gray-500 hover:bg-gray-50 hover:text-foreground'; ?>">
                        <div class="flex items-center gap-3">
                            <span class="uppercase tracking-widest text-[10px] bg-gray-100 px-1.5 py-0.5 rounded text-gray-400 group-hover:text-primary transition-colors"><?php echo esc_html( $lang['slug'] ); ?></span>
                            <span class="tracking-tight"><?php echo esc_html( $lang['name'] ); ?></span>
                        </div>
                        <?php if ( $lang['current_lang'] ) : ?>
                            <div class="w-1.5 h-1.5 rounded-full bg-primary shadow-sm shadow-primary/50"></div>
                        <?php endif; ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
