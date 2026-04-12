<section class="properties-listing py-20 bg-surface">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="max-w-3xl mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-foreground mb-6 uppercase tracking-tighter">
                <?php echo esc_html( t('pages.properties.title') ); ?>
            </h2>
            <p class="text-xl text-secondary leading-relaxed">
                <?php echo esc_html( t('pages.properties.subtitle') ); ?>
            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php
            $properties = t('pages.properties.items');
            if ( is_array($properties) ) :
                foreach ( $properties as $property ) :
                    $image_url = get_template_directory_uri() . '/assets/images/' . $property['image'] . '.png';
                    ?>
                    <article class="property-card group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full" data-aos="fade-up">
                        <!-- Image Container -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="<?php echo esc_attr($property['title']); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-full shadow-sm">
                                <span class="text-primary font-black text-sm uppercase tracking-widest"><?php echo esc_html($property['price']); ?></span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 flex flex-col flex-1 border-x border-b border-gray-50 rounded-b-3xl">
                            <div class="flex items-center gap-2 mb-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                <svg class="w-3 h-3 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <?php echo esc_html($property['location']); ?>
                            </div>
                            <h3 class="text-2xl font-black text-foreground mb-4 group-hover:text-primary transition-colors uppercase tracking-tight leading-tight">
                                <?php echo esc_html($property['title']); ?>
                            </h3>
                            <p class="text-secondary text-sm leading-relaxed line-clamp-2 mb-8">
                                <?php echo esc_html($property['description']); ?>
                            </p>
                            <div class="mt-auto">
                                <a href="#" class="inline-flex items-center justify-center w-full bg-surface-secondary text-foreground font-black text-xs uppercase tracking-widest py-4 rounded-xl hover:bg-primary hover:text-white transition-all duration-300">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
