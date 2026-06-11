<?php
/**
 * Template Name: Privacy Policy
 */

get_header();

$banner_title    = t('pages.privacy_policy.hero.title');
$banner_bg_text  = t('pages.privacy_policy.hero.bg_text');
$banner_subtitle = t('pages.privacy_policy.hero.subtitle');

$shared_banner_path = get_template_directory() . '/shared/dynamic-banner.php';

if ( file_exists( $shared_banner_path ) ) {
    include $shared_banner_path;
}

// Retrieve translated page data from the active locale JSON file
$lang_data = t('pages.privacy_policy.page');

// Fallback to English if translation is missing or not an array
if ( ! is_array( $lang_data ) ) {
    $fallback_path = get_template_directory() . '/languages/en.json';
    if ( file_exists( $fallback_path ) ) {
        $en_json = json_decode( file_get_contents( $fallback_path ), true );
        $lang_data = $en_json['pages']['privacy_policy']['page'] ?? [];
    } else {
        $lang_data = [];
    }
}
?>

<section class="py-24 bg-slate-50 min-h-screen font-sans">
    <div class="container mx-auto px-4">
        
        <!-- Tab Navigation -->
        <div class="flex justify-center mb-12">
            <div class="bg-white p-1 sm:p-1.5 rounded-full shadow-sm border border-slate-100 flex flex-wrap gap-1 sm:gap-2 justify-center max-w-full">
                <button onclick="switchTab('privacy-policy')" id="tab-btn-privacy-policy" 
                    class="tab-btn px-4 sm:px-6 py-2.5 sm:py-3 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider transition-all duration-300 bg-slate-900 text-white shadow-md">
                    <?php echo esc_html( $lang_data['privacy_policy'] ); ?>
                </button>
                <button onclick="switchTab('legal-notice')" id="tab-btn-legal-notice" 
                    class="tab-btn px-4 sm:px-6 py-2.5 sm:py-3 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider transition-all duration-300 text-slate-600 hover:text-slate-900">
                    <?php echo esc_html( $lang_data['legal_notice'] ); ?>
                </button>
            </div>
        </div>

        <!-- Privacy Policy Tab -->
        <div id="tab-content-privacy-policy" class="tab-content space-y-10">
            <!-- Header Card -->
            <div class="bg-white p-6 md:p-12 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[4px] bg-primary"></div>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-3xl font-serif font-bold text-slate-900"><?php echo esc_html( $lang_data['privacy_policy'] ); ?></h2>
                        <p class="text-slate-500 text-sm mt-1"><?php echo esc_html( $lang_data['brand_name'] ); ?></p>
                    </div>
                    <span class="inline-block bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-xl">
                        <?php echo esc_html( $lang_data['last_updated'] ); ?>
                    </span>
                </div>
                <p class="text-slate-600 text-base leading-relaxed mt-6">
                    <?php echo esc_html( $lang_data['intro'] ); ?>
                </p>
            </div>

            <!-- Grid: Section 1 & 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- 1. Data Controller (6 cols) -->
                <div class="lg:col-span-6 bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec1_title'] ); ?></h3>
                        <p class="text-slate-500 text-sm mb-6 leading-relaxed"><?php echo esc_html( $lang_data['sec1_desc'] ); ?></p>
                    </div>
                    <div class="space-y-4 border-t border-slate-50 pt-4 text-xs sm:text-sm">
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['trade_name'] ); ?></span><span class="font-semibold text-slate-800"><?php echo esc_html( $lang_data['brand_name'] ); ?></span></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['nif'] ); ?></span><span class="font-semibold text-slate-800">5525579C</span></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['email'] ); ?></span><a href="mailto:info@capitalunioninvestment.com" class="font-semibold text-primary hover:underline break-all">info@capitalunioninvestment.com</a></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['phone'] ); ?></span><a href="tel:+34639315861" class="font-semibold text-slate-800 hover:text-primary transition-colors">+34 639 315 861</a></div>
                        <div class="flex flex-col gap-1"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['address'] ); ?></span><span class="font-medium text-slate-700 leading-relaxed"><?php echo esc_html( $lang_data['address_val'] ); ?></span></div>
                    </div>
                </div>

                <!-- 2. Purpose of Data Processing (6 cols) -->
                <div class="lg:col-span-6 bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec2_title'] ); ?></h3>
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed"><?php echo esc_html( $lang_data['sec2_desc'] ); ?></p>
                    <ul class="space-y-3.5 text-sm text-slate-700">
                        <?php foreach ($lang_data['sec2_items'] as $item) : ?>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span><?php echo esc_html( $item ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Grid: Section 3 & 4 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- 3. Legal Basis -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec3_title'] ); ?></h3>
                    <ul class="space-y-3.5 text-sm text-slate-700 leading-relaxed">
                        <?php foreach ($lang_data['sec3_items'] as $item) : ?>
                            <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span><span><?php echo esc_html( $item ); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- 4. Data Retention -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec4_title'] ); ?></h3>
                    <p class="text-slate-600 text-sm leading-loose">
                        <?php echo esc_html( $lang_data['sec4_desc'] ); ?>
                    </p>
                </div>
            </div>

            <!-- 5. Recipients of Data (Full Width) -->
            <div class="bg-white p-6 md:p-10 rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec5_title'] ); ?></h3>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    <?php echo esc_html( $lang_data['sec5_desc'] ); ?>
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <?php 
                    $providers = ['Hostinger (Hosting)', 'Google Analytics', 'Google Tag Manager', 'Meta Platforms', 'LinkedIn', 'TikTok', 'Witei CRM', 'WhatsApp Business'];
                    foreach ($providers as $provider) : ?>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center font-bold text-xs text-slate-800 hover:bg-slate-900 hover:text-white transition-all duration-300">
                            <?php echo $provider; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 6. User Rights & Action Card -->
            <div class="bg-white p-6 md:p-10 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec6_title'] ); ?></h3>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    <?php echo esc_html( $lang_data['sec6_desc'] ); ?>
                </p>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8 text-center text-xs font-semibold text-slate-600">
                    <?php foreach ($lang_data['sec6_rights'] as $right) : ?>
                        <div class="bg-slate-50 py-3.5 rounded-xl"><?php echo esc_html( $right ); ?></div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-slate-900 text-white p-6 md:p-8 rounded-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h4 class="font-bold text-base"><?php echo esc_html( $lang_data['sec6_box_title'] ); ?></h4>
                        <p class="text-slate-400 text-xs mt-1"><?php echo esc_html( $lang_data['sec6_box_desc'] ); ?></p>
                    </div>
                    <a href="mailto:info@capitalunioninvestment.com" class="w-full md:w-auto px-6 py-3 bg-primary text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-white hover:text-slate-900 transition-colors text-center break-all">
                        info@capitalunioninvestment.com
                    </a>
                </div>
            </div>

            <!-- Grid: Section 7 & 8 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- 7. Security -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec7_title'] ); ?></h3>
                    <p class="text-slate-600 text-sm leading-loose">
                        <?php echo esc_html( $lang_data['sec7_desc'] ); ?>
                    </p>
                </div>

                <!-- 8. Complaints -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['sec8_title'] ); ?></h3>
                    <p class="text-slate-600 text-sm leading-loose">
                        <?php echo esc_html( $lang_data['sec8_desc'] ); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Legal Notice Tab -->
        <div id="tab-content-legal-notice" class="tab-content hidden space-y-10">
            <!-- Header Card -->
            <div class="bg-white p-6 md:p-12 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-[4px] bg-primary"></div>
                <h2 class="text-3xl font-serif font-bold text-slate-900"><?php echo esc_html( $lang_data['legal_notice'] ); ?></h2>
                <p class="text-slate-500 text-sm mt-1"><?php echo esc_html( $lang_data['brand_name'] ); ?></p>
                <p class="text-slate-600 text-base leading-relaxed mt-6">
                    <?php echo esc_html( $lang_data['ln_intro'] ); ?>
                </p>
            </div>

            <!-- Website Owner Identification -->
            <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-6"><?php echo esc_html( $lang_data['ln_owner_title'] ); ?></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs sm:text-sm">
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['trade_name'] ); ?></span><span class="font-semibold text-slate-800"><?php echo esc_html( $lang_data['brand_name'] ); ?></span></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['nif'] ); ?></span><span class="font-semibold text-slate-800">5525579C</span></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['email'] ); ?></span><a href="mailto:info@capitalunioninvestment.com" class="font-semibold text-primary hover:underline break-all">info@capitalunioninvestment.com</a></div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium">Website</span><span class="font-semibold text-slate-800">www.capitalunioninvestment.com</span></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['phone'] ); ?></span><a href="tel:+34639315861" class="font-semibold text-slate-800 hover:text-primary transition-colors">+34 639 315 861</a></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-2"><span class="text-slate-400 font-medium"><?php echo esc_html( $lang_data['address'] ); ?></span><span class="font-semibold text-slate-800"><?php echo esc_html( $lang_data['address_val'] ); ?></span></div>
                    </div>
                </div>
            </div>

            <!-- Intellectual Property & Disclaimer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Intellectual Property -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['ln_ip_title'] ); ?></h3>
                        <p class="text-slate-600 text-sm leading-loose">
                            <?php echo esc_html( $lang_data['ln_ip_desc'] ); ?>
                        </p>
                    </div>
                </div>

                <!-- Liability Disclaimer -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4"><?php echo esc_html( $lang_data['ln_liability_title'] ); ?></h3>
                    <p class="text-slate-500 text-sm mb-4 leading-relaxed"><?php echo esc_html( $lang_data['ln_liability_desc'] ); ?></p>
                    <ul class="space-y-3.5 text-sm text-slate-700 leading-relaxed">
                        <?php foreach ($lang_data['ln_liability_items'] as $item) : ?>
                            <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span><span><?php echo esc_html( $item ); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
function switchTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(function(el) {
        el.classList.add('hidden');
    });
    // Show selected tab content
    document.getElementById('tab-content-' + tabId).classList.remove('hidden');

    // Reset all tab buttons
    document.querySelectorAll('.tab-btn').forEach(function(el) {
        el.classList.remove('bg-slate-900', 'text-white', 'shadow-md');
        el.classList.add('text-slate-600', 'hover:text-slate-900');
    });
    // Active styling for clicked button
    var activeBtn = document.getElementById('tab-btn-' + tabId);
    activeBtn.classList.remove('text-slate-600', 'hover:text-slate-900');
    activeBtn.classList.add('bg-slate-900', 'text-white', 'shadow-md');
}
</script>

<?php get_footer(); ?>
