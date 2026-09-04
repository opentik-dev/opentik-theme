<?php
function opentik_customize_register_archive($wp_customize) {
    // Rename default WordPress Homepage Settings section
    if ($wp_customize->get_section('static_front_page')) {
        $wp_customize->get_section('static_front_page')->title = esc_html__('إعدادات الصفحة الرئيسية والأرشيف', 'opentik');
        $wp_customize->get_section('static_front_page')->description = esc_html__('تخصيص مظهر وتخطيط المقالات في الصفحة الرئيسية والأرشيف، بالإضافة إلى إعدادات الصفحة الثابتة.', 'opentik');
    }

    // Posts Per Page
    $wp_customize->add_setting('opentik_posts_per_page', [
        'default' => get_option('posts_per_page'),
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('opentik_posts_per_page', [
        'label' => esc_html__('عدد المقالات المعروضة', 'opentik'),
        'section' => 'static_front_page',
        'type' => 'number',
        'input_attrs' => ['min' => 1, 'max' => 50],
        'description' => esc_html__('تحديد عدد المقالات المعروضة في الصفحة الرئيسية وصفحات الأرشيف.', 'opentik'),
    ]);

    // Layout
    $wp_customize->add_setting('opentik_archive_layout', [
        'default' => 'grid-2',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('opentik_archive_layout', [
        'label' => esc_html__('تخطيط عرض المقالات', 'opentik'),
        'section' => 'static_front_page',
        'type' => 'select',
        'choices' => [
            'grid-2' => esc_html__('شبكة منتظمة (عمودين متساويين)', 'opentik'),
            'grid-3' => esc_html__('شبكة منتظمة (3 أعمدة متساوية)', 'opentik'),
            'list' => esc_html__('قائمة عمودية (List)', 'opentik'),
            'masonry' => esc_html__('مربعات متراصة (Masonry)', 'opentik'),
        ],
    ]);

    // Excerpt Length
    $wp_customize->add_setting('opentik_excerpt_length', [
        'default' => 24,
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('opentik_excerpt_length', [
        'label' => esc_html__('طول الملخص (عدد الكلمات)', 'opentik'),
        'section' => 'static_front_page',
        'type' => 'number',
        'input_attrs' => ['min' => 0, 'max' => 100],
    ]);

    // Homepage Slider
    $wp_customize->add_setting('opentik_show_home_slider', [
        'default' => true,
        'sanitize_callback' => 'opentik_sanitize_checkbox',
    ]);
    $wp_customize->add_control('opentik_show_home_slider', [
        'label' => esc_html__('إظهار السلايدر الرئيسي', 'opentik'),
        'section' => 'static_front_page',
        'type' => 'checkbox',
        'description' => esc_html__('عند إيقافه يختفي السلايدر من الصفحة الرئيسية ويُوفَّر استعلام إضافي.', 'opentik'),
    ]);

    // Read More Button
    $wp_customize->add_setting('opentik_read_more_visibility', [
        'default' => false,
        'sanitize_callback' => 'opentik_sanitize_checkbox',
    ]);
    $wp_customize->add_control('opentik_read_more_visibility', [
        'label' => esc_html__('إظهار زر "اقرأ المزيد"', 'opentik'),
        'section' => 'static_front_page',
        'type' => 'checkbox',
    ]);

    $wp_customize->add_setting('opentik_read_more_text', [
        'default' => 'اقرأ المزيد',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('opentik_read_more_text', [
        'label' => esc_html__('نص زر "اقرأ المزيد"', 'opentik'),
        'section' => 'static_front_page',
        'type' => 'text',
    ]);
}
add_action('customize_register', 'opentik_customize_register_archive');
