<?php $leadership = t('pages.about.leadership'); ?>
<section class="relative py-24 bg-white overflow-hidden js-leadership-section">

    <div class="container mx-auto px-6 lg:px-12 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-0">

            <div class="w-full lg:w-5/12 relative group js-leadership-image">
                <div class="absolute -bottom-6 -right-6 w-2/3 h-2/3 border-2 border-secondary z-0 hidden lg:block"></div>

                <div class="relative z-10 rounded-sm overflow-hidden shadow-2xl bg-primary">
                    <img src="<?php echo get_template_directory_uri(); ?>/public/images/about.jpg"
                        alt="<?php echo esc_attr($leadership['name']); ?>"
                        class="w-full h-[550px] object-cover transition-all duration-1000 scale-110 group-hover:scale-100">
                </div>

                <div class="absolute -bottom-10 -left-6 lg:left-[-10%] bg-white p-6 shadow-xl z-20 hidden md:block border-l-4 border-black js-leadership-card">
                    <p class="text-black font-bold text-4xl italic">
                        <span class="js-count-up" data-target="35">0</span>+
                    </p>
                    <p class="text-xs uppercase tracking-widest text-black/60 font-semibold"><?php echo esc_html($leadership['years_label']); ?></p>
                </div>
            </div>

            <div class="w-full lg:w-7/12 lg:pl-24 space-y-8 js-leadership-content">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-black/5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-black animate-pulse"></span>
                        <span class="text-primary font-bold uppercase tracking-widest text-[10px]"><?php echo esc_html($leadership['badge']); ?></span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-secondary tracking-tight leading-[1.1]">
                        <?php echo $leadership['title']; ?>
                    </h2>
                </div>

                <div class="relative">
                    <div class="absolute -left-6 top-0 w-1 h-full bg-primary/20"></div>
                    <p class="text-base md:text-lg text-black leading-relaxed  pl-2">
                        <?php echo wp_kses_post($leadership['message']); ?>
                    </p>
                </div>

                <div class="pt-6">
                    <h4 class="text-2xl font-bold text-secondary mb-1"><?php echo esc_html($leadership['name']); ?></h4>
                    <p class="text-primary font-bold uppercase tracking-[0.2em] text-xs"><?php echo esc_html($leadership['role']); ?></p>
                </div>
            </div>

        </div>
    </div>
</section>
