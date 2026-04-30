<?php
/**
 * Component: Blog Card (Multilingual)
 */
$author_name = get_post_meta(get_the_ID(), '_author_name', true) ?: 'Admin';
$author_role = get_post_meta(get_the_ID(), '_author_designation', true) ?: 'Estate Advisor';
$categories  = get_the_terms(get_the_ID(), 'blog_category');
$category    = !empty($categories) ? $categories[0]->name : 'Journal';

// Translated title and excerpt
$post_title   = get_blog_field('title');
$post_excerpt = get_blog_field('excerpt');

// Reading time (always based on English word count for consistency)
$content    = get_post_field('post_content', get_the_ID());
$word_count = str_word_count(strip_tags($content));
$read_time  = max(1, ceil($word_count / 200));
?>

<article class="group bg-white border border-slate-100 overflow-hidden rounded-3xl hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] transition-all duration-500 flex flex-col h-full" data-aos="fade-up">
    <!-- Image -->
    <div class="relative h-64 overflow-hidden">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s]']); ?>
        <?php else : ?>
            <img src="https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=800" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s]" alt="<?php echo esc_attr($post_title); ?>">
        <?php endif; ?>
        
        <!-- Badges -->
        <div class="absolute top-6 left-6 right-6 flex justify-between items-start">
            <span class="bg-white/90 backdrop-blur-md text-slate-900 text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest shadow-xl border border-white/20">
                <?php echo get_the_date('M d, Y'); ?>
            </span>
            <span class="bg-primary text-white text-[9px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-lg shadow-primary/20">
                <?php echo esc_html($category); ?>
            </span>
        </div>
    </div>

    <!-- Content -->
    <div class="p-8 flex flex-col flex-1">
        <div class="flex items-center gap-2 mb-4">
            <svg class="size-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-slate-400 text-[11px] font-medium uppercase tracking-widest">
                <?php echo $read_time; ?> <?php echo esc_html(t('pages.blog.ui.min_read')); ?>
            </span>
        </div>

        <h3 class="text-2xl font-serif text-slate-900 mb-4 group-hover:text-primary transition-colors leading-tight line-clamp-2">
            <a href="<?php the_permalink(); ?>"><?php echo esc_html($post_title); ?></a>
        </h3>
        
        <div class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-3 font-light">
            <?php echo esc_html(wp_trim_words($post_excerpt, 22)); ?>
        </div>

        <!-- Author Footer -->
        <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="size-11 rounded-2xl bg-slate-50 flex items-center justify-center text-primary font-serif font-bold border border-slate-100 group-hover:bg-primary group-hover:text-white transition-colors">
                    <?php echo esc_html(substr($author_name, 0, 1)); ?>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-900 font-bold text-xs uppercase tracking-wider"><?php echo esc_html($author_name); ?></span>
                    <span class="text-slate-400 text-[10px] uppercase tracking-widest"><?php echo esc_html($author_role); ?></span>
                </div>
            </div>
            
            <a href="<?php the_permalink(); ?>" class="size-11 rounded-2xl bg-slate-900 text-white flex items-center justify-center hover:bg-primary transition-all duration-300 shadow-lg shadow-slate-900/10 group-hover:scale-105" aria-label="<?php echo esc_attr(t('pages.blog.grid.read_more')); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</article>
