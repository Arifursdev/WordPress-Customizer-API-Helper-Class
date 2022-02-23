<?php
defined( 'ABSPATH' ) || die;

if ( is_customize_preview() ) {

    // require class
    require_once './ADEV_WP_Customizer_API.php';

    $customizer = ADEV_WP_Customizer_API::init();

    // Add Panels
    $customizer->add_panels( [
        [
            'id'    => 'sample_panel',
            'title' => 'Theme Options',
        ],
    ] );

    // Add Sections
    $customizer->add_sections( [
        [
            'id'    => 'adev_topbar_options',
            'title' => 'Top Bar Options',
            'panel' => 'adev_theme_options_panel',
        ],
        [
            'id'    => 'adev_bottombar_options',
            'title' => 'Bottom Bar Options',
            'panel' => 'adev_theme_options_panel',
        ],
    ] );

    // Add Fields
    $customizer->add_fields( 'adev_topbar_options', [
        [
            'type'              => 'text',
            'name'              => 'adev_top_bar_text',
            'label'             => 'Top Bar Text',
            'sanitize_callback' => 'sanitize_text_field',
        ],
        [
            'type'              => 'email',
            'name'              => 'email',
            'label'             => 'Email',
            'sanitize_callback' => 'sanitize_email',
        ],
        [
            'type'              => 'number',
            'name'              => 'number',
            'label'             => 'Number',
            'sanitize_callback' => 'absint',
        ],
        [
            'type'  => 'date',
            'name'  => 'date',
            'label' => 'Date',
        ],
        [
            'type'              => 'url',
            'name'              => 'url',
            'label'             => 'URL',
            'sanitize_callback' => 'esc_raw_url',
        ],
        [
            'type'  => 'tel',
            'name'  => 'tel',
            'label' => 'Mobile',
        ],
        [
            'type'        => 'range',
            'name'        => 'range',
            'label'       => 'Range',
            'input_attrs' => [
                'min' => 1,
                'max' => 100,
            ],
        ],
        [
            'type'              => 'textarea',
            'name'              => 'textarea',
            'label'             => 'Textarea',
            'sanitize_callback' => 'sanitize_textarea_field',
        ],
        [
            'type'    => 'checkbox',
            'name'    => 'checkbox',
            'label'   => 'Enable Checkbox',
            'default' => 'on',
        ],
        [
            'type'    => 'select',
            'name'    => 'select',
            'label'   => 'Select Favourites',
            'choices' => [
                ''      => 'None',
                'red'   => 'Red',
                'blue'  => 'Blue',
                'green' => 'Green',
            ],
        ],
        [
            'type'              => 'radio',
            'name'              => 'radio',
            'label'             => 'Radio',
            'default'           => 'intermediate',
            'choices'           => [
                'basic'        => 'Basic',
                'intermediate' => 'Intermediate',
                'advance'      => 'Advance',
            ],
            'sanitize_callback' => 'sanitize_text_field',
            'validate_callback' => 'validate_sectiontyperadio_field',
        ],
        [
            'type'    => 'color',
            'name'    => 'color',
            'label'   => 'Background Color',
            'default' => '#fff',
        ],
        [
            'type'              => 'image',
            'name'              => 'image',
            'label'             => 'Background Image',
            'sanitize_callback' => 'esc_url_raw',
        ],
        [
            'type'              => 'media',
            'name'              => 'media',
            'label'             => 'Files',
            'mime_type'         => 'video',
            'sanitize_callback' => 'absint',
        ],
        [
            'type'               => 'text',
            'name'               => 'enable_footer_text',
            'label'              => 'Enable Footer Text',
            'transport'          => 'postMessage',
            'selective_refresh'  => true,
            'selector'           => '.footer-text',
            'sr_render_callback' => function () {
                echo get_theme_mod( 'enable_footer_text' );
            },
            'sanitize_callback'  => 'sanitize_text_field',
        ],
        [
            'type'         => 'custom',
            'name'         => 'custom_setting',
            'label'        => 'Custom Setting',
            'custom_class' => 'adev_custom_blog_control',
        ],
    ] );
}
