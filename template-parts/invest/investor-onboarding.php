<?php $onboarding = t('pages.invest.onboarding'); ?>

<section class="py-24 bg-white js-onboarding-section">
    <div class="container mx-auto px-6 max-w-6xl">

        <div class="max-w-3xl mx-auto text-center mb-16 js-onboarding-header">
            <span class="inline-block text-primary font-bold uppercase tracking-[0.3em] text-[10px] mb-2">
                <?php echo esc_html($onboarding['badge']); ?>
            </span>
            <h2 class="text-3xl md:text-5xl font-bold text-secondary mb-3 leading-tight">
                <?php echo esc_html($onboarding['title']); ?>
            </h2>
            <p class="text-secondary  mx-auto">
                <?php echo esc_html($onboarding['subtitle']); ?>
            </p>
        </div>

        <div class="w-full js-onboarding-form">
            <div class="bg-[#fcfcfc] p-8 md:p-14 rounded-3xl border border-secondary/5 shadow-sm">
                <form id="investor-onboarding-form" class="space-y-12">
                    <?php wp_nonce_field('estatery_invest_nonce', 'invest_nonce'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-secondary font-bold text-[11px] uppercase tracking-wider block ml-1"><?php echo esc_html($onboarding['form']['name_label']); ?></label>
                            <input type="text" name="full_name" required
                                class="w-full bg-white border border-secondary/10 rounded-xl px-6 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary placeholder:text-secondary/20 shadow-sm"
                                placeholder="<?php echo esc_attr($onboarding['form']['name_placeholder']); ?>">
                        </div>
                        <div class="space-y-3">
                            <label class="text-secondary font-bold text-[11px] uppercase tracking-wider block ml-1"><?php echo esc_html($onboarding['form']['email_label']); ?></label>
                            <input type="email" name="email" required
                                class="w-full bg-white border border-secondary/10 rounded-xl px-6 py-4 focus:border-primary/50 outline-none transition-all text-sm text-secondary placeholder:text-secondary/20 shadow-sm"
                                placeholder="<?php echo esc_attr($onboarding['form']['email_placeholder']); ?>">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <?php 
                        $q_keys = ['existing_client', 'owns_property', 'tax_resident'];
                        foreach ($onboarding['form']['questions'] as $index => $q): 
                            $q_name = $q_keys[$index] ?? 'q_' . $index;
                        ?>
                            <div class="space-y-4">
                                <p class="text-secondary font-bold text-[10px] uppercase tracking-wider opacity-80">
                                    <?php echo esc_html($q); ?></p>
                                <div class="flex gap-2">
                                    <label class="flex-1 group">
                                        <input type="radio" name="<?php echo esc_attr($q_name); ?>" value="no" class="hidden peer" checked>
                                        <div class="text-center py-3 border border-secondary/10 rounded-lg transition-all cursor-pointer font-bold text-[10px] uppercase 
                                            text-secondary/40 bg-white 
                                            peer-checked:bg-secondary peer-checked:text-white peer-checked:border-secondary
                                            group-hover:border-secondary/30">
                                            <?php echo esc_html($onboarding['form']['options']['no']); ?>
                                        </div>
                                    </label>
                                    <label class="flex-1 group">
                                        <input type="radio" name="<?php echo esc_attr($q_name); ?>" value="yes" class="hidden peer">
                                        <div class="text-center py-3 border border-secondary/10 rounded-lg transition-all cursor-pointer font-bold text-[10px] uppercase 
                                            text-secondary/40 bg-white 
                                            peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary
                                            group-hover:border-primary/30">
                                            <?php echo esc_html($onboarding['form']['options']['yes']); ?>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="space-y-6">
                        <p class="text-secondary font-bold text-[11px] uppercase tracking-wider ml-1"><?php echo esc_html($onboarding['form']['interest_label']); ?></p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php foreach ($onboarding['form']['interests'] as $i): ?>
                                <label
                                    class="flex items-center gap-4 px-5 py-4 bg-white border border-secondary/5 rounded-xl cursor-pointer hover:border-primary/20 transition-all group shadow-sm">
                                    <input type="checkbox" name="interests[]" value="<?php echo esc_attr($i); ?>" class="w-4 h-4 accent-primary rounded-sm">
                                    <span
                                        class="text-secondary/60 group-hover:text-secondary text-[11px] font-bold uppercase tracking-tight transition-colors"><?php echo esc_html($i); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-8 items-end pt-10 border-t border-secondary/5">
                        <div class="w-full lg:flex-1 space-y-3">
                            <label class="text-secondary font-bold text-[11px] uppercase tracking-wider ml-1"><?php echo esc_html($onboarding['form']['amount_label']); ?></label>
                            <div class="relative">
                                <select name="amount"
                                    class="w-full bg-white border border-secondary/10 rounded-xl px-5 py-4 text-xs font-bold text-secondary/70 appearance-none outline-none focus:border-primary/50 shadow-sm cursor-pointer">
                                    <?php foreach ($onboarding['form']['amounts'] as $amount) : ?>
                                        <option value="<?php echo esc_attr($amount); ?>"><?php echo esc_html($amount); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-5 flex items-center pointer-events-none opacity-40">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-auto">
                            <button type="submit" id="investor-submit-btn"
                                class="w-full lg:w-auto px-12 py-4.5 bg-primary text-white font-bold uppercase tracking-[0.2em] text-[10px] rounded-xl hover:bg-secondary transition-all duration-500 shadow-md transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <span class="btn-text"><?php echo esc_html($onboarding['form']['submit']); ?></span>
                                <span class="loading-spinner hidden">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div id="form-feedback" class="hidden p-4 rounded-xl text-center text-xs font-bold uppercase tracking-widest border"></div>

                    <div class="flex items-center justify-center gap-2 opacity-30">
                        <svg class="w-3 h-3 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z">
                            </path>
                        </svg>
                        <p class="text-[9px] text-secondary uppercase tracking-[0.3em] font-bold">
                            <?php echo esc_html($onboarding['form']['footer']); ?>
                        </p>
                    </div>
                </form>
            </div>
        </div>



        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('investor-onboarding-form');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const btn = document.getElementById('investor-submit-btn');
                const btnText = btn.querySelector('.btn-text');
                const spinner = btn.querySelector('.loading-spinner');
                const feedback = document.getElementById('form-feedback');
                
                btn.disabled = true;
                btnText.classList.add('opacity-50');
                spinner.classList.remove('hidden');
                feedback.classList.add('hidden');

                const formData = new FormData(form);
                formData.append('action', 'estatery_submit_investment');

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
                        feedback.className = 'p-5 rounded-xl text-center text-xs font-bold uppercase tracking-widest border bg-green-50 text-green-700 border-green-200';
                        feedback.innerText = data.data.message;
                        form.reset();
                    } else {
                        feedback.className = 'p-5 rounded-xl text-center text-xs font-bold uppercase tracking-widest border bg-red-50 text-red-700 border-red-200';
                        feedback.innerText = data.data.message;
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    btnText.classList.remove('opacity-50');
                    spinner.classList.add('hidden');
                    feedback.classList.remove('hidden');
                    feedback.className = 'p-5 rounded-xl text-center text-xs font-bold uppercase tracking-widest border bg-red-50 text-red-700 border-red-200';
                    feedback.innerText = 'Something went wrong. Please try again.';
                });
            });
        });
        </script>

    </div>
</section>