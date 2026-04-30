<?php
namespace Estatery\Core;

/**
 * Blog Custom Post Type and Admin Interface
 */
class BlogCPT {
    public function __construct() {
        add_action('init', [$this, 'register_cpt']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_data']);
    }

    public function register_cpt() {
        $labels = [
            'name'               => 'Blogs',
            'singular_name'      => 'Blog',
            'menu_name'          => 'Blogs',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Blog',
            'edit_item'          => 'Edit Blog',
            'new_item'           => 'New Blog',
            'view_item'          => 'View Blog',
            'search_items'       => 'Search Blogs',
            'not_found'          => 'No blogs found',
            'not_found_in_trash' => 'No blogs found in trash'
        ];

        $args = [
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => ['slug' => 'blog-news'],
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'menu_position'       => 27,
            'menu_icon'           => 'dashicons-admin-post',
            'supports'            => ['title', 'editor', 'thumbnail', 'excerpt']
        ];

        register_post_type('blog', $args);

        // Register Taxonomy
        register_taxonomy('blog_category', 'blog', [
            'labels' => [
                'name' => 'Categories',
                'singular_name' => 'Category',
                'search_items' => 'Search Categories',
                'all_items' => 'All Categories',
                'edit_item' => 'Edit Category',
                'update_item' => 'Update Category',
                'add_new_item' => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'menu_name' => 'Categories',
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'blog-category'],
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

    public function add_meta_boxes() {
        add_meta_box(
            'estatery_blog_details',
            'Blog Author Information',
            [$this, 'render_author_metabox'],
            'blog',
            'normal',
            'high'
        );
    }

    public function render_author_metabox($post) {
        wp_nonce_field('estatery_blog_nonce', 'blog_nonce');
        $author_name = get_post_meta($post->ID, '_author_name', true);
        $author_designation = get_post_meta($post->ID, '_author_designation', true);
        ?>
        <style>
            .estatery-meta-field { margin-bottom: 15px; }
            .estatery-meta-field label { display: block; font-weight: 600; margin-bottom: 8px; color: #475569; font-size: 13px; text-transform: uppercase; }
            .estatery-control-alt { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; font-size: 14px; }
            .estatery-control-alt:focus { border-color: #2563eb; outline: none; background: #fff; }
        </style>
        <div class="estatery-meta-field">
            <label>Author Name</label>
            <input type="text" name="author_name" class="estatery-control-alt" value="<?php echo esc_attr($author_name); ?>" placeholder="e.g. Anna Alizarenko">
        </div>
        <div class="estatery-meta-field">
            <label>Author Designation</label>
            <input type="text" name="author_designation" class="estatery-control-alt" value="<?php echo esc_attr($author_designation); ?>" placeholder="e.g. Founder & Advisor">
        </div>
        <?php
    }

    public function save_meta_data($post_id) {
        if (!isset($_POST['blog_nonce']) || !wp_verify_nonce($_POST['blog_nonce'], 'estatery_blog_nonce')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['author_name'])) {
            update_post_meta($post_id, '_author_name', sanitize_text_field($_POST['author_name']));
        }
        if (isset($_POST['author_designation'])) {
            update_post_meta($post_id, '_author_designation', sanitize_text_field($_POST['author_designation']));
        }
    }
}
