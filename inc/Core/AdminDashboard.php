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
            'Investment Leads',
            'Investment Leads',
            'manage_options',
            'estatery-investments',
            [$this, 'render_investments_page']
        );

        add_submenu_page(
            'estatery-inquiries',
            'Contact Messages',
            'Contact Messages',
            'manage_options',
            'estatery-contacts',
            [$this, 'render_contacts_page']
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

    public function render_contacts_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_contacts';

        if (isset($_GET['view_contact'])) {
            $this->render_single_contact_view(intval($_GET['view_contact']));
            return;
        }

        if (isset($_GET['mark_read'])) {
            $wpdb->update($table_name, ['status' => 'read'], ['id' => intval($_GET['mark_read'])]);
        }

        $messages = $wpdb->get_results("SELECT * FROM $table_name ORDER BY time DESC LIMIT 100");

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Contact Messages</h1>
            <hr class="wp-header-end">

            <style>
                .inquiry-table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
                .inquiry-table th, .inquiry-table td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
                .inquiry-table th { background: #fdfdfd; font-weight: 600; color: #444; border-bottom: 2px solid #f0f0f0; }
                .inquiry-table tr:hover { background: #fafafa; }
                .inquiry-table tr.unread { background: #fffcf0; }
                .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
                .status-unread { background: #fcf6e5; color: #854d0e; }
                .status-read { background: #f3f4f6; color: #6b7280; }
                .view-btn { background: #6366f1 !important; color: white !important; border: none !important; padding: 5px 12px !important; border-radius: 4px !important; text-decoration: none !important; font-size: 12px !important; }
                .view-btn:hover { background: #4f46e5 !important; }
            </style>

            <table class="inquiry-table">
                <thead>
                    <tr>
                        <th style="width: 150px;">Date</th>
                        <th>Sender Name</th>
                        <th>Email</th>
                        <th>Sourcing Focus</th>
                        <th>Budget</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($messages)): ?>
                        <tr><td colspan="6" style="text-align: center; padding: 40px;">No messages found yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($messages as $item): ?>
                            <tr class="<?php echo $item->status; ?>">
                                <td style="color: #666;">
                                    <strong><?php echo date('M d, Y', strtotime($item->time)); ?></strong>
                                </td>
                                <td><strong style="color: #1e293b;"><?php echo esc_html($item->first_name . ' ' . $item->last_name); ?></strong></td>
                                <td><a href="mailto:<?php echo esc_attr($item->email); ?>"><?php echo esc_html($item->email); ?></a></td>
                                <td>
                                    <span style="font-size: 11px; color: #64748b;">
                                        <?php echo esc_html($item->property_type); ?> in <?php echo esc_html($item->city); ?>
                                    </span>
                                </td>
                                <td><strong style="color: #059669;"><?php echo esc_html($item->budget); ?></strong></td>
                                <td>
                                    <a href="?page=estatery-contacts&view_contact=<?php echo $item->id; ?>" class="view-btn">View Full Details</a>
                                    <?php if ($item->status === 'unread'): ?>
                                        <a href="?page=estatery-contacts&mark_read=<?php echo $item->id; ?>" style="font-size: 11px; margin-left: 8px; color: #64748b;">Mark Read</a>
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

    private function render_single_contact_view($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_contacts';
        $contact = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

        if (!$contact) {
            echo '<div class="notice notice-error"><p>Message not found.</p></div>';
            return;
        }

        $wpdb->update($table_name, ['status' => 'read'], ['id' => $id]);

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Contact Message Details</h1>
            <a href="?page=estatery-contacts" class="page-title-action">Back to List</a>
            <hr class="wp-header-end">

            <div style="max-width: 900px; background: white; margin-top: 20px; border-radius: 16px; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); overflow: hidden; border: 1px solid #f1f5f9;">
                <div style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 45px; color: white;">
                    <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.15em; opacity: 0.8; font-weight: 700;">Property Sourcing Inquiry</span>
                    <h2 style="margin: 15px 0 0 0; font-size: 32px; color: white; font-weight: 800;"><?php echo esc_html($contact->first_name . ' ' . $contact->last_name); ?></h2>
                    <div style="margin-top: 10px; font-size: 14px; opacity: 0.9;"><?php echo date('l, F j, Y \a\t H:i', strtotime($contact->time)); ?></div>
                </div>

                <div style="padding: 45px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 45px;">
                        <div>
                            <label style="display: block; color: #94a3b8; font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 10px;">Contact Information</label>
                            <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #f1f5f9;">
                                <a href="mailto:<?php echo esc_attr($contact->email); ?>" style="display: block; font-size: 18px; color: #4f46e5; text-decoration: none; font-weight: 700; margin-bottom: 5px;">
                                    <?php echo esc_html($contact->email); ?>
                                </a>
                                <span style="font-size: 16px; color: #475569; font-weight: 600;"><?php echo esc_html($contact->phone ?: 'No phone provided'); ?></span>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; color: #94a3b8; font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 10px;">Investment Budget</label>
                            <div style="background: #ecfdf5; padding: 24px; border-radius: 12px; border: 1px solid #d1fae5; text-align: center;">
                                <span style="font-size: 28px; color: #059669; font-weight: 900;"><?php echo esc_html($contact->budget ?: 'Not Specified'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 45px;">
                        <label style="display: block; color: #94a3b8; font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 20px;">Sourcing Requirements</label>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div style="padding: 20px; background: white; border: 1px solid #f1f5f9; border-radius: 12px; text-align: center;">
                                <span style="display: block; font-size: 9px; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase;">Property Type</span>
                                <strong style="font-size: 13px; color: #1e293b;"><?php echo esc_html($contact->property_type ?: 'N/A'); ?></strong>
                            </div>
                            <div style="padding: 20px; background: white; border: 1px solid #f1f5f9; border-radius: 12px; text-align: center;">
                                <span style="display: block; font-size: 9px; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase;">Target City</span>
                                <strong style="font-size: 13px; color: #1e293b;"><?php echo esc_html($contact->city ?: 'N/A'); ?></strong>
                            </div>
                            <div style="padding: 20px; background: white; border: 1px solid #f1f5f9; border-radius: 12px; text-align: center;">
                                <span style="display: block; font-size: 9px; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase;">ZIP Code</span>
                                <strong style="font-size: 13px; color: #1e293b;"><?php echo esc_html($contact->zip ?: 'N/A'); ?></strong>
                            </div>
                            <div style="padding: 20px; background: white; border: 1px solid #f1f5f9; border-radius: 12px; text-align: center;">
                                <span style="display: block; font-size: 9px; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase;">Bed/Bath</span>
                                <strong style="font-size: 13px; color: #1e293b;"><?php echo esc_html($contact->bedrooms); ?>B / <?php echo esc_html($contact->bathrooms); ?>B</strong>
                            </div>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 35px; display: flex; justify-content: flex-end;">
                        <a href="mailto:<?php echo esc_attr($contact->email); ?>" 
                           style="background: #1e293b; color: white; text-decoration: none; padding: 14px 28px; border-radius: 10px; font-weight: 700; font-size: 13px; transition: background 0.2s;">
                           Reply to Inquiry
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_investments_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_investments';

        if (isset($_GET['view_invest'])) {
            $this->render_single_invest_view(intval($_GET['view_invest']));
            return;
        }

        if (isset($_GET['mark_read'])) {
            $wpdb->update($table_name, ['status' => 'read'], ['id' => intval($_GET['mark_read'])]);
        }

        $leads = $wpdb->get_results("SELECT * FROM $table_name ORDER BY time DESC LIMIT 100");

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Investment Leads</h1>
            <hr class="wp-header-end">

            <style>
                .inquiry-table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
                .inquiry-table th, .inquiry-table td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
                .inquiry-table th { background: #fdfdfd; font-weight: 600; color: #444; border-bottom: 2px solid #f0f0f0; }
                .inquiry-table tr:hover { background: #fafafa; }
                .inquiry-table tr.unread { background: #fffcf0; }
                .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
                .status-unread { background: #fef9c3; color: #854d0e; }
                .status-read { background: #f3f4f6; color: #6b7280; }
                .view-btn { background: #0f172a !important; color: white !important; border: none !important; padding: 5px 12px !important; border-radius: 4px !important; text-decoration: none !important; font-size: 12px !important; }
                .view-btn:hover { background: #334155 !important; }
            </style>

            <table class="inquiry-table">
                <thead>
                    <tr>
                        <th style="width: 150px;">Received At</th>
                        <th>Investor Name</th>
                        <th>Contact Email</th>
                        <th>Investment Range</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($leads)): ?>
                        <tr><td colspan="6" style="text-align: center; padding: 40px;">No investment leads found yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($leads as $item): ?>
                            <tr class="<?php echo $item->status; ?>">
                                <td style="color: #666;">
                                    <span style="font-weight: 600; color: #222;"><?php echo date('M d, Y', strtotime($item->time)); ?></span><br>
                                    <?php echo date('H:i', strtotime($item->time)); ?>
                                </td>
                                <td><strong style="color: #0f172a;"><?php echo esc_html($item->user_name); ?></strong></td>
                                <td><a href="mailto:<?php echo esc_attr($item->user_email); ?>"><?php echo esc_html($item->user_email); ?></a></td>
                                <td>
                                    <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-weight: 600; color: #475569; font-size: 11px;">
                                        <?php echo esc_html($item->amount); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo $item->status === 'unread' ? 'status-unread' : 'status-read'; ?>">
                                        <?php echo $item->status; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?page=estatery-investments&view_invest=<?php echo $item->id; ?>" class="view-btn">View Profile</a>
                                    <?php if ($item->status === 'unread'): ?>
                                        <a href="?page=estatery-investments&mark_read=<?php echo $item->id; ?>" style="font-size: 11px; margin-left: 8px; color: #64748b;">Mark Read</a>
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

    private function render_single_invest_view($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_investments';
        $lead = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

        if (!$lead) {
            echo '<div class="notice notice-error"><p>Lead not found.</p></div>';
            return;
        }

        $wpdb->update($table_name, ['status' => 'read'], ['id' => $id]);

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Investor Profile</h1>
            <a href="?page=estatery-investments" class="page-title-action">Back to List</a>
            <hr class="wp-header-end">

            <div style="max-width: 800px; background: white; margin-top: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); overflow: hidden;">
                <div style="background: #0f172a; padding: 40px; color: white;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.7;">Investment Lead</span>
                            <h2 style="margin: 10px 0 0 0; font-size: 28px; color: white;"><?php echo esc_html($lead->user_name); ?></h2>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 12px; opacity: 0.7;"><?php echo date('F j, Y \a\t H:i', strtotime($lead->time)); ?></span>
                        </div>
                    </div>
                </div>

                <div style="padding: 40px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
                        <div>
                            <strong style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; margin-bottom: 8px;">Contact Information</strong>
                            <a href="mailto:<?php echo esc_attr($lead->user_email); ?>" style="font-size: 18px; color: #2563eb; text-decoration: none; font-weight: 600;">
                                <?php echo esc_html($lead->user_email); ?>
                            </a>
                        </div>
                        <div>
                            <strong style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; margin-bottom: 8px;">Target Investment Range</strong>
                            <span style="font-size: 18px; color: #0f172a; font-weight: 700;"><?php echo esc_html($lead->amount); ?></span>
                        </div>
                    </div>

                    <div style="background: #f8fafc; padding: 30px; border-radius: 12px; margin-bottom: 40px;">
                        <h3 style="margin: 0 0 20px 0; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; color: #475569;">Investor Qualifications</h3>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                            <div style="padding: 15px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; text-align: center;">
                                <span style="display: block; font-size: 10px; color: #64748b; margin-bottom: 5px;">Existing Client</span>
                                <strong style="font-size: 13px; text-transform: uppercase;"><?php echo esc_html($lead->existing_client); ?></strong>
                            </div>
                            <div style="padding: 15px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; text-align: center;">
                                <span style="display: block; font-size: 10px; color: #64748b; margin-bottom: 5px;">Owns Property</span>
                                <strong style="font-size: 13px; text-transform: uppercase;"><?php echo esc_html($lead->own_spanish_property); ?></strong>
                            </div>
                            <div style="padding: 15px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; text-align: center;">
                                <span style="display: block; font-size: 10px; color: #64748b; margin-bottom: 5px;">Tax Resident</span>
                                <strong style="font-size: 13px; text-transform: uppercase;"><?php echo esc_html($lead->tax_resident); ?></strong>
                            </div>
                        </div>
                    </div>

                    <div>
                        <strong style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; margin-bottom: 15px;">Areas of Interest</strong>
                        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <?php 
                            $interests = explode(', ', $lead->interests);
                            foreach ($interests as $interest): 
                                if (empty($interest)) continue;
                            ?>
                                <span style="padding: 6px 14px; background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    <?php echo esc_html($interest); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
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
