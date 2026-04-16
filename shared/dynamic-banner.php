<?php
// Receive variables or set defaults
$title    = isset($banner_title) ? $banner_title : "Page Title";
$subtitle = isset($banner_subtitle) ? $banner_subtitle : "Default subtitle text goes here.";
$image    = isset($banner_image) ? $banner_image : "https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg";
$bg_text  = isset($banner_bg_text) ? $banner_bg_text : $title;
?>

<section class="relative h-[60vh] min-h-[400px] w-full flex items-center overflow-hidden bg-[#1a1a1a]">
    <div class="absolute inset-0 z-0">
        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="absolute bottom-[-20px] right-[-10px] z-10 select-none hidden lg:block">
        <h2 class="text-[12rem] font-serif font-bold text-transparent opacity-20 uppercase"
            style="-webkit-text-stroke: 2px white; line-height: 1;">
            <?php echo $bg_text; ?>
        </h2>
    </div>

    <div class="container mx-auto px-6 lg:px-12 relative z-20">
        <div class="max-w-2xl space-y-4">
            <nav class="flex items-center gap-2 text-xs uppercase tracking-widest text-gray-400 mb-4">
                <a href="<?php echo site_url(); ?>" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <span class="text-white"><?php echo $title; ?></span>
            </nav>

            <h1 class="text-6xl md:text-8xl font-serif text-white font-medium capitalize leading-tight">
                <?php echo strtolower($title); ?><span class="text-secondary">.</span>
            </h1>

            <p
                class="text-lg md:text-xl text-gray-200 font-light max-w-lg leading-relaxed border-l-2 border-primary pl-6">
                <?php echo $subtitle; ?>
            </p>
        </div>
    </div>
</section>