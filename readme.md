
# WordPress Customizer API
#### A simple Helper class for making customizer options on WordPress!

```php
$customizer = ADEV_WP_Customizer_API::init();
```

### Add add panels     
| Parameter | Type     | Values                       |
| :-------- | :------- | :-------------------------------- |
| `id` | `string` | Section ID (***Required***) |
| `title` | `string` | Section Title (***Required***) |
| `description` | `string` | `optional` Panel Description |
| `priority` | `int` | `optional` Panel Order Priortiy `default:` `10` |
| `capability` | `string` | `optional` Default: `edit_theme_options` |
| `theme_supports` | `string` | `optional` Rarely needed |
| `type` | `string` | `optional` `theme_mod` or `option`. Default: `theme_mod` . |
| `active_callback` | `callback` | `optional` callback function that returns `true` or `false` , if `true` show the panel |

```php
$customizer->add_panels([
    [
        'id' => 'sample_panel',
        'title' => 'Theme Options'
    ],
]);
```

### Add Sections to Panels

| Parameter | Type     | Values                       |
| :-------- | :------- | :-------------------------------- |
| `id` | `string` | Section ID (***Required***) |
| `title` | `string` | Section Title (***Required***) |
| `panel` | `string` | `optional` Panel where section belongs |
| `priority` | `int` | `optional` Section Order Priortiy `default:` `10` |
| `description` | `string` | `optional` Panel Description |
| `capability` | `string` | `optional` Default: `edit_theme_options` |


```php
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
```
### Add Fields to Section

| Parameter | Type     | Values                       |
| :-------- | :------- | :-------------------------------- |
| `type`      | `string` | `text`, `hidden`, `textarea`, `checkbox`, `select`, `radio`, `email`, `tel`, `url`, `range`, `number`, `date`, `image`, `media`, `color`, `custom` |
| `name` | `string` | ***Required***|
| `label` | `string` | ***Required***|
| `default` | `string` | default value |
| `choices` | `array` | ***Required***|
| `input_attrs` | `array` | Input Attributes array with `key` (attribute) and `value` (attribute value) |
| `transport` | `string` | `postMessage` or `refresh` |
| `mime_type` | `string` | `video`, `image`, `pdf` etc. |
| `selective_refresh` | `bool` | `true` or `false`|
| `selector` | `string` | `.class` `#class` js query selector for selective refresh |
| `sr_render_callback` | `callback` | callback for selective refresh |
| `dirty` | `bool` | `true` or `false` Whether or not the setting is initially dirty when created. Default: `false` |
| `container_inclusive` | `bool` | `true` or `false` If partial needs to remove current div or replace. Default: `false` |
| `primary_setting` | `string` | `optional` The ID for the setting that this partial is primarily responsible for rendering. If not supplied, it will default to the ID of the first setting |
| `sanitize_callback` | `callback` | sanitize function callback|
| `validate_callback` | `callback` | validate function callback|
| `sanitize_js_callback` | `callback` | Callback to convert a Customize PHP setting value to a value that is JSON serializable. |

### Add Fields to Section
```php
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
        'sanitize_callback' => function($value){
            // santizing $value inside inline function 
            return !empty($value) ? $value : '123456789';
        },
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
        'validate_callback' => 'validate_radio_field',
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
        'selective_refresh'  => true,
        'selector'           => '.footer-text',
        'transport'          => 'postMessage',
        'sr_render_callback' => function () {
            echo get_theme_mod( 'enable_footer_text' );
        },
        'sanitize_callback'  => 'sanitize_text_field',
    ],
    [
        'type'         => 'custom',
        'name'         => 'custom_setting',
        'label'        => 'Custom Setting',
        'custom_class' => 'Adev_Custom_Blog_Control',
    ]
] );
```

### Example Sanitize Callback
```php
function checkbox_sanitize_callback( $value ) {
    $sanitized = $value === 'on' ? 'on' : 'off';

    return $sanitized;
}
```

### Example Validate Callback
```php
function validate_radio_field( $validity, $value ) {
    if ( $value == 'basic' ) {
        $validity->add( 'what', 'Oh no! you cannot choose basic! :(' );
    }

    return $validity;
}

```

### Custom Customizer Control Class
```php
<?php

class Adev_Custom_Blog_Control extends WP_Customize_Control {

    /* Field Type  */
    public $type = 'adev_blog_control';

    /**
     * Enqueue Assets
     */
    public function enqueue() {
    
    }

    /**
     * Render Field
     */
    public function render_content() {
        $query = new WP_Query( array(
            'post_type'   => 'post',
            'post_status' => 'publish',
            'orderby'     => 'date',
            'order'       => 'DESC',
        ) );

        $input_id = '_customize-input-' . $this->id;

        $html = sprintf( '<label for="%s" class="customize-control-title">%s</label>', $input_id, esc_html( $this->label ) );
        $html .= sprintf( '<span class="description customize-control-description">%s</span>', esc_html( $this->description ) );
        $html .= sprintf( '<select %s id="%s">', $this->get_link(), $input_id );

        while ( $query->have_posts() ) {
            $query->the_post();

            $html .= sprintf( '<option %s value="%d">%s</option>', selected( $this->value(), get_the_ID(), false ), get_the_ID(), the_title( '', '', false ) );
        }

        $html .= '</select>';

        echo $html;
    }

}
```
peace be upon you. take care 
