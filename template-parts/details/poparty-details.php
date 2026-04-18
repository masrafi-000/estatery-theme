<?php
$features = [
    ['name' => 'Garden',         'icon' => '<path d="m12 13 3-3 3 3m-6 0v7a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-7"/><path d="M12 22v-9m0 0 3-3 3 3"/><circle cx="12" cy="5" r="3"/><path d="M7 22V11a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11"/><path d="M18 22V11a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v11"/>'],
    ['name' => 'Pool',           'icon' => '<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>'],
    ['name' => 'Garage',         'icon' => '<path d="M3 10V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4M6 12h12M6 16h12M6 20h12"/><rect width="18" height="12" x="3" y="10" rx="2"/>'],
    ['name' => 'Central AC',     'icon' => '<path d="M12 12V2m0 20v-4m10-6h-4M6 12H2m16.27-6.27-2.83 2.83M8.56 15.44l-2.83 2.83m10.54 0-2.83-2.83M8.56 8.56 5.73 5.73"/>'],
    ['name' => 'Panoramic',      'icon' => '<path d="M3 7V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2M3 17v2a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2M2 9h20v6H2z"/>'],
    ['name' => 'Golf View',      'icon' => '<path d="M4 22V4m0 0 13 4-13 4"/><circle cx="18" cy="20" r="2"/>'],
    ['name' => 'Water View',     'icon' => '<path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/>'],
    ['name' => 'Privacy',        'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>'],
    ['name' => 'Fitness Center', 'icon' => '<path d="m6.5 6.5 11 11M6.5 17.5l11-11M2 9v6M22 9v6M5 21l2-2M17 5l2-2M19 19l2 2M3 3l2 2"/>'],
    ['name' => 'Smart Home',     'icon' => '<path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5M9 22v-4a4.8 4.8 0 0 1 1-3.5"/><path d="M18 10a6 6 0 0 0-12 0c0 4.99 8.29 11.3 12 12 3.71-.7 12-7.01 12-12z"/><path d="M12 9v4M9 12h6"/>'],
    ['name' => 'High Ceiling',   'icon' => '<path d="M5 3h14M12 21V7m0 0-4 4m4-4 4 4"/>'],
    ['name' => 'Security',       'icon' => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>']
];
?>
<section class="max-w-7xl mx-auto px-4 py-12 font-sans text-slate-900">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12 h-auto md:h-[500px]">
        <div class="md:col-span-2 h-[300px] md:h-full overflow-hidden rounded-2xl bg-slate-100 relative group">
            <img id="main-display-image"
                src="https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260"
                alt="Main Property View" class="w-full h-full object-cover transition-all duration-500">
            <div class="absolute inset-0 bg-black/5 pointer-events-none"></div>
        </div>

        <div id="side-gallery-container" class="contents">
        </div>

        <div class="grid grid-cols-2 md:grid-cols-1 md:col-span-1 gap-4">
            <div class="h-[150px] md:h-[242px] overflow-hidden rounded-2xl cursor-pointer group border-2 border-transparent hover:border-primary transition-all gallery-thumb"
                onclick="updateGallery(this, 'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=1260')">
                <img src="https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=600"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="h-[150px] md:h-[242px] overflow-hidden rounded-2xl cursor-pointer group relative transition-all"
                onclick="openModal()">
                <img src="https://images.pexels.com/photos/221506/pexels-photo-221506.jpeg?auto=compress&cs=tinysrgb&w=600"
                    class="w-full h-full object-cover">
                <div
                    class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-white transition-all group-hover:bg-black/40 backdrop-blur-[2px]">
                    <i data-lucide="plus-square" class="w-8 h-8 mb-1 text-primary"></i>
                    <span id="photo-count-label"
                        class="font-bold text-xs uppercase tracking-widest text-center px-2">View Photos</span>
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
                        <p class="text-lg font-bold">04</p>
                        <p class="text-xs text-slate-500 uppercase font-semibold">Bedrooms</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 border-l-0 md:border-l border-slate-200 md:pl-6">
                    <i data-lucide="bath" class="w-6 h-6 text-primary"></i>
                    <div>
                        <p class="text-lg font-bold">02</p>
                        <p class="text-xs text-slate-500 uppercase font-semibold">Bathrooms</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 border-l-0 md:border-l border-slate-200 md:pl-6">
                    <i data-lucide="maximize" class="w-6 h-6 text-primary"></i>
                    <div>
                        <p class="text-lg font-bold">5,200m²</p>
                        <p class="text-xs text-slate-500 uppercase font-semibold">Building</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 border-l-0 md:border-l border-slate-200 md:pl-6">
                    <i data-lucide="layers" class="w-6 h-6 text-primary"></i>
                    <div>
                        <p class="text-lg font-bold">6,800m²</p>
                        <p class="text-xs text-slate-500 uppercase font-semibold">Lot Size</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 p-8 rounded-xl border border-slate-100 space-y-8">
                <div>
                    <h2 class="text-3xl font-serif font-bold mb-6">Descriptions</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Posuere libero litora fusce in rhoncus consequat elementum amet mauris. Platea rhoncus nullam
                        euismod etiam dignissim iaculis. Netus felis senectus rutrum torquent eleifend habitant
                        fringilla.
                    </p>
                    <p class="text-slate-600 leading-relaxed">
                        Experience luxury living in this spacious property. It features high ceilings, premium
                        finishes,
                        and large windows that fill the space with natural light.
                    </p>
                </div>

                <hr class="border-slate-200">

                <div>
                    <h3 class="text-xl font-bold mb-6">Features</h3>


                    <div>
                        <h3 class="text-xl font-bold mb-6">Features</h3>
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
                                        <?php echo $feature['name']; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden border border-slate-200 h-[350px]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.5404230551285!2d-0.12162622337144415!3d51.50072911030101!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604b900d26973%3A0x4291f3172409ea92!2slastminute.com%20London%20Eye!5e0!3m2!1sen!2sbd!4v1710000000000!5m2!1sen!2sbd"
                    class="w-full h-full border-0" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>

        <div class="lg:w-1/3">
            <div class="sticky top-8 bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100">


                <div class="p-8">
                    <h5 class="font-bold mb-4 text-slate-800">Contact Us</h5>
                    <form class="space-y-4">
                        <input type="text" placeholder="Name"
                            class="w-full px-4 py-3 bg-slate-50 border rounded-lg outline-none focus:border-primary">
                        <input type="text" placeholder="Number"
                            class="w-full px-4 py-3 bg-slate-50 border rounded-lg outline-none focus:border-primary">
                        <input type="email" placeholder="Email"
                            class="w-full px-4 py-3 bg-slate-50 border rounded-lg outline-none focus:border-primary">
                        <textarea rows="4" placeholder="I'm interested in this property."
                            class="w-full px-4 py-3 bg-slate-50 border rounded-lg outline-none focus:border-primary resize-none"></textarea>
                        <button
                            class="w-full py-4 bg-primary  hover:text-gray-50 font-bold rounded-lg hover:bg-slate-800 text-white transition-all flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i> SEND MESSAGE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="galleryModal"
        class="fixed inset-0 z-[9999] bg-slate-900/40 hidden backdrop-blur-md items-center justify-center p-4 transition-all duration-500 opacity-0">

        <div class="relative w-full max-w-5xl bg-white/90 p-4 md:p-6 rounded-[2.5rem] border border-white/30 shadow-[0_32px_64px_-15px_rgba(0,0,0,0.5)] flex flex-col gap-5 scale-90 transition-all duration-500"
            id="modalContainer">

            <button onclick="closeModal()"
                class="absolute -top-3 -right-3 md:top-6 md:right-6 p-3  rounded-full shadow-2xl transition-all z-[100001] flex items-center justify-center border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <div
                class="w-full h-[55vh] md:h-[60vh] rounded-3xl overflow-hidden bg-black/40 relative flex items-center justify-center border border-white/10 shadow-inner">

                <img id="modal-main-img" src=""
                    class="w-full h-full object-cover transition-all duration-500 scale-100 opacity-0">
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

        #galleryModal.show {
            opacity: 1;
            display: flex;
        }

        #galleryModal.show #modalContainer {
            scale: 1;
        }
    </style>

    <script>
        const propertyImages = [
            "https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg",
            "https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg",
            "https://images.pexels.com/photos/1910472/pexels-photo-1910472.jpeg",
            "https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg",
            "https://images.pexels.com/photos/221506/pexels-photo-221506.jpeg",
            "https://images.pexels.com/photos/271816/pexels-photo-271816.jpeg",
            "https://images.pexels.com/photos/2062426/pexels-photo-2062426.jpeg",
            "https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg"
        ];

        document.addEventListener('DOMContentLoaded', () => {
            const sideContainer = document.getElementById('side-gallery-container');
            const modalThumbContainer = document.getElementById('modal-thumbnails-container');
            const photoLabel = document.getElementById('photo-count-label');

            if (photoLabel) photoLabel.innerText = `View ${propertyImages.length} Photos`;

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
                thumb.onclick = () => updateModalImg(thumb, img);
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
        const modalMainImg = document.getElementById('modal-main-img');

        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('show'), 10);
            document.body.style.overflow = 'hidden';
            const firstThumb = document.querySelector('.modal-thumb');
            if (firstThumb) updateModalImg(firstThumb, propertyImages[0]);
        }

        function closeModal() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 500);
        }

        function updateModalImg(el, fullUrl) {
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
    </script>
    <script>
        if (window.lucide) {
            lucide.createIcons();
        }
    </script>
</section>