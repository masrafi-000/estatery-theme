<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jost:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-["Inter"] antialiased'); ?>>
    <?php wp_body_open(); ?>

    <!-- Premium Page Transition Overlay -->
    <div id="page-loader" class="fixed inset-0 z-10000 bg-gray-50 flex items-center justify-center pointer-events-auto">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 w-full h-1 bg-white overflow-hidden">
            <div id="loader-progress" class="h-full bg-primary w-0 transition-all duration-300 ease-out"></div>
        </div>
        
        <!-- Logo & Spinner -->
        <div class="relative flex flex-col items-center gap-8">
            <div class="relative max-w-60 max-h-40  flex items-center justify-center">
                <!-- Decorative Ring -->
                <div class="absolute inset-0 border border-white/10 rounded-full scale-150 animate-[ping_3s_infinite]"></div>
                
                <!-- Logo Image (Styled for Loader) -->
                <img src="<?php echo esc_url( get_template_directory_uri() . '/public/images/logo-ll.png' ); ?>" 
                     alt="Loading..." 
                     class="w-full h-auto object-contain opacity-100 scale-150">
            </div>
            
            <div class="flex flex-col items-center gap-3">
                <div class="flex gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-bounce [animation-delay:-0.3s]"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-bounce [animation-delay:-0.15s]"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-bounce"></span>
                </div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-gray-600 font-bold ml-1">Capital Union Investments</span>
            </div>
        </div>
    </div>

    <script>
        // Progress bar simulation
        (function() {
            var progress = document.getElementById('loader-progress');
            if (progress) {
                var width = 0;
                var interval = setInterval(function() {
                    if (width >= 90) clearInterval(interval);
                    width += Math.random() * 5;
                    progress.style.width = Math.min(width, 95) + '%';
                }, 200);
            }
        })();
    </script>


    <!-- Mobile Navigation Drawer -->
    <div id="mobile-drawer" class="fixed inset-0 z-100 invisible pointer-events-none transition-all duration-500">
        <!-- Overlay -->
        <div id="drawer-overlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-500"></div>
        
        <!-- Drawer Content -->
        <aside id="drawer-content" class="absolute top-0 left-0 h-full w-[85%] max-w-[380px] bg-white shadow-2xl transition-transform duration-500 -translate-x-full flex flex-col">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <a href="<?php echo esc_url( \Estatery\Core\Translator::getInstance()->resolve_nav_url('/') ); ?>" class="flex items-center gap-3 no-underline group">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/public/images/logo-ll.png' ); ?>" 
                         alt="<?php bloginfo( 'name' ); ?>" 
                         class="h-6.5 w-auto object-contain scale-[1.8] origin-left transition-transform duration-500">
                </a>
                <button id="drawer-close" class="p-2 text-gray-400 hover:text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Mobile Nav Links -->
            <nav class="flex-1 p-6 overflow-y-auto">
                <ul class="space-y-4">
                    <?php
                    $navigation = t('header.navigation');
                    if ( is_array($navigation) ) :
                        foreach ( $navigation as $item ) :
                            $item_url = \Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url']);
                            ?>
                            <li>
                                <a href="<?php echo esc_url( $item_url ); ?>" class="block px-6 py-4 rounded-xl border border-gray-50 text-secondary font-bold hover:bg-primary/5 hover:text-primary hover:border-primary/20 transition-all duration-300 uppercase tracking-widest text-[11px] no-underline">
                                    <?php echo esc_html( $item['label'] ); ?>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </nav>
        </aside>
    </div>

    <!-- Sticky Header -->
    <header id="masthead" class="site-header bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-90 transition-all duration-300">        
        <!-- Scroll Progress Bar -->
        <div class="absolute top-0 left-0 w-full h-[2px] bg-gray-100 overflow-hidden pointer-events-none">
            <div id="scroll-progress" class="h-full bg-primary origin-left scale-x-0"></div>
        </div>

        <div class="container mx-auto px-4 max-w-[1400px]">
            <div class="flex justify-between items-center h-[72px]">
                
                <!-- Left: Logo -->
                <div class="flex-1 flex justify-start items-center">
                    <a href="<?php echo esc_url( \Estatery\Core\Translator::getInstance()->resolve_nav_url('/') ); ?>" class="flex items-center gap-3 group no-underline">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/public/images/logo-ll.png' ); ?>" 
                             alt="<?php bloginfo( 'name' ); ?>" 
                             class="h-5 md:h-6 w-auto object-contain scale-[2] md:scale-[3] origin-left transition-transform duration-500 max-w-none">
                    </a>
                </div>

                <!-- Center: Desktop Navigation -->
                <nav id="site-navigation" class="hidden md:flex flex-2 justify-center">
                    <ul class="flex gap-1 items-center">
                        <?php
                        $navigation = t('header.navigation');
                        $current_url = rtrim(home_url(add_query_arg(array(), $wp->request)), '/');

                        if ( is_array($navigation) ) :
                            foreach ( $navigation as $item ) :
                                $item_url = rtrim(\Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url']), '/');
                                $is_active = ( $current_url === $item_url );
                                ?>
                                <li class="relative group">
                                    <a href="<?php echo esc_url( \Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url']) ); ?>" 
                                       class="px-4 py-2 block text-secondary font-bold text-[11px] uppercase tracking-[0.15em] no-underline transition-all duration-500 <?php echo $is_active ? 'text-primary' : 'group-hover:text-primary'; ?>">
                                        <?php echo esc_html( $item['label'] ); ?>
                                    </a>
                                    <!-- Animated Underline -->
                                    <span class="absolute bottom-0 left-4 right-4 h-[3px] rounded-full bg-linear-to-r from-primary to-accent transition-all duration-500 origin-left <?php echo $is_active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'; ?>"></span>
                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </nav>

                <!-- Right: Actions & Language -->
                <div class="flex-1 flex justify-end items-center gap-6">
                    <!-- Language Switcher Component -->
                    <?php get_template_part('template-parts/header/language-switcher'); ?>

                    <!-- Mobile Toggle -->
                    <button id="mobile-toggle" class="md:hidden p-2 rounded-xl border-2 border-gray-100 text-foreground hover:border-primary hover:text-primary transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>

            </div>
        </div>
    </header>

