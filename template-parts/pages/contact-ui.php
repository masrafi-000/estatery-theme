<section class="contact-page-ui py-24 bg-surface">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-20">
            <!-- Contact Sidebar -->
            <div class="lg:col-span-1" data-aos="fade-right">
                <h2 class="text-4xl font-black text-foreground mb-10 uppercase tracking-tighter">
                    <?php echo esc_html( t('pages.contact.title') ); ?>
                </h2>
                <div class="space-y-12">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-primary block mb-3">Office Location</span>
                        <p class="text-lg text-secondary font-medium leading-relaxed">
                            <?php echo esc_html( t('pages.contact.info.address') ); ?>
                        </p>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-primary block mb-3">Direct Phone</span>
                        <p class="text-lg text-secondary font-medium uppercase tracking-tighter">
                            <?php echo esc_html( t('pages.contact.info.phone') ); ?>
                        </p>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-primary block mb-3">Inquiries</span>
                        <p class="text-lg text-secondary font-medium">
                            <?php echo esc_html( t('pages.contact.info.email') ); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-10 md:p-16 shadow-2xl shadow-gray-200/50 border border-gray-50" data-aos="fade-left">
                <form action="#" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 ml-1"><?php echo esc_html( t('pages.contact.form.name') ); ?></label>
                        <input type="text" class="w-full bg-surface-secondary border-none rounded-xl px-6 py-4 text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 ml-1"><?php echo esc_html( t('pages.contact.form.email') ); ?></label>
                        <input type="email" class="w-full bg-surface-secondary border-none rounded-xl px-6 py-4 text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 ml-1"><?php echo esc_html( t('pages.contact.form.message') ); ?></label>
                        <textarea rows="6" class="w-full bg-surface-secondary border-none rounded-xl px-6 py-4 text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none"></textarea>
                    </div>
                    <div class="md:col-span-2 pt-4">
                        <button type="submit" class="w-full md:w-auto px-12 py-5 bg-primary text-white font-black text-xs uppercase tracking-widest rounded-xl hover:shadow-2xl hover:shadow-primary/30 transition-all transform hover:-translate-y-1 active:scale-95">
                            <?php echo esc_html( t('pages.contact.form.submit') ); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
