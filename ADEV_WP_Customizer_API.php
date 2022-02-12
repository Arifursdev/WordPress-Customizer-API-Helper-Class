<?php
defined( 'ABSPATH' ) || die;

/**
 * @Author: arifursdev
 * @Version: 1.0
 * @Desc:  WordPress Customizer API Helper Class
 */

use WP_Customize_Color_Control;
use WP_Customize_Image_Control;
use WP_Customize_Media_Control;

class ADEV_WP_Customizer_API {

    private $settings = [];

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'customize_register', [$this, 'customize_register_callback'] );
    }

    /**
     * Returns Instance
     */
    public static function init() {
        $init = null;
        if ( !$init ) {
            $init = new self();
        }

        return $init;
    }

    /**
     * Settings
     * @return array Settings with panels, sections and fields
     */
    public function get_settings() {
        return [
            'panels'   => $this->get_panels(),
            'sections' => $this->get_sections(),
            'fields'   => $this->get_fields(),
        ];
    }

    /**
     * Set Panels
     * @param array $panels Array of Panels Arrays
     */
    public function set_panels( $panels ) {
        $this->settings['panels'] = $panels;
    }

    /**
     * Set Sections
     * @param array $sections Array of Sections Arrays
     */
    public function set_sections( $sections ) {
        $this->settings['sections'] = $sections;
    }

    /**
     * Set Fields
     * @param array $fields Array of Fields Arrays
     */
    public function set_fields( $fields ) {
        $this->settings['fields'] = $fields;
    }

    /**
     * Add Panels
     * @param array $panels Array of Panels Arrays
     */
    public function add_panels( $panels ) {
        if ( isset( $this->settings['panels'] ) ) {
            $this->settings['panels'] = array_merge( $this->settings['panels'], $panels );

            return;
        }

        $this->set_panels( $panels );
    }

    /**
     * Add Sections
     * @param array $sections Array of Sections Arrays
     * @param array $args (optional) array(
     *
     * @param string title Title of the section to show in UI.
     * @param string description Description to show in the UI.
     * @param int Priority of the section, defining the display order of panels and sections. Default 160.
     * @param string panel The panel this section belongs to (if any).
     * @param string capability Capability required for the section. Default 'edit_theme_options'
     * @param string section_type Type of the section.
     * @param string|string[] theme_supports Theme features required to support the section.
     * @param callback active_callback Active callback.
     * @param bool description_hidden Hide the description behind a help icon, instead of inline above the first control. Default false.
     */
    public function add_sections( $sections ) {
        if ( isset( $this->settings['sections'] ) ) {
            $this->settings['sections'] = array_merge( $this->settings['sections'], $sections );

            return;
        }

        $this->set_sections( $sections );
    }

    /**
     * Add Fields
     * @param string $section_id Section ID
     * @param array $fields Array of Fields Arrays
     *
     * @param string type Types: hidden, text, textarea, checkbox, select, radio, email, tel, url, range, number, date, image, media, color, custom etc..
     * @param string name Field ID 'name' attribute in input
     * @param string label Field Label
     * @param string default Default value for the setting. Default is empty string.
     * @param string capability Capability required for the setting. Default 'edit_theme_options'
     * @param int priority priority order of the field default: 10
     * @param string transport Transport Type: 'postMessage', 'refresh (default)'
     * @param array choices Choices Options for 'select/radio/checkboxes' array( array('value' => 'Label'), array('value' => 'Label') )
     * @param array input_attrs Input Attribute arrays array( array('data-something' => 'value' ) )
     * @param Class custom_class Custom Control class name
     * @param string mime_type Mime Types
     *
     * @param callback sanitize_callback Callback to filter a Customize setting value in un-slashed form.
     * @param callback validate_callback Value Validate Callback
     * @param callback sanitize_js_callback Callback to convert a Customize PHP setting value to a value that is JSON serializable.
     * @param bool dirty Whether or not the setting is initially dirty when created.
     * @param string type (setting_type) Type of the setting. Default 'theme_mod'.
     *
     * partials
     * @param bool selective_refresh if field has partial refresh on change, default false
     * @param string selector selector for js selector eg '.class'
     * @param string primary_setting The ID for the setting that this partial is primarily responsible for rendering. If not supplied, it will default to the ID of the first setting.
     * @param callback sr_render_callback Partial render callback
     * @param array settings IDs for settings tied to the partial. If undefined, $id will be used.
     * @param bool container_inclusive If partial needs to remove current div or replace default false;
     * @param bool fallback_refresh Whether to refresh the entire preview in case a partial cannot be refreshed. A partial render is considered a failure if the render_callback returns false.
     */
    public function add_fields( $section_id, $fields ) {
        $fields = [
            $section_id => $fields,
        ];

        if ( isset( $this->settings['fields'] ) ) {
            $this->settings['fields'] = array_merge( $this->settings['fields'], $fields );

            return;
        }

        $this->set_fields( $fields );
    }

    /**
     * Panels
     * @return array Panels
     */
    public function get_panels() {
        return isset( $this->settings['panels'] ) ? $this->settings['panels'] : [];
    }

    /**
     * Sections
     * @return array Sections
     */
    public function get_sections() {
        return isset( $this->settings['sections'] ) ? $this->settings['sections'] : [];
    }

    /**
     * Fields
     * @return array Fields
     */
    public function get_fields() {
        return isset( $this->settings['fields'] ) ? $this->settings['fields'] : [];
    }

    /**
     * Register Panel
     */
    public function register_panels( $wp_customize, $panel ) {
        $wp_customize->add_panel( $panel['id'], [
            'title'           => isset( $panel['title'] ) ? $panel['title'] : '',
            'description'     => isset( $panel['description'] ) ? $panel['description'] : '',
            'priority'        => isset( $panel['priority'] ) ? $panel['priority'] : 10,
            'capability'      => isset( $panel['capability'] ) ? $panel['capability'] : 'edit_theme_options',
            'theme_supports'  => isset( $panel['theme_supports'] ) ? $panel['theme_supports'] : '',
            'type'            => isset( $panel['type'] ) ? $panel['type'] : '',
            'active_callback' => isset( $panel['active_callback'] ) && is_callable( $panel['active_callback'] ) ? $panel['active_callback'] : '',
        ] );
    }

    /**
     * Register Section
     */
    public function register_section( $wp_customize, $section ) {
        $args = [
            'title'       => isset( $section['title'] ) ? $section['title'] : '',
            'description' => isset( $section['description'] ) ? $section['description'] : '',
            'priority'    => isset( $section['priority'] ) ? $section['priority'] : 10,
            'panel'       => isset( $section['panel'] ) ? $section['panel'] : '',
            'capability'  => isset( $section['capability'] ) ? $section['capability'] : 'edit_theme_options',
        ];

        if ( isset( $section['section_type'] ) ) {
            $args['type'] = $section['section_type'];
        }

        if ( isset( $section['active_callback'] ) ) {
            $args['active_callback'] = $section['active_callback'];
        }

        if ( isset( $section['description_hidden'] ) ) {
            $args['description_hidden'] = $section['description_hidden'];
        }

        if ( isset( $section['theme_supports'] ) ) {
            $args['theme_supports'] = $section['theme_supports'];
        }

        $wp_customize->add_section( $section['id'], $args );
    }

    /**
     * Register Settings
     */
    public function register_settings( $wp_customize, $section ) {
        $args = [
            'default'    => isset( $section['default'] ) ? $section['default'] : '',
            'capability' => isset( $section['capability'] ) ? $section['capability'] : 'edit_theme_options',
            'transport'  => isset( $section['transport'] ) ? $section['transport'] : 'refresh',
        ];

        if ( isset( $section['setting_type'] ) ) {
            $args['type'] = $section['setting_type'];
        }

        if ( isset( $section['theme_supports'] ) ) {
            $args['theme_supports'] = $section['theme_supports'];
        }

        if ( isset( $section['validate_callback'] ) ) {
            $args['validate_callback'] = $section['validate_callback'];
        }

        if ( isset( $section['sanitize_callback'] ) ) {
            $args['sanitize_callback'] = $section['sanitize_callback'];
        }

        if ( isset( $section['sanitize_js_callback'] ) ) {
            $args['sanitize_js_callback'] = $section['sanitize_js_callback'];
        }

        if ( isset( $section['dirty'] ) ) {
            $args['dirty'] = $section['dirty'];
        }

        $wp_customize->add_setting( $section['name'], $args );
    }

    /**
     * Register Controls
     * Types: hidden, text, textarea, checkbox, select, radio, email, tel, url, range, number, date, image, media, color custom etc..
     */
    public function register_controls( $wp_customize, $section, $id ) {
        $args = [
            'type'        => isset( $section['type'] ) ? $section['type'] : 'text',
            'description' => isset( $section['description'] ) ? $section['description'] : '',
            'label'       => isset( $section['label'] ) ? $section['label'] : '',
            'section'     => $id,
            'priority'    => isset( $section['priority'] ) ? $section['priority'] : 10,
        ];

        if ( isset( $section['input_attrs'] ) ) {
            $args['input_attrs'] = $section['input_attrs'];
        }

        if ( isset( $section['button_labels'] ) ) {
            $args['button_labels'] = $section['button_labels'];
        }

        // if type is select push select chooices
        if ( isset( $section['choices'] ) && ( $section['type'] == 'select' || $section['type'] == 'radio' ) ) {
            $args['choices'] = $section['choices'];
        }

        switch ( $section['type'] ) {

        case 'custom':
            if ( isset( $section['custom_class'] ) ) {
                $class = $section['custom_class'];
                if ( class_exists( $class ) ) {
                    $wp_customize->add_control( new $class( $wp_customize, $section['name'], $args ) );
                }
            }
            break;

        case 'image':
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $section['name'], $args ) );
            break;

        case 'media':
            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $section['name'], $args ) );
            break;

        case 'color':
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $section['name'], $args ) );
            break;

        default:
            $wp_customize->add_control( $section['name'], $args );
            break;

        }

    }

    /**
     * Partials
     */
    public function register_selective_refresh( $wp_customize, $section ) {
        if ( !isset( $section['selective_refresh'] ) || !isset( $section['selector'] ) || $section['selective_refresh'] !== true || $section['transport'] !== 'postMessage' ) {
            return;
        }

        $args = [
            'selector'            => $section['selector'],
            'render_callback'     => $section['sr_render_callback'],
            'container_inclusive' => isset( $section['container_inclusive'] ) ? $section['container_inclusive'] : false,
        ];

        if ( isset( $section['type'] ) ) {
            $args['type'] = $section['type'];
        }

        if ( isset( $section['name'] ) ) {
            $args['name'] = $section['name'];
        }

        if ( isset( $section['primary_setting'] ) ) {
            $args['primary_setting'] = $section['primary_setting'];
        }

        if ( isset( $section['capability'] ) ) {
            $args['capability'] = $section['capability'];
        }

        if ( isset( $section['fallback_refresh'] ) ) {
            $args['fallback_refresh'] = $section['fallback_refresh'];
        }

        $wp_customize->selective_refresh->add_partial( $section['name'], $args );
    }

    /**
     * Registers all Settings
     */
    public function customize_register_callback( $wp_customize ) {
        $settings = $this->get_settings();

        // Add all Panel
        $panels = $settings['panels'];
        foreach ( $panels as $panel ) {
            $this->register_panels( $wp_customize, $panel );
        }

        // Add all the sections
        $sections = $settings['sections'];
        foreach ( $sections as $section ) {
            $this->register_section( $wp_customize, $section );
        }

        // go over all section fields and add setting and control
        $fields = $settings['fields'];

        foreach ( $fields as $id => $section_fields ) {
            foreach ( $section_fields as $section ) {
                $this->register_settings( $wp_customize, $section );
                $this->register_controls( $wp_customize, $section, $id );
                $this->register_selective_refresh( $wp_customize, $section );
            }
        }

    }

}