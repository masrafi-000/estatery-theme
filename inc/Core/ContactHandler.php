<?php
namespace Estatery\Core;

/**
 * Handle General Contact Form (AJAX, DB, EMAILS)
 */
class ContactHandler {
    public function __construct() {
        add_action('wp_ajax_estatery_submit_contact', [$this, 'handle_contact']);
        add_action('wp_ajax_nopriv_estatery_submit_contact', [$this, 'handle_contact']);
    }

    public function handle_contact() {
        // CSRF Check
        if (!check_ajax_referer('estatery_contact_nonce', 'contact_nonce', false)) {
            wp_send_json_error(['message' => t('js.error_generic') ?: 'Security check failed.']);
        }

        // Sanitize Input (10 fields)
        $first_name    = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name     = sanitize_text_field($_POST['last_name'] ?? '');
        $email         = sanitize_email($_POST['email'] ?? '');
        $phone         = sanitize_text_field($_POST['phone'] ?? '');
        $property_type = sanitize_text_field($_POST['property_type'] ?? '');
        $zip           = sanitize_text_field($_POST['zip'] ?? '');
        $city          = sanitize_text_field($_POST['city'] ?? '');
        $bedrooms      = sanitize_text_field($_POST['bedrooms'] ?? '');
        $bathrooms     = sanitize_text_field($_POST['bathrooms'] ?? '');
        $budget        = sanitize_text_field($_POST['budget'] ?? '');

        if (!$first_name || !$last_name || !$email) {
            wp_send_json_error(['message' => t('js.fill_required') ?: 'Please fill all required fields.']);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_contacts';

        $inserted = $wpdb->insert($table_name, [
            'time'          => current_time('mysql'),
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'email'         => $email,
            'phone'         => $phone,
            'property_type' => $property_type,
            'zip'           => $zip,
            'city'          => $city,
            'bedrooms'      => $bedrooms,
            'bathrooms'     => $bathrooms,
            'budget'        => $budget,
            'status'        => 'unread'
        ]);

        if ($inserted) {
            $this->send_emails($first_name, $last_name, $email, [
                'phone'         => $phone,
                'property_type' => $property_type,
                'zip'           => $zip,
                'city'          => $city,
                'bedrooms'      => $bedrooms,
                'bathrooms'     => $bathrooms,
                'budget'        => $budget
            ]);
            wp_send_json_success(['message' => t('js.success_inquiry') ?: 'Thank you! Your message has been sent successfully.']);
        } else {
            wp_send_json_error(['message' => t('js.error_generic') ?: 'Something went wrong. Please try again.']);
        }
    }

    private function send_emails($first_name, $last_name, $email, $data) {
        $admin_email = get_option('estatery_admin_email', get_option('admin_email'));
        $site_name   = get_bloginfo('name');
        $headers     = ['Content-Type: text/html; charset=UTF-8'];
        $full_name   = "{$first_name} {$last_name}";

        // 1. Admin Notification
        $admin_subject = "New Contact Inquiry: {$full_name} - {$site_name}";
        $admin_body = "
            <div style='font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px;'>
                <h2 style='color: #2563eb;'>New Sourcing Request</h2>
                <p>A new contact form submission has been received with the following details:</p>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Name:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$full_name}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Email:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$email}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Phone:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['phone']}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Property Type:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['property_type']}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Location:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['city']}, {$data['zip']}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Criteria:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['bedrooms']} Beds / {$data['bathrooms']} Baths</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Budget:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['budget']}</td></tr>
                </table>
                <p style='margin-top: 20px; font-size: 12px; color: #666;'>Log in to your dashboard to manage this inquiry.</p>
            </div>
        ";

        wp_mail($admin_email, $admin_subject, $admin_body, $headers);

        // 2. User Confirmation
        $user_subject = "Message Received - {$site_name}";
        $user_body = "
            <div style='font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px;'>
                <h2 style='color: #2563eb;'>Thank You for Contacting Us</h2>
                <p>Hello {$first_name},</p>
                <p>We have received your inquiry. Our team is reviewing your requirements and will get back to you shortly with tailored property options.</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p><strong>Your Request Summary:</strong></p>
                <ul>
                    <li><strong>Property Type:</strong> {$data['property_type']}</li>
                    <li><strong>Area:</strong> {$data['city']}</li>
                    <li><strong>Budget:</strong> {$data['budget']}</li>
                </ul>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p>Best regards,<br>{$site_name} Team</p>
            </div>
        ";

        wp_mail($email, $user_subject, $user_body, $headers);
    }
}
