<?php
namespace Estatery\Core;

/**
 * Admin Dashboard for Inquiries and Settings
 */
class AdminDashboard {
    public function __construct() {
        add_action('admin_menu', [$this, 'register_menus']);
    }

    public function register_menus() {
        add_menu_page(
            'Estatery Inquiries',
            'Inquiries',
            'manage_options',
            'estatery-inquiries',
            [$this, 'render_inquiries_page'],
            'dashicons-email-alt',
            25
        );

        add_submenu_page(
            'estatery-inquiries',
            'Inquiry Settings',
            'Settings',
            'manage_options',
            'estatery-inquiry-settings',
            [$this, 'render_settings_page']
        );
    }

    public function render_inquiries_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_inquiries';

        // Single Inquiry View Mode
        if (isset($_GET['view_inquiry'])) {
            $this->render_single_inquiry_view(intval($_GET['view_inquiry']));
            return;
        }

        // Mark as read if ID provided
        if (isset($_GET['mark_read'])) {
            $wpdb->update($table_name, ['status' => 'read'], ['id' => intval($_GET['mark_read'])]);
        }

        $inquiries = $wpdb->get_results("SELECT * FROM $table_name ORDER BY time DESC LIMIT 100");

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Property Inquiries</h1>
            <hr class="wp-header-end">

