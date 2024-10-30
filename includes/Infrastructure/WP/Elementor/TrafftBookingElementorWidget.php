<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace Elementor;

use TrafftPlugin\Infrastructure\WP\GutenbergBlock\GutenbergBlock;

class TrafftBookingElementorWidget extends Widget_Base
{
    protected $controls_data;

    public function get_name() {
        return 'trafftbooking';
    }

    public function get_title() {
        return 'Trafft';
    }

    public function get_icon() {
        return 'trafft-logo';
    }

    public function get_categories() {
        return ['trafft-elementor'];
    }

    protected function register_controls() {
        $labels = GutenbergBlock::getLabels()['labels'];
        $controls_data = self::trafft_elementor_get_data();

        $this->start_controls_section(
            'trafft_booking_section',
            [
                'label' => '<div class="trafft-elementor-content"><p class="trafft-elementor-content-title">'
                    . 'Trafft Booking'
                    . '</p><br><p class="trafft-elementor-content-p">'
                    . 'Trafft Booking enables your customers to effortlessly schedule appointments with just a few clicks. Utilize templates or adjust the step order to align the booking flow with your specific use case.'
                    . '</p>',
            ]
        );

        $this->add_control(
            'min-height',
            [
                'label' => $labels['min_height'],
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $this->add_control(
            'select_language',
            [
                'label' => $labels['select_language'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['languages'],
                'default' => '',
            ]
        );

        $this->add_control(
            'preselect',
            [
                'label' => $labels['preselect_booking_parameters'],
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'label_on' => $labels['yes'],
                'label_off' => $labels['no'],
            ]
        );

        $this->add_control(
            'select_category',
            [
                'label' => $labels['select_category'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['categories'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        $this->add_control(
            'select_service',
            [
                'label' => $labels['select_service'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['services'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        $this->add_control(
            'select_employee',
            [
                'label' => $labels['select_employee'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['employees'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        $this->add_control(
            'select_location',
            [
                'label' => $labels['select_location'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['locations'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();

        $min_height = $settings['min-height'] === 0 ? 500 : $settings['min-height'];
        $min_height = ' min-height=' . $min_height;

        $category = $settings['select_category'] === '0' ? '' : ' category=' . $settings['select_category'];
        $service = $settings['select_service'] === '0' ? '' : ' service=' . $settings['select_service'];
        $category_service = $settings['select_service'] === '0' ? $category : $service;

        $employee = $settings['select_employee'] === '0' ? '' : ' employee=' . $settings['select_employee'];
        $location = $settings['select_location'] === '0' ? '' : ' location=' . $settings['select_location'];
        $language = $settings['select_language'] === '' ? '' : ' language=' . $settings['select_language'];
        $employee_location = $settings['select_employee'] === '0' ? $location : $employee;

        if ($settings['preselect']) {
            echo esc_html('[trafftbooking' . $category_service . $employee_location . $min_height . $language . ']');
        } else {
            echo esc_html('[trafftbooking' . $min_height . ']');
        }
    }

    public static function trafft_elementor_get_data() {
        $labels = GutenbergBlock::getLabels()['labels'];
        $data = GutenbergBlock::getEntitiesData()['data'];
        $elementorData = [];

        $elementorData['categories'] = [];
        $elementorData['categories'][0] = $labels['show_all_categories'];

        foreach ($data['categories'] as $category) {
            $elementorData['categories'][$category['id']] = $category['name'] . ' (id: ' . $category['id'] . ')';
        }

        $elementorData['services'] = [];
        $elementorData['services'][0] = $labels['show_all_services'];

        foreach ($data['services'] as $service) {
            if ($service) {
                $elementorData['services'][$service['id']] = $service['name'] . ' (id: ' . $service['id'] . ')';
            }
        }

        $elementorData['employees'] = [];
        $elementorData['employees'][0] = $labels['show_all_employees'];

        foreach ($data['employees'] as $provider) {
            $elementorData['employees'][$provider['slug']] = $provider['firstName'] . $provider['lastName'] . ' (id: ' . $provider['id'] . ')';
        }

        $elementorData['locations'] = [];
        $elementorData['locations'][0] = $labels['show_all_locations'];

        foreach ($data['locations'] as $location) {
            $elementorData['locations'][$location['id']] = $location['name'] . ' (id: ' . $location['id'] . ')';
        }

        $elementorData['languages'] = [];
        $elementorData['languages'][''] = $labels['default_language'];

        foreach ($data['languages'] as $language) {
            $elementorData['languages'][$language['code']] = $language['label'];
        }

        return $elementorData;
    }
}
