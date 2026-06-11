<?php
/**
 * Template Name: Cookie Policy
 */

get_header();

$banner_title    = t('pages.cookie_policy.hero.title');
$banner_bg_text  = t('pages.cookie_policy.hero.bg_text');
$banner_subtitle = t('pages.cookie_policy.hero.subtitle');

$shared_banner_path = get_template_directory() . '/shared/dynamic-banner.php';

if ( file_exists( $shared_banner_path ) ) {
    include $shared_banner_path;
}

// Retrieve translated page data from the active locale JSON file
$lang_data = t('pages.cookie_policy.page');

// Fallback to English if translation is missing or not an array
if ( ! is_array( $lang_data ) ) {
    $fallback_path = get_template_directory() . '/languages/en.json';
    if ( file_exists( $fallback_path ) ) {
        $en_json = json_decode( file_get_contents( $fallback_path ), true );
        $lang_data = $en_json['pages']['cookie_policy']['page'] ?? [];
    } else {
        $lang_data = [];
    }
}
?>

<section class="py-24 bg-slate-50 min-h-screen font-sans">
    <div class="container mx-auto px-4">
        
        <!-- Cookies Used Section -->
        <div class="space-y-8 mb-16">
            <div class="bg-white p-6 md:p-12 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[4px] bg-primary"></div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-serif font-bold text-slate-900"><?php echo esc_html( $lang_data['cookies_used_title'] ?? 'Cookies Used' ); ?></h2>
                        <p class="text-slate-500 text-sm mt-1"><?php echo esc_html( t('brand.name') ); ?></p>
                    </div>
                </div>
            </div>

            <!-- Grid: Technical, Analytical, Advertising -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Technical Cookies -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="inline-block bg-indigo-50 text-indigo-700 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4">
                            <?php echo esc_html( $lang_data['tech_title'] ?? 'Technical' ); ?>
                        </span>
                        <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['tech_title'] ?? 'Technical Cookies' ); ?></h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            <?php echo esc_html( $lang_data['tech_desc'] ?? '' ); ?>
                        </p>
                    </div>
                </div>

                <!-- Analytical Cookies -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"></path></svg>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-block bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full">
                                <?php echo esc_html( $lang_data['anal_title'] ?? 'Analytical' ); ?>
                            </span>
                            <span class="text-xs text-slate-400 font-medium">
                                <?php echo esc_html( $lang_data['anal_service'] ?? '' ); ?>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['anal_title'] ?? 'Analytical Cookies' ); ?></h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            <?php echo esc_html( $lang_data['anal_desc'] ?? '' ); ?>
                        </p>
                    </div>
                </div>

                <!-- Advertising Cookies -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-block bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full">
                                <?php echo esc_html( $lang_data['adv_title'] ?? 'Advertising' ); ?>
                            </span>
                            <span class="text-xs text-slate-400 font-medium">
                                <?php echo esc_html( $lang_data['adv_service'] ?? '' ); ?>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['adv_title'] ?? 'Advertising Cookies' ); ?></h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            <?php echo esc_html( $lang_data['adv_desc'] ?? '' ); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cookie Management Section -->
        <div class="bg-white p-6 md:p-12 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mb-6"><?php echo esc_html( $lang_data['manage_title'] ?? 'Cookie Management' ); ?></h3>
            
            <div class="space-y-6 max-w-3xl text-slate-600 text-sm leading-relaxed">
                <div class="flex gap-4 items-start">
                    <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 shrink-0 mt-0.5">1</span>
                    <p><?php echo esc_html( $lang_data['manage_desc1'] ?? '' ); ?></p>
                </div>
                <div class="flex gap-4 items-start">
                    <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 shrink-0 mt-0.5">2</span>
                    <p><?php echo esc_html( $lang_data['manage_desc2'] ?? '' ); ?></p>
                </div>
                <?php if ( !empty($lang_data['manage_desc3']) ) : ?>
                    <div class="bg-primary/5 border border-primary/10 p-5 rounded-2xl text-slate-700 font-medium mt-4">
                        <?php echo esc_html( $lang_data['manage_desc3'] ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer Action Link -->
            <?php if ( !empty($lang_data['privacy_link_text']) ) : ?>
                <div class="mt-10 pt-8 border-t border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <span class="text-xs text-slate-400 font-medium">
                        <?php echo esc_html( $lang_data['privacy_link_text'] ); ?>
                    </span>
                    <a href="<?php echo esc_url( \Estatery\Core\Translator::getInstance()->resolve_nav_url('/privacy-policy') ); ?>" class="w-full sm:w-auto px-6 py-3 bg-slate-900 hover:bg-primary text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-colors text-center break-all">
                        <?php echo esc_html( t('footer.links.privacy') ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php get_footer(); ?>
