<?php
$property_data = get_query_var( 'property_data' );

if ( ! $property_data ) {
    echo '<div class="max-w-7xl mx-auto px-4 py-12 text-center text-slate-500 font-bold text-xl">' . esc_html(t('pages.properties.meta.not_found') ?: 'Property not found.') . '</div>';
    return;
}

$current_lang = \Estatery\Core\Translator::getInstance()->getLang();

$desc_data = $property_data['desc'][0] ?? ($property_data['desc'] ?? []);
$description = $desc_data[$current_lang][0] ?? ($desc_data['en'][0] ?? '');
$description_parts = array_filter(array_map('trim', explode("\n\n", $description)));

$beds = $property_data['beds'][0] ?? '0';
$baths = $property_data['baths'][0] ?? '0';
$surface_built = $property_data['surface_area'][0]['built'][0] ?? '0';
$surface_plot = $property_data['surface_area'][0]['plot'][0] ?? '0';

// Handle Pool (Support both legacy 'pool' and new 'pool_count')
$pool_count = $property_data['pool_count'][0] ?? ($property_data['pool'][0] ?? '0');

// Handle Coordinates (Support both nested JSON and flat DB structure)
$lat = $property_data['lat'][0] ?? ($property_data['location'][0]['latitude'][0] ?? '51.50072911030101');
$lng = $property_data['lng'][0] ?? ($property_data['location'][0]['longitude'][0] ?? '-0.12162622337144415');

// Features mapping — raw strings directly from properties.json or investments.json
$raw_features = $property_data['features'][0]['feature'] ?? ($property_data['features']['feature'] ?? []);
$features = [];
foreach ($raw_features as $feature_name) {
    if (empty($feature_name)) continue;
    $features[] = [
        'name' => $feature_name,
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />'
    ];
}

// Images mapping
$images = [];
if (!empty($property_data['images'][0]['image'])) {
    foreach ($property_data['images'][0]['image'] as $img) {
        if (!empty($img['url'][0])) {
            $images[] = $img['url'][0];
        }
    }
}
if (empty($images)) {
    $images = [
        "https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg",
        "https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg",
        "https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg"
    ]; // fallbacks
}

