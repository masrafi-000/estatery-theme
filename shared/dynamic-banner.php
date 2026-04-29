<?php
// Receive variables or set defaults
$title    = isset($banner_title) ? $banner_title : "Page Title";
$subtitle = isset($banner_subtitle) ? $banner_subtitle : "Default subtitle text goes here.";
$image    = isset($banner_image) ? $banner_image : "https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg";
$bg_text  = isset($banner_bg_text) ? $banner_bg_text : $title;

// Breadcrumbs logic
$breadcrumbs = isset($banner_breadcrumbs) ? $banner_breadcrumbs : [
    ['label' => 'Home', 'url' => site_url()]
];
?>

<section class="relative min-h-[500px] lg:h-[65vh] w-full flex items-center overflow-hidden bg-[#1a1a1a] py-20 lg:py-0">
    <div class="absolute inset-0 z-0">
        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/65"></div>
    </div>

    <div class="absolute lg:bottom-[-20px] lg:right-[-10px] bottom-0 right-0 z-10 select-none pointer-events-none overflow-hidden max-w-full">
        <h2 class="text-[6rem] md:text-[10rem] lg:text-[14rem] font-serif font-bold text-transparent opacity-10 uppercase whitespace-nowrap js-banner-bg-text"
            style="-webkit-text-stroke: 1.5px white; line-height: 0.9;">
            <?php echo $bg_text; ?>
        </h2>
    </div>

    <div class="container mx-auto px-6 lg:px-12 relative z-20">
        <div class="max-w-4xl space-y-6 js-banner-content">
            <nav class="flex items-center gap-3 text-xs uppercase tracking-widest text-gray-300 mb-6 font-medium js-banner-item">
                <?php foreach ($breadcrumbs as $index => $crumb): ?>
                    <?php if ($index > 0): ?>
                        <span class="opacity-50">/</span>
                    <?php endif; ?>
                    
                    <?php if ($index === count($breadcrumbs) - 1): ?>
                        <span class="text-white"><?php echo esc_html($crumb['label']); ?></span>
                    <?php else: ?>
                        <a href="<?php echo esc_url($crumb['url']); ?>" class="hover:text-secondary transition-colors"><?php echo esc_html($crumb['label']); ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>

            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif text-white font-medium capitalize leading-[1.1] wrap-break-word js-banner-item">
                <?php echo strtolower($title); ?><span class="text-secondary">.</span>
            </h1>

            <p
                class="text-lg md:text-xl text-gray-200 font-light max-w-2xl leading-relaxed border-l-2 border-secondary pl-6 mt-8 js-banner-item">
                <?php echo $subtitle; ?>
            </p>
        </div>
    </div>
</section>