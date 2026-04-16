<?php $form = t('pages.contact.form'); ?>
<div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-secondary/5">
    <h3 class="text-2xl font-bold text-secondary mb-8"><?php echo esc_html($form['title']); ?></h3>

    <form action="#" method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['first_name_label']); ?></label>
                <input type="text" placeholder="<?php echo esc_attr($form['first_name_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['last_name_label']); ?></label>
                <input type="text" placeholder="<?php echo esc_attr($form['last_name_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['email_label']); ?></label>
                <input type="email" placeholder="<?php echo esc_attr($form['email_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['phone_label']); ?></label>
                <input type="tel" placeholder="<?php echo esc_attr($form['phone_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['property_info_label']); ?></label>
                <input type="text" placeholder="<?php echo esc_attr($form['property_type_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['zip_label']); ?></label>
                <input type="text" placeholder="<?php echo esc_attr($form['zip_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['city_label']); ?></label>
                <input type="text" placeholder="<?php echo esc_attr($form['city_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['bedrooms_label']); ?></label>
                <input type="number" placeholder="<?php echo esc_attr($form['bedrooms_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['bathrooms_label']); ?></label>
                <input type="number" placeholder="<?php echo esc_attr($form['bathrooms_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['budget_label']); ?></label>
            <input type="text" placeholder="<?php echo esc_attr($form['budget_placeholder']); ?>"
                class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
        </div>

        <button type="submit"
            class="w-full py-5 bg-primary text-white font-bold uppercase tracking-[0.2em] text-xs rounded-xl hover:bg-secondary transition-all duration-500 shadow-xl shadow-primary/20 transform hover:-translate-y-1">
            <?php echo esc_html($form['submit']); ?>
        </button>
    </form>
</div>