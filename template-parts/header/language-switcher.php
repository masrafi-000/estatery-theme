<?php
/**
 * Premium Language Switcher
 */

if ( ! function_exists( 'PLL' ) ) {
    return;
}

$pll_model     = PLL()->model;
$all_languages = $pll_model->get_languages_list();

if ( empty( $all_languages ) ) {
    return;
}

// ── Active language source of truth: our Translator instance ──────────────────
$current_lang_slug = \Estatery\Core\Translator::getInstance()->getLang();
// ─────────────────────────────────────────────────────────────────────────────

$languages = array();

foreach ( $all_languages as $lang_obj ) {
    $slug = $lang_obj->slug;

    // data-url = current page URL + ?set_lang=slug
    // PHP init hook catches this, sets PHP cookie, redirects to clean URL.
    // User stays on the SAME PAGE but with the new language applied.
    $switch_url = add_query_arg( 'set_lang', $slug );

    $languages[ $slug ] = array(
        'slug'         => $slug,
        'name'         => $lang_obj->name,
        'url'          => esc_url( $switch_url ),
        'current_lang' => ( $slug === $current_lang_slug ),
    );
}

$current_lang = isset( $languages[ $current_lang_slug ] )
    ? $languages[ $current_lang_slug ]
    : reset( $languages );
?>

<div class="next-lang-switcher relative z-[100]" id="language-routing-wrapper">

    <!-- Trigger Button -->
    <button type="button"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl border-2 border-gray-100 hover:border-primary hover:bg-primary/5 transition-all duration-300 group"
            id="lang-select-trigger"
            aria-haspopup="true"
            aria-expanded="false">

        <!-- Globe Icon -->
        <svg class="w-4.5 h-4.5 text-gray-400 group-hover:text-primary transition-colors duration-300"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9-9H3m9 9V3m0 18a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
        </svg>

        <!-- Active lang label — initialized from PHP (cookie), updated by JS state -->
        <span class="lang-label text-[11px] font-black uppercase tracking-widest text-foreground group-hover:text-primary transition-colors duration-300">
            <?php echo esc_html( $current_lang['slug'] ); ?>
        </span>

        <!-- Chevron -->
        <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-primary transition-transform duration-500"
             id="lang-select-chevron"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Options Dropdown -->
    <div class="lang-options-menu absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-2xl shadow-2xl flex flex-col overflow-hidden"
         id="lang-options-list"
         style="opacity:0; visibility:hidden; transform:translateY(12px); pointer-events:none; transition: opacity 0.3s ease, transform 0.3s cubic-bezier(0.34,1.56,0.64,1), visibility 0.3s;">
        <ul class="py-2">
            <?php foreach ( $languages as $lang ) : ?>
                <li>
                    <button data-url="<?php echo esc_url( $lang['url'] ); ?>"
                            data-slug="<?php echo esc_attr( $lang['slug'] ); ?>"
                            class="lang-option-btn w-full flex items-center justify-between px-5 py-3.5 text-xs font-bold transition-all duration-300 <?php echo $lang['current_lang'] ? 'text-primary bg-primary/5 active-lang' : 'text-gray-500 hover:bg-gray-50 hover:text-foreground'; ?>">
                        <div class="flex items-center gap-3">
                            <span class="uppercase tracking-widest text-[10px] bg-gray-100 px-1.5 py-0.5 rounded text-gray-400"><?php echo esc_html( $lang['slug'] ); ?></span>
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
