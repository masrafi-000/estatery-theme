<?php
// Receive variables or set defaults
$title    = isset($banner_title) ? $banner_title : "Page Title";
$subtitle = isset($banner_subtitle) ? $banner_subtitle : "Default subtitle text goes here.";
$bg_text  = isset($banner_bg_text) ? $banner_bg_text : $title;

// Handle the header image dynamically from WordPress admin panel
$image = isset($banner_image) ? $banner_image : '';
if ( empty( $image ) || strpos( $image, 'pexels.com' ) !== false || strpos( $image, 'unsplash.com' ) !== false ) {
    if ( has_header_image() ) {
        $image = get_header_image();
    }
}
if ( empty( $image ) ) {
    $image = "https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg";
}

// Breadcrumbs logic
$breadcrumbs = isset($banner_breadcrumbs) ? $banner_breadcrumbs : [
    ['label' => 'Home', 'url' => site_url()]
];
?>

<section
    class="relative min-h-[420px] sm:min-h-[500px] lg:h-[65vh] w-full flex items-center overflow-hidden bg-[#1a1a1a] py-20 sm:py-24 lg:py-0">

    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img
            src="<?php echo esc_url($image); ?>"
            alt="<?php echo esc_attr($title); ?>"
            class="w-full h-full object-cover">

        <div class="absolute inset-0 bg-black/65"></div>
    </div>

    <!-- Background Text -->
    <div
        class="absolute bottom-2 right-0 sm:bottom-0 lg:bottom-[-20px] lg:right-[-10px] z-10 select-none pointer-events-none overflow-hidden max-w-full px-2">

        <h2
            class="text-[3.5rem] sm:text-[4rem] md:text-[6rem] lg:text-[10rem]
                   font-serif font-bold text-transparent opacity-10 uppercase
                   whitespace-nowrap js-banner-bg-text"
            style="-webkit-text-stroke: 1px white; line-height: 0.9;">

            <?php echo esc_html($bg_text); ?>
        </h2>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-12 relative z-20 w-full">

        <div class="max-w-4xl space-y-5 sm:space-y-6 js-banner-content js-reveal-stagger">

            <!-- Breadcrumb -->
            <nav
                class="flex flex-wrap items-center gap-x-2 gap-y-1
                       text-[10px] sm:text-xs uppercase tracking-[0.2em] sm:tracking-widest
                       text-gray-300 mb-4 sm:mb-6 font-medium
                       js-banner-item js-reveal-fade">

                <?php foreach ($breadcrumbs as $index => $crumb): ?>

                    <?php if ($index > 0): ?>
                        <span class="opacity-50">/</span>
                    <?php endif; ?>

                    <?php if ($index === count($breadcrumbs) - 1): ?>

                        <span class="text-white">
                            <?php echo esc_html($crumb['label']); ?>
                        </span>

                    <?php else: ?>

                        <a
                            href="<?php echo esc_url($crumb['url']); ?>"
                            class="hover:text-secondary transition-colors duration-300">

                            <?php echo esc_html($crumb['label']); ?>
                        </a>

                    <?php endif; ?>

                <?php endforeach; ?>
            </nav>

            <!-- Title -->
            <h1
                class="text-3xl sm:text-5xl md:text-5xl lg:text-6xl
                       font-serif text-white font-medium capitalize
                       leading-[1.1] break-words
                       js-banner-item js-reveal-text">

                <?php echo strtolower(esc_html($title)); ?>
                <span class="text-secondary">.</span>
            </h1>

            <!-- Subtitle -->
            <p
                class="text-sm sm:text-base md:text-lg lg:text-xl
                       text-gray-200 font-light
                       max-w-2xl leading-relaxed
                       border-l-2 border-secondary
                       pl-4 sm:pl-6 mt-6 sm:mt-8
                       js-banner-item js-reveal-fade">

                <?php echo esc_html($subtitle); ?>
            </p>

        </div>
    </div>
</section>