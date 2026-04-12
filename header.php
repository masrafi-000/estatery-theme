<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-["Inter"] antialiased'); ?>>
    <?php wp_body_open(); ?>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-drawer" class="fixed inset-0 z-[100] invisible pointer-events-none transition-all duration-500">
        <!-- Overlay -->
        <div id="drawer-overlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-500"></div>
        
        <!-- Drawer Content -->
        <aside id="drawer-content" class="absolute top-0 left-0 h-full w-[85%] max-w-[380px] bg-white shadow-2xl transition-transform duration-500 -translate-x-full flex flex-col">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 no-underline group">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Logo-1.png' ); ?>" 
                         alt="<?php bloginfo( 'name' ); ?>" 
                         class="h-12 w-auto object-contain transition-transform duration-500 group-hover:scale-105">
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
    <header id="masthead" class="site-header bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-[90] transition-all duration-300">        
        <div class="container mx-auto px-4 max-w-[1400px]">
            <div class="flex justify-between items-center h-[72px]">
                
                <!-- Left: Logo -->
                <div class="flex-1 flex justify-start items-center">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 group no-underline">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Logo-1.png' ); ?>" 
                             alt="<?php bloginfo( 'name' ); ?>" 
                             class="h-16 md:h-19 w-auto object-contain transition-transform duration-500 group-hover:scale-105">
                    </a>
                </div>

                <!-- Center: Desktop Navigation -->
                <nav id="site-navigation" class="hidden md:flex flex-[2] justify-center">
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
                                    <span class="absolute bottom-0 left-4 right-4 h-[3px] rounded-full bg-gradient-to-r from-primary to-accent transition-all duration-500 origin-left <?php echo $is_active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'; ?>"></span>
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

    <script>
        // Drawer Logic
        const drawer = document.getElementById('mobile-drawer');
        const content = document.getElementById('drawer-content');
        const overlay = document.getElementById('drawer-overlay');
        const toggle = document.getElementById('mobile-toggle');
        const close = document.getElementById('drawer-close');

        function openDrawer() {
            drawer.classList.remove('invisible', 'pointer-events-none');
            drawer.classList.add('visible');
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
            content.classList.remove('-translate-x-full');
            content.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            content.classList.remove('translate-x-0');
            content.classList.add('-translate-x-full');
            setTimeout(() => {
                drawer.classList.remove('visible');
                drawer.classList.add('invisible');
                drawer.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 500);
        }

        if (toggle) toggle.addEventListener('click', openDrawer);
        if (close) close.addEventListener('click', closeDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);
    </script>
