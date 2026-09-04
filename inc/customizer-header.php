<?php
function opentik_customize_register_header($wp_customize) {
    // --- Panel for Header ---
    $wp_customize->add_panel('opentik_header_panel', [
        'title' => esc_html__('إعدادات الهيدر (Header)', 'opentik'),
        'priority' => 32,
    ]);

    // Move existing Top Bar section to the new Panel
    $wp_customize->get_section('opentik_header_section')->panel = 'opentik_header_panel';
    $wp_customize->get_section('opentik_header_section')->title = esc_html__('الشريط العلوي', 'opentik');

    // MOVE Core Site Identity section to our Panel and Rename it
    $wp_customize->get_section('title_tagline')->panel = 'opentik_header_panel';
    $wp_customize->get_section('title_tagline')->title = esc_html__('هوية الموقع (الشعار والاسم)', 'opentik');
    $wp_customize->get_section('title_tagline')->priority = 10; // put it at the top of the panel

    // Now we add our new settings directly to the 'title_tagline' section

    // Header Padding
    $wp_customize->add_setting('opentik_header_padding_y', ['default' => 3, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('opentik_header_padding_y', [
        'label' => esc_html__('مساحة الهيدر العلوية والسفلية (Padding)', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'range',
        'priority' => 50,
        'input_attrs' => ['min' => 0, 'max' => 12, 'step' => 1]
    ]);

    // Logo Size
    $wp_customize->add_setting('opentik_header_logo_size', ['default' => 40, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('opentik_header_logo_size', [
        'label' => esc_html__('أقصى ارتفاع للشعار (بالبكسل)', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'range',
        'priority' => 51,
        'input_attrs' => ['min' => 20, 'max' => 150, 'step' => 2]
    ]);

    // Title Position
    $wp_customize->add_setting('opentik_header_title_position', ['default' => 'left', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_header_title_position', [
        'label' => esc_html__('موضع اسم الموقع بالنسبة للشعار', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'select',
        'priority' => 52,
        'choices' => [
            'left' => esc_html__('يسار الشعار (الافتراضي)', 'opentik'),
            'right' => esc_html__('يمين الشعار', 'opentik'),
            'top' => esc_html__('أعلى الشعار', 'opentik'),
            'bottom' => esc_html__('أسفل الشعار', 'opentik'),
        ]
    ]);

    // Title Gap
    $wp_customize->add_setting('opentik_header_title_gap', ['default' => 3, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('opentik_header_title_gap', [
        'label' => esc_html__('المسافة بين الشعار واسم الموقع', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'range',
        'priority' => 53,
        'input_attrs' => ['min' => 0, 'max' => 10, 'step' => 1]
    ]);

    // Title Size
    $wp_customize->add_setting('opentik_header_title_size', ['default' => 18, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('opentik_header_title_size', [
        'label' => esc_html__('حجم خط اسم الموقع (بالبكسل)', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'range',
        'priority' => 54,
        'input_attrs' => ['min' => 10, 'max' => 48, 'step' => 1]
    ]);

    // Title Style (Background / Border)
    $wp_customize->add_setting('opentik_header_title_style', ['default' => 'transparent', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_header_title_style', [
        'label' => esc_html__('نمط خلفية اسم الموقع', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'select',
        'priority' => 55,
        'choices' => [
            'transparent' => esc_html__('بدون خلفية (نص فقط)', 'opentik'),
            'solid' => esc_html__('خلفية ملونة (Solid)', 'opentik'),
            'glass' => esc_html__('زجاجي فاخر (Glassmorphic)', 'opentik'),
            'outline' => esc_html__('برواز فقط (Outline)', 'opentik'),
        ]
    ]);

    // Title Background Color
    $wp_customize->add_setting('opentik_header_title_bg_color', ['default' => '#facc15', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'opentik_header_title_bg_color', [
        'label' => esc_html__('لون الخلفية / البرواز', 'opentik'),
        'section' => 'title_tagline',
        'priority' => 56,
    ]));

    $vis_choices = [
        'show' => esc_html__('دائماً ظاهر', 'opentik'),
        'hover' => esc_html__('يظهر عند التمرير (Hover)', 'opentik'),
        'hide' => esc_html__('مخفي تماماً', 'opentik'),
    ];

    // Title Visibility
    $wp_customize->add_setting('opentik_header_title_visibility', ['default' => 'show', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_header_title_visibility', [
        'label' => esc_html__('ظهور اسم الموقع', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'select',
        'priority' => 57,
        'choices' => $vis_choices
    ]);

    // Description Visibility
    $wp_customize->add_setting('opentik_header_desc_visibility', ['default' => 'hide', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_header_desc_visibility', [
        'label' => esc_html__('ظهور وصف الموقع (أسفل الشعار والاسم)', 'opentik'),
        'section' => 'title_tagline',
        'type' => 'select',
        'priority' => 58,
        'choices' => $vis_choices
    ]);
}
add_action('customize_register', 'opentik_customize_register_header', 98);
