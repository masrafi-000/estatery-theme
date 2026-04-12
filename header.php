<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header id="masthead" class="site-header bg-white shadow-sm sticky top-0 z-50">        
        <div class="container mx-auto px-4 flex justify-between items-center py-4">
            <div class="site-branding flex items-center gap-6">
                <h1 class="text-2xl font-black text-primary tracking-tighter uppercase leading-none">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Estatery</a>
                </h1>
                <div class="h-6 w-[1px] bg-gray-200 hidden md:block"></div>
                <div class="language-switcher flex items-center">
                    <span class="mr-3 font-medium text-secondary text-[10px] uppercase tracking-widest hidden sm:block"><?php echo esc_html( t('header.language_label') ); ?></span>
                    <?php get_template_part('template-parts/header/language-switcher'); ?>
                </div>
            </div>
            <nav id="site-navigation" class="main-navigation">
                <?php
                if ( has_nav_menu( 'menu-1' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'menu_class'     => 'flex gap-8 font-medium text-foreground hover:text-primary transition-colors uppercase tracking-widest text-xs',
                        )
                    );
                }
                ?>
            </nav>
        </div>
    </header>
