<?php
namespace Estatery\Core;

/**
 * Blog Custom Post Type, Admin Interface, and Multilingual Content
 * Admin UI follows the same design pattern as PropertyCPT.
 */
class BlogCPT {

    /** Supported languages (besides English which is the default WP fields) */
    const LANGS = [
        'es' => 'Español (Spanish)',
        'pl' => 'Polski (Polish)',
        'ru' => 'Русский (Russian)',
    ];

    public function __construct() {
        add_action('init',                    [$this, 'register_cpt']);
        add_action('add_meta_boxes',          [$this, 'add_meta_boxes']);
        add_action('add_meta_boxes',          [$this, 'remove_default_meta_boxes'], 99);
        add_action('save_post_blog',          [$this, 'save_meta_data']);       // scoped to blog CPT only
        add_action('admin_enqueue_scripts',   [$this, 'enqueue_admin_assets']);
        add_filter('manage_blog_posts_columns',       [$this, 'custom_columns']);
        add_action('manage_blog_posts_custom_column', [$this, 'render_custom_column'], 10, 2);
    }

    /* =========================================================
       CPT & TAXONOMY REGISTRATION
    ========================================================= */

    public function register_cpt() {
        $labels = [
            'name'               => 'Blog & News',
            'singular_name'      => 'Post',
            'menu_name'          => 'Blog & News',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Blog / News',
            'edit_item'          => 'Edit Post',
            'new_item'           => 'New Post',
            'view_item'          => 'View Post',
            'search_items'       => 'Search Posts',
            'not_found'          => 'No posts found',
            'not_found_in_trash' => 'No posts found in trash'
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'blog-news'],
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_position'      => 27,
            'menu_icon'          => 'dashicons-admin-post',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt']
        ];

        register_post_type('blog', $args);

