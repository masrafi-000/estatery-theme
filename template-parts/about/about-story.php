<?php $story = t('pages.about.story'); ?>
<section class="relative py-16 lg:py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-6 grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 reveal-images">

                <!-- Left Side -->
                <div class="grid grid-rows-2 gap-4 lg:gap-6 h-full">

                    <div class="rounded-xl overflow-hidden shadow-lg h-[200px] md:h-[220px] lg:h-full bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?q=80&w=1000&auto=format&fit=crop"
                            alt="Luxury Living Room"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>

                    <div class="rounded-xl overflow-hidden shadow-lg h-[200px] md:h-[220px] lg:h-full bg-gray-100">
                        <img src="https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=1000"
                            alt="Modern Kitchen Interior"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>

                </div>

                <!-- Right Side -->
                <div class="flex items-stretch">
                    <div
                        class="rounded-xl overflow-hidden shadow-2xl w-full h-[420px] md:h-[460px] lg:h-full bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1000&auto=format&fit=crop"
                            alt="Corporate Building Architecture"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                </div>

            </div>

            <div class="lg:col-span-6 space-y-6 reveal-text">
                <div class="flex items-center gap-2">
                    <span class=" text-secondary font-bold uppercase tracking-[0.3em] text-xs"> <?php echo esc_html($story['badge']); ?></span>
                </div>

                <h2 class="text-4xl font-extrabold text-secondary mb-6">
                    <?php echo $story['title']; ?>
                </h2>

                <p class="text-secondary max-w-xl mb-0">
                    <?php echo esc_html($story['description']); ?>
                </p>

                <ul class="space-y-4 py-4">
                    <?php foreach ($story['features'] as $item): ?>
                        <li class="flex items-center gap-4 group">
                            <span class="h-[2px] w-8 bg-primary group-hover:w-12 transition-all duration-300"></span>
                            <span class="text-gray-700 font-medium tracking-wide"><?php echo esc_html($item); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="grid grid-cols-3 gap-4 pt-6">
                    <div class="rounded-lg overflow-hidden h-24 shadow-md">
                        <img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&q=80"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-lg overflow-hidden h-24 shadow-md">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-lg overflow-hidden h-24 shadow-md">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80"
                            class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>