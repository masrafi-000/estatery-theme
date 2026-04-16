<?php $leadership = t('pages.about.leadership'); ?>
<section class="relative py-24 bg-white overflow-hidden">


    <div class="container mx-auto px-6 lg:px-12 relative z-10">
        <div class="flex flex-col lg:flex-row items-center  gap-12 lg:gap-0">

            <div class="w-full lg:w-5/12 relative group reveal-image-container">
                <div class="absolute -bottom-6 -right-6 w-2/3 h-2/3 border-2 border-secondary z-0 hidden lg:block">
                </div>

                <div class="relative z-10 rounded-sm overflow-hidden shadow-2xl bg-primary">
                    <img src="https://images.pexels.com/photos/2182970/pexels-photo-2182970.jpeg?auto=compress&cs=tinysrgb&w=1000"
                        alt="CEO"
                        class="w-full h-[550px] object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 scale-110 group-hover:scale-100">
                </div>

                <div
                    class="absolute -bottom-10 -left-6 lg:left-[-10%] bg-white p-6 shadow-xl z-20 hidden md:block border-l-4 border-secondary reveal-card">
                    <p class="text-secondary font-bold text-4xl italic">
                        <span class="count-up" data-target="35">0</span>+
                    </p>
                    <p class="text-xs uppercase tracking-widest text-gray-500 font-semibold"><?php echo esc_html($leadership['years_label']); ?></p>
                </div>
            </div>

            <div class="w-full lg:w-7/12 lg:pl-24 space-y-8 reveal-content">
                <div class="inline-block">
                    <span class="text-secondary font-bold uppercase tracking-[0.3em] text-xs flex items-center gap-3">
                        <span class="w-10 h-[1px] bg-secondary"></span>
                        <?php echo esc_html($leadership['badge']); ?>
                    </span>
                </div>

                <h2 class="text-4xl font-extrabold text-secondary mb-6">
                    <?php echo $leadership['title']; ?>
                </h2>

                <div class="relative">


                    <p class=" border-l-2 text-secondary border-primary/90 pl-8">
                        <?php echo esc_html($leadership['message']); ?>
                    </p>
                </div>

                <div class="flex items-center gap-6 pt-6">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-secondary shadow-md">
                        <img src="https://images.pexels.com/photos/2182970/pexels-photo-2182970.jpeg?auto=compress&cs=tinysrgb&w=100"
                            class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-secondary tracking-tight"><?php echo esc_html($leadership['name']); ?></h4>
                        <p class="text-secondary text-xs uppercase tracking-widest font-bold"><?php echo esc_html($leadership['role']); ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<script>
    gsap.registerPlugin(ScrollTrigger);

    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: ".reveal-image-container",
            start: "top 80%",
        }
    });

    // 1. Image Container Slide Up
    tl.from(".reveal-image-container", {
            y: 80,
            opacity: 0,
            duration: 1.2,
            ease: "power4.out"
        })
        // 2. Staggered Text Entry
        .from(".reveal-content > *", {
            x: 40,
            opacity: 0,
            duration: 0.8,
            stagger: 0.15,
            ease: "power3.out"
        }, "-=0.9")
        // 3. Floating Card Pop-in
        .from(".reveal-card", {
            scale: 0.8,
            opacity: 0,
            duration: 0.6,
            ease: "back.out(1.7)"
        }, "-=0.6")
        // 4. Numerical Counter Animation
        .to(".count-up", {
            innerText: (i, target) => target.getAttribute('data-target'),
            duration: 2,
            snap: {
                innerText: 1
            },
            ease: "power1.inOut",
            onUpdate: function() {
                // Optional: Ensure the number remains an integer during tween
                this.targets()[0].innerHTML = Math.ceil(this.targets()[0].innerText);
            }
        }, "-=0.4");
</script>