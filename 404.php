<?php
/**
 * The template for displaying 404 pages (not found)
 * Designed with a modern, classic aesthetic and GSAP animation hooks.
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404-section relative overflow-hidden bg-white min-h-[85vh] flex items-center justify-center py-20">
        
        <!-- Background 404 Text for Parallax/Movement -->
        <div class="error-bg-text absolute inset-0 flex items-center justify-center z-0 pointer-events-none select-none overflow-hidden">
            <h1 id="js-404-parallax" class="text-[clamp(150px,40vw,600px)] font-black text-gray-100/40 leading-none tracking-tighter transition-transform duration-700 ease-out">
                <?php echo esc_html( t('pages.error_404.bg_text') ); ?>
            </h1>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <div class="max-w-3xl mx-auto">
                
                <!-- Modern Visual Element -->
                <div class="js-reveal-fade inline-flex items-center justify-center w-24 h-24 bg-primary/10 text-primary rounded-[2.5rem] mb-10 shadow-inner group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-12 transition-transform duration-500">
                        <circle cx="12" cy="12" r="10"/><path d="m16 12-4-4-4 4"/><path d="M12 16V8"/>
                    </svg>
                </div>

                <h2 class="js-reveal-text text-4xl md:text-5xl lg:text-7xl font-bold text-secondary mb-6 leading-[1.1] tracking-tight">
                    <?php echo esc_html( t('pages.error_404.subtitle') ); ?>
                </h2>

                <p class="js-reveal-fade text-lg md:text-xl text-gray-500 mb-12 leading-relaxed max-w-2xl mx-auto">
                    <?php echo esc_html( t('pages.error_404.message') ); ?>
                    <span class="block mt-3 px-4 py-2 bg-gray-50 rounded-lg italic text-primary break-all border border-gray-100 inline-block font-medium">
                        <?php echo esc_html( home_url( $_SERVER['REQUEST_URI'] ) ); ?>
                    </span>
                </p>

                <!-- Premium Search Integration -->
                <div class="js-reveal-fade max-w-xl mx-auto mb-16 px-2">
                    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="relative group">
                        <input type="text" name="s"
                               placeholder="<?php echo esc_attr( t('pages.error_404.search_placeholder') ); ?>"
                               class="w-full pl-16 pr-6 py-6 bg-white border-2 border-gray-100 focus:border-primary/30 rounded-[2.5rem] text-secondary text-lg shadow-xl shadow-gray-200/50 transition-all duration-500 outline-none">
                        
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                            </svg>
                        </span>

                        <button type="submit" class="absolute right-3 top-3 bottom-3 px-8 bg-secondary text-white rounded-[2rem] font-bold hover:bg-primary transition-all duration-300 hover:shadow-lg hover:shadow-primary/25 active:scale-95 flex items-center justify-center gap-2">
                            <span class="hidden sm:inline"><?php echo esc_html( t('home.hero.form.search_button') ); ?></span>
                            <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.3-4.3M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path></svg>
                        </button>
                    </form>
                </div>

                <!-- Strategic Navigation -->
                <div class="js-reveal-fade flex flex-wrap items-center justify-center gap-6">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       class="group relative px-12 py-5 bg-secondary text-white font-bold rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-secondary/20 active:scale-95">
                        <span class="relative z-10"><?php echo esc_html( t('pages.error_404.back_home') ); ?></span>
                        <div class="absolute inset-0 bg-primary translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                    
                    <a href="<?php echo esc_url( \Estatery\Core\Translator::getInstance()->resolve_nav_url('/properties') ); ?>"
                       class="px-12 py-5 bg-white border-2 border-gray-200 text-secondary font-bold rounded-2xl hover:border-primary/40 hover:text-primary transition-all duration-300 hover:shadow-xl hover:shadow-gray-100 hover:-translate-y-1 active:scale-95">
                        <?php echo esc_html( t('pages.error_404.view_properties') ); ?>
                    </a>
                </div>

            </div>
        </div>

        <!-- Abstract Decorative Shapes -->
        <div class="error-shape absolute -top-20 -right-20 w-80 h-80 bg-primary/5 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="error-shape absolute -bottom-20 -left-20 w-80 h-80 bg-accent/5 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
    </section>
</main>

<?php
get_footer();
