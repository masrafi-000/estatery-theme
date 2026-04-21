<?php $leadership = t('pages.about.leadership'); ?>
<section class="relative py-24 bg-white overflow-hidden js-leadership-section">

    <div class="container mx-auto px-6 lg:px-12 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-0">

            <div class="w-full lg:w-5/12 relative group js-leadership-image">
                <div class="absolute -bottom-6 -right-6 w-2/3 h-2/3 border-2 border-secondary z-0 hidden lg:block"></div>

                <div class="relative z-10 rounded-sm overflow-hidden shadow-2xl bg-primary">
                    <img src="https://images.pexels.com/photos/2182970/pexels-photo-2182970.jpeg?auto=compress&cs=tinysrgb&w=1000"
                        alt="CEO"
                        class="w-full h-[550px] object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 scale-110 group-hover:scale-100">
                </div>

                <div class="absolute -bottom-10 -left-6 lg:left-[-10%] bg-white p-6 shadow-xl z-20 hidden md:block border-l-4 border-secondary js-leadership-card">
                    <p class="text-secondary font-bold text-4xl italic">
                        <span class="js-count-up" data-target="35">0</span>+
                    </p>
                    <p class="text-xs uppercase tracking-widest text-gray-500 font-semibold"><?php echo esc_html($leadership['years_label']); ?></p>
                </div>
            </div>

            <div class="w-full lg:w-7/12 lg:pl-24 space-y-8 js-leadership-content">
                <div class="inline-block">
                    <span class="text-secondary font-bold uppercase tracking-[0.3em] text-xs flex items-center gap-3">
                        <span class="w-10 h-[1px] bg-secondary"></span>
                        <?php echo esc_html($leadership['badge']); ?>
                    </span>
                </div>

                <h2 class="text-4xl font-extrabold text-secondary mb-6">
                    <?php echo $leadership['title']; ?>
                </h2>

                <div class="relative">
                    <p class="border-l-2 text-secondary border-primary/90 pl-8">
                        <?php echo esc_html($leadership['message']); ?>
                    </p>
                </div>

                <div class="flex items-center gap-6 pt-6">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-secondary shadow-md">
                        <img src="https://images.pexels.com/photos/2182970/pexels-photo-2182970.jpeg?auto=compress&cs=tinysrgb&w=100"
                            class="w-full h-full object-cover" alt="">
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-secondary tracking-tight"><?php echo esc_html($leadership['name']); ?></h4>
                        <p class="text-secondary text-xs uppercase tracking-widest font-bold"><?php echo esc_html($leadership['role']); ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    function initLeadership() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

        gsap.registerPlugin(ScrollTrigger);

        var section      = document.querySelector('.js-leadership-section');
        if (!section) return;

        var imageWrap    = section.querySelector('.js-leadership-image');
        var contentItems = section.querySelectorAll('.js-leadership-content > *');
        var card         = section.querySelector('.js-leadership-card');
        var counter      = section.querySelector('.js-count-up');

        var tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top 80%',
                toggleActions: 'play none none none',
                once: true
            }
        });

        // 1. Image container slides up
        if (imageWrap) {
            gsap.set(imageWrap, { opacity: 0, y: 60 });
            tl.to(imageWrap, {
                opacity: 1,
                y: 0,
                duration: 0.9,
                ease: 'power3.out'
            });
        }

        // 2. Content children stagger in from right
        if (contentItems.length) {
            gsap.set(contentItems, { opacity: 0, x: 35 });
            tl.to(contentItems, {
                opacity: 1,
                x: 0,
                duration: 0.75,
                stagger: 0.1,
                ease: 'power3.out'
            }, '-=0.6');
        }

        // 3. Floating card pops in
        if (card) {
            gsap.set(card, { opacity: 0, scale: 0.78 });
            tl.to(card, {
                opacity: 1,
                scale: 1,
                duration: 0.65,
                ease: 'back.out(1.6)'
            }, '-=0.5');
        }

        // 4. Counter — runs only when the card is visible
        if (counter) {
            var target = parseInt(counter.getAttribute('data-target'), 10) || 0;
            var obj = { val: 0 };

            tl.to(obj, {
                val: target,
                duration: 1.6,
                ease: 'power2.inOut',
                onUpdate: function () {
                    counter.textContent = Math.ceil(obj.val);
                }
            }, '-=0.4');
        }
    }

    if (document.readyState === 'loading') {
        window.addEventListener('load', initLeadership);
    } else {
        initLeadership();
    }
})();
</script>
