<?php
/**
 * Component: Property Card (Rollback Design)
 * @var array $args
 */
$property = $args['property'];
?>
<article class="property-card group bg-white  overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full" data-aos="fade-up">
    <!-- Image Container -->
    <div class="relative h-64 overflow-hidden">
        <img src="<?php echo esc_url($property['image']); ?>" 
             alt="<?php echo esc_attr($property['title']); ?>" 
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s]">
        
        <div class="absolute top-6 left-6 flex flex-col gap-2">
            <?php if ( !empty($property['new_build']) ) : ?>
                <span class="bg-white text-slate-900 text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest shadow-xl border border-slate-100">
                    <?php echo esc_html( t('pages.properties.filters.new_build') ); ?>
                </span>
            <?php elseif ( !empty($property['resale']) ) : ?>
                <span class="bg-slate-900 text-white text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest shadow-xl">
                    <?php echo esc_html( t('pages.properties.filters.resale') ); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="absolute bottom-6 left-2 right-2">
            <div class="bg-white/90 backdrop-blur-md py-3 px-1.5  shadow-lg border border-white/20">
                <div class="flex justify-between items-center gap-2">
                    <div class="text-primary font-black text-base tracking-tighter w-[30%]">
                        <?php echo esc_html($property['price']); ?>
                    </div>
                    <div class="text-end text-xs! text-slate-600! capitalize tracking-widest w-[70%]">
                        <svg class="size-4 text-primary inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <?php echo esc_html($property['location']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="py-4 px-4 flex flex-col flex-1">
        <h3 class="text-2xl font-semibold text-slate-900 mb-2 group-hover:text-primary transition-colors leading-tight">
            <?php echo esc_html($property['title']); ?>
        </h3>
        
        <p class="text-slate-500 text-[13px] leading-relaxed mb-4 line-clamp-2">
            <?php echo esc_html($property['description']); ?>
        </p>

        <div class="grid grid-cols-3 gap-2 py-4 border-y border-slate-50 mb-4 text-center ring-1 ring-slate-50 rounded-2xl">
            <div class="flex flex-col gap-1">
                <span class="text-slate-900 font-black text-sm"><?php echo esc_html($property['beds']); ?></span>
                <span class="text-[9px] text-slate-400 uppercase font-bold tracking-widest"><?php echo esc_html( t('home.featured.beds') ); ?></span>
            </div>
            <div class="flex flex-col gap-1 border-x border-slate-100">
                <span class="text-slate-900 font-black text-sm"><?php echo esc_html($property['baths']); ?></span>
                <span class="text-[9px] text-slate-400 uppercase font-bold tracking-widest"><?php echo esc_html( t('home.featured.baths') ); ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-slate-900 font-black text-sm"><?php echo (int)($property['pool'] ?? 0); ?></span>
                <span class="text-[9px] text-slate-400 uppercase font-bold tracking-widest"><?php echo esc_html( t('home.featured.pool') ?: 'POOL' ); ?></span>
            </div>
        </div>

        <div class="mt-auto">
            <a href="<?php echo esc_url( home_url( '/property-details/?id=' . urlencode($property['id'] ?? '') ) ); ?>" class="flex items-center justify-center gap-3 w-full bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] py-4  hover:bg-primary transition-all duration-300 shadow-xl shadow-slate-900/10 active:scale-[0.98]">
                <?php echo esc_html( t('pages.properties.actions.view_details') ); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</article>
