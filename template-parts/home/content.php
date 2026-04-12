<?php
/**
 * Unified Home Content
 * Fetches data from JSON locales via the Translator service.
 */
?>
<main id="primary" class="site-main py-20 bg-background text-foreground">
    <div class="container mx-auto px-4">
        <article class="mb-16 max-w-4xl">
            <header class="entry-header mb-6">
                <h2 class="text-5xl font-black tracking-tight mb-4 gsap-reveal">
                    <?php echo esc_html( t('home.hero.title') ); ?>
                </h2>
                <div class="h-1 w-20 bg-primary mb-6"></div>
            </header>
            <div class="entry-content text-lg text-secondary leading-relaxed gsap-reveal">
                <p><?php echo esc_html( t('home.hero.description') ); ?></p>
            </div>
        </article>
    </div>
</main>

<section class="animation-demo py-32 bg-surface-secondary border-y border-gray-100">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-5xl font-black mb-12 gsap-reveal tracking-tighter uppercase">
            <?php echo esc_html( t('home.features.title') ); ?>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- GSAP -->
            <div class="bg-white p-10 rounded-2xl shadow-xl shadow-gray-200/50 gsap-card border border-gray-50">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="text-2xl font-bold">GS</span>
                </div>
                <h3 class="text-2xl font-bold mb-4"><?php echo esc_html( t('home.features.gsap.title') ); ?></h3>
                <p class="text-secondary leading-relaxed"><?php echo esc_html( t('home.features.gsap.description') ); ?></p>
            </div>
            <!-- LENIS -->
            <div class="bg-white p-10 rounded-2xl shadow-xl shadow-gray-200/50 gsap-card border border-gray-50 border-t-4 border-t-accent">
                <div class="w-16 h-16 bg-accent/10 text-accent rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="text-2xl font-bold">LN</span>
                </div>
                <h3 class="text-2xl font-bold mb-4"><?php echo esc_html( t('home.features.lenis.title') ); ?></h3>
                <p class="text-secondary leading-relaxed"><?php echo esc_html( t('home.features.lenis.description') ); ?></p>
            </div>
            <!-- TAILWIND -->
            <div class="bg-white p-10 rounded-2xl shadow-xl shadow-gray-200/50 gsap-card border border-gray-50">
                <div class="w-16 h-16 bg-secondary/10 text-secondary rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="text-2xl font-bold">TW</span>
                </div>
                <h3 class="text-2xl font-bold mb-4"><?php echo esc_html( t('home.features.tailwind.title') ); ?></h3>
                <p class="text-secondary leading-relaxed"><?php echo esc_html( t('home.features.tailwind.description') ); ?></p>
            </div>
        </div>
        
        <div class="mt-16 gsap-reveal">
            <a href="#" class="inline-block bg-primary text-primary-foreground px-10 py-5 rounded-full font-bold text-lg hover:bg-accent hover:text-accent-foreground transition-all duration-300 transform hover:-translate-y-1">
                <?php echo esc_html( t('home.cta') ); ?>
            </a>
        </div>
    </div>
</section>
