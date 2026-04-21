<?php $philosophy = t('pages.about.philosophy'); ?>
<section class="py-24 bg-[#FCFCFC] overflow-hidden js-philosophy-section">
    <div class="container mx-auto px-6">

        <div class="container mb-16 js-philosophy-header">
            <h4 class="text-secondary font-bold uppercase tracking-[0.3em] text-center pb-4 text-xs"><?php echo esc_html($philosophy['badge']); ?></h4>
            <h2 class="text-4xl font-extrabold text-center text-secondary mb-6">
                <?php echo $philosophy['title']; ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 js-philosophy-cards">

            <?php
            $icons = [
                "M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4",
                "M13 10V3L4 14h7v7l9-11h-7z",
                "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
            ];
            foreach ($philosophy['values'] as $idx => $val):
            ?>
                <div class="js-value-card group relative p-10 bg-white shadow border border-gray-100 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl overflow-hidden">
                    <div class="absolute top-0 left-0 w-0 h-[3px] bg-secondary group-hover:w-full transition-all duration-700"></div>

                    <div class="relative z-10">
                        <span class="text-5xl font-serif text-gray-200 group-hover:text-secondary/20 transition-colors duration-500 font-bold"><?php echo esc_html($val['id']); ?></span>

                        <div class="mt-6 mb-4 text-secondary">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="<?php echo $icons[$idx]; ?>"></path>
                            </svg>
                        </div>

                        <h4 class="text-2xl font-bold text-secondary mb-4"><?php echo esc_html($val['title']); ?></h4>
                        <p class="body-copy mb-0">
                            <?php echo esc_html($val['description']); ?>
                        </p>
                    </div>

                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<script>
(function () {
    function initPhilosophy() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

        gsap.registerPlugin(ScrollTrigger);

        var section     = document.querySelector('.js-philosophy-section');
        if (!section) return;

        var headerItems = section.querySelectorAll('.js-philosophy-header > *');
        var cards       = section.querySelectorAll('.js-value-card');

        // --- Header ---
        if (headerItems.length) {
            gsap.set(headerItems, { opacity: 0, y: 30 });

            ScrollTrigger.create({
                trigger: section.querySelector('.js-philosophy-header'),
                start: 'top 82%',
                once: true,
                onEnter: function () {
                    gsap.to(headerItems, {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        stagger: 0.12,
                        ease: 'power3.out'
                    });
                }
            });
        }

        // --- Cards ---
        if (cards.length) {
            gsap.set(cards, { opacity: 0, y: 45, scale: 0.97 });

            ScrollTrigger.create({
                trigger: section.querySelector('.js-philosophy-cards'),
                start: 'top 82%',
                once: true,
                onEnter: function () {
                    gsap.to(cards, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.8,
                        stagger: 0.13,
                        ease: 'power3.out',
                        clearProps: 'transform,opacity'
                    });
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        window.addEventListener('load', initPhilosophy);
    } else {
        initPhilosophy();
    }
})();
</script>
