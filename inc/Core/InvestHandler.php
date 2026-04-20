<?php
namespace Estatery\Core;

/**
 * Handle Investor Onboarding (AJAX, DB, EMAILS)
 */
class InvestHandler {
    public function __construct() {
        add_action('wp_ajax_estatery_submit_investment', [$this, 'handle_investment']);
        add_action('wp_ajax_nopriv_estatery_submit_investment', [$this, 'handle_investment']);
    }

    public function handle_investment() {
        // CSRF Check
        if (!check_ajax_referer('estatery_invest_nonce', 'invest_nonce', false)) {
            wp_send_json_error(['message' => t('js.error_generic') ?: 'Security check failed.']);
        }

        // Sanitize Input
        $name      = sanitize_text_field($_POST['full_name'] ?? '');
        $email     = sanitize_email($_POST['email'] ?? '');
        $q1        = sanitize_text_field($_POST['existing_client'] ?? 'no');
        $q2        = sanitize_text_field($_POST['owns_property'] ?? 'no');
        $q3        = sanitize_text_field($_POST['tax_resident'] ?? 'no');
        $interests = isset($_POST['interests']) ? array_map('sanitize_text_field', $_POST['interests']) : [];
        $amount    = sanitize_text_field($_POST['amount'] ?? '');

        if (!$name || !$email) {
            wp_send_json_error(['message' => t('js.fill_required') ?: 'Please fill all required fields.']);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'estatery_investments';

        $inserted = $wpdb->insert($table_name, [
            'time'                 => current_time('mysql'),
            'user_name'            => $name,
            'user_email'           => $email,
            'existing_client'      => $q1,
            'own_spanish_property' => $q2,
            'tax_resident'         => $q3,
            'interests'            => implode(', ', $interests),
            'amount'               => $amount,
            'status'               => 'unread'
        ]);

        if ($inserted) {
            $this->send_emails($name, $email, [
                'q1'        => $q1,
                'q2'        => $q2,
                'q3'        => $q3,
                'interests' => implode(', ', $interests),
                'amount'    => $amount
            ]);
            wp_send_json_success(['message' => t('js.success_inquiry') ?: 'Thank you! Your investment application has been sent successfully.']);
        } else {
            wp_send_json_error(['message' => t('js.error_generic') ?: 'Something went wrong. Please try again.']);
        }
    }

    private function send_emails($name, $email, $data) {
        $admin_email = get_option('estatery_admin_email', get_option('admin_email'));
        $site_name   = get_bloginfo('name');
        $headers     = ['Content-Type: text/html; charset=UTF-8'];

        // 1. Admin Notification
        $admin_subject = "New Investor Onboarding: {$name} - {$site_name}";
        $admin_body = "
            <div style='font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px;'>
                <h2 style='color: #2563eb;'>New Investor Application</h2>
                <p>A new applicant has completed the onboarding process.</p>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Name:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$name}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Email:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$email}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Existing Client:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['q1']}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Owns Spanish Property:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['q2']}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Tax Resident:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['q3']}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Interests:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['interests']}</td></tr>
                    <tr><td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Investment Amount:</strong></td><td style='padding: 8px; border-bottom: 1px solid #eee;'>{$data['amount']}</td></tr>
                </table>
                <p style='margin-top: 20px; font-size: 12px; color: #666;'>This application has been saved to your dashboard.</p>
            </div>
        ";

        wp_mail($admin_email, $admin_subject, $admin_body, $headers);

        // 2. User Confirmation
        $user_subject = "Onboarding Received - {$site_name}";
        $user_body = "
            <div style='font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px;'>
                <h2 style='color: #2563eb;'>Thank You for Joining Us</h2>
                <p>Hello {$name},</p>
                <p>We have received your investor onboarding application. Our Capital Relations team will review your profile and reach out to you shortly to discuss your investment objectives.</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p><strong>Your Selected Range:</strong> {$data['amount']}</p>
                <p><strong>Areas of Interest:</strong> {$data['interests']}</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p>Best regards,<br>{$site_name} Team</p>
            </div>
        ";

        wp_mail($email, $user_subject, $user_body, $headers);
    }
}
