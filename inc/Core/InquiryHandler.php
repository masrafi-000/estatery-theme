<?php
namespace Estatery\Core;

/**
 * Handle Property Inquiries (AJAX, DB, EMAILS)
 */
class InquiryHandler {
    public function __construct() {
        add_action('wp_ajax_estatery_submit_inquiry', [$this, 'handle_inquiry']);
        add_action('wp_ajax_nopriv_estatery_submit_inquiry', [$this, 'handle_inquiry']);
    }

    public function handle_inquiry() {
        // CSRF Check
        if (!check_ajax_referer('estatery_inquiry_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => t('js.error_generic') ?: 'Security check failed.']);
        }

        // Sanitize Input
        $name    = sanitize_text_field($_POST['name'] ?? '');
        $email   = sanitize_email($_POST['email'] ?? '');
        $phone   = sanitize_text_field($_POST['phone'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');

        if (!$name || !$email || !$message) {
            wp_send_json_error(['message' => t('js.fill_required') ?: 'Please fill all required fields.']);
        }

        // Property Details (Passed from hidden fields or context)
        $prop_id    = sanitize_text_field($_POST['prop_id'] ?? '');
        $prop_title = sanitize_text_field($_POST['prop_title'] ?? '');
        $prop_price = sanitize_text_field($_POST['prop_price'] ?? '');
        $prop_area  = sanitize_text_field($_POST['prop_area'] ?? '');
        $prop_image = esc_url_raw($_POST['prop_image'] ?? '');
        $prop_beds  = sanitize_text_field($_POST['prop_beds'] ?? '');
        $prop_baths = sanitize_text_field($_POST['prop_baths'] ?? '');
        $prop_pool  = sanitize_text_field($_POST['prop_pool'] ?? '');
        $prop_type  = sanitize_text_field($_POST['prop_type'] ?? '');
        $prop_loc   = sanitize_text_field($_POST['prop_loc'] ?? '');
        $prop_lat   = sanitize_text_field($_POST['prop_lat'] ?? '');
        $prop_lng   = sanitize_text_field($_POST['prop_lng'] ?? '');
        $is_invest  = ($_POST['is_investment'] ?? '0') === '1';

        global $wpdb;
        $table_name = $is_invest ? $wpdb->prefix . 'estatery_investment_queries' : $wpdb->prefix . 'estatery_inquiries';

        $inserted = $wpdb->insert($table_name, [
            'time'              => current_time('mysql'),
            'property_id'       => $prop_id,
            'property_title'    => $prop_title,
            'property_price'    => $prop_price,
            'property_area'     => $prop_area,
            'property_image'    => $prop_image,
            'property_beds'     => $prop_beds,
            'property_baths'    => $prop_baths,
            'property_pool'     => $prop_pool,
            'property_type'     => $prop_type,
            'property_location' => $prop_loc,
            'property_lat'      => $prop_lat,
            'property_lng'      => $prop_lng,
            'user_name'         => $name,
            'user_email'        => $email,
            'user_phone'        => $phone,
            'user_message'      => $message,
            'status'            => 'unread'
        ]);

        if ($inserted) {
            $this->send_emails($name, $email, $phone, $message, [
                'title' => $prop_title,
                'price' => $prop_price,
                'id'    => $prop_id,
                'image' => $prop_image
            ]);
            wp_send_json_success(['message' => t('js.success_inquiry') ?: 'Thank you! Your inquiry has been sent successfully.']);
        } else {
            wp_send_json_error(['message' => t('js.error_generic') ?: 'Something went wrong. Please try again.']);
        }
    }

    private function send_emails($name, $email, $phone, $message, $prop) {
        $admin_email = get_option('estatery_admin_email', get_option('admin_email'));
        $site_name   = get_bloginfo('name');

        $headers = ['Content-Type: text/html; charset=UTF-8'];

        // 1. Admin Email
        $admin_subject = "New Inquiry: {$prop['title']} - {$site_name}";
        $admin_body = "
            <div style='font-family: sans-serif; line-height: 1.6; color: #333;'>
                <h2 style='color: #2563eb;'>New Property Inquiry</h2>
                <hr>
                <p><strong>Property:</strong> {$prop['title']} (ID: {$prop['id']})</p>
                <p><strong>Price:</strong> {$prop['price']}</p>
                <img src='{$prop['image']}' style='max-width: 300px; border-radius: 8px;'>
                <hr>
                <h3>User Details</h3>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Phone:</strong> {$phone}</p>
                <p><strong>Message:</strong><br>{$message}</p>
                <hr>
                <p style='font-size: 12px; color: #666;'>Sent from {$site_name} Website</p>
            </div>
        ";

        wp_mail($admin_email, $admin_subject, $admin_body, $headers);

        // 2. User Confirmation Email
        $user_subject = "Thank you for your interest in {$prop['title']} - {$site_name}";
        $user_body = "
            <div style='font-family: sans-serif; line-height: 1.6; color: #333;'>
                <h2 style='color: #2563eb;'>We've Received Your Inquiry</h2>
                <p>Hello {$name},</p>
                <p>Thank you for reaching out about <strong>{$prop['title']}</strong>. One of our specialists will contact you shortly regarding your request.</p>
                <hr>
                <p><strong>Your Message:</strong><br>{$message}</p>
                <hr>
                <p>Best regards,<br>{$site_name} Team</p>
            </div>
        ";

        wp_mail($email, $user_subject, $user_body, $headers);
    }
}
