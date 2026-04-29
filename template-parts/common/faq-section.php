<?php
/**
 * Dynamic Tabbed FAQ Section Template Part
 *
 */

$perspective = $args['perspective'] ?? 'home';

// All FAQ tabs data keyed by group
$all_faq_groups = t('common_faq_tabs');

if (empty($all_faq_groups) || !is_array($all_faq_groups)) return;

$active_index = 0;
?>

<section class="js-faq-section py-24 bg-white border-b border-secondary/5 overflow-hidden">
    <div class="container mx-auto px-6 lg:px-12">

        <!-- Header -->
        <div class="js-faq-header mb-16 lg:mb-20">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 border border-secondary/20 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                <span class="text-secondary font-semibold uppercase tracking-[0.2em] text-[10px]"><?php echo esc_html( t('home.faq.eyebrow') ?: 'FAQ' ); ?></span>
            </div>
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                <h2 class="text-4xl md:text-5xl lg:text-[3.25rem] font-extrabold text-secondary tracking-tight leading-[1.05]">
                    <?php echo t('home.faq.frequently_asked') ?: 'Frequently Asked<br>Questions'; ?>
                </h2>
                <div class="flex flex-col lg:items-end gap-5 max-w-sm">
                    <p class="text-secondary text-sm leading-relaxed lg:text-right">
                        <?php echo esc_html( t('home.faq.common_subtitle') ?: 'Everything you need to know about buying, investing, and living in Costa Blanca.' ); ?>
                    </p>
                    <a href="<?php echo \Estatery\Core\Translator::getInstance()->resolve_nav_url('/contact'); ?>" class="inline-flex items-center gap-3 group">
                        <span class="text-secondary font-bold uppercase tracking-widest text-[10px] group-hover:opacity-70 transition-opacity duration-300"><?php echo esc_html( t('home.faq.contact_button') ?: 'Contact Us' ); ?></span>
                        <div class="w-9 h-9 border border-secondary/20 flex items-center justify-center group-hover:bg-secondary group-hover:border-secondary transition-all duration-300">
                            <svg class="w-3.5 h-3.5 text-secondary group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab Layout -->
        <div class="flex flex-col lg:flex-row gap-0 border border-secondary/10">

            <!-- Left: Tab Navigation -->
            <div class="lg:w-72 xl:w-80 shrink-0 border-b lg:border-b-0 lg:border-r border-secondary/10">
                <nav class="js-faq-tabs flex flex-row lg:flex-col overflow-x-auto lg:overflow-x-visible">
                    <?php foreach ($all_faq_groups as $i => $group) : ?>
                        <button
                            class="js-faq-tab group relative flex items-center justify-between gap-3 px-6 py-4 lg:py-5 w-full text-left border-b border-secondary/10 last:border-b-0 transition-all duration-200 whitespace-nowrap lg:whitespace-normal <?php echo $i === $active_index ? 'is-active bg-secondary text-white' : 'bg-white text-secondary'; ?>"
                            data-tab="<?php echo esc_attr($group['key']); ?>"
                            aria-selected="<?php echo $i === $active_index ? 'true' : 'false'; ?>"
                        >
                            <span class="text-sm font-semibold tracking-wide transition-colors duration-200">
                                <?php echo esc_html($group['label']); ?>
                            </span>
                            <svg class="w-3.5 h-3.5 shrink-0 opacity-0 group-[.is-active]:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    <?php endforeach; ?>
                </nav>
            </div>

            <!-- Right: FAQ Accordion Panels -->
            <div class="flex-1 min-w-0">
                <?php foreach ($all_faq_groups as $i => $group) : ?>
                    <div
                        class="js-faq-panel <?php echo $i === $active_index ? '' : 'hidden'; ?>"
                        data-panel="<?php echo esc_attr($group['key']); ?>"
                    >
                        <!-- Panel title row -->
                        <div class="flex items-center justify-between px-8 py-5 border-b border-secondary/10">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-secondary/40">
                                <?php echo esc_html($group['label']); ?>
                            </span>
                            <span class="text-xs text-secondary/30">
                                <?php echo count($group['items']); ?> questions
                            </span>
                        </div>

                        <!-- Accordion items -->
                        <div class="js-faq-accordion">
                            <?php foreach ($group['items'] as $idx => $item) : ?>
                                <div class="js-faq-item border-b border-secondary/10 last:border-b-0">
                                    <button class="js-faq-trigger w-full flex items-start justify-between gap-6 px-8 py-6 text-left focus:outline-none cursor-pointer group">
                                        <span class="js-faq-question text-secondary font-semibold text-[15px] leading-snug group-hover:opacity-80 transition-opacity duration-200 pr-2">
                                            <?php echo esc_html($item['question']); ?>
                                        </span>
                                        <span class="js-faq-icon flex-shrink-0 mt-0.5 w-5 h-5 flex items-center justify-center border border-secondary/20 text-secondary transition-all duration-300 group-hover:bg-secondary group-hover:border-secondary group-hover:text-white">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path class="js-icon-line" stroke-linecap="square" stroke-linejoin="miter" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="js-faq-content overflow-hidden" style="height:0; opacity:0;">
                                        <div class="px-8 pb-7 pt-0 lg:pr-24">
                                            <p class="text-black text-sm leading-relaxed opacity-90">
                                                <?php echo esc_html($item['answer']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div><!-- end tab layout -->

    </div>
</section>

<script>
(function () {
    'use strict';
    function initFAQ() {
        const section = document.querySelector('.js-faq-section');
        if (!section) return;

        const tabs   = section.querySelectorAll('.js-faq-tab');
        const panels = section.querySelectorAll('.js-faq-panel');

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                const key = tab.dataset.tab;
                tabs.forEach(function (t) {
                    const active = t.dataset.tab === key;
                    t.classList.toggle('is-active', active);
                    t.classList.toggle('bg-secondary', active);
                    t.classList.toggle('text-white', active);
                    t.classList.toggle('bg-white', !active);
                    t.classList.toggle('text-secondary', !active);
                    t.setAttribute('aria-selected', active ? 'true' : 'false');
                });

                panels.forEach(function (panel) {
                    if (panel.dataset.panel === key) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            });
        });

        function initAccordion(panel) {
            var items = panel.querySelectorAll('.js-faq-item');
            items.forEach(function (item) {
                var trigger = item.querySelector('.js-faq-trigger');
                var content = item.querySelector('.js-faq-content');

                trigger.addEventListener('click', function () {
                    var isOpen = item.classList.contains('is-open');

                    items.forEach(function (other) {
                        if (other !== item && other.classList.contains('is-open')) {
                            var oc = other.querySelector('.js-faq-content');
                            oc.style.height = '0';
                            oc.style.opacity = '0';
                            other.classList.remove('is-open');
                        }
                    });

                    if (isOpen) {
                        content.style.height = '0';
                        content.style.opacity = '0';
                        item.classList.remove('is-open');
                    } else {
                        content.style.height = 'auto';
                        content.style.opacity = '1';
                        var height = content.scrollHeight + 'px';
                        content.style.height = '0';
                        setTimeout(() => {
                            content.style.height = height;
                            content.style.opacity = '1';
                        }, 10);
                        item.classList.add('is-open');
                    }
                });
            });
        }
        panels.forEach(initAccordion);
    }

    if (document.readyState === 'loading') {
        window.addEventListener('load', initFAQ);
    } else {
        initFAQ();
    }
})();
</script>

<style>
    .js-faq-content {
        transition: height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
    }
    .js-faq-icon svg {
        transition: transform 0.3s ease;
    }
    .js-faq-item.is-open .js-faq-icon svg {
        transform: rotate(45deg);
    }
    
   
    .js-faq-tab:not(.is-active):hover {
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    
    .js-faq-trigger:hover .js-faq-question {
        color: var(--color-primary, #000);
        opacity: 1;
    }
</style>