<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace TrafftPlugin\Infrastructure\WP\ShortcodeService;

class BookingShortcodeService
{
    public static function shortcodeHandler($attributes): string
    {
        $params = '';
        $minHeight = '500px';
        $employee =  '';
        $language = '';

        if (is_array($attributes)) {
            if (isset($attributes['employee'])) {
                $employee = $attributes['employee'];
            }

            if (isset($attributes['min-height'])) {
                $minHeight = $attributes['min-height'] . 'px';
            }

            if (isset($attributes['language'])) {
                $language = $attributes['language'];
            }
        }

        $attributes = shortcode_atts(
            [
                'category' => null,
                'service'  => null,
                'location' => null,
            ],
            $attributes
        );

        $attributesMap = [
            'category' => 'serviceCategory'
        ];

        foreach ($attributes as $name => $value) {
            if ($value) {
                if (key_exists($name, $attributesMap)) {
                    $name = $attributesMap[$name];
                }

                $params .= '&' . $name . '=' . $value;
            }
        }

        return '<div class="embedded-booking"
            data-url="' . 'https://' . get_option( 'trafft_option' )['tenantName'] . '.trafft.com' . '"
            data-autoresize="1"
            data-query="' . $params . '"
            data-employee="'  . $employee . '"
            data-showsidebar="1"
            data-lang="' . $language . '"
            style="border: none; width: 100%; height: '. $minHeight . '; margin: 0 auto;"></div>';
    }
}
