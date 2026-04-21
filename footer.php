<?php
/**
 * Classic Dark Footer Configuration
 */
$marketplace_links = [
    ["label" => t('header.navigation.0.label') ?: 'Home', "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/')],
    ["label" => t('header.navigation.1.label') ?: 'Properties', "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/properties')],
    ["label" => t('header.navigation.3.label') ?: 'Invest', "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/invest')],
];

$company_links = [
    ["label" => t('header.navigation.2.label') ?: 'About Us', "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/about')],
    ["label" => t('header.navigation.4.label') ?: 'Contact', "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/contact')],
];

$legal_links = [
    ["label" => t('footer.links.privacy'), "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/privacy-policy')],
    ["label" => t('footer.links.terms'), "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/terms-of-service')],
    ["label" => t('footer.links.cookie'), "url" => \Estatery\Core\Translator::getInstance()->resolve_nav_url('/cookie-policy')],
];

$social_links = [
    "facebook" => [
        "url"  => "https://facebook.com/capitalunion",
        "icon" => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>'
    ],
    "instagram" => [
        "url"  => "https://instagram.com/capitalunion",
        "icon" => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849s-.011 3.585-.069 4.85c-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.849-.07c-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849s.012-3.584.07-4.849c.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>'
    ],
    "linkedin" => [
        "url"  => "https://linkedin.com/company/capitalunion",
        "icon" => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path></svg>'
    ]
];
?>

<footer class="bg-white text-slate-600 pt-24 pb-12 border-t border-gray-100 font-sans js-footer-section">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-16 mb-24">

            <!-- Agency Brand -->
            <div class="lg:col-span-4 space-y-8">
                <a href="<?php echo \Estatery\Core\Translator::getInstance()->resolve_nav_url('/'); ?>" class="inline-block transition-transform hover:scale-105 duration-300">
                    <img src="<?php echo get_template_directory_uri(); ?>/public/images/Logo.png"
                        alt="<?php echo esc_attr( t('brand.name') ); ?>" class="h-24 md:h-32 w-auto">
                </a>
                <p class="text-slate-500 leading-relaxed max-w-sm text-sm">
                    <?php echo esc_html( t('footer.tagline') ); ?>
                </p>
                <div class="flex items-center gap-4">
                    <?php foreach ($social_links as $name => $data): ?>
                        <a href="<?php echo esc_url($data['url']); ?>" target="_blank"
                            class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all duration-300 shadow-sm border border-slate-100"
                            aria-label="<?php echo esc_attr($name); ?>">
                            <?php echo $data['icon']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Marketplace -->
            <div class="lg:col-span-2">
                <h4 class="text-secondary font-bold uppercase tracking-[0.2em] text-[10px] mb-8">
                    <?php echo esc_html( t('footer.menus.quick_links') ); ?>
                </h4>
                <ul class="space-y-4">
                    <?php foreach ($marketplace_links as $link): ?>
                        <li>
                            <a href="<?php echo esc_url($link['url']); ?>" class="text-slate-600 hover:text-primary transition-colors duration-300 font-semibold text-sm">
                                <?php echo esc_html( $link['label'] ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Company -->
            <div class="lg:col-span-2">
                <h4 class="text-secondary font-bold uppercase tracking-[0.2em] text-[10px] mb-8">
                    <?php echo esc_html( t('footer.menus.company') ); ?>
                </h4>
                <ul class="space-y-4">
                    <?php foreach ($company_links as $link): ?>
                        <li>
                            <a href="<?php echo esc_url($link['url']); ?>" class="text-slate-600 hover:text-primary transition-colors duration-300 font-semibold text-sm">
                                <?php echo esc_html( $link['label'] ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Contact/Location -->
            <div class="lg:col-span-4">
                <h4 class="text-secondary font-bold uppercase tracking-[0.2em] text-[10px] mb-8">
                    <?php echo esc_html( t('pages.contact.info.badge') ?: 'Reach Us' ); ?>
                </h4>
                <div class="space-y-6">
                    <div class="flex gap-4 items-start group">
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100 group-hover:bg-primary/5 transition-colors">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-500 leading-relaxed group-hover:text-secondary transition-colors">
                            <?php echo esc_html( t('pages.contact.info.office_address') ); ?>
                        </p>
                    </div>
                    <div class="flex gap-4 items-center group">
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100 group-hover:bg-primary/5 transition-colors">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-500 group-hover:text-secondary transition-colors">
                            <?php echo esc_html( t('brand.email') ); ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sub-Footer -->
        <div class="pt-10 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-slate-400 text-[11px] font-medium tracking-wider">
                © <?php echo date('Y'); ?> <span class="text-secondary font-bold"><?php echo esc_html( t('brand.platform') ); ?></span>. <?php echo esc_html( t('footer.copyright') ); ?>
            </p>

            <div class="flex items-center gap-8">
                <?php foreach ($legal_links as $link): ?>
                    <a href="<?php echo esc_url($link['url']); ?>" class="text-slate-400 hover:text-secondary text-[10px] uppercase font-bold tracking-[0.2em] transition-colors">
                        <?php echo esc_html( $link['label'] ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</footer>

<script>
(function() {
    function initFooterAnims() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);
        const footer = document.querySelector(".js-footer-section");
        if (!footer) return;

        gsap.from(footer.querySelectorAll(".container > *"), {
            scrollTrigger: {
                trigger: footer,
                start: "top 95%",
                toggleActions: "play none none none"
            },
            opacity: 0,
            y: 40,
            duration: 1,
            stagger: 0.15,
            ease: "power3.out"
        });
    }
    if (document.readyState === 'loading') {
        window.addEventListener('load', initFooterAnims);
    } else {
        initFooterAnims();
    }
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
