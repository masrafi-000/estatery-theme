<?php $form = t('pages.contact.form'); ?>
<div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-secondary/5">
    <h3 class="text-2xl font-bold text-secondary mb-8"><?php echo esc_html($form['title']); ?></h3>

    <form id="estatery-contact-form" class="space-y-6">
        <?php wp_nonce_field('estatery_contact_nonce', 'contact_nonce'); ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['first_name_label']); ?></label>
                <input type="text" name="first_name" required placeholder="<?php echo esc_attr($form['first_name_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['last_name_label']); ?></label>
                <input type="text" name="last_name" required placeholder="<?php echo esc_attr($form['last_name_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['email_label']); ?></label>
                <input type="email" name="email" required placeholder="<?php echo esc_attr($form['email_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['phone_label']); ?></label>
                <input type="tel" name="phone" placeholder="<?php echo esc_attr($form['phone_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['property_info_label']); ?></label>
                <input type="text" name="property_type" placeholder="<?php echo esc_attr($form['property_type_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['zip_label']); ?></label>
                <input type="text" name="zip" placeholder="<?php echo esc_attr($form['zip_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['city_label']); ?></label>
                <input type="text" name="city" placeholder="<?php echo esc_attr($form['city_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['bedrooms_label']); ?></label>
                <input type="number" name="bedrooms" placeholder="<?php echo esc_attr($form['bedrooms_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
            <div class="space-y-2">
                <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['bathrooms_label']); ?></label>
                <input type="number" name="bathrooms" placeholder="<?php echo esc_attr($form['bathrooms_placeholder']); ?>"
                    class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-secondary font-bold text-[11px] uppercase tracking-widest ml-1"><?php echo esc_html($form['budget_label']); ?></label>
            <input type="text" name="budget" placeholder="<?php echo esc_attr($form['budget_placeholder']); ?>"
                class="w-full bg-gray-50/50 border border-secondary/10 rounded-xl px-5 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary">
        </div>

        <button type="submit" id="contact-submit-btn"
            class="w-full py-5 bg-primary text-white font-bold uppercase tracking-[0.2em] text-xs rounded-xl hover:bg-secondary transition-all duration-500 shadow-xl shadow-primary/20 transform hover:-translate-y-1 flex items-center justify-center gap-2">
            <span class="btn-text"><?php echo esc_html($form['submit']); ?></span>
            <span class="loading-spinner hidden">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>

        <div id="contact-feedback" class="hidden p-4 rounded-xl text-center text-xs font-bold uppercase tracking-widest border"></div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('estatery-contact-form');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('contact-submit-btn');
            const btnText = btn.querySelector('.btn-text');
            const spinner = btn.querySelector('.loading-spinner');
            const feedback = document.getElementById('contact-feedback');
            
            btn.disabled = true;
            btnText.classList.add('opacity-50');
            spinner.classList.remove('hidden');
            feedback.classList.add('hidden');

            const formData = new FormData(form);
            formData.append('action', 'estatery_submit_contact');

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btnText.classList.remove('opacity-50');
                spinner.classList.add('hidden');

                feedback.classList.remove('hidden');
                if (data.success) {
                    feedback.className = 'p-5 rounded-xl text-center text-xs font-bold uppercase tracking-widest border bg-green-50 text-green-700 border-green-200 mt-4';
                    feedback.innerText = data.data.message;
                    form.reset();
                } else {
                    feedback.className = 'p-5 rounded-xl text-center text-xs font-bold uppercase tracking-widest border bg-red-50 text-red-700 border-red-200 mt-4';
                    feedback.innerText = data.data.message;
                }
            })
            .catch(error => {
                btn.disabled = false;
                btnText.classList.remove('opacity-50');
                spinner.classList.add('hidden');
                feedback.classList.remove('hidden');
                feedback.className = 'p-5 rounded-xl text-center text-xs font-bold uppercase tracking-widest border bg-red-50 text-red-700 border-red-200 mt-4';
                feedback.innerText = 'Something went wrong. Please try again.';
            });
        });
    });
    </script>
</div>