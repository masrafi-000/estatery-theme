<?php

/**
 * Template Part: Compact Premium Featured Properties Carousel
 * Show 4 cards per row on large screens
 */

$properties = [
    ['title' => 'Spacious Loft', 'location' => 'Los Angeles, CA', 'price' => '$2,500/mo', 'beds' => 1, 'baths' => 1, 'sqft' => 1200, 'type' => 'Rent', 'featured' => true, 'slug' => 'spacious-loft', 'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1200'],
    ['title' => 'Modern Luxury Villa', 'location' => 'Miami Beach, FL', 'price' => '$1.2M', 'beds' => 5, 'baths' => 4, 'sqft' => 4500, 'type' => 'Buy', 'featured' => true, 'slug' => 'luxury-villa', 'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?q=80&w=1200'],
    ['title' => 'Downtown Apartment', 'location' => 'New York, NY', 'price' => '$3,800/mo', 'beds' => 2, 'baths' => 2, 'sqft' => 1100, 'type' => 'Rent', 'featured' => false, 'slug' => 'downtown-apt', 'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80&w=1200'],
    ['title' => 'Skyline Penthouse', 'location' => 'Chicago, IL', 'price' => '$2.5M', 'beds' => 4, 'baths' => 3, 'sqft' => 3200, 'type' => 'Buy', 'featured' => true, 'slug' => 'skyline-penthouse', 'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1200'],
    ['title' => 'Garden Cottage', 'location' => 'Austin, TX', 'price' => '$550K', 'beds' => 3, 'baths' => 2, 'sqft' => 1800, 'type' => 'Buy', 'featured' => false, 'slug' => 'garden-cottage', 'image' => 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?q=80&w=1200'],
];
?>


<style>
    .prop-carousel-wrapper a {
        text-decoration: none !important;
    }

    .prop-carousel-wrapper .custom-dot {
        width: 8px !important;
        height: 8px !important;
        background: #cbd5e1 !important;
        opacity: 1 !important;
        border-radius: 50px !important;
        transition: all 0.3s ease !important;
    }

    .prop-carousel-wrapper .swiper-pagination-bullet-active {
        background: #3b82f6 !important;
        width: 25px !important;
    }

    .property-card:hover .img-zoom {
        transform: scale(1.1);
    }
</style>

<section class="prop-carousel-wrapper py-20 bg-[#fcfdfe]">
    <div class="container mx-auto px-4">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-primary font-bold tracking-[0.2em] uppercase text-[10px] mb-2 inline-block"><?php echo esc_html( t('home.featured.label') ); ?></span>
            <h2 class="text-3xl md:text-4xl font-black text-secondary mb-4 leading-tight"><?php echo esc_html( t('home.featured.title') ); ?></h2>
            <div class="w-12 h-1 bg-primary mx-auto mb-4 rounded-full"></div>
            <p class="text-slate-500 text-base leading-relaxed"><?php echo esc_html( t('home.featured.description') ); ?></p>
        </div>

        <div class="relative group">
            <div class="swiper propertySlider pb-12">
                <div class="swiper-wrapper">
                    <?php foreach ($properties as $property) : ?>
                        <div class="swiper-slide h-auto">
                            <div
                                class="property-card bg-white rounded-[1.5rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 h-full flex flex-col group">

                                <div class="relative h-48 overflow-hidden">
                                    <img src="<?php echo $property['image']; ?>"
                                        class="img-zoom w-full h-full object-cover transition-transform duration-[1.5s]"
                                        alt="<?php echo $property['title']; ?>">
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="bg-primary text-white text-[9px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">
                                            <?php 
                                                // Dynamic translation for Buy/Rent types
                                                $type_key = 'home.hero.tabs.' . strtolower($property['type']);
                                                echo esc_html( t($type_key) ?: $property['type'] ); 
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="text-lg font-bold text-slate-900 mb-2 truncate">
                                        <a href="<?php echo home_url('/property/' . $property['slug']); ?>"
                                            class="text-inherit hover:text-primary transition-colors">
                                            <?php echo $property['title']; ?>
                                        </a>
                                    </h3>

                                    <div class="flex items-center text-slate-400 text-xs font-medium mb-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" class="mr-1 text-primary">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span class="truncate"><?php echo $property['location']; ?></span>
                                    </div>

                                    <div class="grid grid-cols-3 gap-2 py-4 border-y border-slate-50 mb-5 text-center">
                                        <div>
                                            <span
                                                class="block text-slate-900 font-black text-xs"><?php echo $property['beds']; ?></span>
                                            <span class="text-[9px] text-slate-400 uppercase font-bold"><?php echo esc_html( t('home.featured.beds') ); ?></span>
                                        </div>
                                        <div class="border-x border-slate-50">
                                            <span
                                                class="block text-slate-900 font-black text-xs"><?php echo $property['baths']; ?></span>
                                            <span class="text-[9px] text-slate-400 uppercase font-bold"><?php echo esc_html( t('home.featured.baths') ); ?></span>
                                        </div>
                                        <div>
                                            <span
                                                class="block text-slate-900 font-black text-xs"><?php echo number_format($property['sqft']); ?></span>
                                            <span class="text-[9px] text-slate-400 uppercase font-bold"><?php echo esc_html( t('home.featured.sqft') ); ?></span>
                                        </div>
                                    </div>

                                    <div class="mt-auto flex justify-between items-center">
                                        <span
                                            class="text-primary font-black text-lg tracking-tighter"><?php echo $property['price']; ?></span>
                                        <a href="<?php echo home_url('/property/' . $property['slug']); ?>"
                                            class="p-2.5 bg-slate-900 text-white rounded-xl hover:bg-primary transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination-premium flex justify-center mt-8 gap-2"></div>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="<?php echo home_url('properties'); ?>"
                class="inline-flex items-center gap-3 bg-primary text-white font-black px-6 py-3 rounded-2xl hover:bg-slate-900 transition-all duration-500 shadow-xl shadow-primary/20 group text-xs">
                <?php echo esc_html( t('home.featured.view_all') ); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" class="transition-transform group-hover:translate-x-1">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.propertySlider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination-premium',
                clickable: true,
                renderBullet: function(index, className) {
                    return `<span class="${className} custom-dot"></span>`;
                }
            },
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 24
                } // 4 Cards on Desktop
            }
        });
    });
</script>