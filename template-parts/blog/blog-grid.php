<?php
/**
 * Component: Blog Grid Listing (Categorized & Polished)
 */

$view_cat = $_GET['cat'] ?? null;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

/**
 * Helper to get query
 */
function get_blog_type_query($type_slug, $posts_per_page = 3, $paged = 1) {
    return new WP_Query([
        'post_type'      => 'blog',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'tax_query'      => [
            [
                'taxonomy' => 'blog_category',
                'field'    => 'slug',
                'terms'    => $type_slug,
            ],
        ],
    ]);
}

$news_query = null;
$blog_query = null;

if ($view_cat === 'news') {
    $news_query = get_blog_type_query('news', 9, $paged);
} elseif ($view_cat === 'blog') {
    $blog_query = get_blog_type_query('blog', 9, $paged);
} else {
    $news_query = get_blog_type_query('news', 3, 1);
    $blog_query = get_blog_type_query('blog', 3, 1);
}
?>

<!-- SECTION 1: NEWS (Light Slate BG for contrast) -->
<?php if ($news_query && ($news_query->have_posts() || $view_cat === 'news')) : ?>
    <section class="py-32 <?php echo !$view_cat ? 'bg-slate-50/50' : 'bg-white'; ?>">
        <div class="container mx-auto px-4 max-w-[1400px]">
            <div id="news-section">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8" data-aos="fade-up">
                    <div class="max-w-2xl">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="w-12 h-px bg-primary"></span>
                            <span class="text-primary font-bold text-[10px] uppercase tracking-[0.4em]"><?php echo esc_html(t('pages.blog.sections.news_label')); ?></span>
                        </div>
                        <h2 class="text-4xl md:text-6xl font-serif text-slate-900 leading-[1.1]">
                            <?php echo esc_html(t('pages.blog.sections.news_title')); ?><span class="text-primary">.</span>
                        </h2>
                    </div>
                    <?php if (!$view_cat) : ?>
                        <div class="pb-2">
                            <a href="?cat=news" class="inline-flex items-center gap-4 bg-white text-slate-900 px-10 py-5 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all duration-500 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-primary/20 group">
                                <?php echo esc_html(t('pages.blog.ui.explore_all_news')); ?>
                                <svg class="size-4 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($news_query->have_posts()) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                            <?php get_template_part('template-parts/blog/blog-card'); ?>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($view_cat === 'news') : ?>
                        <div class="mt-20 flex justify-center">
                            <?php echo paginate_links(['total' => $news_query->max_num_pages, 'current' => $paged, 'type' => 'list', 'class' => 'estatery-pagination']); ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="text-center py-32 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <div class="size-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 4v4h4"/></svg>
                        </div>
                        <p class="text-slate-400 font-light text-lg"><?php echo esc_html(t('pages.blog.ui.no_news')); ?></p>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>


<!-- SECTION 2: BLOGS (Clean White BG) -->
<?php if ($blog_query && ($blog_query->have_posts() || $view_cat === 'blog')) : ?>
    <section class="py-32 bg-white">
        <div class="container mx-auto px-4 max-w-[1400px]">
            <div id="blogs-section">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8" data-aos="fade-up">
                    <div class="max-w-2xl">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="w-12 h-px bg-primary"></span>
                            <span class="text-primary font-bold text-[10px] uppercase tracking-[0.4em]"><?php echo esc_html(t('pages.blog.sections.blog_label')); ?></span>
                        </div>
                        <h2 class="text-4xl md:text-6xl font-serif text-slate-900 leading-[1.1]">
                            <?php echo esc_html(t('pages.blog.sections.blog_title')); ?><span class="text-primary">.</span>
                        </h2>
                    </div>
                    <?php if (!$view_cat) : ?>
                        <div class="pb-2">
                            <a href="?cat=blog" class="inline-flex items-center gap-4 bg-slate-900 text-white px-10 py-5 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary transition-all duration-500 shadow-xl shadow-slate-900/10 hover:shadow-primary/20 group">
                                <?php echo esc_html(t('pages.blog.ui.view_full_blog')); ?>
                                <svg class="size-4 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($blog_query->have_posts()) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                        <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                            <?php get_template_part('template-parts/blog/blog-card'); ?>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($view_cat === 'blog') : ?>
                        <div class="mt-20 flex justify-center">
                            <?php echo paginate_links(['total' => $blog_query->max_num_pages, 'current' => $paged, 'type' => 'list', 'class' => 'estatery-pagination']); ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="text-center py-32 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                        <div class="size-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 shadow-sm">
                            <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <p class="text-slate-400 font-light text-lg"><?php echo esc_html(t('pages.blog.ui.no_blogs')); ?></p>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ($view_cat) : ?>
    <div class="py-20 text-center bg-slate-50/30 border-t border-slate-100">
        <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="inline-flex items-center gap-3 text-slate-900 font-black text-[10px] uppercase tracking-[0.4em] hover:text-primary transition-colors group">
            <svg class="size-4 transform group-hover:-translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"/></svg>
            <?php echo esc_html(t('pages.blog.ui.back_overview')); ?>
        </a>
    </div>
<?php endif; ?>

<style>
    .estatery-pagination { display: flex; gap: 12px; list-style: none; }
    .estatery-pagination li a, .estatery-pagination li span { 
        display: flex; align-items: center; justify-content: center; 
        width: 50px; height: 50px; border-radius: 16px; 
        border: 1px solid #e2e8f0; color: #1e293b; 
        font-weight: 800; font-size: 14px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        background: white;
    }
    .estatery-pagination li span.current { background: #1e293b; color: white; border-color: #1e293b; transform: scale(1.1); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .estatery-pagination li a:hover { border-color: #2563eb; color: #2563eb; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.1); }
</style>
