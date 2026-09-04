<?php
function opentik_customize_register_footer($wp_customize) {
    // Helper function for choices
    $align_choices = [
        'right' => esc_html__('يمين', 'opentik'),
        'center' => esc_html__('وسط', 'opentik'),
        'left' => esc_html__('يسار', 'opentik'),
    ];
    $style_choices = [
        'expanded' => esc_html__('مفرود (افتراضي)', 'opentik'),
        'compact' => esc_html__('مضغوط', 'opentik'),
    ];
    $col_choices = [
        'brand' => esc_html__('العلامة التجارية والشعار', 'opentik'),
        'links' => esc_html__('قائمة الروابط', 'opentik'),
        'popular' => esc_html__('المقالات الرائجة', 'opentik'),
        'tags' => esc_html__('الوسوم / التصنيفات', 'opentik'),
        'custom' => esc_html__('عنصر مخصص (HTML)', 'opentik'),
        'none' => esc_html__('فارغ (لا شيء)', 'opentik'),
    ];

    // --- Panel for Footer ---
    $wp_customize->add_panel('opentik_footer_panel', [
        'title' => esc_html__('إعدادات الفوتر (Footer Builder)', 'opentik'),
        'priority' => 33,
    ]);

    // --- Section: Footer Layout ---
    $wp_customize->add_section('opentik_footer_layout_section', [
        'title' => esc_html__('تخطيط وترتيب الأعمدة', 'opentik'),
        'panel' => 'opentik_footer_panel',
        'priority' => 10,
    ]);
    
    $wp_customize->add_setting('opentik_footer_layout_style', ['default' => 'equal_grid', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_layout_style', [
        'label' => esc_html__('قالب تخطيط الأعمدة', 'opentik'),
        'section' => 'opentik_footer_layout_section',
        'type' => 'select',
        'priority' => 5,
        'choices' => [
            'equal_grid' => esc_html__('الشبكة المتساوية (Equal Grid)', 'opentik'),
            'top_1_grid' => esc_html__('عمود 1 بالأعلى + شبكة بالأسفل', 'opentik'),
            'grid_bottom_1' => esc_html__('شبكة بالأعلى + العمود الأخير بالأسفل', 'opentik'),
            'top_1_grid_bottom_1' => esc_html__('عمود 1 علوي + شبكة بالوسط + عمود أخير سفلي', 'opentik'),
        ]
    ]);
    
    for ($i = 1; $i <= 5; $i++) {
        $default = 'none';
        if ($i == 1) $default = 'brand';
        if ($i == 2) $default = 'links';
        if ($i == 3) $default = 'popular';
        if ($i == 4) $default = 'tags';
        
        $wp_customize->add_setting("opentik_footer_col_$i", ['default' => $default, 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("opentik_footer_col_$i", [
            'label' => sprintf(esc_html__('العمود %s', 'opentik'), $i),
            'section' => 'opentik_footer_layout_section',
            'type' => 'select',
            'choices' => $col_choices,
        ]);
    }

    // --- Section: Footer Styling ---
    $wp_customize->add_section('opentik_footer_style_section', [
        'title' => esc_html__('ألوان وخلفية الفوتر', 'opentik'),
        'panel' => 'opentik_footer_panel',
        'priority' => 15,
    ]);

    $wp_customize->add_setting('opentik_footer_bg_type', ['default' => 'dark', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_bg_type', [
        'label' => esc_html__('نمط خلفية الفوتر', 'opentik'),
        'section' => 'opentik_footer_style_section',
        'type' => 'select',
        'choices' => [
            'dark' => esc_html__('داكن دائماً (Classic Dark)', 'opentik'),
            'dynamic' => esc_html__('ديناميكي يتكيف مع الموقع (Dynamic)', 'opentik'),
            'custom' => esc_html__('لون مخصص (Custom Color)', 'opentik'),
        ]
    ]);

    $wp_customize->add_setting('opentik_footer_bg_color', ['default' => '#0f172a', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'opentik_footer_bg_color', [
        'label' => esc_html__('اختر لون الخلفية', 'opentik'),
        'section' => 'opentik_footer_style_section',
    ]));

    $wp_customize->add_setting('opentik_footer_text_type', ['default' => 'light', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_text_type', [
        'label' => esc_html__('لون النصوص العامة بالفوتر', 'opentik'),
        'section' => 'opentik_footer_style_section',
        'type' => 'radio',
        'choices' => [
            'light' => esc_html__('نصوص فاتحة (للخلفيات الداكنة)', 'opentik'),
            'dark' => esc_html__('نصوص داكنة (للخلفيات الفاتحة)', 'opentik'),
        ]
    ]);
    
    // --- Section: Footer Brand ---
    $wp_customize->add_section('opentik_footer_brand_section', [
        'title' => esc_html__('العلامة التجارية والشعار', 'opentik'),
        'panel' => 'opentik_footer_panel',
    ]);
    
    $wp_customize->add_setting('opentik_footer_brand_align', ['default' => 'right', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_brand_align', ['label' => esc_html__('محاذاة القسم', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'select', 'choices' => $align_choices]);

    $wp_customize->add_setting('opentik_footer_logo_width', ['default' => 150, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('opentik_footer_logo_width', ['label' => esc_html__('حجم الشعار (بالبكسل)', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'range', 'input_attrs' => ['min' => 50, 'max' => 400, 'step' => 5]]);
    
    $wp_customize->add_setting('opentik_footer_title_visibility', ['default' => true, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
    $wp_customize->add_control('opentik_footer_title_visibility', ['label' => esc_html__('إظهار اسم الموقع', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'checkbox']);

    // Title Style (Background / Border)
    $wp_customize->add_setting('opentik_footer_title_style', ['default' => 'transparent', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_title_style', [
        'label' => esc_html__('نمط خلفية اسم الموقع', 'opentik'),
        'section' => 'opentik_footer_brand_section',
        'type' => 'select',
        'choices' => [
            'transparent' => esc_html__('بدون خلفية (نص فقط)', 'opentik'),
            'solid' => esc_html__('خلفية ملونة (Solid)', 'opentik'),
            'glass' => esc_html__('زجاجي فاخر (Glassmorphic)', 'opentik'),
            'outline' => esc_html__('برواز فقط (Outline)', 'opentik'),
        ]
    ]);

    // Title Background Color
    $wp_customize->add_setting('opentik_footer_title_bg_color', ['default' => '#facc15', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'opentik_footer_title_bg_color', [
        'label' => esc_html__('لون الخلفية / البرواز', 'opentik'),
        'section' => 'opentik_footer_brand_section',
    ]));
    
    $wp_customize->add_setting('opentik_footer_title_position', ['default' => 'bottom', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_title_position', ['label' => esc_html__('موضع اسم الموقع بالنسبة للشعار', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'select', 'choices' => [
        'bottom' => esc_html__('أسفل الشعار', 'opentik'),
        'top' => esc_html__('أعلى الشعار', 'opentik'),
        'right' => esc_html__('يمين الشعار', 'opentik'),
        'left' => esc_html__('يسار الشعار', 'opentik'),
    ]]);
    
    $wp_customize->add_setting('opentik_footer_description_visibility', ['default' => true, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
    $wp_customize->add_control('opentik_footer_description_visibility', ['label' => esc_html__('إظهار وصف الموقع', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'checkbox']);

    $wp_customize->add_setting('opentik_footer_description_position', ['default' => 'bottom', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_description_position', ['label' => esc_html__('موضع الوصف بالنسبة للشعار والاسم', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'select', 'choices' => [
        'bottom' => esc_html__('أسفل الشعار والاسم', 'opentik'),
        'top' => esc_html__('أعلى الشعار والاسم', 'opentik'),
        'right' => esc_html__('يمين الشعار والاسم', 'opentik'),
        'left' => esc_html__('يسار الشعار والاسم', 'opentik'),
    ]]);

    $wp_customize->add_setting('opentik_footer_description', ['default' => get_bloginfo('description'), 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('opentik_footer_description', ['label' => esc_html__('نص الوصف', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'textarea']);

    $wp_customize->add_setting('opentik_footer_description_style', ['default' => 'expanded', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_description_style', ['label' => esc_html__('نمط عرض الوصف', 'opentik'), 'section' => 'opentik_footer_brand_section', 'type' => 'select', 'choices' => $style_choices]);


    // --- Section: Footer Links ---
    $wp_customize->add_section('opentik_footer_links_section', [
        'title' => esc_html__('قائمة الروابط', 'opentik'),
        'panel' => 'opentik_footer_panel',
    ]);
    $wp_customize->add_setting('opentik_footer_links_title', ['default' => 'روابط تهمك', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_links_title', ['label' => esc_html__('العنوان', 'opentik'), 'section' => 'opentik_footer_links_section', 'type' => 'text']);
    
    $wp_customize->add_setting('opentik_footer_links_align', ['default' => 'right', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_links_align', ['label' => esc_html__('محاذاة القسم', 'opentik'), 'section' => 'opentik_footer_links_section', 'type' => 'select', 'choices' => $align_choices]);

    $wp_customize->add_setting('opentik_footer_links_style', ['default' => 'expanded', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_links_style', ['label' => esc_html__('نمط عرض القائمة', 'opentik'), 'section' => 'opentik_footer_links_section', 'type' => 'select', 'choices' => $style_choices]);


    // --- Section: Footer Popular ---
    $wp_customize->add_section('opentik_footer_popular_section', [
        'title' => esc_html__('المقالات الرائجة', 'opentik'),
        'panel' => 'opentik_footer_panel',
    ]);
    $wp_customize->add_setting('opentik_footer_popular_title', ['default' => 'الأكثر رواجاً', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_popular_title', ['label' => esc_html__('العنوان', 'opentik'), 'section' => 'opentik_footer_popular_section', 'type' => 'text']);
    
    $wp_customize->add_setting('opentik_footer_popular_count', ['default' => 3, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('opentik_footer_popular_count', ['label' => esc_html__('عدد المقالات', 'opentik'), 'section' => 'opentik_footer_popular_section', 'type' => 'number']);
    
    $wp_customize->add_setting('opentik_footer_popular_thumbnails', ['default' => true, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
    $wp_customize->add_control('opentik_footer_popular_thumbnails', ['label' => esc_html__('إظهار الصور المصغرة', 'opentik'), 'section' => 'opentik_footer_popular_section', 'type' => 'checkbox']);

    $wp_customize->add_setting('opentik_footer_popular_align', ['default' => 'right', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_popular_align', ['label' => esc_html__('محاذاة القسم', 'opentik'), 'section' => 'opentik_footer_popular_section', 'type' => 'select', 'choices' => $align_choices]);

    $wp_customize->add_setting('opentik_footer_popular_style', ['default' => 'expanded', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_popular_style', ['label' => esc_html__('نمط عرض القائمة', 'opentik'), 'section' => 'opentik_footer_popular_section', 'type' => 'select', 'choices' => $style_choices]);


    // --- Section: Footer Tags ---
    $wp_customize->add_section('opentik_footer_tags_section', [
        'title' => esc_html__('الوسوم والتصنيفات', 'opentik'),
        'panel' => 'opentik_footer_panel',
    ]);
    $wp_customize->add_setting('opentik_footer_tags_title', ['default' => 'أبرز الوسوم', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_tags_title', ['label' => esc_html__('العنوان', 'opentik'), 'section' => 'opentik_footer_tags_section', 'type' => 'text']);

    $wp_customize->add_setting('opentik_footer_tags_type', ['default' => 'tags', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_tags_type', ['label' => esc_html__('نوع المحتوى', 'opentik'), 'section' => 'opentik_footer_tags_section', 'type' => 'radio', 'choices' => ['tags' => 'الوسوم', 'categories' => 'التصنيفات']]);

    $wp_customize->add_setting('opentik_footer_tags_count', ['default' => 12, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('opentik_footer_tags_count', ['label' => esc_html__('عدد العناصر', 'opentik'), 'section' => 'opentik_footer_tags_section', 'type' => 'number']);

    $wp_customize->add_setting('opentik_footer_tags_align', ['default' => 'right', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_tags_align', ['label' => esc_html__('محاذاة القسم', 'opentik'), 'section' => 'opentik_footer_tags_section', 'type' => 'select', 'choices' => $align_choices]);

    $wp_customize->add_setting('opentik_footer_tags_style', ['default' => 'expanded', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_tags_style', ['label' => esc_html__('نمط عرض القائمة', 'opentik'), 'section' => 'opentik_footer_tags_section', 'type' => 'select', 'choices' => $style_choices]);


    // --- Section: Footer Custom ---
    $wp_customize->add_section('opentik_footer_custom_section', [
        'title' => esc_html__('العنصر المخصص (HTML)', 'opentik'),
        'panel' => 'opentik_footer_panel',
    ]);
    $wp_customize->add_setting('opentik_footer_custom_title', ['default' => 'عنصر مخصص', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_custom_title', ['label' => esc_html__('العنوان', 'opentik'), 'section' => 'opentik_footer_custom_section', 'type' => 'text']);

    $wp_customize->add_setting('opentik_footer_custom_html', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('opentik_footer_custom_html', ['label' => esc_html__('كود HTML المخصص', 'opentik'), 'section' => 'opentik_footer_custom_section', 'type' => 'textarea']);

    $wp_customize->add_setting('opentik_footer_custom_align', ['default' => 'right', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('opentik_footer_custom_align', ['label' => esc_html__('محاذاة القسم', 'opentik'), 'section' => 'opentik_footer_custom_section', 'type' => 'select', 'choices' => $align_choices]);

}
add_action('customize_register', 'opentik_customize_register_footer', 99);
