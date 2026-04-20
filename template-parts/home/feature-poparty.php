<?php
/**
 * Template Part: Compact Premium Featured Properties Carousel
 * Refactored: Now uses AJAX for high-performance lazy loading of 58MB JSON data.
 */
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
                <div class="swiper-wrapper" id="featured-properties-container">
                    <!-- Skeleton Loaders -->
                    <?php for($i=0; $i<4; $i++): ?>
                    <div class="swiper-slide h-auto">
                        <div class="bg-gray-50 rounded-[1.5rem] h-[450px] w-full animate-pulse border border-gray-100 flex flex-col p-6">
                            <div class="h-48 bg-gray-100 rounded-xl mb-6"></div>
                            <div class="h-6 bg-gray-100 rounded w-3/4 mb-4"></div>
                            <div class="h-4 bg-gray-100 rounded w-1/2 mb-8"></div>
                            <div class="mt-auto flex justify-between">
                                <div class="h-8 bg-gray-100 rounded w-1/3"></div>
                                <div class="h-10 bg-gray-100 rounded-xl w-10"></div>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <div class="swiper-pagination-premium flex justify-center mt-8 gap-2"></div>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="<?php echo esc_url(\Estatery\Core\Translator::getInstance()->resolve_nav_url('/properties')); ?>"
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
        const container = document.getElementById('featured-properties-container');
        if (!container) return;

        function initSwiper() {
            return new Swiper('.propertySlider', {
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
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4, spaceBetween: 24 }
                }
            });
        }

        // Fetch Featured Properties via AJAX
        const lang = "<?php echo \Estatery\Core\Translator::getInstance()->getLang(); ?>";
        const ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";

        const formData = new FormData();
        formData.append('action', 'get_featured_properties');
        formData.append('lang', lang);

        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.success && res.data.html) {
                container.innerHTML = res.data.html;
                // Timeout to ensure DOM is updated before Swiper init
                setTimeout(() => {
                    initSwiper();
                }, 50);
            }
        })
        .catch(err => console.error('Error fetching featured properties:', err));
    });
</script>