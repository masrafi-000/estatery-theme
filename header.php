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
            <!-- Left Side: Logo -->
            <div class="site-branding flex-1 flex justify-start">
                <h1 class="text-2xl font-black text-primary tracking-tighter uppercase leading-none">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Estatery</a>
                </h1>
            </div>

            <!-- Middle: Navigation Menu (JSON-Driven) -->
            <nav id="site-navigation" class="main-navigation flex-1 flex justify-center">
                <ul class="flex gap-8 font-bold text-foreground transition-all duration-300 uppercase tracking-widest text-[11px]">
                    <?php
                    $navigation = t('header.navigation');
                    $current_url = home_url(add_query_arg(array(), $wp->request));
                    $current_url = rtrim($current_url, '/');

                    if ( is_array($navigation) ) :
                        foreach ( $navigation as $item ) :
                            $item_url = \Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url']);
                            $item_url = rtrim($item_url, '/');
                            $is_active = ( $current_url === $item_url ) ? 'text-primary' : 'hover:text-primary';
                            ?>
                            <li>
                                <a href="<?php echo esc_url( \Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url']) ); ?>" 
                                   class="<?php echo esc_attr($is_active); ?> transition-colors duration-300">
                                    <?php echo esc_html( $item['label'] ); ?>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </nav>

            <!-- Right Side: Language Switcher -->
            <div class="header-actions flex-1 flex justify-end items-center gap-4">
                <div class="language-switcher flex items-center">
                    <span class="mr-3 font-bold text-secondary text-[10px] uppercase tracking-[0.2em] hidden lg:block"><?php echo esc_html( t('header.language_label') ); ?></span>
                    <?php get_template_part('template-parts/header/language-switcher'); ?>
                </div>
            </div>
        </div>
    </header>
