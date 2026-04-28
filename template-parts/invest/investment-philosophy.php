<?php $philosophy = t('pages.invest.philosophy'); ?>

<section class="py-24 bg-white border-b border-secondary/5 js-philosophy-section">
    <div class="container mx-auto px-6 lg:px-12">

        <div class="max-w-4xl mb-10 mx-auto text-center js-philosophy-header">
            <div class="inline-flex items-center gap-4 mb-6 justify-center">
                <div class="w-10 h-[1px] bg-secondary/30"></div>
                <span class="text-secondary font-bold uppercase tracking-[0.3em] text-xs">
                    <?php echo esc_html($philosophy['badge']); ?>
                </span>
                <div class="w-10 h-[1px] bg-secondary/30"></div>
            </div>

            <h2 class="text-3xl md:text-4xl font-black text-secondary mb-4 leading-tight">
                <?php echo $philosophy['title']; ?>
            </h2>
        </div>

        <div class="flex flex-col lg:flex-row border border-secondary/10 overflow-hidden">

            <div class="w-full lg:w-1/2 p-2 border-r border-secondary/10 js-philosophy-image-wrap">
                <div class="relative h-full min-h-[400px] overflow-hidden group">
                    <img src="https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg?auto=compress&cs=tinysrgb&w=1200"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 js-philosophy-img"
                        alt="<?php echo esc_attr($philosophy['focus_area_title']); ?>">
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-secondary/80 to-transparent">
                        <p class="text-white text-xs font-mono uppercase tracking-widest opacity-70"><?php echo esc_html($philosophy['focus_area_label']); ?></p>
                        <h4 class="text-white text-lg font-bold"><?php echo esc_html($philosophy['focus_area_title']); ?></h4>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col js-philosophy-content">
                <div class="p-8 md:p-16 border-b border-secondary/10 js-philosophy-text">
                    <p class="text-secondary text-lg leading-relaxed mb-8 font-medium">
                        <?php echo esc_html($philosophy['description']); ?>
                    </p>
                    <p class="text-secondary">
                        <?php echo esc_html($philosophy['quote']); ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 flex-grow js-philosophy-grid">
                    <?php foreach ($philosophy['items'] as $item) : ?>
                        <div class="p-8 md:p-12 border-r border-secondary/10 last:border-r-0 group hover:bg-secondary/[0.02] transition-colors js-philosophy-item">
                            <span class="text-secondary/20 font-black text-2xl block mb-4"><?php echo esc_html($item['id']); ?></span>
                            <h4 class="text-secondary font-bold uppercase tracking-widest text-xs mb-3"><?php echo esc_html($item['title']); ?></h4>
                            <p class="text-secondary text-[13px] leading-relaxed">
                                <?php echo esc_html($item['description']); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>

