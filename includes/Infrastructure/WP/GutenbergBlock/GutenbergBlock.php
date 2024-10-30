<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace TrafftPlugin\Infrastructure\WP\GutenbergBlock;

class GutenbergBlock
{
    /**
     * Register WP Ajax actions.
     */
    public static function init(): void
    {
        global $pagenow;

        if (is_admin() && function_exists('register_block_type')) {
            if (in_array($pagenow, ['post.php','post-new.php', 'widgets.php'])) {
                if (self::isGutenbergActive()) {
                    $class = get_called_class();
                    add_action('enqueue_block_editor_assets', function () use ($class) {
                        $class::registerBlockType();
                    });
                }

            }
        }
    }

    /**
     * Register block for gutenberg
     */
    public static function registerBlockType(): void
    {
    }

    /**
     * Check if Block Editor is active.
     *
     * @return bool
     */
    public static function isGutenbergActive(): bool
    {
        // Gutenberg plugin is installed and activated.
        $gutenberg = !(false === has_filter('replace_editor', 'gutenberg_init'));

        // Block editor since 5.0.
        $block_editor = version_compare($GLOBALS['wp_version'], '5.0-beta', '>');

        if (!$gutenberg && !$block_editor) {
            return false;
        }

        // Fix for conflict with Avada - Fusion builder and gutenberg blocks
        if (class_exists('FusionBuilder') && !(isset($_GET['gutenberg-editor']))) {
            return false;
        }

        // Fix for conflict with Disable Gutenberg plugin
        if (class_exists('DisableGutenberg')) {
            return false;
        }

        // Fix for conflict with WP Bakery Page Builder
        if (class_exists('Vc_Manager') && (isset($_GET['classic-editor']))) {
            return false;
        }

        // Fix for conflict with WooCommerce product page
        if (isset($_GET['post_type']) &&
            sanitize_text_field($_GET['post_type']) === 'product' &&
            class_exists('WooCommerce')
        ) {
            return false;
        }

        return true;
    }

    /**
     * Check if Classic Editor plugin is active
     *
     * @return bool
     */
    public static function isClassicEditorPluginActive(): bool
    {

        if (!function_exists('is_plugin_active')) {

            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if (is_plugin_active('classic-editor/classic-editor.php')) {

            return true;
        }

        return false;
    }

    /**
     * Get entities data for front-end
     */
    public static function getEntitiesData(): array
    {
        $url = 'https://' . get_option( 'trafft_option' )['tenantName'] . '.trafft.com';

        $categories = (array) json_decode(wp_remote_retrieve_body(
            wp_remote_get($url . '/api/v1/public/booking/steps/service-categories')
        ));
        $servicesByCategory = (array) json_decode(wp_remote_retrieve_body(
            wp_remote_get($url . '/api/v1/public/booking/steps/services')
        ));
        $employees = (array) json_decode(wp_remote_retrieve_body(
            wp_remote_get($url . '/api/v1/public/booking/steps/employees')
        ));
        $locations = (array) json_decode(wp_remote_retrieve_body(
            wp_remote_get($url . '/api/v1/public/booking/steps/locations')
        ));
        $languages = (array) json_decode(wp_remote_retrieve_body(
            wp_remote_get($url . '/api/v1/public/languages')
        ));

        $services = [];
        foreach ($servicesByCategory as $serviceCategory) {
            foreach ($serviceCategory->services as $service) {
                $services[] = ['id' => $service->id, 'name' => $service->name];
            }
        }

        return ['data' => [
            'categories' => array_map(function ($category) {
                return ['id' => $category->id, 'name' => $category->name];
            }, $categories),
            'services'   => $services,
            'locations'  => array_map(function ($location) {
                return ['id' => $location->id, 'name' => $location->name];
            }, $locations),
            'employees'  => array_map(function ($employee) {
                return [
                    'id'        => $employee->id,
                    'firstName' => $employee->firstName,
                    'lastName'  => $employee->lastName,
                    'slug'      => $employee->slug,
                ];
            }, $employees),
            'languages'  => array_map(function ($language) {
                return ['code' => $language->code, 'label' => $language->label];
            }, $languages),
        ]];
    }

    public static function getLabels(): array
    {
        return ['labels' => [
            'preselect_booking_parameters' => 'Preselect Booking Parameters',
            'select_category' => 'Select category',
            'select_service' => 'Select service',
            'select_employee' => 'Select employee',
            'select_location' => 'Select location',
            'select_language' => 'Select language',
            'show_all_categories' => 'Show all categories',
            'show_all_services' => 'Show all services',
            'show_all_employees' => 'Show all employees',
            'show_all_locations' => 'Show all locations',
            'no_entities_notice' => 'Notice: Please create category, service and employee first.',
            'yes' => 'yes',
            'no' => 'no',
            'show_all' => 'Show all',
            'min_height' => 'Min Height (px)',
            'language'  => 'Language',
            'default_language' => 'Default language',
        ]];
    }
}