        register_taxonomy('blog_category', 'blog', [
            'labels' => [
                'name'          => 'Categories',
                'singular_name' => 'Category',
                'search_items'  => 'Search Categories',
                'all_items'     => 'All Categories',
                'edit_item'     => 'Edit Category',
                'update_item'   => 'Update Category',
                'add_new_item'  => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'menu_name'     => 'Categories',
            ],
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'blog-category'],
        ]);

        $this->seed_default_terms();
    }

    private function seed_default_terms() {
        if (!term_exists('News', 'blog_category')) {
            wp_insert_term('News', 'blog_category', ['slug' => 'news']);
        }
        if (!term_exists('Blog', 'blog_category')) {
            wp_insert_term('Blog', 'blog_category', ['slug' => 'blog']);
        }
    }

    /* =========================================================
       CUSTOM LIST TABLE COLUMNS
    ========================================================= */

    public function custom_columns($columns) {
        return [
            'cb'            => $columns['cb'],
            'title'         => 'Title',
            'blog_thumb'    => 'Image',
            'blog_category' => 'Category',
            'blog_author'   => 'Author',
            'date'          => 'Published',
        ];
    }

    public function render_custom_column($column, $post_id) {
        if ($column === 'blog_thumb') {
            if (has_post_thumbnail($post_id)) {
                $thumb = get_the_post_thumbnail_url($post_id, 'thumbnail');
                echo '<img src="' . esc_url($thumb) . '" style="width:56px;height:40px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">';
            } else {
                echo '<div style="width:56px;height:40px;background:#f1f5f9;border-radius:6px;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#cbd5e1;font-size:18px;">📷</div>';
            }
        }
        if ($column === 'blog_author') {
            $name = get_post_meta($post_id, '_author_name', true);
            $role = get_post_meta($post_id, '_author_designation', true);
            echo '<span style="font-size:13px;font-weight:600;color:#1e293b;">' . esc_html($name ?: '—') . '</span>';
            if ($role) echo '<br><span style="font-size:11px;color:#94a3b8;">' . esc_html($role) . '</span>';
        }
        if ($column === 'blog_category') {
            $terms = get_the_terms($post_id, 'blog_category');
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    $color = strtolower($term->name) === 'news' ? '#0ea5e9' : '#8b5cf6';
                    echo '<span style="display:inline-block;background:' . $color . '1a;color:' . $color . ';font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:2px 10px;border-radius:30px;">' . esc_html($term->name) . '</span> ';
                }
            } else {
                echo '<span style="color:#94a3b8;">—</span>';
            }
        }
    }

    /* =========================================================
       META BOXES
    ========================================================= */

    public function remove_default_meta_boxes() {
        // Replace the generic WP "Excerpt" box with our labelled version
        remove_meta_box('postexcerpt', 'blog', 'normal');
    }

    public function add_meta_boxes() {
        // 1. Our labelled Card Preview Text (replaces WP Excerpt)
        add_meta_box(
            'estatery_blog_card_preview',
            '📋 Card Preview Text (English)',
            [$this, 'render_excerpt_metabox'],
            'blog', 'normal', 'high'
        );
        // 2. Author info (sidebar)
        add_meta_box(
            'estatery_blog_author',
            'Author Information',
            [$this, 'render_author_metabox'],
            'blog', 'side', 'high'
        );
        // 3. Multilingual translations
        add_meta_box(
            'estatery_blog_translations',
            '🌍 Multilingual Content (ES / PL / RU)',
            [$this, 'render_translations_metabox'],
            'blog', 'normal', 'high'
        );
    }

    /* =========================================================
       ADMIN ASSETS
       Only loaded on blog add/edit screens (post.php / post-new.php)
    ========================================================= */

    public function enqueue_admin_assets($hook) {
        global $post_type;

        // Only on blog CPT edit/new screens — NOT on the list table
        if ($post_type !== 'blog') return;
        if (!in_array($hook, ['post.php', 'post-new.php'])) return;

        // Register + enqueue a proper handle so wp_add_inline_style works
        wp_register_style('estatery-blog-admin', false);
        wp_enqueue_style('estatery-blog-admin');
        wp_add_inline_style('estatery-blog-admin', $this->get_admin_css());

        wp_add_inline_script('jquery', $this->get_admin_js());
    }

    private function get_admin_css() {
        return "
            /* ── Shared field styles (PropertyCPT parity) ── */
            .estatery-meta-field { margin-bottom: 16px; }
            .estatery-meta-field label { display:block; font-weight:600; margin-bottom:8px; color:#475569; font-size:12px; text-transform:uppercase; letter-spacing:.05em; }
            .estatery-control-alt { width:100%; padding:10px 14px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; font-size:14px; color:#1e293b; transition:border-color .2s,box-shadow .2s; box-sizing:border-box; }
            .estatery-control-alt:focus { border-color:#2563eb; outline:none; background:#fff; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
            textarea.estatery-control-alt { min-height:100px; resize:vertical; line-height:1.6; font-family:inherit; }

            /* ── Language tab bar ── */
            .eb-tabs { display:flex; border-bottom:2px solid #e2e8f0; margin-bottom:20px; }
            .eb-tab  { padding:9px 20px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; cursor:pointer; border:none; background:transparent; color:#94a3b8; border-bottom:2px solid transparent; margin-bottom:-2px; transition:color .15s,border-color .15s; }
            .eb-tab:hover  { color:#2563eb; }
            .eb-tab.active { color:#0f172a; border-bottom-color:#0f172a; }

            /* ── Info / hint banners ── */
            .eb-info { background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:11px 14px; margin-bottom:18px; font-size:12px; color:#0369a1; line-height:1.6; }
            .eb-hint { font-size:11px; color:#94a3b8; margin-top:5px; line-height:1.5; }
            .eb-section-divider { border:none; border-top:1px solid #f1f5f9; margin:16px 0; }

            /* ── Article body textarea ── */
            .eb-body-area { width:100%; min-height:280px; padding:12px 14px; border:1px solid #e2e8f0; border-radius:8px; background:#f8fafc; font-size:13px; line-height:1.8; font-family:inherit; resize:vertical; box-sizing:border-box; transition:border-color .2s; }
            .eb-body-area:focus { border-color:#2563eb; outline:none; background:#fff; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
        ";
    }

    private function get_admin_js() {
        return "
        jQuery(document).ready(function(\$) {

            // ── Tab switching: pure jQuery show/hide, no TinyMCE dependency ──
            function switchTab(\$group, newLang) {
                \$group.find('.eb-tab').removeClass('active');
                \$group.find('.eb-tab-panel').each(function() {
                    if (\$(this).data('lang') === newLang) {
                        \$(this).css('display', 'block').addClass('active');
                    } else {
                        \$(this).css('display', 'none').removeClass('active');
                    }
                });
                // Activate the clicked tab button
                \$group.find('.eb-tab[data-lang=\"' + newLang + '\"]').addClass('active');
            }

            // Hide non-active panels on load (inline style beats any CSS conflict)
            \$('.eb-tab-group').each(function() {
                var \$g   = \$(this);
                var first = \$g.find('.eb-tab.active').first().data('lang') || \$g.find('.eb-tab').first().data('lang');
                \$g.find('.eb-tab-panel').css('display', 'none').removeClass('active');
                \$g.find('.eb-tab-panel[data-lang=\"' + first + '\"]').css('display', 'block').addClass('active');
                // Ensure the tab button matches
                \$g.find('.eb-tab').removeClass('active');
                \$g.find('.eb-tab[data-lang=\"' + first + '\"]').addClass('active');
            });

            // Click handler
            \$(document).on('click', '.eb-tab', function(e) {
                e.preventDefault();
                var \$group  = \$(this).closest('.eb-tab-group');
                var newLang = \$(this).data('lang');
                if (\$(this).hasClass('active')) return;
                switchTab(\$group, newLang);
            });

        });
        ";
    }

    /* =========================================================
       CARD PREVIEW TEXT META BOX  (replaces default WP Excerpt)
    ========================================================= */

    public function render_excerpt_metabox($post) {
        // The nonce lives here so it is always present regardless of sidebar state
        wp_nonce_field('estatery_blog_save', 'estatery_blog_nonce');
        ?>
        <div style="margin-bottom:10px;padding:10px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;font-size:12px;color:#166534;line-height:1.6;">
            <strong>What is this?</strong> The 1–2 sentence teaser shown on the blog/news listing cards — the text a visitor reads <em>before</em> clicking the article. Use the <strong>Multilingual Content</strong> box below for translations.
        </div>
        <textarea
            name="excerpt"
            id="excerpt"
            rows="4"
            class="estatery-control-alt"
            placeholder="Write a short, engaging 1–2 sentence summary that entices visitors to read the full article…"
            style="width:100%;"><?php echo esc_textarea($post->post_excerpt); ?></textarea>
        <p class="eb-hint">💡 Aim for <strong>20–30 words</strong>. Shown on blog/news cards beneath the post title.</p>
        <?php
    }

    /* =========================================================
       AUTHOR META BOX
    ========================================================= */

    public function render_author_metabox($post) {
        $name = get_post_meta($post->ID, '_author_name',        true);
        $role = get_post_meta($post->ID, '_author_designation', true);
        ?>
        <div class="estatery-meta-field">
            <label>Author Name</label>
            <input type="text" name="author_name" class="estatery-control-alt" value="<?php echo esc_attr($name); ?>" placeholder="e.g. Anna Alizarenko">
        </div>
        <div class="estatery-meta-field">
            <label>Job Title / Designation</label>
            <input type="text" name="author_designation" class="estatery-control-alt" value="<?php echo esc_attr($role); ?>" placeholder="e.g. Estate Advisor">
        </div>
        <?php
    }

    /* =========================================================
       MULTILINGUAL META BOX
    ========================================================= */

    public function render_translations_metabox($post) {
        $id = $post->ID;
        ?>
        <div class="eb-info">
            The <strong>Title</strong>, <strong>Content</strong>, and <strong>Card Preview Text</strong> fields above are the <strong>English (EN)</strong> version.
            Use the tabs below for translations. <strong>Leave any field blank</strong> to automatically fall back to English.
        </div>

        <div class="eb-tab-group">

            <!-- Tab buttons -->
            <div class="eb-tabs">
                <?php $first = true; foreach (self::LANGS as $code => $label) : ?>
                    <button type="button"
                            class="eb-tab<?php echo $first ? ' active' : ''; ?>"
                            data-lang="<?php echo esc_attr($code); ?>">
                        <?php echo esc_html($label); ?>
                    </button>
                <?php $first = false; endforeach; ?>
            </div>

            <!-- Tab panels -->
            <?php $first = true; foreach (self::LANGS as $code => $label) :
                $t_title   = get_post_meta($id, "_title_{$code}",   true);
                $t_preview = get_post_meta($id, "_excerpt_{$code}", true);
                $t_content = get_post_meta($id, "_content_{$code}", true);
            ?>
                <div class="eb-tab-panel<?php echo $first ? ' active' : ''; ?>"
                     data-lang="<?php echo esc_attr($code); ?>"
                     style="<?php echo $first ? '' : 'display:none;'; ?>">

                    <!-- Post Title -->
                    <div class="estatery-meta-field">
                        <label>Post Title (<?php echo strtoupper($code); ?>)</label>
                        <input type="text"
                               name="blog_title_<?php echo $code; ?>"
                               class="estatery-control-alt"
                               value="<?php echo esc_attr($t_title); ?>"
                               placeholder="Translated headline — leave blank to use English">
                    </div>

                    <hr class="eb-section-divider">

                    <!-- Card Preview Text -->
                    <div class="estatery-meta-field">
                        <label>Card Preview Text (<?php echo strtoupper($code); ?>)</label>
                        <textarea name="blog_excerpt_<?php echo $code; ?>"
                                  class="estatery-control-alt"
                                  rows="3"
                                  placeholder="1–2 sentence teaser on listing cards — leave blank to use English"><?php echo esc_textarea($t_preview); ?></textarea>
                        <p class="eb-hint">💡 Aim for 20–30 words.</p>
                    </div>

                    <hr class="eb-section-divider">

                    <!-- Full Article Body -->
                    <div class="estatery-meta-field">
                        <label>Full Article Body (<?php echo strtoupper($code); ?>)</label>
                        <p class="eb-hint" style="margin-bottom:8px;">📝 Displayed on the article detail page. Supports basic HTML. Leave blank to use English.</p>
                        <textarea name="blog_content_<?php echo $code; ?>"
                                  class="eb-body-area"
                                  placeholder="Full article in <?php echo esc_attr($label); ?> — leave blank to use English"><?php echo esc_textarea($t_content); ?></textarea>
                    </div>

                </div>
            <?php $first = false; endforeach; ?>

        </div><!-- /.eb-tab-group -->
        <?php
    }

    /* =========================================================
       SAVE META DATA
    ========================================================= */

    public function save_meta_data($post_id) {
        // Verify nonce (set in render_excerpt_metabox, always visible)
        if (!isset($_POST['estatery_blog_nonce']) || !wp_verify_nonce($_POST['estatery_blog_nonce'], 'estatery_blog_save')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        // Author fields
        if (isset($_POST['author_name'])) {
            update_post_meta($post_id, '_author_name', sanitize_text_field($_POST['author_name']));
        }
        if (isset($_POST['author_designation'])) {
            update_post_meta($post_id, '_author_designation', sanitize_text_field($_POST['author_designation']));
        }

        // Multilingual fields
        foreach (array_keys(self::LANGS) as $code) {
            if (isset($_POST["blog_title_{$code}"])) {
                update_post_meta($post_id, "_title_{$code}", sanitize_text_field($_POST["blog_title_{$code}"]));
            }
            if (isset($_POST["blog_excerpt_{$code}"])) {
                update_post_meta($post_id, "_excerpt_{$code}", sanitize_textarea_field($_POST["blog_excerpt_{$code}"]));
            }
            if (isset($_POST["blog_content_{$code}"])) {
                update_post_meta($post_id, "_content_{$code}", wp_kses_post($_POST["blog_content_{$code}"]));
            }
        }
    }
}
