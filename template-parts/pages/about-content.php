<section class="about-page-content py-24 bg-white">
    <div class="container mx-auto px-4">
        <!-- Main Story -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center mb-32">
            <div data-aos="fade-right">
                <span class="text-accent font-black text-xs uppercase tracking-[0.3em] mb-4 block"><?php echo esc_html( t('pages.about.subtitle') ); ?></span>
                <h2 class="text-4xl md:text-6xl font-black text-foreground mb-8 uppercase tracking-tighter leading-none">
                    <?php echo esc_html( t('pages.about.title') ); ?>
                </h2>
                <div class="w-20 h-2 bg-primary mb-8"></div>
                <p class="text-xl text-secondary leading-relaxed mb-8">
                    <?php echo esc_html( t('pages.about.content') ); ?>
                </p>
            </div>
            <div class="relative" data-aos="fade-left">
                <div class="aspect-square bg-surface-secondary rounded-full overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=1000" 
                         alt="About Estatery" 
                         class="w-full h-full object-cover opacity-80 grayscale hover:grayscale-0 transition-all duration-1000">
                </div>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 border-t border-gray-100 pt-20">
            <div data-aos="fade-up">
                <h3 class="text-xs font-black uppercase tracking-widest text-primary mb-6">Our Mission</h3>
                <p class="text-2xl font-bold text-foreground leading-snug">
                    "<?php echo esc_html( t('pages.about.mission') ); ?>"
                </p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-xs font-black uppercase tracking-widest text-primary mb-6">Our Vision</h3>
                <p class="text-2xl font-bold text-foreground leading-snug">
                    "<?php echo esc_html( t('pages.about.vision') ); ?>"
                </p>
            </div>
        </div>
    </div>
</section>