            <style>
                .inquiry-table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
                .inquiry-table th, .inquiry-table td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
                .inquiry-table th { background: #fdfdfd; font-weight: 600; color: #444; border-bottom: 2px solid #f0f0f0; }
                .inquiry-table tr:hover { background: #fafafa; }
                .inquiry-table tr.unread { background: #fffcf0; }
                .prop-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
                .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
                .status-unread { background: #fef9c3; color: #854d0e; }
                .status-read { background: #f3f4f6; color: #6b7280; }
                .view-btn { background: #2563eb !important; color: white !important; border: none !important; padding: 5px 12px !important; border-radius: 4px !important; text-decoration: none !important; font-size: 12px !important; }
                .view-btn:hover { background: #1d4ed8 !important; }
            </style>

            <table class="inquiry-table">
                <thead>
                    <tr>
                        <th style="width: 150px;">Received At</th>
                        <th>Property Info</th>
                        <th>User Details</th>
                        <th>Message Preview</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inquiries)): ?>
                        <tr><td colspan="5" style="text-align: center; padding: 40px;">No inquiries found yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($inquiries as $item): ?>
                            <tr class="<?php echo $item->status; ?>">
                                <td style="color: #666;">
                                    <span style="font-weight: 600; color: #222;"><?php echo date('M d, Y', strtotime($item->time)); ?></span><br>
                                    <?php echo date('H:i', strtotime($item->time)); ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <img src="<?php echo esc_url($item->property_image); ?>" class="prop-thumb">
                                        <div>
                                            <strong style="display: block; margin-bottom: 4px;"><?php echo esc_html($item->property_title); ?></strong>
                                            <span style="font-size: 11px; padding: 2px 6px; background: #f1f5f9; border-radius: 4px; color: #475569;">
                                                <?php echo esc_html($item->property_type); ?> | <?php echo esc_html($item->property_price); ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong style="color: #222;"><?php echo esc_html($item->user_name); ?></strong><br>
                                    <a href="mailto:<?php echo esc_attr($item->user_email); ?>" style="text-decoration: none; font-size: 12px;"><?php echo esc_html($item->user_email); ?></a>
                                </td>
                                <td style="max-width: 300px;">
                                    <div style="font-size: 12px; color: #64748b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?php echo esc_html($item->user_message); ?>
                                    </div>
                                </td>
                                <td>
                                    <a href="?page=estatery-inquiries&view_inquiry=<?php echo $item->id; ?>" class="view-btn">View Details</a>
                                    <?php if ($item->status === 'unread'): ?>
                                        <a href="?page=estatery-inquiries&mark_read=<?php echo $item->id; ?>" style="font-size: 11px; margin-left: 8px; color: #64748b;">Mark Read</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    private function render_single_inquiry_view($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_inquiries';
        $inquiry = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

        if (!$inquiry) {
            echo '<div class="notice notice-error"><p>Inquiry not found.</p></div>';
            return;
        }

        // Mark as read automatically when viewed
        $wpdb->update($table_name, ['status' => 'read'], ['id' => $id]);

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Inquiry Details</h1>
            <a href="?page=estatery-inquiries" class="page-title-action">Back to List</a>
            <hr class="wp-header-end">

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 20px;">
                <!-- User & Message Section -->
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
                        <div>
                            <span style="font-size: 12px; text-transform: uppercase; color: #64748b; font-weight: 600; letter-spacing: 0.05em;">Inquiry from</span>
                            <h2 style="margin: 5px 0; font-size: 24px; color: #1e293b;"><?php echo esc_html($inquiry->user_name); ?></h2>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 12px; color: #64748b;"><?php echo date('F j, Y \a\t H:i', strtotime($inquiry->time)); ?></span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; padding: 20px; background: #f8fafc; border-radius: 8px;">
                        <div>
                            <strong style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase;">Email Address</strong>
                            <a href="mailto:<?php echo esc_attr($inquiry->user_email); ?>" style="font-size: 16px; color: #2563eb; text-decoration: none;"><?php echo esc_html($inquiry->user_email); ?></a>
                        </div>
                        <div>
                            <strong style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase;">Phone Number</strong>
                            <span style="font-size: 16px; color: #1e293b;"><?php echo esc_html($inquiry->user_phone ?: 'Not provided'); ?></span>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <strong style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; margin-bottom: 10px;">Message from User</strong>
                        <div style="font-size: 16px; line-height: 1.8; color: #334155; white-space: pre-line; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff;">
                            <?php echo esc_html($inquiry->user_message); ?>
                        </div>
                    </div>
                </div>

                <!-- Property Details Section -->
                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); height: fit-content;">
                    <img src="<?php echo esc_url($inquiry->property_image); ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
                    
                    <h3 style="margin: 0 0 5px 0; font-size: 18px; color: #1e293b;"><?php echo esc_html($inquiry->property_title); ?></h3>
                    <div style="color: #2563eb; font-weight: 700; font-size: 20px; margin-bottom: 15px;"><?php echo esc_html($inquiry->property_price); ?></div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px;">
                        <div style="padding: 10px; background: #f1f5f9; border-radius: 6px; text-align: center;">
                            <span style="display: block; font-size: 10px; color: #64748b; text-transform: uppercase;">Beds</span>
                            <strong style="font-size: 14px;"><?php echo esc_html($inquiry->property_beds); ?></strong>
                        </div>
                        <div style="padding: 10px; background: #f1f5f9; border-radius: 6px; text-align: center;">
                            <span style="display: block; font-size: 10px; color: #64748b; text-transform: uppercase;">Baths</span>
                            <strong style="font-size: 14px;"><?php echo esc_html($inquiry->property_baths); ?></strong>
                        </div>
                        <div style="padding: 10px; background: #f1f5f9; border-radius: 6px; text-align: center;">
                            <span style="display: block; font-size: 10px; color: #64748b; text-transform: uppercase;">Pool</span>
                            <strong style="font-size: 14px;"><?php echo esc_html($inquiry->property_pool); ?></strong>
                        </div>
                        <div style="padding: 10px; background: #f1f5f9; border-radius: 6px; text-align: center;">
                            <span style="display: block; font-size: 10px; color: #64748b; text-transform: uppercase;">Area</span>
                            <strong style="font-size: 14px;"><?php echo esc_html($inquiry->property_area); ?></strong>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #e2e8f0; padding-top: 15px;">
                        <strong style="display: block; color: #64748b; font-size: 10px; text-transform: uppercase; margin-bottom: 5px;">Location</strong>
                        <p style="font-size: 13px; color: #475569; margin: 0;"><?php echo esc_html($inquiry->property_location); ?></p>
                        
                        <?php if ($inquiry->property_lat && $inquiry->property_lng): ?>
                            <div style="margin-top: 10px; font-size: 11px; color: #94a3b8;">
                                Coordinates: <?php echo esc_html($inquiry->property_lat); ?>, <?php echo esc_html($inquiry->property_lng); ?>
                            </div>
                        <?php endif; ?>

                        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px dashed #e2e8f0;">
                            <a href="<?php echo esc_url(home_url('/property-details/?id=' . $inquiry->property_id)); ?>" 
                               target="_blank"
                               style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; color: #1e293b; text-decoration: none; font-weight: 600; font-size: 13px; transition: all 0.2s;">
                               <span style="margin-right: 8px;">🌐</span> View Property on Site
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_settings_page() {
        if (isset($_POST['estatery_save_settings'])) {
            check_admin_referer('estatery_settings_nonce');
            update_option('estatery_admin_email', sanitize_email($_POST['admin_email']));
            echo '<div class="updated"><p>Settings saved.</p></div>';
        }

        $admin_email = get_option('estatery_admin_email', get_option('admin_email'));
        ?>
        <div class="wrap">
            <h1>Inquiry Settings</h1>
            <form method="post" action="">
                <?php wp_nonce_field('estatery_settings_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="admin_email">Notification Recipient Email</label></th>
                        <td>
                            <input name="admin_email" type="email" id="admin_email" value="<?php echo esc_attr($admin_email); ?>" class="regular-text">
                            <p class="description">This email will receive all property inquiry notifications. Defaults to WordPress admin email.</p>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="estatery_save_settings" id="submit" class="button button-primary" value="Save Settings">
                </p>
            </form>
        </div>
        <?php
    }
}
