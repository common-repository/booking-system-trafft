<?php
/*
Plugin Name: Booking System Trafft
Plugin URI: https://trafft.com/
Description: Trafft represents a cutting-edge booking and scheduling software, presenting an array of limitless opportunities to configure entirely personalized schedules. It stands as an all-encompassing booking and management software solution that caters to every facet of your business. By doing so, it significantly diminishes the hours spent on administrative work and repetitive tasks.
Keywords: booking, scheduling, appointment, booking system, appointment booking, booking calendar
Author: TMS
Version: 1.0.5
Author URI: https://trafft.com/
*/

namespace TrafftPlugin;

use TrafftPlugin\Infrastructure\WP\ButtonService\ButtonService;
use TrafftPlugin\Infrastructure\WP\Elementor\ElementorBlock;
use TrafftPlugin\Infrastructure\WP\GutenbergBlock\GutenbergBlock;
use TrafftPlugin\Infrastructure\WP\GutenbergBlock\TrafftBookingGutenbergBlock;

if (!defined('TRAFFT_VERSION')) {
    define('TRAFFT_VERSION', '1.0.5');
}

if (!defined('TRAFFT_PATH')) {
    define('TRAFFT_PATH', __DIR__);
}

if (!defined('TRAFFT_ACTION_URL')) {
    define('TRAFFT_ACTION_URL', admin_url('admin-ajax.php', '') . '?action=trafft_api&call=');
}

if (!defined('TRAFFT_URL')) {
    define('TRAFFT_URL', plugin_dir_url(__FILE__));
}

require_once TRAFFT_PATH . '/vendor/autoload.php';

class TrafftPlugin {
    public function __construct() {
        add_action( 'admin_menu', [$this, 'trafftPluginAddPage']);
        add_action( 'admin_init', [$this, 'trafftPluginPageInit']);
        add_action('admin_enqueue_scripts', [$this, 'trafftEnqueueAdminAssets']);
        add_action( 'wp_ajax_get_options', [$this, 'trafftGetOptions']);
        add_action( 'wp_ajax_set_options', [$this, 'trafftSetOptions']);
        add_action( 'wp_ajax_get_entities', [$this, 'trafftGetEntities']);
        add_action( 'plugin_loaded', [$this, 'trafftAddElementorWidget']);

        if (!is_admin()) {
            add_shortcode(
                'trafftbooking',
                ['TrafftPlugin\Infrastructure\WP\ShortcodeService\BookingShortcodeService', 'shortcodeHandler']
            );

            add_action( 'wp_enqueue_scripts', [$this, 'trafftAdminAssets']);
        }
    }

    public function trafftGetOptions(): void
    {
        check_ajax_referer('trafft_action', 'trafft_nonce');  // Check the nonce.
        wp_send_json(['tenantName' => get_option( 'trafft_option' )['tenantName']]);
        wp_die();
    }

    public function trafftSetOptions(): string
    {
        check_ajax_referer('trafft_action', 'trafft_nonce');  // Check the nonce.
        $tenantName = sanitize_text_field($_POST['tenantName']);
        $responseCode = wp_remote_retrieve_response_code(wp_remote_get('https://' . $tenantName . '.trafft.com'));

        if ($responseCode !== 200) {
            wp_send_json(['text' => 'Company name not found. Please check the name or select “Sign Up” to create the account.', 'type' => 'danger']);
            wp_die();
        }

        update_option('trafft_option', ['tenantName' => $tenantName]);
        wp_send_json(['text' => 'You have successfully connected your account', 'type' => 'positive']);
        wp_die();
    }

    public function trafftGetEntities(): void
    {
        wp_send_json(array_merge(GutenbergBlock::getLabels(), GutenbergBlock::getEntitiesData()));
        wp_die();
    }

    public function trafftPluginAddPage(): void
    {
        add_menu_page(
            'Trafft',
            'Trafft',
            'manage_options',
            'trafft',
            [$this, 'trafftAdminIndex'],
            TRAFFT_URL . 'assets/img/logo-symbol.svg',
            100
        );
    }

    public function trafftAdminIndex(): void
    {
        require_once plugin_dir_path(__FILE__) . 'includes/Templates/Admin/Index.php';
    }

    public function trafftPluginPageInit(): void
    {
        register_setting(
            'trafft_option_group',
            'trafft_option',
            array( $this, 'trafftSanitize')
        );

        add_settings_section(
            'trafft_setting_section',
            'Settings',
            function () {},
            'url-admin'
        );

        add_settings_field(
            'tenantName',
            'Tenant Name',
            function () {},
            'url-admin',
            'trafft_setting_section'
        );

        ButtonService::renderButton();
        TrafftBookingGutenbergBlock::init();
    }

    public function trafftAddElementorWidget(): void
    {
        if (defined('ELEMENTOR_VERSION')) {
            ElementorBlock::get_instance();
        }
    }

    public function trafftSanitize($input): array
    {
        $sanitary_values = [];
        if ( isset( $input['tenantName'] ) ) {
            $sanitary_values['tenantName'] = sanitize_text_field($input['tenantName']);
        }

        return $sanitary_values;
    }

    public function trafftEnqueueAdminAssets(): void
    {
        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) === 'trafft') {
            wp_enqueue_style('trafft_booking_style_main', TRAFFT_URL . 'public/css/main.css');
        }

        wp_localize_script('trafft_booking_scripts_main', 'trafft_plugin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'trafft_nonce' => wp_create_nonce('trafft_action'),
            'url' => TRAFFT_URL,
        ));

        wp_print_inline_script_tag('const trafft_plugin = '. wp_json_encode([
            'ajax_url' => admin_url('admin-ajax.php'),
            'trafft_nonce' => wp_create_nonce('trafft_action'),
            'url' => TRAFFT_URL,
        ]));

        wp_print_script_tag(
            array(
                'src' => esc_url( TRAFFT_URL . 'public/js/main.js'),
                'type' => 'module',
            )
        );
    }

    public function trafftAdminAssets(): void
    {
        wp_enqueue_script(
            'trafft_booking_scripts_embedded',
            'https://' . get_option( 'trafft_option' )['tenantName'] . '.trafft.com/embed.js',
            NULL,
            NULL,
            true
        );
    }
}

new TrafftPlugin();
