<?php
/**
 * Component: Investment Properties Listing (High-Performance Direct Fetch)
 */
$current_lang = \Estatery\Core\Translator::getInstance()->getLang();
$data_url = get_template_directory_uri() . '/data/investments.json';
?>

<section class="py-24 bg-white overflow-hidden js-invest-props-section">
    <div class="container mx-auto px-6 ">
        
        <div class="max-w-3xl mb-16 js-invest-props-header">
            <h2 class="text-secondary font-bold uppercase tracking-[0.2em] text-[10px] mb-4 js-invest-prop-item">
                <?php echo esc_html( t('pages.invest.properties_label') ?: 'Exclusive Opportunities' ); ?>
            </h2>
            <h3 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 leading-tight js-invest-prop-item">
                <?php echo esc_html( t('pages.invest.properties_title') ?: 'Prime Real Estate Investment Portfolio' ); ?>
            </h3>
            <p class="text-slate-500 mt-6 text-lg leading-relaxed js-invest-prop-item">
                <?php echo esc_html( t('pages.invest.properties_subtitle') ?: 'Discover hand-picked properties with high yield potential and strong capital appreciation in the most sought-after areas of Alicante.' ); ?>
            </p>
        </div>

        <div id="investments-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 js-invest-props-grid min-h-[400px]">
            <!-- Skeletons (Visible while loading) -->
            <?php for ($i = 0; $i < 6; $i++) : ?>
                <div class="skeleton-card bg-slate-50 rounded-3xl h-[500px] animate-pulse"></div>
            <?php endfor; ?>
        </div>

    </div>
</section>

<script>
(function($) {
    const CONFIG = {
        lang: '<?php echo $current_lang; ?>',
        dataUrl: '<?php echo $data_url; ?>',
        baseUrl: '<?php echo home_url(); ?>',
        i18n: {
            new_build: '<?php echo esc_js( t('pages.properties.filters.new_build') ); ?>',
            resale: '<?php echo esc_js( t('pages.properties.filters.resale') ); ?>',
            beds: '<?php echo esc_js( t('home.featured.beds') ); ?>',
            baths: '<?php echo esc_js( t('home.featured.baths') ); ?>',
            pool: '<?php echo esc_js( t('home.featured.pool') ?: 'POOL' ); ?>',
            view_details: '<?php echo esc_js( t('pages.properties.actions.view_details') ); ?>',
            no_properties: '<?php echo esc_js( t('pages.invest.no_properties') ); ?>'
        }
    };

    function formatPrice(val) {
        if (!val) return 'POA';
        return new Intl.NumberFormat(CONFIG.lang === 'ru' ? 'ru-RU' : (CONFIG.lang === 'es' ? 'es-ES' : 'en-GB'), {
            style: 'currency',
            currency: 'EUR',
            maximumFractionDigits: 0
        }).format(val);
    }

    function renderPropertyCard(prop) {
        const title = prop.town[0] + ' ' + (prop.type[0] || 'Property');
        const price = formatPrice(prop.price[0]);
        const description = prop.desc && prop.desc[CONFIG.lang] ? prop.desc[CONFIG.lang][0] : (prop.desc && prop.desc['en'] ? prop.desc['en'][0] : '');
        const image = prop.images[0].image[0].url[0];
        const detailUrl = `${CONFIG.baseUrl}/investment-details/?id=${encodeURIComponent(prop.id[0])}`;
        
        const badge = prop.new_build[0] === "1" 
            ? `<span class="bg-white text-slate-900 text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest shadow-xl border border-slate-100">${CONFIG.i18n.new_build}</span>`
            : `<span class="bg-slate-900 text-white text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest shadow-xl">${CONFIG.i18n.resale}</span>`;

        return `
            <article class="property-card group bg-white overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full">
                <div class="relative h-64 overflow-hidden">
                    <img src="${image}" alt="${title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s]">
                    <div class="absolute top-6 left-6 flex flex-col gap-2">${badge}</div>
                    <div class="absolute bottom-6 left-2 right-2">
                        <div class="bg-white/90 backdrop-blur-md py-3 px-1.5 shadow-lg border border-white/20">
                            <div class="flex justify-between items-center gap-2">
                                <div class="text-primary font-black text-base tracking-tighter w-[35%]">${price}</div>
                                <div class="text-end text-[11px] text-slate-500 uppercase font-medium tracking-widest w-[65%] flex items-center justify-end">
                                    <svg class="w-4 h-4 text-primary mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    ${prop.town[0]}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-4 px-4 flex flex-col flex-1">
                    <h3 class="text-2xl font-semibold text-slate-900 mb-2 group-hover:text-primary transition-colors leading-tight">${title}</h3>
                    <p class="text-slate-500 text-[13px] leading-relaxed mb-4 line-clamp-2">${description}</p>
                    <div class="grid grid-cols-3 gap-2 py-4 border-y border-slate-50 mb-4 text-center ring-1 ring-slate-50 rounded-2xl">
                        <div class="flex flex-col gap-1">
                            <span class="text-slate-900 font-black text-sm">${prop.beds[0]}</span>
                            <span class="text-[9px] text-slate-400 uppercase font-bold tracking-widest">${CONFIG.i18n.beds}</span>
                        </div>
                        <div class="flex flex-col gap-1 border-x border-slate-100">
                            <span class="text-slate-900 font-black text-sm">${prop.baths[0]}</span>
                            <span class="text-[9px] text-slate-400 uppercase font-bold tracking-widest">${CONFIG.i18n.baths}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-slate-900 font-black text-sm">1</span>
                            <span class="text-[9px] text-slate-400 uppercase font-bold tracking-widest">${CONFIG.i18n.pool}</span>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <a href="${detailUrl}" class="flex items-center justify-center gap-3 w-full bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] py-4 hover:bg-primary transition-all duration-300 shadow-xl shadow-slate-900/10 active:scale-[0.98]">
                            ${CONFIG.i18n.view_details}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </article>`;
    }

    async function loadInvestments() {
        const $container = $('#investments-container');
        try {
            const response = await fetch(CONFIG.dataUrl);
            const data = await response.json();
            const properties = data.root.property;

            if (properties && properties.length) {
                let html = '';
                properties.forEach(prop => {
                    html += renderPropertyCard(prop);
                });
                $container.html(html);
                initInvestPropsAnims();
            } else {
                $container.html(`<div class="col-span-full py-20 text-center text-slate-400 font-medium italic">${CONFIG.i18n.no_properties}</div>`);
            }
        } catch (error) {
            console.error('Error loading investment data:', error);
            $container.html('<div class="col-span-full py-20 text-center text-red-400 font-medium italic">An error occurred while loading investments.</div>');
        }
    }

    function initInvestPropsAnims() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);
        const section = document.querySelector(".js-invest-props-section");
        const cards = section.querySelectorAll(".property-card");
        const tl = gsap.timeline({ scrollTrigger: { trigger: section, start: "top 80%", once: true } });
        if (cards.length) {
            gsap.set(cards, { opacity: 0, y: 50 });
            tl.to(cards, { opacity: 1, y: 0, duration: 1, stagger: 0.1, ease: "power4.out", clearProps: "transform,opacity" });
        }
    }

    $(document).ready(loadInvestments);
})(jQuery);
</script>

<style>
.skeleton-card {
    background: linear-gradient(90deg, #f1f5f9 25%, #f8fafc 50%, #f1f5f9 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
}
@keyframes skeleton-loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
</style>