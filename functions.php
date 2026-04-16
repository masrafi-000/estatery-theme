<?php
/**
 * Estatery theme functions and definitions
 * MVC Architecture: Entry point for core controllers
 */

// Include core classes (Manual autoloader for simplicity)
require_once get_template_directory() . '/inc/Core/Setup.php';
require_once get_template_directory() . '/inc/Core/Enqueue.php';
require_once get_template_directory() . '/inc/Core/I18n.php';
require_once get_template_directory() . '/inc/Core/ThemeSetup.php';
require_once get_template_directory() . '/inc/Core/Translator.php';

// Instantiate Core Controllers
new Estatery\Core\Setup();
new Estatery\Core\Enqueue();
new Estatery\Core\I18n();

// Bootstrap pages and settings
\Estatery\Core\ThemeSetup::init();

// Global helper for translations (Like Next.js)
function t($key) {
    return \Estatery\Core\Translator::getInstance()->t($key);
}



// FAQ Custom Post Type Register
function register_faq_custom_post_type()
{
    $labels = [
        'name' => 'FAQs',
        'singular_name' => 'FAQ',
        'add_new' => 'Add New FAQ',
        'add_new_item' => 'Add New FAQ',
        'menu_name' => 'FAQs',
    ];
    $args = [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => ['title', 'editor'],
        'show_in_rest' => true,
    ];
    register_post_type('faq', $args);
}
add_action('init', 'register_faq_custom_post_type');
 
 
function insert_default_faqs()
{
    if (get_option('default_faqs_inserted')) return;
 
    $defaults = [
        ['q' => 'How do I start searching for a property?', 'a' => 'You can start by using our search bar at the top of the page.'],
        ['q' => 'Are the property listings verified?', 'a' => 'Yes, every listing on Estatery goes through a strict verification process.'],
        ['q' => 'Can I list my own property for sale?', 'a' => 'Absolutely! Click on the Sell Property button and follow the steps.'],
        ['q' => 'Is there any commission fee for buyers?', 'a' => 'We provide transparent pricing. Browsing is free.'],
        ['q' => 'How can I contact a real estate agent?', 'a' => 'Each detail page has a Contact Agent button.']
    ];
 
    foreach ($defaults as $faq) {
        wp_insert_post([
            'post_title'   => $faq['q'],
            'post_content' => $faq['a'],
            'post_status'  => 'publish',
            'post_type'    => 'faq',
        ]);
    }
    update_option('default_faqs_inserted', true);
}
add_action('admin_init', 'insert_default_faqs');



/**

 * Hero Section Customizer Settings
 * Path: Appearance > Customize > Hero Slider Images
 */
function hero_customizer_settings($wp_customize)
{
    $wp_customize->add_section('hero_settings', array(
        'title'    => 'Hero Slider Content',
        'priority' => 30,
    ));

    for ($i = 1; $i <= 5; $i++) {
        // --- 1. Image Control ---
        $wp_customize->add_setting("hero_bg_image_$i");
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_bg_image_$i", array(
            'label'    => "Slider $i: Background Image",
            'section'  => 'hero_settings',
            'settings' => "hero_bg_image_$i",
        )));

        // --- 2. Title Control ---
        $wp_customize->add_setting("hero_title_$i", array('default' => 'Find Your Dream Apartment'));
        $wp_customize->add_control("hero_title_$i", array(
            'label'    => "Slider $i: Main Title",
            'section'  => 'hero_settings',
            'type'     => 'text',
        ));

        // --- 3. Subtitle Control ---
        $wp_customize->add_setting("hero_subtitle_$i", array('default' => 'Explore our luxury properties tailored to your lifestyle.'));
        $wp_customize->add_control("hero_subtitle_$i", array(
            'label'    => "Slider $i: Subtitle Text",
            'section'  => 'hero_settings',
            'type'     => 'textarea',
        ));
    }
}
add_action('customize_register', 'hero_customizer_settings');


// dynamic banner function with default values
/**
 * Global Page Banner Function with Default Values
 */
function get_page_banner($title = "Welcome", $image_url = "")
{
    // Default Image URL (Jodi image dite bhule jan)
    $default_image = "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop";

    $final_image = (!empty($image_url)) ? $image_url : $default_image;
    $final_title = (!empty($title)) ? $title : "Welcome";
?>

    <section class="relative w-full h-[400px] md:h-[450px] flex items-center justify-center overflow-hidden bg-slate-100">
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url($final_image); ?>" alt="<?php echo esc_attr($final_title); ?>"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 tracking-tight">
                <?php echo esc_html($final_title); ?>
            </h1>

            <nav class="flex justify-center items-center gap-3 text-white/90 font-medium">
                <a href="<?php echo esc_url(home_url()); ?>"
                    class="flex items-center gap-2 hover:text-blue-400 transition-colors">
                    HOME
                </a>
                <span class="text-blue-500 text-xl">•</span>
                <span class="uppercase tracking-widest text-sm"><?php echo esc_html($final_title); ?></span>
            </nav>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-10">
            <svg class="relative block w-full h-[50px]" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M1200 120L0 120 309.19 0 1200 120z" fill="#ffffff"></path>
            </svg>
        </div>
    </section>
<?php
}