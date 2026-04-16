(function($) {
    'use strict';

    $(function() {
        /**
         * 1. Mobile Navigation Drawer
         */
        const $drawer = $('#mobile-drawer');
        const $content = $('#drawer-content');
        const $overlay = $('#drawer-overlay');
        const $toggle = $('#mobile-toggle');
        const $close = $('#drawer-close');

        function openDrawer() {
            $drawer.removeClass('invisible pointer-events-none').addClass('visible');
            $overlay.removeClass('opacity-0').addClass('opacity-100');
            $content.removeClass('-translate-x-full').addClass('translate-x-0');
            $('body').css('overflow', 'hidden');
        }

        function closeDrawer() {
            $overlay.removeClass('opacity-100').addClass('opacity-0');
            $content.removeClass('translate-x-0').addClass('-translate-x-full');
            setTimeout(() => {
                $drawer.removeClass('visible').addClass('invisible pointer-events-none');
                $('body').css('overflow', '');
            }, 500);
        }

        if ($toggle.length) $toggle.on('click', openDrawer);
        if ($close.length) $close.on('click', closeDrawer);
        if ($overlay.length) $overlay.on('click', closeDrawer);


        /**
         * 2. Language Switcher — jQuery CSS layer ONLY
         * This handler manages the dropdown's CSS state (open/close classes).
         * ALL cookie-setting, AJAX, and navigation is owned exclusively by
         * LanguageSwitcher.js (ES module) to avoid race conditions.
         */
        const $langTrigger    = $('#lang-select-trigger');
        const $langMenu       = $('#lang-options-list');
        const $langChevron    = $('#lang-select-chevron');
        const $langOptionBtns = $('.lang-option-btn');

        function toggleLangMenu() {
            const isOpen = $langMenu.hasClass('active-menu');
            if (!isOpen) {
                $langMenu.removeClass('opacity-0 invisible translate-y-6 pointer-events-none')
                          .addClass('opacity-100 visible translate-y-0 pointer-events-auto active-menu');
                $langChevron.addClass('rotate-180');
                $langTrigger.attr('aria-expanded', 'true');
            } else {
                $langMenu.addClass('opacity-0 invisible translate-y-6 pointer-events-none')
                          .removeClass('opacity-100 visible translate-y-0 pointer-events-auto active-menu');
                $langChevron.removeClass('rotate-180');
                $langTrigger.attr('aria-expanded', 'false');
            }
        }

        if ($langTrigger.length && $langMenu.length) {
            $langTrigger.on('click', function(e) {
                e.stopPropagation();
                toggleLangMenu();
            });

            // Option click: Only close the CSS menu state.
            // LanguageSwitcher.js will handle AJAX save + navigation.
            $langOptionBtns.on('click', function() {
                if ($langMenu.hasClass('active-menu')) toggleLangMenu();
            });

            $(document).on('click', function(e) {
                if (!$langMenu.is(e.target) && $langMenu.has(e.target).length === 0 &&
                    !$langTrigger.is(e.target) && $langTrigger.has(e.target).length === 0) {
                    if ($langMenu.hasClass('active-menu')) toggleLangMenu();
                }
            });
        }


        /**
         * 3. Hero Filter Tabs Logic
         */
        $('.filter-tab').on('click', function() {
            $('.filter-tab').removeClass('bg-primary text-white active').addClass('bg-white/90 text-slate-900');
            $(this).addClass('bg-primary text-white active').removeClass('bg-white/90 text-slate-900');
            $('#listing-type-input').val($(this).data('type'));
        });


        /**
         * 4. Swiper Initialization (Featured Properties)
         */
        if ($('.propertySlider').length && typeof Swiper !== 'undefined') {
            new Swiper('.propertySlider', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                speed: 1000,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: {
                    el: '.swiper-pagination-premium',
                    clickable: true,
                    renderBullet: (index, className) => `<span class="${className} custom-dot"></span>`
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4, spaceBetween: 24 }
                }
            });
        }


        /**
         * 5. Why Choose Us (Dynamic Features & GSAP)
         */
        const $featureWrapper = $('#dynamic-features-wrapper');
        const features = (typeof estateryData !== 'undefined') ? estateryData.why_choose_features : [];

        if ($featureWrapper.length && features.length) {
            $featureWrapper.html(features.map(feature => `
                <div class="feature-box p-10 bg-white rounded-[2.5rem] border border-transparent hover:border-primary/20 transition-all flex flex-col items-start shadow-sm group hover:shadow-xl duration-500">
                    <div class="w-16 h-16 ${feature.bgColor} text-primary rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        ${feature.icon}
                    </div>
                    <h3 class="text-2xl font-bold text-secondary mb-4">${feature.title}</h3>
                    <p class="text-text-gray text-base leading-relaxed">
                        ${feature.description}
                    </p>
                </div>
            `).join(''));

            if (typeof gsap !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);
                
                if (document.querySelector('.reveal')) {
                    gsap.to(".reveal", {
                        scrollTrigger: { trigger: "#why-choose", start: "top 85%", toggleActions: "play none none none" },
                        opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: "power4.out"
                    });
                }
                
                if (document.querySelector('.feature-box')) {
                    gsap.to(".feature-box", {
                        scrollTrigger: { trigger: "#dynamic-features-wrapper", start: "top 80%", toggleActions: "play none none none" },
                        opacity: 1, y: 0, scale: 1, stagger: 0.1, duration: 0.8, ease: "power4.out"
                    });
                }
            }
        }


        /**
         * 6. Scroll Triggered Counter
         */
        if ($('#stats-counter-section').length && typeof gsap !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
            const $counters = $('.counter-value');
            if ($counters.length) {
                $counters.each(function() {
                    const $this = $(this);
                    const targetValue = parseInt($this.data('target'));
                    gsap.to(this, {
                        innerText: targetValue,
                        duration: 1.5,
                        ease: "power2.out",
                        snap: { innerText: 1 },
                        scrollTrigger: { trigger: "#stats-counter-section", start: "top 85%", toggleActions: "play none none none" },
                        onUpdate: function() {
                            $this.text(Math.ceil(this.targets()[0].innerText));
                        }
                    });
                });
            }
        }


        /**
         * 7. FAQ Accordion (GSAP)
         */
        const $faqSection = $('#faq-section');
        if ($faqSection.length && typeof gsap !== 'undefined') {
            const $faqToggles = $('.faq-toggle');
            const $faqCards = $('.faq-card');

            $faqToggles.on('click', function() {
                const $parent = $(this).parent();
                const $answer = $(this).next();
                const isActive = $parent.hasClass('active');

                if (!isActive) {
                    $parent.addClass('active');
                    gsap.set($answer[0], { display: 'block' });
                    gsap.fromTo($answer[0], { opacity: 0, height: 0 }, { opacity: 1, height: 'auto', duration: 0.4, ease: "power4.out" });

                    $faqCards.not($parent).each(function(index) {
                        const xSide = index % 2 === 0 ? -150 : 150;
                        gsap.to(this, { xPercent: xSide, autoAlpha: 0, scale: 0.7, height: 0, marginBottom: 0, pointerEvents: 'none', duration: 0.8, ease: "expo.inOut" });
                    });
                } else {
                    $parent.removeClass('active');
                    gsap.to($answer[0], {
                        height: 0, opacity: 0, duration: 0.3,
                        onComplete: () => gsap.set($answer[0], { display: 'none' })
                    });
                    $faqCards.each(function() {
                        gsap.to(this, { xPercent: 0, autoAlpha: 1, scale: 1, height: 'auto', marginBottom: '1rem', pointerEvents: 'auto', duration: 0.8, ease: "back.out(1.2)", clearProps: "transform,scale,margin-bottom" });
                    });
                }
            });
        }


        /**
         * 8. 404 Page Animations (GSAP)
         */
        const $errorPage = $('.error-404-section');
        if ($errorPage.length && typeof gsap !== 'undefined') {
            // Parallax 404 Text - Subtle mouse follow
            const $parallax404 = $('#gsap-404-parallax');
            $(document).on('mousemove', function(e) {
                const { clientX, clientY } = e;
                const xPos = (clientX / window.innerWidth - 0.5) * 80;
                const yPos = (clientY / window.innerHeight - 0.5) * 80;
                
                gsap.to($parallax404[0], {
                    x: xPos,
                    y: yPos,
                    duration: 1.5,
                    ease: "power2.out"
                });
            });

            // Content Reveal Sequence
            const tl = gsap.timeline({ defaults: { ease: "power4.out" } });
            tl.fromTo(".reveal-fade", 
                { opacity: 0, scale: 0.9, y: 20 }, 
                { opacity: 1, scale: 1, y: 0, duration: 0.8, delay: 0.1 }
            )
            .fromTo(".reveal-up", 
                { opacity: 0, y: 30 }, 
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.1 }, 
                "-=0.6"
            );

            // Floating Background Shapes
            gsap.to(".error-shape", {
                y: "random(-40, 40)",
                x: "random(-30, 30)",
                rotation: "random(-15, 15)",
                duration: "random(4, 7)",
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        }
    });

})(jQuery);
