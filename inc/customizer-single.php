<?php
function opentik_customize_register_single($wp_customize) {
    $wp_customize->add_section('opentik_single_post_section', [
        'title' => esc_html__('إعدادات المقالات', 'opentik'),
        'priority' => 30,
        'description' => esc_html__('تخصيص مظهر وتخطيط صفحة المقال الفردي', 'opentik'),
    ]);

    // Add Setting for Featured Image Position
    $wp_customize->add_setting('opentik_featured_image_position', [
        'default' => 'below_title',
        'sanitize_callback' => 'opentik_sanitize_image_position',
        'transport' => 'refresh',
    ]);

    // Add Control for Featured Image Position
    $wp_customize->add_control('opentik_featured_image_position', [
        'label' => esc_html__('موضع الصورة المميزة للمقال', 'opentik'),
        'section' => 'opentik_single_post_section',
        'type' => 'radio',
        'choices' => [
            'below_title' => esc_html__('أسفل العنوان (الوضع الافتراضي)', 'opentik'),
            'behind_title' => esc_html__('خلف العنوان (هيدر كامل احترافي)', 'opentik'),
        ],
        'description' => esc_html__('اختر الموضع المناسب للصورة المميزة داخل صفحة المقال الفردي.', 'opentik'),
    ]);

    // Add Setting for Post Navigation
    $wp_customize->add_setting('opentik_single_post_navigation', [
        'default' => true,
        'sanitize_callback' => 'opentik_sanitize_checkbox',
    ]);

    $wp_customize->add_control('opentik_single_post_navigation', [
        'label' => esc_html__('تفعيل أزرار التنقل (السابق/التالي)', 'opentik'),
        'section' => 'opentik_single_post_section',
        'type' => 'checkbox',
    ]);
}
add_action('customize_register', 'opentik_customize_register_single');
