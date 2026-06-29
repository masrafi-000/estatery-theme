<?php
// Dynamic logo management
$preloader_logo_url = get_theme_mod('preloader_logo');
if (empty($preloader_logo_url)) {
    $preloader_logo_url = get_template_directory_uri() . '/public/images/logo.png';
}

$header_logo_url = get_theme_mod('header_logo');
if (empty($header_logo_url) && has_custom_logo()) {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_data = wp_get_attachment_image_src($custom_logo_id, 'full');
    if (! empty($logo_data)) {
        $header_logo_url = $logo_data[0];
    }
}
if (empty($header_logo_url)) {
    $header_logo_url = get_template_directory_uri() . '/public/images/logo.png';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jost:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <?php
    // Localized SEO Meta Tags Integration
    $seo_title = '';
    $seo_desc = '';
    $seo_keywords = '';

    if (is_front_page() || is_home()) {
        $seo_title    = t('seo.home.title');
        $seo_desc     = t('seo.home.description');
        $seo_keywords = t('seo.home.keywords');
    } elseif (is_page_template('page-about.php') || is_page('about')) {
        $seo_title    = t('seo.about.title');
        $seo_desc     = t('seo.about.description');
        $seo_keywords = t('seo.about.keywords');
    } elseif (is_page_template('page-privacy-policy.php') || is_page('privacy-policy')) {
        $seo_title    = t('seo.privacy_policy.title');
        $seo_desc     = t('seo.privacy_policy.description');
        $seo_keywords = t('seo.privacy_policy.keywords');
    } elseif (is_page_template('page-cookie-policy.php') || is_page('cookie-policy')) {
        $seo_title    = t('seo.cookie_policy.title');
        $seo_desc     = t('seo.cookie_policy.description');
        $seo_keywords = t('seo.cookie_policy.keywords');
    } elseif (is_page_template('page-blog.php') || is_page('blog')) {
        $seo_title    = t('seo.blog.title');
        $seo_desc     = t('seo.blog.description');
        $seo_keywords = t('seo.blog.keywords');
    } elseif (is_page_template('page-contact.php') || is_page('contact')) {
        $seo_title    = t('seo.contact.title');
        $seo_desc     = t('seo.contact.description');
        $seo_keywords = t('seo.contact.keywords');
    } elseif (is_page_template('page-invest.php') || is_page('invest')) {
        $seo_title    = t('seo.invest.title');
        $seo_desc     = t('seo.invest.description');
        $seo_keywords = t('seo.invest.keywords');
    } elseif (is_page_template('page-properties.php') || is_page('properties')) {
        $seo_title    = t('seo.properties.title');
        $seo_desc     = t('seo.properties.description');
        $seo_keywords = t('seo.properties.keywords');
    } elseif (is_page_template('page-terms-of-service.php') || is_page('terms-of-service')) {
        $seo_title    = t('seo.terms_of_service.title');
        $seo_desc     = t('seo.terms_of_service.description');
        $seo_keywords = t('seo.terms_of_service.keywords');
    } elseif (is_page_template('page-property-details.php') || is_page('property-details') || is_page_template('page-investment-details.php') || is_page('investment-details')) {
        $property_id = $_GET['id'] ?? '';
        $property_data = null;
        if ($property_id) {
            $json_file = get_template_directory() . '/data/properties.json';
            if (file_exists($json_file)) {
                $json_data = file_get_contents($json_file);
                $parsed_data = json_decode($json_data, true);
                $raw_properties = $parsed_data['root']['property'] ?? [];
                foreach ($raw_properties as $prop) {
                    if (($prop['id'][0] ?? '') == $property_id) {
                        $property_data = $prop;
                        break;
                    }
                }
            }
            if (! $property_data && is_numeric($property_id)) {
                $property_data = \Estatery\Core\PropertyCPT::to_kyero_array(intval($property_id));
            }
        }
        if ($property_data) {
            $raw_type = strtolower($property_data['type'][0] ?? 'property');
            $translated_type = t("pages.properties.meta.{$raw_type}") ?: ucfirst($raw_type);
            $seo_title = !empty($property_data['title'][0]) ? $property_data['title'][0] : ($translated_type . ' ' . (!empty($property_data['town'][0]) ? $property_data['town'][0] : ''));

            $beds = $property_data['beds'][0] ?? '';
            $baths = $property_data['baths'][0] ?? '';
            $price = !empty($property_data['price'][0]) ? number_format(intval($property_data['price'][0])) : '';
            $town = $property_data['town'][0] ?? '';
            $desc_parts = [];
            if ($beds) $desc_parts[] = "$beds " . (t('home.featured.beds') ?: 'beds');
            if ($baths) $desc_parts[] = "$baths " . (t('home.featured.baths') ?: 'baths');
            if ($town) $desc_parts[] = "in $town";
            if ($price) $desc_parts[] = "for €$price";

            $seo_desc = implode(' ', $desc_parts);
            if (empty($seo_desc)) {
                $seo_desc = t('pages.property_details.subtitle');
            } else {
                $seo_desc = ucfirst($seo_desc) . ". " . t('brand.tagline');
            }

            $seo_keywords = implode(', ', array_filter([$raw_type, $town, 'spain real estate', 'costa blanca']));
        }
    }

    // Default Fallbacks
    if (empty($seo_title) || strpos($seo_title, 'seo.') === 0) {
        $seo_title = wp_title('|', false, 'right') . get_bloginfo('name');
    }
    if (empty($seo_desc) || strpos($seo_desc, 'seo.') === 0) {
        $seo_desc = get_bloginfo('description');
    }
    ?>

    <meta name="description" content="<?php echo esc_attr($seo_desc); ?>">
    <?php if (!empty($seo_keywords) && strpos($seo_keywords, 'seo.') !== 0) : ?>
        <meta name="keywords" content="<?php echo esc_attr($seo_keywords); ?>">
    <?php endif; ?>

    <!-- Open Graph / Facebook SEO -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url(home_url($_SERVER['REQUEST_URI'] ?? '')); ?>">
    <meta property="og:title" content="<?php echo esc_attr($seo_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($seo_desc); ?>">
    <meta property="og:image" content="<?php echo esc_url(get_theme_mod('header_logo') ?: (get_template_directory_uri() . '/public/images/logo.png')); ?>">

    <!-- Twitter SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo esc_url(home_url($_SERVER['REQUEST_URI'] ?? '')); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr($seo_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($seo_desc); ?>">
    <meta name="twitter:image" content="<?php echo esc_url(get_theme_mod('header_logo') ?: (get_template_directory_uri() . '/public/images/logo.png')); ?>">

    <style>
        #top-bar {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out, padding 0.3s ease-in-out;
            overflow: hidden;
            max-height: 100px;
        }
        .header-scrolled #top-bar {
            max-height: 0 !important;
            opacity: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            border-bottom-width: 0 !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const masthead = document.getElementById('masthead');
            if (masthead) {
                const handleScroll = function() {
                    if (window.scrollY > 20) {
                        masthead.classList.add('header-scrolled');
                    } else {
                        masthead.classList.remove('header-scrolled');
                    }
                };
                window.addEventListener('scroll', handleScroll, { passive: true });
                handleScroll(); // Initial check
            }
        });
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class('font-["Inter"] antialiased'); ?>>
    <?php wp_body_open(); ?>

    <!-- Premium Page Transition Overlay -->
    <div id="page-loader"
        class="fixed inset-0 z-[10000] bg-gray-50 flex items-center justify-center overflow-hidden px-4">

        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 w-full h-[3px] sm:h-1 bg-white overflow-hidden">
            <div id="loader-progress"
                class="h-full bg-primary w-0 transition-all duration-300 ease-out">
            </div>
        </div>

        <!-- Loader Content -->
        <div class="relative flex flex-col items-center justify-center gap-6 sm:gap-8 text-center">

            <!-- Logo Wrapper -->
            <div
                class="relative w-[140px] xs:w-[160px] sm:w-[200px] md:w-[240px] lg:w-[280px] aspect-[3/2] flex items-center justify-center">

                <!-- Decorative Ring -->
                <div
                    class="absolute inset-0 border border-white/10 rounded-full scale-125 sm:scale-140 md:scale-150 animate-[ping_3s_infinite]">
                </div>

                <!-- Logo -->
                <img
                    src="<?php echo esc_url($preloader_logo_url); ?>"
                    alt="Loading..."
                    class="w-full h-full object-contain scale-110 sm:scale-125 md:scale-140 lg:scale-150 select-none">
            </div>

            <!-- Bottom Content -->
            <div class="flex flex-col items-center gap-3">

                <!-- Animated Dots -->
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <span
                        class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-primary animate-bounce [animation-delay:-0.3s]"></span>

                    <span
                        class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-primary animate-bounce [animation-delay:-0.15s]"></span>

                    <span
                        class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-primary animate-bounce"></span>
                </div>

                <!-- Company Name -->
                <span
                    class="max-w-[90vw] text-[8px] xs:text-[9px] sm:text-[10px] md:text-xs uppercase tracking-[0.2em] sm:tracking-[0.35em] md:tracking-[0.4em] text-gray-600 font-bold leading-relaxed break-words">
                    Capital Union Investments
                </span>
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
                <a href="<?php echo esc_url(\Estatery\Core\Translator::getInstance()->resolve_nav_url('/')); ?>" class="flex items-center gap-3 no-underline group">
                    <img src="<?php echo esc_url($header_logo_url); ?>"
                        alt="<?php bloginfo('name'); ?>"
                        class="h-8 w-auto object-contain scale-[1.8] origin-left transition-transform duration-500">
                </a>
                <button id="drawer-close" class="p-2 text-gray-400 hover:text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Nav Links -->
            <nav class="flex-1 p-6 overflow-y-auto">
                <ul class="space-y-4">
                    <?php
                    $navigation = t('header.navigation');
                    if (is_array($navigation)) :
                        foreach ($navigation as $item) :
                            $item_url = \Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url']);
                    ?>
                            <li>
                                <a href="<?php echo esc_url($item_url); ?>" class="block px-6 py-4 rounded-xl border border-gray-50 text-secondary font-bold hover:bg-primary/5 hover:text-primary hover:border-primary/20 transition-all duration-300 uppercase tracking-widest text-[11px] no-underline">
                                    <?php echo esc_html($item['label']); ?>
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

        <div id="top-bar" class="border-b border-gray-100 bg-white/50">
            <div class="container mx-auto px-4 max-w-[1400px] flex flex-col sm:flex-row justify-between items-center py-2 gap-2 sm:gap-0">
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <a href="https://maps.google.com/?q=Avenida+de+la+Constitucion+Formentera+del+Segura+03179+Alicante" target="_blank" rel="noopener noreferrer" class="hover:text-primary transition-colors no-underline text-slate-600 font-medium">
                        Avenida de la Constitución, Formentera del Segura 03179 (Alicante)
                    </a>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                    </svg>
                    <a href="tel:+34639315861" class="hover:text-primary transition-colors no-underline text-slate-600 font-bold">
                        +34 639 31 58 61
                    </a>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 max-w-[1400px]">
            <div class="flex justify-between items-center h-[72px]">

                <!-- Left: Logo -->
                <div class="flex-1 flex justify-start items-center">
                    <a href="<?php echo esc_url(\Estatery\Core\Translator::getInstance()->resolve_nav_url('/')); ?>" class="flex items-center gap-3 group no-underline">
                        <img src="<?php echo esc_url($header_logo_url); ?>"
                            alt="<?php bloginfo('name'); ?>"
                            class="h-8 md:h-8 w-auto object-contain scale-[2] md:scale-[3] origin-left transition-transform duration-500 max-w-none">
                    </a>
                </div>

                <!-- Center: Desktop Navigation -->
                <nav id="site-navigation" class="hidden md:flex flex-2 justify-center">
                    <ul class="flex gap-1 items-center">
                        <?php
                        global $wp;
                        $navigation = t('header.navigation');
                        $current_url = rtrim(home_url(add_query_arg(array(), $wp->request)), '/');

                        if (is_array($navigation)) :
                            foreach ($navigation as $item) :
                                $item_url = rtrim(\Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url']), '/');
                                $is_active = ($current_url === $item_url);
                        ?>
                                <li class="relative group">
                                    <a href="<?php echo esc_url(\Estatery\Core\Translator::getInstance()->resolve_nav_url($item['url'])); ?>"
                                        class="px-4 py-2 block text-secondary font-bold text-[11px] uppercase tracking-[0.15em] no-underline transition-all duration-500 <?php echo $is_active ? 'text-primary' : 'group-hover:text-primary'; ?>">
                                        <?php echo esc_html($item['label']); ?>
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
                <div class="flex-1 flex justify-end items-center gap-2 md:gap-4">
                    <!-- Language Switcher Component -->
                    <?php get_template_part('template-parts/header/language-switcher'); ?>

                    <!-- Mobile Toggle -->
                    <button id="mobile-toggle" class="md:hidden p-2 rounded-xl border-2 border-gray-100 text-foreground hover:border-primary hover:text-primary transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </header>