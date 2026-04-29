<?php $philosophy = t('pages.about.philosophy'); ?>
<section class="py-24 bg-[#FCFCFC] overflow-hidden js-philosophy-section">
    <div class="container mx-auto px-6">

        <!-- Header -->
        <div class="max-w-4xl mb-16 lg:mb-24 js-philosophy-header js-reveal-stagger">
            <div class="inline-flex items-center justify-center gap-2.5 px-4 py-2 border border-black/20 mb-8 js-reveal-fade">
                <span class="w-1.5 h-1.5 rounded-full bg-black"></span>
                <span class="text-primary font-bold uppercase tracking-[0.3em] text-[10px]"><?php echo esc_html($philosophy['badge']); ?></span>
            </div>
            <h2 class="text-4xl md:text-5xl font-extrabold text-secondary tracking-tight leading-[1.1] mb-8 js-reveal-text">
                <?php echo $philosophy['title']; ?>
            </h2>
            <p class="text-secondary text-lg leading-relaxed max-w-2xl js-reveal-fade">
                <?php echo esc_html($philosophy['subtitle'] ?? ''); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 js-philosophy-cards js-reveal-stagger">

            <?php
            $icons = [
                "M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z", // Search
                "M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z", // Chart Bar
                "M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z", // Shield Check
                "M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4", // Clipboard
                "M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z", // Globe
                "M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" // Key
            ];
            foreach ($philosophy['values'] as $idx => $val):
            ?>
                <div class="js-value-card group relative p-10 bg-white shadow border border-gray-100 transition-[box-shadow,transform] duration-500 hover:-translate-y-2 hover:shadow-2xl overflow-hidden js-reveal-fade">
                    <div class="absolute top-0 left-0 w-0 h-[3px] bg-black group-hover:w-full transition-all duration-700"></div>

                    <div class="relative z-10">
                        <span class="text-5xl font-serif text-gray-200 group-hover:text-black/20 transition-colors duration-500 font-bold"><?php echo esc_html($val['id']); ?></span>

                        <div class="mt-6 mb-4 text-black">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="<?php echo $icons[$idx]; ?>"></path>
                            </svg>
                        </div>

                        <h2 class="text-3xl md:text-4xl font-extrabold text-secondary mb-6"><?php echo esc_html($val['title']); ?></h2>
                        <p class="text-black mb-0 opacity-80 leading-relaxed">
                            <?php echo esc_html($val['description']); ?>
                        </p>
                    </div>

                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
