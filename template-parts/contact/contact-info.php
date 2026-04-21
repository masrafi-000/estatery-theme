<?php $info = t('pages.contact.info'); ?>
<<section class="py-24 bg-[#fcfcfc] js-contact-section" id="contact-page">
    <div class="container mx-auto px-6 max-w-7xl">

        <div class="max-w-3xl mx-auto text-center mb-20 js-contact-header">
            <span class="inline-block text-secondary font-bold uppercase tracking-[0.3em] text-[10px]">
                <?php echo esc_html($info['badge']); ?>
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-secondary mb-6 leading-tight">
                <?php echo esc_html($info['title']); ?>
            </h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-16 items-start">

            <div class="w-full lg:w-2/3 js-contact-form-wrap">
                <?php
                get_template_part('template-parts/contact/contact-form');
                ?>
            </div>

            <div class="w-full lg:w-1/3 space-y-10 bg-white p-8 md:p-10 rounded-[2.5rem] border border-secondary/5 shadow-sm js-contact-details">

                <div class="space-y-6 pb-6 border-b border-secondary/5">
                    <div class="text-2xl font-black text-secondary uppercase tracking-tighter">
                        <?php echo esc_html($info['company']); ?>
                    </div>
                    <p class="text-secondary/60 text-sm leading-relaxed">
                        <?php echo esc_html($info['description']); ?>
                    </p>
                </div>

                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-secondary font-bold uppercase tracking-widest text-[10px] mb-1 opacity-50">
                                <?php echo esc_html($info['office_label']); ?></h4>
                            <p class="text-secondary text-sm font-semibold"><?php echo esc_html($info['office_address']); ?></p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-secondary font-bold uppercase tracking-widest text-[10px] mb-1 opacity-50">
                                <?php echo esc_html($info['email_label']); ?></h4>
                            <a href="mailto:info@altara.com"
                                class="text-secondary text-sm font-semibold hover:text-primary transition-colors">info@altara.com</a>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-secondary font-bold uppercase tracking-widest text-[10px] mb-1 opacity-50">
                                <?php echo esc_html($info['phone_label']); ?></h4>
                            <a href="tel:+880123456789"
                                class="text-secondary text-sm font-semibold hover:text-primary transition-colors">+88
                                0123 456 789</a>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-secondary/5">
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-10 h-10 rounded-lg bg-secondary/5 flex items-center justify-center text-secondary hover:bg-primary hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-lg bg-secondary/5 flex items-center justify-center text-secondary hover:bg-primary hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.266.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-lg bg-secondary/5 flex items-center justify-center text-secondary hover:bg-primary hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-20 w-full h-[450px] rounded-[2.5rem] overflow-hidden border border-secondary/5 shadow-2xl transition-all duration-700 hover:grayscale-0 js-contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3590.963471012879!2d-80.13264982361663!3d25.77174780821953!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b48999335805%3A0xc6829148d8881b7a!2s2892%20Ocean%20Dr%2C%20Miami%20Beach%2C%20FL%2033139%2C%20USA!5e0!3m2!1sen!2sbd!4v1713175000000!5m2!1sen!2sbd"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>

    </div>
</section>

<script>
(function() {
    function initContactPageAnims() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        
        gsap.registerPlugin(ScrollTrigger);
        const section = document.querySelector(".js-contact-section");
        if (!section) return;

        const headerItems = section.querySelectorAll(".js-contact-header > *");
        const formCard    = section.querySelector(".js-contact-form-card");
        const infoCard    = section.querySelector(".js-contact-details");
        const mapArea     = section.querySelector(".js-contact-map");

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: "top 82%",
                toggleActions: "play none none none",
                once: true
            }
        });

        // 1. Header
        if (headerItems.length) {
            gsap.set(headerItems, { opacity: 0, y: 30 });
            tl.to(headerItems, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.12,
                ease: "power3.out"
            });
        }

        // 2. Form and Info Cards (Staggered entrance)
        if (formCard || infoCard) {
            const cards = [];
            if (formCard) {
                gsap.set(formCard, { opacity: 0, x: -30 });
                cards.push(formCard);
            }
            if (infoCard) {
                gsap.set(infoCard, { opacity: 0, x: 30 });
                cards.push(infoCard);
            }

            tl.to(cards, {
                opacity: 1,
                x: 0,
                duration: 1,
                stagger: 0.2,
                ease: "power3.out",
                clearProps: "transform,opacity"
            }, "-=0.6");
        }

        // 3. Map Reveal
        if (mapArea) {
            gsap.set(mapArea, { opacity: 0, scale: 0.96, y: 30 });
            tl.to(mapArea, {
                opacity: 1,
                scale: 1,
                y: 0,
                duration: 1.2,
                ease: "power2.out"
            }, "-=0.8");
        }
    }

    if (document.readyState === 'loading') {
        window.addEventListener('load', initContactPageAnims);
    } else {
        initContactPageAnims();
    }
})();
</script>