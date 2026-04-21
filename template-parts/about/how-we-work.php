<?php $how_we_work = t('pages.about.how_we_work'); ?>
<section class="py-14 bg-[#fcfcfc] overflow-hidden js-how-we-work">
    <div class="container mx-auto px-6 lg:px-12">

        <div class="text-center max-w-3xl mx-auto mb-20 js-process-header">
            <span class="text-secondary font-bold uppercase text-xs pb-2 flex justify-center items-center gap-3">
                <span class="w-8 h-[1px] bg-secondary"></span>
                <?php echo esc_html($how_we_work['badge']); ?>
                <span class="w-8 h-[1px] bg-secondary"></span>
            </span>
            <h2 class="text-4xl font-extrabold text-secondary mb-6">
                <?php echo $how_we_work['title']; ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative js-process-grid">

            <!-- Connector line (desktop only) -->
            <div class="js-process-line absolute top-1/4 left-0 w-0 h-[1px] bg-primary/10 z-0 hidden lg:block"></div>

            <?php foreach ($how_we_work['steps'] as $index => $step): ?>
                <div class="js-process-step relative z-10 group p-8 rounded-xl bg-white border border-primary/5 hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5 transition-all duration-500">

                    <div class="step-icon w-16 h-16 bg-white border border-primary/10 flex items-center justify-center rounded-full mb-6 group-hover:border-primary transition-colors duration-500 shadow-sm relative overflow-hidden">
                        <span class="text-secondary font-bold text-xl relative z-10"><?php echo esc_html($step['id']); ?></span>
                        <div class="absolute inset-0 bg-primary translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                        <span class="text-white font-bold text-xl absolute z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"><?php echo esc_html($step['id']); ?></span>
                    </div>

                    <h4 class="text-xl font-bold text-secondary mb-3"><?php echo esc_html($step['title']); ?></h4>
                    <p class="body-copy mb-0 text-gray-500 leading-relaxed">
                        <?php echo esc_html($step['description']); ?>
                    </p>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<script>
(function () {
    function initHowWeWork() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

        gsap.registerPlugin(ScrollTrigger);

        var section     = document.querySelector('.js-how-we-work');
        if (!section) return;

        var headerItems = section.querySelectorAll('.js-process-header > *');
        var line        = section.querySelector('.js-process-line');
        var cards       = section.querySelectorAll('.js-process-step');

        // Set initial states immediately so nothing flashes visible
        if (headerItems.length) gsap.set(headerItems, { opacity: 0, y: 30 });
        if (cards.length)       gsap.set(cards,       { opacity: 0, y: 40 });
        // line starts at width:0 via CSS class — no extra set() needed

        var tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top 82%',
                toggleActions: 'play none none none',
                once: true
            }
        });

        // 1. Header children stagger down
        if (headerItems.length) {
            tl.to(headerItems, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.12,
                ease: 'power3.out'
            });
        }

        // 2. Connector line expands (desktop only — element is hidden on mobile via CSS)
        if (line) {
            tl.to(line, {
                width: '100%',
                duration: 0.9,
                ease: 'power3.inOut'
            }, '-=0.45');
        }

        // 3. Cards stagger up — clearProps so CSS hover transitions work after
        if (cards.length) {
            tl.to(cards, {
                opacity: 1,
                y: 0,
                duration: 0.75,
                stagger: 0.12,
                ease: 'power3.out',
                clearProps: 'transform,opacity'
            }, '-=0.65');
        }
    }

    if (document.readyState === 'loading') {
        window.addEventListener('load', initHowWeWork);
    } else {
        initHowWeWork();
    }
})();
</script>