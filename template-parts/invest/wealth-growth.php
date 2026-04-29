<?php $growth = t('pages.invest.growth'); ?>

<section class="py-20 bg-[#F8FAFC] js-wealth-section">
    <div class="container mx-auto px-5">
        <div class="text-center mb-16 js-wealth-header js-reveal-stagger">
            <h2 class="text-3xl md:text-5xl font-bold text-secondary mb-4 js-reveal-text"><?php echo esc_html($growth['title']); ?></h2>
            <p class="text-secondary max-w-2xl mx-auto js-reveal-fade"><?php echo esc_html($growth['subtitle']); ?></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 js-growth-cards js-reveal-stagger">
            <?php foreach ($growth['items'] as $item) : ?>
                <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-primary transition-all duration-500 js-wealth-card js-reveal-fade">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500">
                        <svg class="w-8 h-8 text-primary group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-secondary mb-3 group-hover:text-white"><?php echo esc_html($item['title']); ?></h3>
                    <p class="text-secondary group-hover:text-blue-100 leading-relaxed"><?php echo esc_html($item['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-16 p-8 bg-secondary rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6 js-wealth-cta">
            <div class="text-white">
                <h4 class="text-2xl font-bold"><?php echo esc_html($growth['cta']['title']); ?></h4>
                <p class="text-gray-400"><?php echo esc_html($growth['cta']['subtitle']); ?></p>
            </div>
            <a href="#"
                class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 transition-colors">
                <?php echo esc_html($growth['cta']['button']); ?>
            </a>
        </div>
    </div>
</section>
