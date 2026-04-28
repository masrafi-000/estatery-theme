(function($) {
    'use strict';

    $(function() {
        /**
         * 1. Mobile Navigation Drawer
         */
        const $drawer = $('#mobile-drawer');
        const $content = $('#drawer-content');
        const $overlay = $('#drawer-overlay');
        const $toggle = $('#mobile-toggle');
        const $close = $('#drawer-close');

        function openDrawer() {
            $drawer.removeClass('invisible pointer-events-none').addClass('visible');
            $overlay.removeClass('opacity-0').addClass('opacity-100');
            $content.removeClass('-translate-x-full').addClass('translate-x-0');
            $('body').css('overflow', 'hidden');
        }

        function closeDrawer() {
            $overlay.removeClass('opacity-100').addClass('opacity-0');
            $content.removeClass('translate-x-0').addClass('-translate-x-full');
            setTimeout(() => {
                $drawer.removeClass('visible').addClass('invisible pointer-events-none');
                $('body').css('overflow', '');
            }, 500);
        }

        if ($toggle.length) $toggle.on('click', openDrawer);
        if ($close.length) $close.on('click', closeDrawer);
        if ($overlay.length) $overlay.on('click', closeDrawer);




        /**
         * 3. Hero Filter Tabs Logic
         */
        $('.filter-tab').on('click', function() {
            $('.filter-tab').removeClass('bg-primary text-white active').addClass('bg-white/90 text-slate-900');
            $(this).addClass('bg-primary text-white active').removeClass('bg-white/90 text-slate-900');
            $('#listing-type-input').val($(this).data('type'));
        });

        console.log('Theme Base Logic Initialized');
    });

})(jQuery);