$main_image = $images[0] ?? '';
$gallery_images_json = json_encode($images);
?>
<section class="max-w-7xl mx-auto px-4 py-12 font-sans text-slate-900">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12 h-auto md:h-[500px]">
        <div class="md:col-span-2 h-[300px] md:h-full overflow-hidden rounded-2xl bg-slate-100 relative group">
            <img id="main-display-image"
                src="<?php echo esc_url($main_image); ?>?auto=compress&cs=tinysrgb&w=1260"
                alt="Main Property View" class="w-full h-full object-cover transition-all duration-500">
            <div class="absolute inset-0 bg-black/5 pointer-events-none"></div>
        </div>

        <div id="side-gallery-container" class="contents">
        </div>

        <div class="grid grid-cols-2 md:grid-cols-1 md:col-span-1 gap-4">
            <div class="h-[150px] md:h-[242px] overflow-hidden rounded-2xl cursor-pointer group border-2 border-transparent hover:border-primary transition-all gallery-thumb"
                onclick="updateGallery(this, '<?php echo esc_url($images[1] ?? $main_image); ?>?auto=compress&cs=tinysrgb&w=1260')">
                <img src="<?php echo esc_url($images[1] ?? $main_image); ?>?auto=compress&cs=tinysrgb&w=600"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="h-[150px] md:h-[242px] overflow-hidden rounded-2xl cursor-pointer group relative transition-all"
                onclick="openModal()">
                <img src="<?php echo esc_url($images[2] ?? $main_image); ?>?auto=compress&cs=tinysrgb&w=600"
                    class="w-full h-full object-cover">
                <div
                    class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-white transition-all group-hover:bg-black/40 backdrop-blur-[2px]">
                    <i data-lucide="plus-square" class="w-8 h-8 mb-1 text-primary"></i>
                    <span id="photo-count-label"
                        class="font-bold text-xs uppercase tracking-widest text-center px-2"><?php echo esc_html(t('pages.property_details.view_photos')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-2/3 space-y-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-6 rounded-xl border border-slate-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="bed" class="w-6 h-6 text-primary"></i>
                    <div>
                        <p class="text-lg font-bold"><?php echo esc_html(str_pad($beds, 2, '0', STR_PAD_LEFT)); ?></p>
                        <p class="text-xs text-slate-500 uppercase font-semibold"><?php echo esc_html(t('pages.property_details.bedrooms')); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-3 border-l-0 md:border-l border-slate-200 md:pl-6">
                    <i data-lucide="bath" class="w-6 h-6 text-primary"></i>
                    <div>
                        <p class="text-lg font-bold"><?php echo esc_html(str_pad($baths, 2, '0', STR_PAD_LEFT)); ?></p>
                        <p class="text-xs text-slate-500 uppercase font-semibold"><?php echo esc_html(t('pages.property_details.bathrooms')); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-3 border-l-0 md:border-l border-slate-200 md:pl-6">
                    <i data-lucide="maximize" class="w-6 h-6 text-primary"></i>
                    <div>
                        <p class="text-lg font-bold"><?php echo esc_html(number_format((float)$surface_built)); ?>m²</p>
                        <p class="text-xs text-slate-500 uppercase font-semibold"><?php echo esc_html(t('pages.property_details.building')); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-3 border-l-0 md:border-l border-slate-200 md:pl-6">
                    <i data-lucide="layers" class="w-6 h-6 text-primary"></i>
                    <div>
                        <p class="text-lg font-bold"><?php echo esc_html(number_format((float)$surface_plot)); ?>m²</p>
                        <p class="text-xs text-slate-500 uppercase font-semibold"><?php echo esc_html(t('pages.property_details.lot_size')); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 p-8 rounded-xl border border-slate-100 space-y-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2">
                    <div>
                        <?php if(!empty($property_data['new_build'][0])): ?>
                            <span class="inline-block bg-white text-slate-900 border border-slate-100 text-[10px] font-black px-3 py-1 rounded-xl uppercase tracking-widest mb-2 shadow-sm"><?php echo esc_html(t('pages.property_details.new_build')); ?></span>
                        <?php elseif(!empty($property_data['resale'][0]) || (isset($property_data['new_build'][0]) && $property_data['new_build'][0] === '0')): ?>
                            <span class="inline-block bg-slate-900 text-white text-[10px] font-black px-3 py-1 rounded-xl uppercase tracking-widest mb-2"><?php echo esc_html(t('pages.property_details.resale')); ?></span>
                        <?php endif; ?>
                        <?php 
                            $title = $property_data['title'][0] ?? '';
                            if (empty($title)) {
                                $raw_type = strtolower($property_data['type'][0] ?? 'property');
                                $title = t("pages.properties.meta.{$raw_type}") ?: ucfirst($raw_type);
                            }
                        ?>
                        <h2 class="text-3xl font-serif font-bold text-slate-900"><?php echo esc_html($title); ?></h2>
                        <p class="text-slate-500 mt-1 flex items-center gap-1 text-sm font-medium">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <?php echo esc_html(($property_data['location_detail'][0] ?? '') . ', ' . ($property_data['town'][0] ?? '') . ', ' . ($property_data['province'][0] ?? '')); ?>
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-black text-primary">
                            <?php 
                            $price = number_format((float)($property_data['price'][0] ?? 0), 0, '.', ',');
                            $currency = ($property_data['currency'][0] ?? 'EUR') === 'EUR' ? '€' : ($property_data['currency'][0] ?? '');
                            echo esc_html($price . ' ' . $currency); 
                            ?>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200">

                <div>
                    <h2 class="text-2xl font-serif font-bold mb-4"><?php echo esc_html(t('pages.property_details.description')); ?></h2>
                    <?php foreach ($description_parts as $part): ?>
                        <p class="text-slate-600 leading-relaxed mb-4">
                            <?php echo esc_html($part); ?>
                        </p>
                    <?php endforeach; ?>
                </div>

                <hr class="border-slate-200">

                <div>
                    <h3 class="text-xl font-bold mb-6"><?php echo esc_html(t('pages.property_details.features')); ?></h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4">
                        <?php foreach ($features as $feature): ?>
                            <div class="flex items-center gap-3 group">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center  transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-5 h-5  transition-transform duration-300 group-hover:scale-110">
                                        <?php echo $feature['icon']; ?>
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-semibold text-slate-600 group-hover:text-slate-900 transition-colors">
                                    <?php echo esc_html($feature['name']); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden border border-slate-200 h-[350px]">
                <?php
                $map_url = "https://maps.google.com/maps?q={$lat},{$lng}&z=15&output=embed";
                ?>
                <iframe
                    src="<?php echo esc_url($map_url); ?>"
                    class="w-full h-full border-0" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>

        <div class="lg:w-1/3">
            <div class="sticky top-8 bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100">
                <div class="p-8">
                    <h5 class="font-bold mb-4 text-slate-800"><?php echo esc_html(t('pages.property_details.form.contact_us')); ?></h5>
                    <form id="property-inquiry-form" class="space-y-4">
                        <?php wp_nonce_field('estatery_inquiry_nonce', 'inquiry_nonce'); ?>
                        
                        <!-- Hidden Property Data -->
                        <input type="hidden" name="prop_id" value="<?php echo esc_attr($property_data['id'][0] ?? ''); ?>">
                        <input type="hidden" name="prop_title" value="<?php echo esc_attr(ucfirst($property_data['type'][0] ?? 'Property') . ' ' . ($property_data['town'][0] ?? '')); ?>">
                        <input type="hidden" name="prop_price" value="<?php echo esc_attr($price . ' ' . $currency); ?>">
                        <input type="hidden" name="prop_area" value="<?php echo esc_attr($surface_built); ?>">
                        <input type="hidden" name="prop_image" value="<?php echo esc_url($main_image); ?>">
                        <input type="hidden" name="prop_beds" value="<?php echo esc_attr($beds); ?>">
                        <input type="hidden" name="prop_baths" value="<?php echo esc_attr($baths); ?>">
                        <input type="hidden" name="prop_pool" value="<?php echo esc_attr($pool_count); ?>">
                        <input type="hidden" name="prop_type" value="<?php echo esc_attr($property_data['type'][0] ?? ''); ?>">
                        <input type="hidden" name="prop_loc" value="<?php echo esc_attr(($property_data['location_detail'][0] ?? '') . ', ' . ($property_data['town'][0] ?? '') . ', ' . ($property_data['province'][0] ?? '')); ?>">
                        <input type="hidden" name="prop_lat" value="<?php echo esc_attr($lat); ?>">
                        <input type="hidden" name="prop_lng" value="<?php echo esc_attr($lng); ?>">
                        <input type="hidden" name="is_investment" value="<?php echo get_query_var('is_investment') ? '1' : '0'; ?>">

                        <input type="text" name="name" required placeholder="<?php echo esc_attr(t('pages.property_details.form.name')); ?>"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-primary transition-all">
                        <input type="text" name="phone" placeholder="<?php echo esc_attr(t('pages.property_details.form.number')); ?>"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-primary transition-all">
                        <input type="email" name="email" required placeholder="<?php echo esc_attr(t('pages.property_details.form.email')); ?>"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-primary transition-all">
                        <textarea name="message" rows="4" required placeholder="<?php echo esc_attr(t('pages.property_details.form.message')); ?>"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-primary resize-none transition-all"></textarea>
                        
                        <div id="inquiry-message" class="hidden text-sm p-4 rounded-lg"></div>

                        <button type="submit" id="submit-button"
                            class="w-full py-4 bg-primary hover:text-gray-50 font-bold rounded-lg hover:bg-slate-800 text-white transition-all flex items-center justify-center gap-2 group">
                            <span class="button-text flex items-center gap-2">
                                <i data-lucide="send" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i> <?php echo esc_html(t('pages.property_details.form.submit')); ?>
                            </span>
                            <span class="loading-spinner hidden">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </form>

                    <script>
                    function showInquirySuccess() {
                        const modal = document.getElementById('inquirySuccessModal');
                        const container = modal.querySelector('.modal-content');
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        setTimeout(() => {
                            modal.classList.add('opacity-100');
                            container.classList.add('scale-100', 'opacity-100');
                            container.classList.remove('scale-95', 'opacity-0');
                        }, 10);
                    }

                    function closeInquirySuccess() {
                        const modal = document.getElementById('inquirySuccessModal');
                        const container = modal.querySelector('.modal-content');
                        modal.classList.remove('opacity-100');
                        container.classList.remove('scale-100', 'opacity-100');
                        container.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        }, 400);
                    }

                    document.getElementById('property-inquiry-form').addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const form = this;
                        const btn = form.querySelector('#submit-button');
                        const btnText = btn.querySelector('.button-text');
                        const spinner = btn.querySelector('.loading-spinner');
                        const msgBox = document.getElementById('inquiry-message');
                        
                        btn.disabled = true;
                        btnText.classList.add('hidden');
                        spinner.classList.remove('hidden');
                        msgBox.classList.add('hidden');

                        const formData = new FormData(form);
                        formData.append('action', 'estatery_submit_inquiry');
                        formData.append('nonce', form.querySelector('[name="inquiry_nonce"]').value);

                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            btn.disabled = false;
                            btnText.classList.remove('hidden');
                            spinner.classList.add('hidden');

                            if (data.success) {
                                form.reset();
                                showInquirySuccess();
                            } else {
                                msgBox.classList.remove('hidden');
                                msgBox.className = 'text-sm p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 mb-4';
                                msgBox.innerText = data.data.message;
                            }
                        })
                        .catch(error => {
                            btn.disabled = false;
                            btnText.classList.remove('hidden');
                            spinner.classList.add('hidden');
                            msgBox.classList.remove('hidden');
                            msgBox.className = 'text-sm p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 mb-4';
                            msgBox.innerText = '<?php echo esc_js(t('pages.properties.js.error_generic') ?: 'Something went wrong. Please try again.'); ?>';
                        });
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Inquiry Success Modal -->
    <div id="inquirySuccessModal" class="fixed inset-0 z-[10000] bg-slate-900/60 backdrop-blur-xl flex items-center justify-center p-4 hidden transition-opacity duration-400 opacity-0">
        <div class="modal-content relative w-full max-w-sm bg-white/95 rounded-[2.5rem] p-10 text-center shadow-[0_32px_64px_-15px_rgba(0,0,0,0.3)] border border-white/40 transform scale-95 opacity-0 origin-center transition-all duration-400">
            
            <!-- Success Icon -->
            <div class="mb-8 inline-flex items-center justify-center w-24 h-24 bg-green-50 rounded-full text-green-500 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>

            <h3 class="text-3xl font-bold text-slate-800 mb-4 tracking-tight">
                <?php echo esc_html(t('js.applied')); ?>
            </h3>
            <p class="text-slate-600 mb-10 leading-relaxed text-lg">
                <?php echo esc_html(t('js.success_inquiry')); ?>
            </p>

            <button onclick="closeInquirySuccess()" 
                class="w-full py-5 bg-primary text-white font-bold rounded-2xl hover:bg-slate-900 transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-2 group">
                <span class="group-hover:-translate-y-0.5 transition-transform">
                    <?php echo esc_html(t('js.close') ?: 'Close'); ?>
                </span>
            </button>
        </div>
    </div>

    <div id="galleryModal"
        class="fixed inset-0 z-[9999] bg-slate-900/60 backdrop-blur-xl flex items-center justify-center p-4 hidden transition-opacity duration-400 opacity-0">

        <div class="modal-content relative w-full max-w-5xl bg-white/90 p-4 md:p-6 rounded-[2.5rem] border border-white/30 shadow-[0_32px_64px_-15px_rgba(0,0,0,0.5)] flex flex-col gap-5 transform scale-95 opacity-0 origin-center transition-all duration-400"
            id="modalContainer">

            <button onclick="closeModal()"
                class="absolute top-5 right-5 md:top-8 md:right-8 w-12 h-12 rounded-full bg-slate-900/90 backdrop-blur-md text-white shadow-2xl transition-all duration-500 z-[100002] flex items-center justify-center group/close hover:bg-primary hover:rotate-90 hover:scale-110 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-colors">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <div
                class="w-full h-[55vh] md:h-[60vh] rounded-3xl overflow-hidden bg-black/40 relative flex items-center justify-center border border-white/10 shadow-inner group/modal">
                <img id="modal-main-img" src=""
                    class="w-full h-full object-cover transition-all duration-500 scale-100 opacity-100">

                <!-- Navigation Buttons -->
                <button onclick="navigateGallery(-1)" 
                    class="absolute left-4 p-4 rounded-full bg-primary shadow-2xl shadow-primary/40 text-white hover:bg-slate-900 transition-all duration-300 hidden md:flex items-center justify-center z-[10001] hover:scale-110 active:scale-95 group/nav">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"></path>
                        <path d="M12 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button onclick="navigateGallery(1)" 
                    class="absolute right-4 p-4 rounded-full bg-primary shadow-2xl shadow-primary/40 text-white hover:bg-slate-900 transition-all duration-300 hidden md:flex items-center justify-center z-[10001] hover:scale-110 active:scale-95 group/nav">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="M12 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Mobile Navigation Controls -->
                <div class="absolute bottom-6 flex gap-4 md:hidden z-[10001]">
                    <button onclick="navigateGallery(-1)" class="p-4 rounded-full bg-primary shadow-xl text-white">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5"></path>
                            <path d="M12 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button onclick="navigateGallery(1)" class="p-4 rounded-full bg-primary shadow-xl text-white">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="modal-thumbnails-container"
                class="flex gap-3 overflow-x-auto py-2 px-2 scrollbar-hide justify-start md:justify-center">
            </div>
        </div>
    </div>

    <style>
        .fade-out {
            opacity: 0;
            transform: scale(0.98);
        }

        .active-modal-thumb {
            border-color: #fbbf24 !important;
            opacity: 1 !important;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 10px 20px -5px rgba(251, 191, 36, 0.4);
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <script>
        const propertyImages = <?php echo $gallery_images_json; ?>;
        let currentGalleryIndex = 0;

        document.addEventListener('DOMContentLoaded', () => {
            const sideContainer = document.getElementById('side-gallery-container');
            const modalThumbContainer = document.getElementById('modal-thumbnails-container');
            const photoLabel = document.getElementById('photo-count-label');

            if (photoLabel) {
                const viewPhotosText = <?php echo json_encode( t('pages.property_details.view_photos') ); ?>;
                photoLabel.innerText = `${viewPhotosText} (${propertyImages.length})`;
            }

            const sideImages = propertyImages.slice(1, 3);
            let sideHtml = '<div class="grid grid-cols-2 md:grid-cols-1 md:col-span-1 gap-4">';
            sideImages.forEach(img => {
                sideHtml += `
                    <div class="h-[150px] md:h-[242px] overflow-hidden rounded-2xl cursor-pointer group border-2 border-transparent hover:border-primary transition-all gallery-thumb"
                        onclick="updateGallery(this, '${img}?auto=compress&cs=tinysrgb&w=1260')">
                        <img src="${img}?auto=compress&cs=tinysrgb&w=600" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>`;
            });
            sideHtml += '</div>';
            sideContainer.innerHTML = sideHtml;

            propertyImages.forEach((img, index) => {
                const thumb = document.createElement('img');
                thumb.src = `${img}?auto=compress&cs=tinysrgb&w=300`;
                thumb.className =
                    "modal-thumb w-16 h-16 md:w-20 md:h-20 rounded-2xl object-cover cursor-pointer border-2 border-transparent opacity-40 hover:opacity-100 transition-all flex-shrink-0";
                thumb.onclick = () => updateModalImg(thumb, img, index);
                modalThumbContainer.appendChild(thumb);
            });

            if (window.lucide) lucide.createIcons();
        });

        function updateGallery(element, imageUrl) {
            const mainImg = document.getElementById('main-display-image');
            mainImg.classList.add('fade-out');
            setTimeout(() => {
                mainImg.src = imageUrl;
                document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('border-primary'));
                element.classList.add('border-primary');
                mainImg.classList.remove('fade-out');
            }, 250);
        }

        const modal = document.getElementById('galleryModal');
        const modalContainer = modal.querySelector('.modal-content');
        const modalMainImg = document.getElementById('modal-main-img');

        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                modal.classList.add('opacity-100');
                modalContainer.classList.add('scale-100', 'opacity-100');
                modalContainer.classList.remove('scale-95', 'opacity-0');
            }, 10);

            const allThumbs = document.querySelectorAll('.modal-thumb');
            const targetThumb = allThumbs[currentGalleryIndex] || allThumbs[0];
            if (targetThumb) updateModalImg(targetThumb, propertyImages[currentGalleryIndex] || propertyImages[0], currentGalleryIndex);
        }

        function closeModal() {
            modal.classList.remove('opacity-100');
            modalContainer.classList.remove('scale-100', 'opacity-100');
            modalContainer.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 400);
        }

        function navigateGallery(direction) {
            currentGalleryIndex = (currentGalleryIndex + direction + propertyImages.length) % propertyImages.length;
            const allThumbs = document.querySelectorAll('.modal-thumb');
            const thumb = allThumbs[currentGalleryIndex];
            const img = propertyImages[currentGalleryIndex];
            if (thumb) updateModalImg(thumb, img, currentGalleryIndex);
        }

        function updateModalImg(el, fullUrl, index) {
            currentGalleryIndex = index;
            modalMainImg.classList.remove('opacity-100', 'scale-100');
            modalMainImg.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modalMainImg.src = `${fullUrl}?auto=compress&cs=tinysrgb&w=1600`;
                modalMainImg.onload = () => {
                    modalMainImg.classList.remove('opacity-0', 'scale-95');
                    modalMainImg.classList.add('opacity-100', 'scale-100');
                };
                document.querySelectorAll('.modal-thumb').forEach(img => img.classList.remove(
                    'active-modal-thumb'));
                el.classList.add('active-modal-thumb');
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }, 300);
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (modal.classList.contains('hidden')) return;
            
            if (e.key === 'Escape') closeModal();
            if (e.key === 'ArrowRight') navigateGallery(1);
            if (e.key === 'ArrowLeft') navigateGallery(-1);
        });
    </script>
    <script>
        if (window.lucide) {
            lucide.createIcons();
        }
    </script>
</section>