<script src="https://unpkg.com/lucide@latest"></script>

<?php
// Video Handling
$video_id    = get_theme_mod('hero_video_file');
$video_url   = $video_id ? wp_get_attachment_url($video_id) : get_template_directory_uri() . '/assets/images/hero-video.mp4';
?>

<section class="relative min-h-[100vh] flex items-center justify-center overflow-hidden bg-[#0a1d23]">

    <div id="hero-bg-container" class="absolute inset-0 z-0">
        <div class="absolute inset-0 z-10 bg-gradient-to-b from-[#0a1d23]/80 via-transparent to-[#0a1d23]"></div>
        <video id="hero-video" autoplay muted loop playsinline preload="auto"
            class="absolute top-1/2 left-1/2 min-w-full min-h-full w-auto h-auto -translate-x-1/2 -translate-y-1/2 object-cover">
            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="container mx-auto px-4 relative z-20 text-center text-white js-reveal-stagger">
        <span
            class="js-reveal-fade inline-block text-xs md:text-sm font-semibold mt-12 md:mt-0 mb-4 tracking-[0.2em] uppercase opacity-90 border-b border-primary pb-1">
            <?php echo esc_html( t('home.hero.agency_label') ); ?>
        </span>

        <h1 class="js-reveal-text text-4xl md:text-6xl lg:text-7xl font-serif font-bold mb-6 tracking-tight leading-[1.1]">
            <?php echo t('home.hero.title'); ?>
        </h1>

        <p class="js-reveal-fade text-gray-200 text-sm md:text-lg mb-12 leading-relaxed opacity-90 max-w-2xl mx-auto">
            <?php echo esc_html( t('home.hero.description') ); ?>
        </p>

        <div class="js-reveal-fade max-w-6xl mx-auto mb-12 md:mb-0">

            <div
                class="bg-white/95 backdrop-blur-md rounded-2xl lg:rounded-b-2xl lg:rounded-tr-none shadow-2xl p-6 lg:p-8">
                <form action="<?php echo esc_url( \Estatery\Core\Translator::getInstance()->resolve_nav_url('properties') ); ?>" method="get"
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 items-end">

                    <div class="flex flex-col gap-2 text-left text-slate-900">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">
                            <?php echo esc_html( t('home.hero.form.search_label') ); ?>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <i data-lucide="search"
                                    class="w-4 h-4 text-slate-400 group-focus-within:text-primary transition-colors"></i>
                            </div>
                            <input type="text" name="search" placeholder="<?php echo esc_attr( t('home.hero.form.search_placeholder') ); ?>"
                                class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all placeholder:text-slate-400">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 text-left text-slate-900">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">
                            <?php echo esc_html( t('pages.properties.filters.type') ); ?>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <i data-lucide="home"
                                    class="w-4 h-4 text-slate-400 group-focus-within:text-primary transition-colors"></i>
                            </div>
                            <select name="types"
                                class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none cursor-pointer appearance-none transition-all">
                                <option value=""><?php echo esc_html( t('pages.properties.filters.any') ); ?></option>
                                <option value="apartment"><?php echo esc_html( t('home.hero.form.property_types.apartment') ); ?></option>
                                <option value="luxury"><?php echo esc_html( t('home.hero.form.property_types.luxury') ); ?></option>
                                <option value="villa"><?php echo esc_html( t('home.hero.form.property_types.villa') ); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 text-left text-slate-900">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">
                            <?php echo esc_html( t('pages.properties.filters.beds') ); ?>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <i data-lucide="bed"
                                    class="w-4 h-4 text-slate-400 group-focus-within:text-primary transition-colors"></i>
                            </div>
                            <select name="beds"
                                class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none cursor-pointer appearance-none transition-all">
                                <option value=""><?php echo esc_html( t('pages.properties.filters.any') ); ?></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4+</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 text-left text-slate-900">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">
                            <?php echo esc_html( t('pages.properties.filters.baths') ); ?>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <i data-lucide="bath"
                                    class="w-4 h-4 text-slate-400 group-focus-within:text-primary transition-colors"></i>
                            </div>
                            <select name="baths"
                                class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none cursor-pointer appearance-none transition-all">
                                <option value=""><?php echo esc_html( t('pages.properties.filters.any') ); ?></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4+</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full h-[56px] bg-[#0a1d23] text-white rounded-xl font-bold hover:bg-primary hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/10">
                        <i data-lucide="search" class="w-5 h-5"></i>
                        <?php echo esc_html( t('home.hero.form.search_button') ); ?>
                    </button>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            const video = document.getElementById('hero-video');
            if (video) {
                video.muted = true;
                video.play().catch(() => {
                    const playOnInteraction = () => {
                        video.play();
                        ['click', 'touchstart'].forEach(ev => window.removeEventListener(ev,
                            playOnInteraction));
                    };
                    ['click', 'touchstart'].forEach(ev => window.addEventListener(ev, playOnInteraction));
                });
            }

        });
    </script>
</section>