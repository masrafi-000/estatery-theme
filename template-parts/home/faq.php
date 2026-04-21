<section class="py-24 bg-white overflow-hidden" id="faq-section">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl font-extrabold text-secondary mb-6"><?php echo esc_html( t('home.faq.title') ); ?></h2>
            <p class="text-secondary"><?php echo esc_html( t('home.faq.description') ); ?></p>
        </div>

        <div class="flex flex-col lg:flex-row gap-12 items-start">
            <div class="lg:w-5/12 w-full">
                <div class="bg-gray-50 p-10 rounded-[2.5rem] border border-gray-100 sticky top-10">
                    <h3 class="text-3xl font-bold text-secondary mb-6"><?php echo esc_html( t('home.faq.help_title') ); ?></h3>
                    <p class="text-secondary mb-8"><?php echo esc_html( t('home.faq.help_description') ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"
                        class="bg-secondary text-white px-8 py-4 rounded-2xl font-bold inline-block hover:bg-blue-600 transition-all">
                        <?php echo esc_html( t('home.faq.contact_button') ); ?>
                    </a>
                </div>
            </div>

            <div class="lg:w-7/12 space-y-4 w-full relative" id="accordion-container">
                <?php
                $faq_items = t('home.faq.items');
                if (!empty($faq_items) && is_array($faq_items)) :
                    foreach ($faq_items as $item) : ?>
                <div class="faq-card bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button class="faq-toggle w-full flex items-center justify-between p-7 text-left outline-none">
                        <span class="text-lg font-bold text-secondary pr-4"><?php echo esc_html($item['question']); ?></span>
                        <span class="faq-icon text-blue-500 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer hidden px-7 pb-7 text-secondary leading-relaxed">
                        <div class="w-full h-px bg-gray-200 mb-5"></div>
                        <div class="prose max-w-none">
                            <?php echo wp_kses_post($item['answer']); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
/* Prevent layout collapse when items hide */
#accordion-container {
    min-height: 400px;
}

.faq-card.active {
    background-color: #fff !important;
    border-color: #3b82f6 !important;
    box-shadow: 0 20px 40px -12px rgba(59, 130, 246, 0.15);
    z-index: 20;
    position: relative;
}

.faq-card.active .faq-icon {
    transform: rotate(180deg);
}

.faq-card {
    will-change: transform, opacity;
    display: block;
    /* Ensure visibility */
}
</style>


