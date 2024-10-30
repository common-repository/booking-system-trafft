<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace TrafftPlugin\Infrastructure\WP\Elementor;

use Elementor\Plugin;
use Elementor\TrafftBookingElementorWidget;

class ElementorBlock
{
    protected static $instance;

    public static function get_instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    protected function __construct()
    {
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'widget_styles']);
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
        add_action('elementor/elements/categories_registered', [$this, 'register_widget_categories']);
    }

    public function includes()
    {
        require_once(TRAFFT_PATH . '/includes/Infrastructure/WP/Elementor/TrafftBookingElementorWidget.php');
    }

    public function register_widgets()
    {
        $this->includes();
        Plugin::instance()->widgets_manager->register(new TrafftBookingElementorWidget());
    }

    public function widget_styles()
    {
        wp_register_style('trafft-elementor-widget-font', TRAFFT_URL . 'assets/css/elementor.css', array(), TRAFFT_VERSION);
        wp_enqueue_style('trafft-elementor-widget-font');
    }

    public function register_widget_categories($elements_manager)
    {
        $elements_manager->add_category(
            'trafft-elementor',
            [
                'title' => 'Trafft',
                'icon'  => 'trafft-logo',
            ], 1);
    }
}