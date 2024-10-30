<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace TrafftPlugin\Infrastructure\WP\GutenbergBlock;

class TrafftBookingGutenbergBlock extends GutenbergBlock
{
    /**
     * Register Trafft Booking block for Gutenberg
     */
    public static function registerBlockType(): void
    {
        wp_enqueue_script(
            'trafft_booking_gutenberg_block',
            TRAFFT_URL . 'assets/js/gutenberg/trafft-booking-gutenberg.js',
            array( 'wp-blocks', 'wp-components', 'wp-element', 'wp-editor')
        );

        wp_localize_script(
            'trafft_booking_gutenberg_block',
            'wpTrafftLabels',
            array_merge(
                self::getLabels(),
                self::getEntitiesData()
            )
        );

        register_block_type(
            'trafft/booking-gutenberg-block',
            array('editor_script' => 'trafft_booking_gutenberg_block')
        );
    }
}