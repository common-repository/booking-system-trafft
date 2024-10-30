<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace TrafftPlugin\Infrastructure\WP\ButtonService;

class ButtonService
{
    /**
     * Function that adds shortcode button to WordPress TinyMCE editor on Page and Post pages
     */
    public static function renderButton()
    {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        if (get_user_option('rich_editing') !== 'true') {
            return;
        }

        add_filter('mce_external_plugins', [self::class, 'addButton']);
        add_filter('mce_buttons', [self::class, 'registerButton']);
    }

    /**
     * Function that add buttons for MCE editor
     *
     * @param $pluginArray
     *
     * @return array
     */
    public static function addButton($pluginArray): array
    {
        $pluginArray['trafftBookingPlugin'] = TRAFFT_URL . 'assets/js/tinymce/trafft-mce.js';

        return $pluginArray;
    }

    /**
     * Function that register buttons for MCE editor
     *
     * @param $buttons
     *
     * @return array
     */
    public static function registerButton($buttons): array
    {
        $buttons[] = 'trafftButton';

        return $buttons;
    }
}
