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

<section class="js-faq-section py-24 bg-white border-b border-black/10 overflow-hidden">
    <div class="container mx-auto px-6 lg:px-12">

        <!-- Header -->
        <div class="js-faq-header mb-16 lg:mb-20">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 border border-black/20 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-black"></span>
                <span class="text-black font-semibold uppercase tracking-[0.2em] text-[10px]"><?php echo esc_html( t('home.faq.eyebrow') ?: 'FAQ' ); ?></span>
            </div>
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                <h2 class="text-4xl md:text-5xl lg:text-[3.25rem] font-extrabold text-black tracking-tight leading-[1.05]">
                    <?php echo t('home.faq.frequently_asked') ?: 'Frequently Asked<br>Questions'; ?>
                </h2>
                <div class="flex flex-col lg:items-end gap-5 max-w-sm">
                    <p class="text-black/50 text-sm leading-relaxed lg:text-right">
                        <?php echo esc_html( t('home.faq.common_subtitle') ?: 'Everything you need to know about buying, investing, and living in Costa Blanca.' ); ?>
                    </p>
                    <a href="<?php echo \Estatery\Core\Translator::getInstance()->resolve_nav_url('/contact'); ?>" class="inline-flex items-center gap-3 group">
                        <span class="text-black font-bold uppercase tracking-widest text-[10px] group-hover:opacity-40 transition-opacity duration-300"><?php echo esc_html( t('home.faq.contact_button') ?: 'Contact Us' ); ?></span>
                        <div class="w-9 h-9 border border-black/20 flex items-center justify-center group-hover:bg-black group-hover:border-black transition-all duration-300">
                            <svg class="w-3.5 h-3.5 text-black group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab Layout -->
        <div class="flex flex-col lg:flex-row gap-0 border border-black/10">

            <!-- Left: Tab Navigation -->
            <div class="lg:w-72 xl:w-80 shrink-0 border-b lg:border-b-0 lg:border-r border-black/10">
                <nav class="js-faq-tabs flex flex-row lg:flex-col overflow-x-auto lg:overflow-x-visible">
                    <?php foreach ($all_faq_groups as $i => $group) : ?>
                        <button
                            class="js-faq-tab group relative flex items-center justify-between gap-3 px-6 py-4 lg:py-5 w-full text-left border-b border-black/10 last:border-b-0 transition-all duration-200 whitespace-nowrap lg:whitespace-normal <?php echo $i === $active_index ? 'is-active bg-black text-white' : 'bg-white text-black hover:bg-black/5'; ?>"
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
                        <div class="flex items-center justify-between px-8 py-5 border-b border-black/10">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-black/40">
                                <?php echo esc_html($group['label']); ?>
                            </span>
                            <span class="text-xs text-black/30">
                                <?php echo count($group['items']); ?> questions
                            </span>
                        </div>

                        <!-- Accordion items -->
                        <div class="js-faq-accordion">
                            <?php foreach ($group['items'] as $idx => $item) : ?>
                                <div class="js-faq-item border-b border-black/10 last:border-b-0">
                                    <button class="js-faq-trigger w-full flex items-start justify-between gap-6 px-8 py-6 text-left focus:outline-none cursor-pointer group">
                                        <span class="js-faq-question text-black font-semibold text-[15px] leading-snug group-hover:opacity-60 transition-opacity duration-200 pr-2">
                                            <?php echo esc_html($item['question']); ?>
                                        </span>
                                        <span class="js-faq-icon flex-shrink-0 mt-0.5 w-5 h-5 flex items-center justify-center border border-black/20 text-black transition-all duration-300 group-hover:bg-black group-hover:border-black group-hover:text-white">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path class="js-icon-line" stroke-linecap="square" stroke-linejoin="miter" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="js-faq-content overflow-hidden" style="height:0; opacity:0;">
                                        <div class="px-8 pb-7 pt-0 lg:pr-24">
                                            <p class="text-black/55 text-sm leading-relaxed">
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

        // ── Tab switching ─────────────────────────────────────────────────────
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                const key = tab.dataset.tab;

                // Update tab states
                tabs.forEach(function (t) {
                    const active = t.dataset.tab === key;
                    t.classList.toggle('is-active', active);
                    t.classList.toggle('bg-black', active);
                    t.classList.toggle('text-white', active);
                    t.classList.toggle('bg-white', !active);
                    t.classList.toggle('text-black', !active);
                    t.setAttribute('aria-selected', active ? 'true' : 'false');
                });

                // Show / hide panels (reset open accordions on switch)
                panels.forEach(function (panel) {
                    if (panel.dataset.panel === key) {
                        panel.classList.remove('hidden');
                        // Entrance: stagger items if GSAP available
                        if (typeof gsap !== 'undefined') {
                            const items = panel.querySelectorAll('.js-faq-item');
                            gsap.fromTo(items,
                                { opacity: 0, y: 10 },
                                { opacity: 1, y: 0, duration: 0.4, stagger: 0.06, ease: 'power2.out', clearProps: 'opacity,transform' }
                            );
                        }
                    } else {
                        // Close any open accordion before hiding
                        panel.querySelectorAll('.js-faq-item.is-open').forEach(function (openItem) {
                            var c = openItem.querySelector('.js-faq-content');
                            if (typeof gsap !== 'undefined') {
                                gsap.set(c, { height: 0, opacity: 0 });
                            } else {
                                c.style.height  = '0';
                                c.style.opacity = '0';
                            }
                            openItem.classList.remove('is-open');
                        });
                        panel.classList.add('hidden');
                    }
                });
            });
        });

        // ── Accordion helper ──────────────────────────────────────────────────
        function initAccordion(panel) {
            var items = panel.querySelectorAll('.js-faq-item');

            items.forEach(function (item) {
                var trigger = item.querySelector('.js-faq-trigger');
                var content = item.querySelector('.js-faq-content');
                var icon    = item.querySelector('.js-faq-icon');

                trigger.addEventListener('click', function () {
                    var isOpen = item.classList.contains('is-open');

                    // Close siblings in this panel
                    items.forEach(function (other) {
                        if (other !== item && other.classList.contains('is-open')) {
                            var oc = other.querySelector('.js-faq-content');
                            var oi = other.querySelector('.js-faq-icon');
                            if (typeof gsap !== 'undefined') {
                                gsap.to(oc, { height: 0, opacity: 0, duration: 0.3, ease: 'power2.inOut' });
                                gsap.to(oi, { rotation: 0, duration: 0.3, ease: 'power2.inOut' });
                            } else {
                                oc.style.height  = '0';
                                oc.style.opacity = '0';
                            }
                            other.classList.remove('is-open');
                        }
                    });

                    if (isOpen) {
                        if (typeof gsap !== 'undefined') {
                            gsap.to(content, { height: 0, opacity: 0, duration: 0.3, ease: 'power2.inOut' });
                            gsap.to(icon, { rotation: 0, duration: 0.3, ease: 'power2.inOut' });
                        } else {
                            content.style.height  = '0';
                            content.style.opacity = '0';
                        }
                        item.classList.remove('is-open');
                    } else {
                        if (typeof gsap !== 'undefined') {
                            gsap.set(content, { height: 'auto', opacity: 1 });
                            var nat = content.offsetHeight;
                            gsap.fromTo(content,
                                { height: 0, opacity: 0 },
                                { height: nat, opacity: 1, duration: 0.38, ease: 'power3.out' }
                            );
                            gsap.to(icon, { rotation: 45, duration: 0.35, ease: 'back.out(1.4)' });
                        } else {
                            content.style.height  = 'auto';
                            content.style.opacity = '1';
                        }
                        item.classList.add('is-open');
                    }
                });
            });
        }

        panels.forEach(function (panel) { initAccordion(panel); });

        // ── Entrance animation (GSAP optional) ───────────────────────────────
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            var header = section.querySelector('.js-faq-header');
            var navBtns = section.querySelectorAll('.js-faq-tab');
            var firstPanel = section.querySelector('.js-faq-panel:not(.hidden) .js-faq-item');

            var tl = gsap.timeline({
                scrollTrigger: {
                    trigger: section,
                    start: 'top 82%',
                    toggleActions: 'play none none none',
                }
            });

            if (header) {
                gsap.set(header, { opacity: 0, y: 20 });
                tl.to(header, { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out', clearProps: 'opacity,transform' });
            }
            if (navBtns.length) {
                gsap.set(navBtns, { opacity: 0, x: -10 });
                tl.to(navBtns, { opacity: 1, x: 0, duration: 0.5, stagger: 0.07, ease: 'power2.out', clearProps: 'opacity,transform' }, '-=0.4');
            }

            setTimeout(function () { ScrollTrigger.refresh(); }, 150);
        }
    }

    if (document.readyState === 'loading') {
        window.addEventListener('load', initFAQ);
    } else {
        initFAQ();
    }
})();
</script>