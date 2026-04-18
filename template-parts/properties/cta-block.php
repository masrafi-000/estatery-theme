<?php
/**
 * Component: Properties Call to Action
 */
?>
<section class=" w-full my-8">
    <div class=" mx-auto ">
        <div class="relative bg-slate-900 overflow-hidden shadow-2xl">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000"
                     class="w-full h-full object-cover opacity-20 grayscale"
                     alt="City skyline">
            </div>

            <!-- Gradient Overlays -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary/30 via-slate-900/40 to-slate-900/90"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>

            <!-- Decorative Grid Lines -->
            <div class="absolute inset-0 opacity-[0.04]"
                 style="background-image: linear-gradient(rgba(255,255,255,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,1) 1px, transparent 1px); background-size: 60px 60px;">
            </div>

            <!-- Top accent line -->
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-primary to-transparent"></div>


            <!-- Content -->
            <div class="relative z-10 py-28 px-6 md:px-16 lg:px-24">
                <div class="max-w-5xl mx-auto">

                    <!-- Two-column layout: text left, actions right -->
                    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-14">

                        <!-- Left: Text Block -->
                        <div class="flex-1" data-aos="fade-right">

                            <!-- Eyebrow -->
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-8 h-[2px] bg-primary"></div>
                                <span class="text-white text-[10px] font-black uppercase tracking-[0.4em]">
                                    <?php echo esc_html( t('pages.properties.cta.eyebrow') ?? 'Opportunity Awaits' ); ?>
                                </span>
                            </div>

                            <!-- Headline -->
                            <h2 class="text-5xl md:text-6xl lg:text-7xl font-black text-white leading-[0.92] tracking-tight uppercase mb-8">
                                <?php
                                    $title = t('pages.properties.cta.title') ?? 'Find Your Dream Property';
                                    $words = explode(' ', esc_html($title));
                                    $half  = ceil(count($words) / 2);
                                    echo implode(' ', array_slice($words, 0, $half));
                                ?>
                                <span class="block text-white">
                                    <?php echo implode(' ', array_slice($words, $half)); ?>
                                </span>
                            </h2>

                            <!-- Subtitle -->
                            <p class="text-white/80 text-base md:text-lg font-medium leading-relaxed max-w-xl">
                                <?php echo esc_html( t('pages.properties.cta.subtitle') ?? 'Browse thousands of curated listings and connect with trusted agents to make your next move.' ); ?>
                            </p>
                        </div>

                        <!-- Right: Stats + CTA -->
                        <div class="flex flex-col gap-10 lg:items-end lg:min-w-[300px]" data-aos="fade-left">

                            <!-- Stats Row -->
                            <div class="grid grid-cols-3 lg:grid-cols-1 gap-4 w-full lg:w-auto">
                                <?php
                                $stats = [
                                    [ 'value' => '12K+', 'label' => t('pages.properties.cta.stat_listings')  ?? 'Active Listings'  ],
                                    [ 'value' => '98%',  'label' => t('pages.properties.cta.stat_clients')   ?? 'Happy Clients'    ],
                                    [ 'value' => '15Y',  'label' => t('pages.properties.cta.stat_experience')?? 'Years Experience'  ],
                                ];
                                foreach ( $stats as $stat ) : ?>
                                    <div class="border border-white/10 bg-white/5 px-5 py-4 lg:flex lg:items-center lg:justify-between lg:gap-8 backdrop-blur-sm">
                                        <span class="block text-2xl lg:text-3xl font-black text-white tracking-tight">
                                            <?php echo esc_html($stat['value']); ?>
                                        </span>
                                        <span class="block text-[10px] font-bold text-white/90 uppercase tracking-[0.15em] mt-1 lg:mt-0 lg:text-right">
                                            <?php echo esc_html($stat['label']); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 w-full">
                                <a href="<?php echo esc_url( home_url('/properties') ); ?>"
                                   class="group relative inline-flex items-center justify-between gap-4 px-8 py-5 bg-primary text-white text-[10px] font-black uppercase tracking-[0.25em] overflow-hidden transition-all duration-300 hover:bg-white hover:text-slate-900 active:scale-[0.97] shadow-lg shadow-primary/30">
                                    <span class="relative z-10">
                                        <?php echo esc_html( t('pages.properties.cta.button_primary') ?? 'Browse Listings' ); ?>
                                    </span>
                                    <svg class="relative z-10 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>

                                <a href="<?php echo esc_url( home_url('/contact') ); ?>"
                                   class="group inline-flex items-center justify-between gap-4 px-8 py-5 bg-transparent border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.25em] hover:border-white/50 hover:bg-white/5 active:scale-[0.97] transition-all duration-300">
                                    <span>
                                        <?php echo esc_html( t('pages.properties.cta.button_secondary') ?? 'Talk to an Agent' ); ?>
                                    </span>
                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8m0 0l-4-4m4 4l-4 4"/>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>

                    <!-- Bottom Trust Strip -->
                    <div class="mt-20 pt-8 border-t border-white/10 flex flex-wrap items-center gap-x-10 gap-y-4" data-aos="fade-up">
                        <?php
                        $badges = [
                            t('pages.properties.cta.badge_licensed')  ?? 'Licensed & Regulated',
                            t('pages.properties.cta.badge_secure')     ?? 'Secure Transactions',
                            t('pages.properties.cta.badge_support')    ?? '24/7 Client Support',
                            t('pages.properties.cta.badge_verified')   ?? 'Verified Listings Only',
                        ];
                        foreach ( $badges as $badge ) : ?>
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-[10px] font-bold text-white/70 uppercase tracking-[0.15em]">
                                    <?php echo esc_html($badge); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>