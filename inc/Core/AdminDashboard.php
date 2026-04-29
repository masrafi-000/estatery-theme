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
            'Inquiry Management',
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
            'Investment Inquiries',
            'Investment Inquiries',
            'manage_options',
            'estatery-investment-queries',
            [$this, 'render_investment_queries_page']
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

        add_menu_page(
            'Manage Properties',
            'Properties',
            'manage_options',
            'estatery-properties',
            [$this, 'render_properties_page'],
            'dashicons-admin-home',
            26
        );

        add_submenu_page(
            'estatery-properties',
            'Add Properties',
            'Add Properties',
            'manage_options',
            'estatery-add-property',
            [$this, 'render_add_properties_page']
        );

        add_menu_page(
            'Investment Portfolio',
            'Invest Portfolio',
            'manage_options',
            'estatery-investment-portfolio',
            [$this, 'render_investment_portfolio_page'],
            'dashicons-chart-line',
            27
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

    public function render_properties_page() {
        $action = $_GET['action'] ?? 'list';
        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

        if ($action === 'add' || $action === 'edit') {
            $this->render_property_form($post_id);
            return;
        }

        if ($action === 'delete' && $post_id) {
            check_admin_referer('estatery_delete_property_' . $post_id);
            wp_delete_post($post_id, true);
            echo '<div class="updated"><p>Property deleted.</p></div>';
        }

        $properties = get_posts([
            'post_type' => 'property',
            'posts_per_page' => -1,
            'post_status' => ['publish', 'draft', 'pending']
        ]);

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Manage Properties</h1>
            <a href="?page=estatery-add-property" class="page-title-action">Add New Property</a>
            <hr class="wp-header-end">

            <style>
                .prop-list-table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
                .prop-list-table th, .prop-list-table td { padding: 15px; text-align: left; border-bottom: 1px solid #f1f5f9; }
                .prop-list-table th { background: #f8fafc; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em; }
                .prop-list-table tr:hover { background: #fcfcfc; }
                .prop-thumb-small { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; }
                .badge { padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
                .badge-blue { background: #eff6ff; color: #2563eb; }
                .badge-green { background: #ecfdf5; color: #059669; }
                .btn-edit { color: #2563eb; text-decoration: none; font-weight: 600; margin-right: 15px; }
                .btn-delete { color: #dc2626; text-decoration: none; font-weight: 600; }
            </style>

            <table class="prop-list-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">Image</th>
                        <th>Property Title</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Specs</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($properties)): ?>
                        <tr><td colspan="7" style="text-align: center; padding: 50px; color: #94a3b8;">No properties added yet. Click "Add New Property" to begin.</td></tr>
                    <?php else: ?>
                        <?php foreach ($properties as $prop): 
                            $price = get_post_meta($prop->ID, '_price', true);
                            $currency = get_post_meta($prop->ID, '_currency', true) ?: 'EUR';
                            $town = get_post_meta($prop->ID, '_town', true);
                            $type = get_post_meta($prop->ID, '_type', true);
                            $beds = get_post_meta($prop->ID, '_beds', true);
                            $baths = get_post_meta($prop->ID, '_baths', true);
                            $img = get_the_post_thumbnail_url($prop->ID, 'thumbnail') ?: (get_post_meta($prop->ID, '_gallery', true)[0] ?? '');
                        ?>
                            <tr>
                                <td><img src="<?php echo esc_url($img ?: 'https://via.placeholder.com/150'); ?>" class="prop-thumb-small"></td>
                                <td>
                                    <strong style="display: block; color: #1e293b;"><?php echo esc_html($prop->post_title); ?></strong>
                                    <span style="font-size: 11px; color: #64748b;"><?php echo esc_html(ucfirst($type)); ?></span>
                                </td>
                                <td><span style="font-size: 13px; color: #475569;"><?php echo esc_html($town); ?></span></td>
                                <td><strong style="color: #2563eb;"><?php echo number_format((float)$price); ?> <?php echo $currency === 'EUR' ? '€' : '$'; ?></strong></td>
                                <td>
                                    <span style="font-size: 12px; color: #64748b;">
                                        <?php echo $beds; ?> Beds | <?php echo $baths; ?> Baths
                                    </span>
                                </td>
                                <td><span class="badge badge-blue"><?php echo $prop->post_status; ?></span></td>
                                <td>
                                    <a href="?page=estatery-properties&action=edit&post_id=<?php echo $prop->ID; ?>" class="btn-edit">Edit</a>
                                    <a href="<?php echo wp_nonce_url('?page=estatery-properties&action=delete&post_id=' . $prop->ID, 'estatery_delete_property_' . $prop->ID); ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this property?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_add_properties_page() {
        $this->render_property_form(0);
    }

    private function render_property_form($post_id = 0) {
        $is_edit = $post_id > 0;
        
        // Ensure WordPress Media scripts are loaded
        wp_enqueue_media();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['estatery_save_property'])) {
            check_admin_referer('estatery_save_property_nonce');
            
            $post_data = [
                'post_title'   => sanitize_text_field($_POST['post_title']),
                'post_content' => wp_kses_post($_POST['post_content']),
                'post_status'  => 'publish',
                'post_type'    => 'property'
            ];

            if ($is_edit) {
                $post_data['ID'] = $post_id;
                wp_update_post($post_data);
            } else {
                $post_id = wp_insert_post($post_data);
            }

            // Manually trigger meta save from PropertyCPT class
            $cpt = new \Estatery\Core\PropertyCPT();
            $cpt->save_meta_data($post_id);
            
            echo '<div class="updated notice is-dismissible" style="border-left-color: #2563eb;"><p><strong>Property saved successfully!</strong></p></div>';
            $is_edit = true;
        }

        $post = $is_edit ? get_post($post_id) : null;
        $cpt = new \Estatery\Core\PropertyCPT();
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            .estatery-admin-wrap { font-family: 'Inter', sans-serif; color: #1e293b; max-width: 1200px; margin: 20px auto; }
            .estatery-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
            .estatery-header h1 { font-size: 28px; font-weight: 700; color: #0f172a; margin: 0; }
            .estatery-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #f1f5f9; }
            
            .estatery-form-layout { display: grid; grid-template-columns: 240px 1fr; gap: 2px; background: #f1f5f9; }
            .estatery-form-tabs { background: white; padding: 20px 0; }
            .estatery-tab-link { display: flex; align-items: center; gap: 12px; padding: 12px 24px; color: #64748b; text-decoration: none; font-weight: 500; transition: all 0.2s; border-right: 3px solid transparent; cursor: pointer; }
            .estatery-tab-link:hover { background: #f8fafc; color: #2563eb; }
            .estatery-tab-link.active { background: #eff6ff; color: #2563eb; border-right-color: #2563eb; }
            .estatery-tab-link svg { width: 18px; height: 18px; }

            .estatery-form-content { background: white; padding: 40px; min-height: 600px; }
            .estatery-section-title { font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 24px 0; display: flex; align-items: center; gap: 10px; }
            .estatery-section-title::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }

            .estatery-input-group { margin-bottom: 24px; }
            .estatery-input-group label { display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.025em; }
            .estatery-control { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 15px; color: #1e293b; transition: all 0.2s; background: #f8fafc; }
            .estatery-control:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); background: white; }
            
            .estatery-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
            .estatery-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

            .estatery-btn-primary { background: #2563eb; color: white; padding: 12px 32px; border-radius: 12px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; font-size: 15px; display: inline-flex; align-items: center; gap: 8px; }
            .estatery-btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.2); }
            .estatery-btn-primary:active { transform: translateY(0); }

            .estatery-btn-outline { background: white; color: #64748b; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s; }
            .estatery-btn-outline:hover { background: #f8fafc; color: #1e293b; border-color: #cbd5e1; }

            .estatery-wizard-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 50px; padding-top: 30px; border-top: 1px solid #f1f5f9; }

            .estatery-tab-pane { display: none; animation: fadeIn 0.3s ease-out; }
            .estatery-tab-pane.active { display: block; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

            /* Customizing the child forms from PropertyCPT */
            .estatery-custom-fields hr { border: none; border-top: 1px solid #f1f5f9; margin: 30px 0; }
            .estatery-gallery-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)) !important; }
            .estatery-gallery-item { border-radius: 12px !important; border: 2px dashed #e2e8f0 !important; transition: all 0.2s; }
            .estatery-gallery-item:hover { border-color: #2563eb !important; }
            
            /* WP Editor Overrides */
            .wp-editor-container { border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0 !important; }
        </style>

        <div class="estatery-admin-wrap">
            <div class="estatery-header">
                <div>
                    <a href="?page=estatery-properties" class="estatery-btn-outline" style="margin-bottom: 10px; display: inline-block;">← Back to List</a>
                    <h1><?php echo $is_edit ? 'Edit Property' : 'Create New Property'; ?></h1>
                </div>
                <button type="submit" form="property-form" name="estatery_save_property" class="estatery-btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <?php echo $is_edit ? 'Update Property' : 'Publish Property'; ?>
                </button>
            </div>

            <form id="property-form" method="post" action="">
                <?php wp_nonce_field('estatery_save_property_nonce'); ?>
                <?php wp_nonce_field('estatery_property_nonce', 'property_nonce'); ?>

                <div class="estatery-card estatery-form-layout">
                    <!-- Sidebar Tabs -->
                    <div class="estatery-form-tabs">
                        <div class="estatery-tab-link active" data-tab="general">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            General
                        </div>
                        <div class="estatery-tab-link" data-tab="specs">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Specifications
                        </div>
                        <div class="estatery-tab-link" data-tab="location">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Location
                        </div>
                        <div class="estatery-tab-link" data-tab="translations">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5a18.022 18.022 0 01-3.827-5.806m1.002 5.038a2 2 0 01-.996-2.011m12.153-1.16a9 9 0 01-18.151 0l16.7 1.181a9 9 0 011.451 0z"/></svg>
                            Translations
                        </div>
                        <div class="estatery-tab-link" data-tab="media">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Gallery
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="estatery-form-content">
                        <!-- General Tab -->
                        <div id="pane-general" class="estatery-tab-pane active">
                            <h2 class="estatery-section-title">General Information & Pricing</h2>
                            <div class="estatery-input-group">
                                <label>Property Listing Title</label>
                                <input type="text" name="post_title" class="estatery-control" placeholder="Enter property name (e.g. Luxury Villa in Polop)..." value="<?php echo esc_attr($post ? $post->post_title : ''); ?>" required>
                            </div>
                            
                            <div style="background: #f8fafc; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 30px;">
                                <?php $cpt->render_pricing_fields($post ?: (object)['ID' => 0]); ?>
                            </div>

                            <div class="estatery-input-group">
                                <label>English Description (Main)</label>
                                <?php wp_editor($post ? $post->post_content : '', 'post_content', ['textarea_rows' => 12, 'media_buttons' => false]); ?>
                            </div>

                            <div class="estatery-wizard-footer">
                                <div></div>
                                <button type="button" class="estatery-btn-primary wizard-next" data-next="specs">Next: Specifications →</button>
                            </div>
                        </div>

                        <!-- Specs Tab -->
                        <div id="pane-specs" class="estatery-tab-pane">
                            <h2 class="estatery-section-title">Specifications & Amenities</h2>
                            <p style="color: #64748b; margin-bottom: 24px;">Enter the physical details and features that will appear in the property spec sheet.</p>
                            <?php $cpt->render_specs_fields($post ?: (object)['ID' => 0]); ?>

                            <div class="estatery-wizard-footer">
                                <button type="button" class="estatery-btn-outline wizard-prev" data-prev="general">← Back</button>
                                <button type="button" class="estatery-btn-primary wizard-next" data-next="location">Next: Location →</button>
                            </div>
                        </div>

                        <!-- Location Tab -->
                        <div id="pane-location" class="estatery-tab-pane">
                            <h2 class="estatery-section-title">Geographic Location</h2>
                            <p style="color: #64748b; margin-bottom: 24px;">Provide the exact location. Coordinates are used to place the pin on the Google Map.</p>
                            <?php $cpt->render_location_fields($post ?: (object)['ID' => 0]); ?>

                            <div class="estatery-wizard-footer">
                                <button type="button" class="estatery-btn-outline wizard-prev" data-prev="specs">← Back</button>
                                <button type="button" class="estatery-btn-primary wizard-next" data-next="translations">Next: Translations →</button>
                            </div>
                        </div>

                        <!-- Translations Tab -->
                        <div id="pane-translations" class="estatery-tab-pane">
                            <h2 class="estatery-section-title">Multilingual Descriptions</h2>
                            <p style="color: #64748b; margin-bottom: 24px;">Provide translations for international visitors. If left blank, the English description will be used.</p>
                            <div class="estatery-translations-container">
                                <?php $cpt->render_translations_metabox($post ?: (object)['ID' => 0]); ?>
                            </div>

                            <div class="estatery-wizard-footer">
                                <button type="button" class="estatery-btn-outline wizard-prev" data-prev="location">← Back</button>
                                <button type="button" class="estatery-btn-primary wizard-next" data-next="media">Next: Media Gallery →</button>
                            </div>
                        </div>

                        <!-- Media Tab -->
                        <div id="pane-media" class="estatery-tab-pane">
                            <h2 class="estatery-section-title">Property Media & Featured Image</h2>
                            <p style="color: #64748b; margin-bottom: 24px;">Upload and arrange images. The <strong>Featured Image</strong> is what users see first in the search results.</p>
                            
                            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
                                <div>
                                    <?php $cpt->render_featured_image_section($post ?: (object)['ID' => 0]); ?>
                                </div>
                                <div style="background: #f8fafc; padding: 30px; border-radius: 16px; border: 2px dashed #e2e8f0; text-align: center;">
                                    <label style="display: block; font-weight: 700; margin-bottom: 15px; text-align: left; color: #1e293b;">Additional Gallery Images</label>
                                    <?php $cpt->render_gallery_metabox($post ?: (object)['ID' => 0]); ?>
                                </div>
                            </div>

                            <div class="estatery-wizard-footer">
                                <button type="button" class="estatery-btn-outline wizard-prev" data-prev="translations">← Back</button>
                                <button type="submit" name="estatery_save_property" class="estatery-btn-primary">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Save & Publish Property
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            jQuery(document).ready(function($) {
                // Main Tab Switching Logic
                $('.estatery-tab-link').on('click', function() {
                    var tab = $(this).data('tab');
                    $('.estatery-tab-link').removeClass('active');
                    $(this).addClass('active');
                    $('.estatery-tab-pane').removeClass('active');
                    $('#pane-' + tab).addClass('active');
                });

                // Wizard Next/Prev Buttons
                $('.wizard-next').on('click', function() {
                    var currentPane = $(this).closest('.estatery-tab-pane');
                    var isValid = true;
                    var errors = [];

                    // Validation Logic per Tab
                    currentPane.find('[required]').each(function() {
                        if (!$(this).val() || $(this).val() === '0') {
                            isValid = false;
                            $(this).css('border-color', '#ef4444');
                            errors.push($(this).prev('label').text().replace(':', '') + ' is required.');
                        } else {
                            $(this).css('border-color', '#e2e8f0');
                        }
                    });

                    // Custom validation for specific tabs
                    if (currentPane.attr('id') === 'pane-general') {
                        var price = $('input[name="property_price"]').val();
                        if (!price || price <= 0) {
                            isValid = false;
                            $('input[name="property_price"]').css('border-color', '#ef4444');
                            errors.push('Price must be greater than 0.');
                        }
                    }

                    if (currentPane.attr('id') === 'pane-location') {
                        var lat = $('input[name="property_latitude"]').val();
                        var lng = $('input[name="property_longitude"]').val();
                        if (!lat || !lng) {
                            isValid = false;
                            $('input[name="property_latitude"], input[name="property_longitude"]').css('border-color', '#ef4444');
                            errors.push('Coordinates (Latitude/Longitude) are required for the map.');
                        }
                    }

                    if (!isValid) {
                        alert('Please complete the following:\n\n- ' + errors.join('\n- '));
                        return false;
                    }

                    var nextTab = $(this).data('next');
                    $('.estatery-tab-link[data-tab="' + nextTab + '"]').click();
                    window.scrollTo(0, 0);
                });

                $('.wizard-prev').on('click', function() {
                    var prevTab = $(this).data('prev');
                    $('.estatery-tab-link[data-tab="' + prevTab + '"]').click();
                    window.scrollTo(0, 0);
                });

                // Media Uploader Logic
                var galleryFrame;
                $(document).on('click', '#estatery-add-gallery', function(e) {
                    e.preventDefault();
                    if (galleryFrame) { galleryFrame.open(); return; }
                    galleryFrame = wp.media({
                        title: 'Select Property Images',
                        button: { text: 'Add to Gallery' },
                        multiple: true
                    });
                    galleryFrame.on('select', function() {
                        var attachments = galleryFrame.state().get('selection').toJSON();
                        attachments.forEach(function(attachment) {
                            var html = '<div class="estatery-gallery-item">' +
                                       '<img src="' + attachment.url + '">' +
                                       '<button type="button" class="remove-img">×</button>' +
                                       '<input type="hidden" name="property_gallery[]" value="' + attachment.url + '">' +
                                       '</div>';
                            $('#estatery-gallery-container').append(html);
                        });
                    });
                    galleryFrame.open();
                });

                $(document).on('click', '.remove-img', function(e) {
                    e.preventDefault();
                    $(this).closest('.estatery-gallery-item').remove();
                });

                // Featured Image Logic
                var featuredFrame;
                $(document).on('click', '#estatery-featured-img-container', function(e) {
                    e.preventDefault();
                    if (featuredFrame) { featuredFrame.open(); return; }
                    featuredFrame = wp.media({
                        title: 'Select Featured Image',
                        button: { text: 'Set Featured Image' },
                        multiple: false
                    });
                    featuredFrame.on('select', function() {
                        var attachment = featuredFrame.state().get('selection').first().toJSON();
                        $('#estatery-featured-img-container').html('<img src="' + attachment.url + '" style="max-width:100%; border-radius:8px; margin-bottom:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"><br><button type="button" id="estatery-remove-featured" class="button button-link-delete" style="color:#ef4444;">Remove Image</button><input type="hidden" name="_thumbnail_id" id="estatery-featured-img-id" value="' + attachment.id + '">');
                    });
                    featuredFrame.open();
                });

                $(document).on('click', '#estatery-remove-featured', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('#estatery-featured-img-container').html('<div style="color: #64748b;"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" style="margin-bottom: 10px; opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><p style="margin: 0; font-weight: 500;">Click to set featured image</p></div><input type="hidden" name="_thumbnail_id" id="estatery-featured-img-id" value="">');
                });

                // Multilingual Inner Tabs
                $(document).on('click', '.estatery-inner-tab-btn', function() {
                    var target = $(this).data('target');
                    var container = $(this).closest('.estatery-translations-container');
                    container.find('.estatery-inner-tab-btn').removeClass('active');
                    $(this).addClass('active');
                    container.find('.estatery-inner-tab-content').removeClass('active').hide();
                    container.find('#' + target).addClass('active').show();
                });
            });
        </script>
        <?php
    }

    public function render_investment_queries_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_investment_queries';

        if (isset($_GET['view_inquiry'])) {
            $this->render_single_investment_query_view(intval($_GET['view_inquiry']));
            return;
        }

        if (isset($_GET['mark_read'])) {
            $wpdb->update($table_name, ['status' => 'read'], ['id' => intval($_GET['mark_read'])]);
        }

        $inquiries = $wpdb->get_results("SELECT * FROM $table_name ORDER BY time DESC LIMIT 100");

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Investment Property Inquiries</h1>
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
                        <tr><td colspan="5" style="text-align: center; padding: 40px;">No investment inquiries found yet.</td></tr>
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
                                    <a href="?page=estatery-investment-queries&view_inquiry=<?php echo $item->id; ?>" class="view-btn">View Details</a>
                                    <?php if ($item->status === 'unread'): ?>
                                        <a href="?page=estatery-investment-queries&mark_read=<?php echo $item->id; ?>" style="font-size: 11px; margin-left: 8px; color: #64748b;">Mark Read</a>
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

    private function render_single_investment_query_view($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_investment_queries';
        $inquiry = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

        if (!$inquiry) {
            echo '<div class="notice notice-error"><p>Inquiry not found.</p></div>';
            return;
        }

        $wpdb->update($table_name, ['status' => 'read'], ['id' => $id]);

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Investment Inquiry Details</h1>
            <a href="?page=estatery-investment-queries" class="page-title-action">Back to List</a>
            <hr class="wp-header-end">

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 20px;">
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
                        <div>
                            <span style="font-size: 12px; text-transform: uppercase; color: #64748b; font-weight: 600; letter-spacing: 0.05em;">Investment Inquiry from</span>
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
                        <strong style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; margin-bottom: 10px;">Message from Investor</strong>
                        <div style="font-size: 16px; line-height: 1.8; color: #334155; white-space: pre-line; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff;">
                            <?php echo esc_html($inquiry->user_message); ?>
                        </div>
                    </div>
                </div>

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
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_investment_portfolio_page() {
        $handler = new InvestPortfolioHandler();
        $action = $_GET['action'] ?? 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Handle Actions
        if ($action === 'sync') {
            $handler->import_from_json();
            echo '<div class="updated"><p>Successfully imported properties from JSON file.</p></div>';
            $action = 'list';
        }

        if ($action === 'delete' && $id) {
            check_admin_referer('estatery_delete_invest_' . $id);
            $handler->delete($id);
            echo '<div class="updated"><p>Investment property deleted.</p></div>';
            $action = 'list';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['estatery_save_invest'])) {
            check_admin_referer('estatery_save_invest_nonce');
            
            $data = [
                'id'              => $id,
                'external_id'     => $_POST['external_id'],
                'title'           => $_POST['title'],
                'price'           => $_POST['price'],
                'currency'        => $_POST['currency'],
                'type'            => $_POST['type'],
                'town'            => $_POST['town'],
                'province'        => $_POST['province'],
                'country'         => $_POST['country'],
                'location_detail' => $_POST['location_detail'],
                'beds'            => $_POST['beds'],
                'baths'           => $_POST['baths'],
                'built_area'      => $_POST['built_area'],
                'plot_size'       => $_POST['plot_size'],
                'new_build'       => $_POST['new_build'] ?? '0',
                'pool_count'      => $_POST['pool_count'] ?? '0',
                'images'          => $_POST['property_gallery'] ?? [],
                'descriptions'    => [
                    'en' => [$_POST['desc_en']],
                    'es' => [$_POST['desc_es']],
                    'pl' => [$_POST['desc_pl']],
                    'ru' => [$_POST['desc_ru']]
                ],
                'features'        => $_POST['property_features'] ?? [],
                'lat'             => $_POST['lat'] ?? '',
                'lng'             => $_POST['lng'] ?? '',
                'featured_image'  => $_POST['featured_image'] ?? ''
            ];

            $handler->save($data);
            echo '<div class="updated"><p>Investment property saved successfully!</p></div>';
            $action = 'list';
        }

        // Render Views
        if ($action === 'add' || $action === 'edit') {
            $this->render_investment_form($id);
            return;
        }

        $items = $handler->get_all();
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            .estatery-admin-wrap { font-family: 'Inter', sans-serif; color: #1e293b; max-width: 1200px; margin: 20px auto; }
            .estatery-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
            .estatery-header h1 { font-size: 28px; font-weight: 700; color: #0f172a; margin: 0; }
            .estatery-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #f1f5f9; }
            
            .estatery-table { width: 100%; border-collapse: collapse; }
            .estatery-table th { background: #f8fafc; padding: 16px 24px; text-align: left; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; }
            .estatery-table td { padding: 20px 24px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; color: #475569; font-size: 14px; }
            .estatery-table tr:last-child td { border-bottom: none; }
            .estatery-table tr:hover td { background: #fdfdfd; }

            .prop-thumb { width: 64px; height: 44px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            .prop-id { font-family: monospace; background: #f1f5f9; padding: 4px 8px; border-radius: 6px; color: #475569; font-size: 11px; font-weight: 600; }
            .prop-title { font-weight: 700; color: #0f172a; display: block; margin-bottom: 4px; }
            .prop-loc { font-size: 12px; color: #94a3b8; display: flex; align-items: center; gap: 4px; }
            .prop-price { font-weight: 700; color: #059669; font-size: 15px; }

            .estatery-btn-primary { background: #2563eb; color: white; padding: 10px 20px; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
            .estatery-btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }
            .estatery-btn-outline { background: white; color: #64748b; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; }
            .estatery-btn-outline:hover { background: #f8fafc; color: #1e293b; border-color: #cbd5e1; }
            
            .action-btns { display: flex; gap: 8px; }
            .btn-edit { color: #2563eb; background: #eff6ff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; }
            .btn-edit:hover { background: #dbeafe; }
            .btn-delete { color: #ef4444; background: #fef2f2; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; }
            .btn-delete:hover { background: #fee2e2; }
        </style>

        <div class="estatery-admin-wrap">
            <div class="estatery-header">
                <h1>Investment Portfolio</h1>
                <div style="display: flex; gap: 12px;">
                    <a href="?page=estatery-investment-portfolio&action=sync" class="estatery-btn-outline" style="background: #0f172a; color: white; border: none;" onclick="return confirm('Import from JSON if database is empty?')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Import from JSON
                    </a>
                    <a href="?page=estatery-investment-portfolio&action=add" class="estatery-btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add New Investment
                    </a>
                </div>
            </div>

            <div class="estatery-card">
                <table class="estatery-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Property</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Specifications</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr><td colspan="6" style="text-align: center; padding: 80px; color: #94a3b8; font-style: italic;">No investment properties found. Start by adding one or importing from JSON.</td></tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): 
                                $imgs = json_decode($item['images'], true);
                                $thumb = !empty($imgs) ? $imgs[0] : '';
                            ?>
                                <tr>
                                    <td><span class="prop-id"><?php echo esc_html($item['external_id']); ?></span></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <img src="<?php echo esc_url($thumb); ?>" class="prop-thumb">
                                            <div>
                                                <span class="prop-title"><?php echo esc_html($item['title']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-size: 11px; background: #f1f5f9; padding: 4px 8px; border-radius: 6px; text-transform: uppercase; font-weight: 600; color: #64748b;"><?php echo esc_html($item['type']); ?></span>
                                    </td>
                                    <td>
                                        <?php if ($item['new_build']): ?>
                                            <span style="font-size: 11px; background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 9999px; font-weight: 600;">NEW BUILD</span>
                                        <?php else: ?>
                                            <span style="font-size: 11px; background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 9999px; font-weight: 600;">RESALE</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="prop-loc">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                            <?php echo esc_html($item['town']); ?>, <?php echo esc_html($item['country']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #64748b;">
                                            <span><strong><?php echo $item['beds']; ?></strong> Beds, <strong><?php echo $item['baths']; ?></strong> Baths</span>
                                            <span><strong><?php echo $item['built_area']; ?></strong> m² Built, <strong><?php echo $item['plot_size']; ?></strong> m² Plot</span>
                                            <?php if ($item['pool_count'] > 0): ?>
                                                <span><strong><?php echo $item['pool_count']; ?></strong> <?php echo $item['pool_count'] > 1 ? 'Pools' : 'Pool'; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="prop-price"><?php echo number_format($item['price']); ?> <?php echo esc_html($item['currency']); ?></span>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="?page=estatery-investment-portfolio&action=edit&id=<?php echo $item['id']; ?>" class="btn-edit">Edit</a>
                                            <a href="<?php echo wp_nonce_url('?page=estatery-investment-portfolio&action=delete&id=' . $item['id'], 'estatery_delete_invest_' . $item['id']); ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    private function render_investment_form($id = 0) {
        $handler = new InvestPortfolioHandler();
        $item = $id > 0 ? $handler->get_by_id($id) : null;
        $images = $item ? json_decode($item['images'], true) : [];
        $descriptions = $item ? json_decode($item['descriptions'], true) : [];
        $features = $item ? json_decode($item['features'], true) : [];

        wp_enqueue_media();
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            .estatery-admin-wrap { font-family: 'Inter', sans-serif; color: #1e293b; max-width: 1200px; margin: 20px auto; }
            .estatery-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
            .estatery-header h1 { font-size: 28px; font-weight: 700; color: #0f172a; margin: 0; }
            .estatery-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #f1f5f9; }
            
            .estatery-form-layout { display: grid; grid-template-columns: 240px 1fr; gap: 2px; background: #f1f5f9; }
            .estatery-form-tabs { background: white; padding: 20px 0; }
            .estatery-tab-link { display: flex; align-items: center; gap: 12px; padding: 12px 24px; color: #64748b; text-decoration: none; font-weight: 500; transition: all 0.2s; border-right: 3px solid transparent; cursor: pointer; }
            .estatery-tab-link:hover { background: #f8fafc; color: #2563eb; }
            .estatery-tab-link.active { background: #eff6ff; color: #2563eb; border-right-color: #2563eb; }
            .estatery-tab-link svg { width: 18px; height: 18px; }

            .estatery-form-content { background: white; padding: 40px; min-height: 600px; }
            .estatery-section-title { font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 24px 0; display: flex; align-items: center; gap: 10px; }
            .estatery-section-title::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }

            .estatery-input-group { margin-bottom: 24px; }
            .estatery-input-group label { display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.025em; }
            .estatery-control { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 15px; color: #1e293b; transition: all 0.2s; background: #f8fafc; }
            .estatery-control:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); background: white; }
            
            .estatery-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
            .estatery-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

            .estatery-btn-primary { background: #2563eb; color: white; padding: 12px 32px; border-radius: 12px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; font-size: 15px; display: inline-flex; align-items: center; gap: 8px; }
            .estatery-btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.2); }
            .estatery-btn-outline { background: white; color: #64748b; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s; }
            .estatery-btn-outline:hover { background: #f8fafc; color: #1e293b; border-color: #cbd5e1; }

            .estatery-tab-pane { display: none; animation: fadeIn 0.3s ease-out; }
            .estatery-tab-pane.active { display: block; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

            .estatery-inner-tab-nav { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
            .estatery-inner-tab-btn { background: none; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; color: #64748b; font-weight: 600; font-size: 13px; }
            .estatery-inner-tab-btn.active { background: #f1f5f9; color: #2563eb; }

            /* Gallery Styles */
            .estatery-gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 15px; margin-top: 15px; }
            .estatery-gallery-item { position: relative; aspect-ratio: 1; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; background: #f1f5f9; }
            .estatery-gallery-item img { width: 100%; height: 100%; object-fit: cover; }
            .estatery-gallery-item .remove-img { position: absolute; top: 5px; right: 5px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            
            .featured-img-preview { width: 100%; aspect-ratio: 16/9; background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; position: relative; }
            .featured-img-preview img { width: 100%; height: 100%; object-fit: cover; }
            .featured-img-preview:hover { border-color: #2563eb; }

            .wizard-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid #f1f5f9; }
        </style>

        <div class="estatery-admin-wrap">
            <div class="estatery-header">
                <div>
                    <a href="?page=estatery-investment-portfolio" class="estatery-btn-outline" style="margin-bottom: 10px; display: inline-block;">← Back to Portfolio</a>
                    <h1><?php echo $id > 0 ? 'Edit Investment' : 'New Investment'; ?></h1>
                </div>
                <button type="submit" form="investment-form" name="estatery_save_invest" class="estatery-btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Investment
                </button>
            </div>

            <form id="investment-form" method="post" action="">
                <?php wp_nonce_field('estatery_save_invest_nonce'); ?>
                
                <div class="estatery-card estatery-form-layout">
                    <!-- Sidebar Tabs -->
                    <div class="estatery-form-tabs">
                        <div class="estatery-tab-link active" data-tab="general">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            General
                        </div>
                        <div class="estatery-tab-link" data-tab="specs">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Specs
                        </div>
                        <div class="estatery-tab-link" data-tab="location">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Location
                        </div>
                        <div class="estatery-tab-link" data-tab="translations">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5a18.022 18.022 0 01-3.827-5.806m1.002 5.038a2 2 0 01-.996-2.011m12.153-1.16a9 9 0 01-18.151 0l16.7 1.181a9 9 0 011.451 0z"/></svg>
                            Descriptions
                        </div>
                        <div class="estatery-tab-link" data-tab="media">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Media
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="estatery-form-content">
                        <!-- General Tab -->
                        <div class="estatery-tab-pane active" data-tab="general">
                            <h3 class="estatery-section-title">General Information</h3>
                            <div class="estatery-grid-2">
                                <div class="estatery-input-group">
                                    <label>Internal ID (e.g. INV001)</label>
                                    <input type="text" name="external_id" value="<?php echo esc_attr($item['external_id'] ?? ''); ?>" class="estatery-control" required>
                                </div>
                                <div class="estatery-input-group">
                                    <label>Main Title</label>
                                    <input type="text" name="title" value="<?php echo esc_attr($item['title'] ?? ''); ?>" class="estatery-control" required>
                                </div>
                            </div>

                            <div class="estatery-grid-3">
                                <div class="estatery-input-group">
                                    <label>Price (€)</label>
                                    <input type="number" name="price" value="<?php echo esc_attr($item['price'] ?? ''); ?>" class="estatery-control" required>
                                </div>
                                <div class="estatery-input-group">
                                    <label>Currency</label>
                                    <select name="currency" class="estatery-control">
                                        <option value="EUR" <?php selected($item['currency'] ?? 'EUR', 'EUR'); ?>>EUR (€)</option>
                                        <option value="USD" <?php selected($item['currency'] ?? '', 'USD'); ?>>USD ($)</option>
                                        <option value="GBP" <?php selected($item['currency'] ?? '', 'GBP'); ?>>GBP (£)</option>
                                    </select>
                                </div>
                                <div class="estatery-input-group">
                                    <label>Property Type</label>
                                    <select name="type" class="estatery-control">
                                        <option value="villa" <?php selected($item['type'] ?? '', 'villa'); ?>>Villa</option>
                                        <option value="apartment" <?php selected($item['type'] ?? '', 'apartment'); ?>>Apartment</option>
                                        <option value="penthouse" <?php selected($item['type'] ?? '', 'penthouse'); ?>>Penthouse</option>
                                        <option value="townhouse" <?php selected($item['type'] ?? '', 'townhouse'); ?>>Townhouse</option>
                                        <option value="bungalow" <?php selected($item['type'] ?? '', 'bungalow'); ?>>Bungalow</option>
                                        <option value="plot" <?php selected($item['type'] ?? '', 'plot'); ?>>Plot / Land</option>
                                        <option value="commercial" <?php selected($item['type'] ?? '', 'commercial'); ?>>Commercial</option>
                                    </select>
                                </div>
                            </div>

                            <div class="estatery-grid-2">
                                <div class="estatery-input-group">
                                    <label>Property Status</label>
                                    <select name="new_build" class="estatery-control">
                                        <option value="1" <?php selected($item['new_build'] ?? 0, 1); ?>>New Build</option>
                                        <option value="0" <?php selected($item['new_build'] ?? 0, 0); ?>>Resale</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Specs Tab -->
                        <div class="estatery-tab-pane" data-tab="specs">
                            <h3 class="estatery-section-title">Property Specifications</h3>
                            <div class="estatery-grid-2">
                                <div class="estatery-input-group">
                                    <label>Bedrooms</label>
                                    <input type="number" name="beds" value="<?php echo esc_attr($item['beds'] ?? 0); ?>" class="estatery-control">
                                </div>
                                <div class="estatery-input-group">
                                    <label>Bathrooms</label>
                                    <input type="number" name="baths" value="<?php echo esc_attr($item['baths'] ?? 0); ?>" class="estatery-control">
                                </div>
                                <div class="estatery-input-group">
                                    <label>Number of Pools</label>
                                    <select name="pool_count" class="estatery-control">
                                        <option value="0" <?php selected($item['pool_count'] ?? 0, 0); ?>>None</option>
                                        <option value="1" <?php selected($item['pool_count'] ?? 0, 1); ?>>1 Pool</option>
                                        <option value="2" <?php selected($item['pool_count'] ?? 0, 2); ?>>2 Pools</option>
                                        <option value="3" <?php selected($item['pool_count'] ?? 0, 3); ?>>3 Pools</option>
                                    </select>
                                </div>
                            </div>
                            <div class="estatery-grid-2">
                                <div class="estatery-input-group">
                                    <label>Built Area (m²)</label>
                                    <input type="number" name="built_area" value="<?php echo esc_attr($item['built_area'] ?? 0); ?>" class="estatery-control">
                                </div>
                                <div class="estatery-input-group">
                                    <label>Plot Size (m²)</label>
                                    <input type="number" name="plot_size" value="<?php echo esc_attr($item['plot_size'] ?? 0); ?>" class="estatery-control">
                                </div>
                            </div>
                            <div class="estatery-input-group">
                                <label>Amenities / Features</label>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-top: 5px;">
                                    <?php 
                                    $available_features = [
                                        'Terrace', 'Swimming Pool', 'Solarium', 'Garden', 
                                        'Private pool', 'Private parking', 'Basement', 'Clear Views',
                                        'Air Conditioning', 'Heating', 'Sea Views', 'Mountain Views',
                                        'Garage', 'Gym', 'Alarm System', 'Lift', 'Furnished', 
                                        'Storage Room', 'Utility Room', 'White Goods'
                                    ];
                                    foreach ($available_features as $feature): ?>
                                        <label style="font-size: 13px; font-weight: 500; color: #475569; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                            <input type="checkbox" name="property_features[]" value="<?php echo esc_attr($feature); ?>" 
                                                   <?php checked(in_array($feature, $features)); ?>>
                                            <?php echo esc_html($feature); ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Location Tab -->
                        <div class="estatery-tab-pane" data-tab="location">
                            <h3 class="estatery-section-title">Location Details</h3>
                            <div class="estatery-grid-2">
                                <div class="estatery-input-group">
                                    <label>Town / City</label>
                                    <input type="text" name="town" value="<?php echo esc_attr($item['town'] ?? ''); ?>" class="estatery-control">
                                </div>
                                <div class="estatery-input-group">
                                    <label>Province / State</label>
                                    <input type="text" name="province" value="<?php echo esc_attr($item['province'] ?? ''); ?>" class="estatery-control">
                                </div>
                            </div>
                            <div class="estatery-grid-2">
                                <div class="estatery-input-group">
                                    <label>Country</label>
                                    <input type="text" name="country" value="<?php echo esc_attr($item['country'] ?? 'Spain'); ?>" class="estatery-control">
                                </div>
                                <div class="estatery-input-group">
                                    <label>Exact Location (Optional)</label>
                                    <input type="text" name="location_detail" value="<?php echo esc_attr($item['location_detail'] ?? ''); ?>" class="estatery-control">
                                </div>
                            </div>
                            <div class="estatery-grid-2">
                                <div class="estatery-input-group">
                                    <label>Latitude (Lat)</label>
                                    <input type="text" name="lat" value="<?php echo esc_attr($item['lat'] ?? ''); ?>" class="estatery-control" placeholder="e.g. 38.5342">
                                </div>
                                <div class="estatery-input-group">
                                    <label>Longitude (Lng)</label>
                                    <input type="text" name="lng" value="<?php echo esc_attr($item['lng'] ?? ''); ?>" class="estatery-control" placeholder="e.g. -0.1234">
                                </div>
                            </div>
                        </div>

                        <!-- Translations Tab -->
                        <div class="estatery-tab-pane" data-tab="translations">
                            <h3 class="estatery-section-title">Multilingual Descriptions</h3>
                            <div class="estatery-translations-container">
                                <div class="estatery-inner-tab-nav">
                                    <button type="button" class="estatery-inner-tab-btn active" data-target="desc-en">English</button>
                                    <button type="button" class="estatery-inner-tab-btn" data-target="desc-es">Spanish</button>
                                    <button type="button" class="estatery-inner-tab-btn" data-target="desc-pl">Polish</button>
                                    <button type="button" class="estatery-inner-tab-btn" data-target="desc-ru">Russian</button>
                                </div>
                                <div id="desc-en" class="estatery-inner-tab-content active">
                                    <textarea name="desc_en" rows="10" class="estatery-control" placeholder="English description..."><?php echo esc_textarea($descriptions['en'][0] ?? ''); ?></textarea>
                                </div>
                                <div id="desc-es" class="estatery-inner-tab-content" style="display:none;">
                                    <textarea name="desc_es" rows="10" class="estatery-control" placeholder="Spanish description..."><?php echo esc_textarea($descriptions['es'][0] ?? ''); ?></textarea>
                                </div>
                                <div id="desc-pl" class="estatery-inner-tab-content" style="display:none;">
                                    <textarea name="desc_pl" rows="10" class="estatery-control" placeholder="Polish description..."><?php echo esc_textarea($descriptions['pl'][0] ?? ''); ?></textarea>
                                </div>
                                <div id="desc-ru" class="estatery-inner-tab-content" style="display:none;">
                                    <textarea name="desc_ru" rows="10" class="estatery-control" placeholder="Russian description..."><?php echo esc_textarea($descriptions['ru'][0] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Media Tab -->
                        <div class="estatery-tab-pane" data-tab="media">
                            <h3 class="estatery-section-title">Featured Image</h3>
                            <div class="estatery-input-group">
                                <div id="featured-img-container" class="featured-img-preview">
                                    <?php if (!empty($item['featured_image'])): ?>
                                        <img src="<?php echo esc_url($item['featured_image']); ?>">
                                        <input type="hidden" name="featured_image" value="<?php echo esc_url($item['featured_image']); ?>">
                                    <?php else: ?>
                                        <div style="text-align: center; color: #64748b;">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" style="margin: 0 auto 10px; opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <p style="margin:0; font-weight: 500;">Click to select featured image</p>
                                        </div>
                                        <input type="hidden" name="featured_image" value="">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <h3 class="estatery-section-title" style="margin-top: 40px;">Gallery Images</h3>
                            <div class="estatery-input-group">
                                <button type="button" id="add-gallery-btn" class="estatery-btn-outline" style="width: 100%; justify-content: center;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" style="margin-right: 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add Gallery Images
                                </button>
                                <div id="gallery-container" class="estatery-gallery-grid">
                                    <?php if (!empty($images)): ?>
                                        <?php foreach ($images as $img_url): ?>
                                            <div class="estatery-gallery-item">
                                                <img src="<?php echo esc_url($img_url); ?>">
                                                <button type="button" class="remove-img">×</button>
                                                <input type="hidden" name="property_gallery[]" value="<?php echo esc_url($img_url); ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Wizard Footer -->
                        <div class="wizard-footer">
                            <button type="button" id="prev-step" class="estatery-btn-outline" style="visibility: hidden;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" style="margin-right: 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                Previous Step
                            </button>
                            <button type="button" id="next-step" class="estatery-btn-primary">
                                Next Step
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" style="margin-left: 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            jQuery(document).ready(function($) {
                const tabs = ['general', 'specs', 'location', 'translations', 'media'];
                let currentTabIndex = 0;

                function updateWizardButtons() {
                    if (currentTabIndex === 0) {
                        $('#prev-step').css('visibility', 'hidden');
                    } else {
                        $('#prev-step').css('visibility', 'visible');
                    }

                    if (currentTabIndex === tabs.length - 1) {
                        $('#next-step').html('Finish & Save <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" style="margin-left: 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>');
                    } else {
                        $('#next-step').html('Next Step <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" style="margin-left: 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>');
                    }
                }

                // Tab Switching
                $('.estatery-tab-link').click(function() {
                    var tab = $(this).data('tab');
                    currentTabIndex = tabs.indexOf(tab);
                    $('.estatery-tab-link').removeClass('active');
                    $(this).addClass('active');
                    $('.estatery-tab-pane').removeClass('active');
                    $('.estatery-tab-pane[data-tab="' + tab + '"]').addClass('active');
                    updateWizardButtons();
                });

                // Next/Prev Step Buttons
                $('#next-step').click(function() {
                    if (currentTabIndex < tabs.length - 1) {
                        currentTabIndex++;
                        var nextTab = tabs[currentTabIndex];
                        $('.estatery-tab-link[data-tab="' + nextTab + '"]').click();
                    } else {
                        $('#investment-form').submit();
                    }
                });

                $('#prev-step').click(function() {
                    if (currentTabIndex > 0) {
                        currentTabIndex--;
                        var prevTab = tabs[currentTabIndex];
                        $('.estatery-tab-link[data-tab="' + prevTab + '"]').click();
                    }
                });

                // Inner Language Tabs
                $('.estatery-inner-tab-btn').click(function() {
                    var target = $(this).data('target');
                    $(this).closest('.estatery-translations-container').find('.estatery-inner-tab-btn').removeClass('active');
                    $(this).addClass('active');
                    $(this).closest('.estatery-translations-container').find('.estatery-inner-tab-content').hide();
                    $('#' + target).show();
                });

                // Featured Image Logic
                var featuredFrame;
                $('#featured-img-container').click(function(e) {
                    e.preventDefault();
                    if (featuredFrame) { featuredFrame.open(); return; }
                    featuredFrame = wp.media({
                        title: 'Select Featured Image',
                        button: { text: 'Set Featured Image' },
                        multiple: false
                    });
                    featuredFrame.on('select', function() {
                        var attachment = featuredFrame.state().get('selection').first().toJSON();
                        $('#featured-img-container').html('<img src="' + attachment.url + '"><input type="hidden" name="featured_image" value="' + attachment.url + '">');
                    });
                    featuredFrame.open();
                });

                // Gallery Logic
                var galleryFrame;
                $('#add-gallery-btn').click(function(e) {
                    e.preventDefault();
                    if (galleryFrame) { galleryFrame.open(); return; }
                    galleryFrame = wp.media({
                        title: 'Select Gallery Images',
                        button: { text: 'Add to Gallery' },
                        multiple: true
                    });
                    galleryFrame.on('select', function() {
                        var attachments = galleryFrame.state().get('selection').toJSON();
                        attachments.forEach(function(attachment) {
                            var html = '<div class="estatery-gallery-item">' +
                                       '<img src="' + attachment.url + '">' +
                                       '<button type="button" class="remove-img">×</button>' +
                                       '<input type="hidden" name="property_gallery[]" value="' + attachment.url + '">' +
                                       '</div>';
                            $('#gallery-container').append(html);
                        });
                    });
                    galleryFrame.open();
                });

                $(document).on('click', '.remove-img', function(e) {
                    e.preventDefault();
                    $(this).closest('.estatery-gallery-item').remove();
                });
            });
        </script>
        <?php
    }
}