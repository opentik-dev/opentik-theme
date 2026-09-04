<?php
if (!function_exists('opentik_setup')) {
    function opentik_setup(): void
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', ['search-form', 'gallery', 'caption', 'navigation-widgets']);
        add_theme_support('automatic-feed-links');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('custom-logo', [
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => ['site-title', 'site-description'],
        ]);
        add_theme_support('customize-selective-refresh-widgets');

        register_nav_menus([
            'primary' => __('Primary Menu', 'opentik'),
            'footer' => __('Footer Menu', 'opentik')
        ]);

        add_image_size('opentik-card', 720, 480, true);
        set_post_thumbnail_size(1200, 675, true);
    }
    add_action('after_setup_theme', 'opentik_setup');
}

if (!function_exists('opentik_excerpt_length')) {
    function opentik_excerpt_length(int $length): int
    {
        return 22;
    }
    add_filter('excerpt_length', 'opentik_excerpt_length', 999);
}

if (!function_exists('opentik_widgets_init')) {
    function opentik_widgets_init(): void
    {
        register_sidebar([
            'name' => __('Primary Sidebar', 'opentik'),
            'id' => 'sidebar-1',
            'before_widget' => '<section class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ]);
    }
    add_action('widgets_init', 'opentik_widgets_init');
}

/**
 * Register Customizer selective refresh support.
 */
if (!function_exists('opentik_customize_register')) {
    function opentik_customize_register($wp_customize): void
    {
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
        $wp_customize->get_setting('custom_logo')->transport = 'postMessage';

        if (isset($wp_customize->selective_refresh)) {
            $wp_customize->selective_refresh->add_partial('site_branding', [
                'selector' => '.site-branding',
                'settings' => ['custom_logo', 'blogname'],
                'render_callback' => 'opentik_customize_partial_site_branding',
            ]);
        }

        // Add Section for Single Post Settings


        // --- Pages Settings ---
        $wp_customize->add_section('opentik_pages_section', [
            'title' => esc_html__('إعدادات الصفحات', 'opentik'),
            'priority' => 31,
            'description' => esc_html__('إعدادات واجهة التبويبات الموحدة للصفحات.', 'opentik'),
        ]);
        $wp_customize->add_setting('opentik_enable_page_tabs', ['default' => true, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
        $wp_customize->add_control('opentik_enable_page_tabs', ['label' => esc_html__('تفعيل القائمة الجانبية (التبويبات الموحدة) للصفحات', 'opentik'), 'section' => 'opentik_pages_section', 'type' => 'checkbox']);
        $wp_customize->add_setting('opentik_page_tabs_title', ['default' => 'معلومات تهمك', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control('opentik_page_tabs_title', ['label' => esc_html__('عنوان التبويبات الجانبية', 'opentik'), 'section' => 'opentik_pages_section', 'type' => 'text']);

        // --- Header Settings ---
        $wp_customize->add_section('opentik_header_section', ['title' => esc_html__('إعدادات الهيدر', 'opentik'), 'priority' => 32]);
        $wp_customize->add_setting('opentik_show_top_bar', ['default' => true, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
        $wp_customize->add_control('opentik_show_top_bar', ['label' => esc_html__('إظهار الشريط العلوي (التاريخ والترحيب)', 'opentik'), 'section' => 'opentik_header_section', 'type' => 'checkbox']);
        $wp_customize->add_setting('opentik_top_bar_text', ['default' => sprintf(esc_html__('أهلاً بك في %s - تغطيتك التقنية الموثوقة', 'opentik'), get_bloginfo('name')), 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control('opentik_top_bar_text', ['label' => esc_html__('نص الترحيب في الشريط العلوي', 'opentik'), 'section' => 'opentik_header_section', 'type' => 'text']);

        // --- Analytics Settings ---
        $wp_customize->add_section('opentik_analytics_section', [
            'title' => esc_html__('إعدادات التحليلات والتتبع', 'opentik'),
            'priority' => 34,
            'description' => esc_html__('إعدادات دمج منصات الإحصائيات مثل Umami و Google Analytics للحفاظ على خصوصية الزوار.', 'opentik'),
        ]);

        // Umami Settings
        $wp_customize->add_setting('opentik_umami_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control('opentik_umami_id', [
            'label' => esc_html__('معرف موقع Umami (Website ID)', 'opentik'),
            'description' => esc_html__('مثال: f898ef00-bcb7-43a1-a4a5-f076d2694b92', 'opentik'),
            'section' => 'opentik_analytics_section',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('opentik_umami_url', ['default' => 'https://cloud.umami.is/script.js', 'sanitize_callback' => 'esc_url_raw']);
        $wp_customize->add_control('opentik_umami_url', [
            'label' => esc_html__('رابط سكربت Umami', 'opentik'),
            'description' => esc_html__('الرابط الافتراضي للخدمة السحابية. يمكنك تغييره إذا كنت تستضيف Umami بنفسك.', 'opentik'),
            'section' => 'opentik_analytics_section',
            'type' => 'url',
        ]);

        // Google Analytics Settings
        $wp_customize->add_setting('opentik_ga_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control('opentik_ga_id', [
            'label' => esc_html__('معرف Google Analytics (Measurement ID)', 'opentik'),
            'description' => esc_html__('مثال: G-XXXXXXXXXX (يُستخدم اختيارياً للمستقبل).', 'opentik'),
            'section' => 'opentik_analytics_section',
            'type' => 'text',
        ]);

        // --- Cusdis Comments Settings ---
        $wp_customize->add_section('opentik_comments_section', [
            'title' => esc_html__('إعدادات التعليقات (Cusdis)', 'opentik'),
            'priority' => 35,
            'description' => esc_html__('إعدادات دمج منصة التعليقات الخفيفة والآمنة Cusdis أسفل المقالات.', 'opentik'),
        ]);

        $wp_customize->add_setting('opentik_show_comments', ['default' => true, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
        $wp_customize->add_control('opentik_show_comments', [
            'label' => esc_html__('تفعيل التعليقات في المقالات', 'opentik'),
            'section' => 'opentik_comments_section',
            'type' => 'checkbox',
        ]);

        $wp_customize->add_setting('opentik_cusdis_app_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control('opentik_cusdis_app_id', [
            'label' => esc_html__('معرف تطبيق Cusdis (App ID)', 'opentik'),
            'description' => esc_html__('مثال: 5f90001f-0da9-4f4a-a5c6-e5e90c0ab61f', 'opentik'),
            'section' => 'opentik_comments_section',
            'type' => 'text',
        ]);

        // --- Advanced Settings (Static Sites Compatibility) ---
        $wp_customize->add_section('opentik_advanced_section', [
            'title' => esc_html__('إعدادات متقدمة (Advanced)', 'opentik'),
            'priority' => 36,
            'description' => esc_html__('إعدادات برمجية لحل مشاكل التوافق، مثل مشاكل تحويل الموقع لثابت (Staatic).', 'opentik'),
        ]);

        $wp_customize->add_setting('opentik_disable_wp_sitemap', ['default' => false, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
        $wp_customize->add_control('opentik_disable_wp_sitemap', [
            'label' => esc_html__('تعطيل خريطة الموقع الافتراضية (Sitemap)', 'opentik'),
            'description' => esc_html__('قم بتفعيل هذا الخيار لتجنب أخطاء توقف إضافة Staatic عند قراءة wp-sitemap.xml (مفيد أيضاً إذا كنت تستخدم إضافات SEO تولد خريطتها الخاصة).', 'opentik'),
            'section' => 'opentik_advanced_section',
            'type' => 'checkbox',
        ]);

        // --- Social Share Settings ---
        $wp_customize->add_section('opentik_social_share_section', [
            'title' => esc_html__('إعدادات المشاركة والطباعة', 'opentik'),
            'priority' => 37,
            'description' => esc_html__('تخصيص أزرار المشاركة الاجتماعية الفاخرة (WhatsApp, X, LinkedIn, Facebook) وزر الطباعة المدمجة.', 'opentik'),
        ]);

        $wp_customize->add_setting('opentik_share_visibility', ['default' => true, 'sanitize_callback' => 'opentik_sanitize_checkbox']);
        $wp_customize->add_control('opentik_share_visibility', [
            'label' => esc_html__('تفعيل أزرار المشاركة', 'opentik'),
            'section' => 'opentik_social_share_section',
            'type' => 'checkbox',
        ]);

        $wp_customize->add_setting('opentik_share_position', ['default' => 'bottom', 'sanitize_callback' => 'opentik_sanitize_share_position']);
        $wp_customize->add_control('opentik_share_position', [
            'label' => esc_html__('موضع الأزرار', 'opentik'),
            'section' => 'opentik_social_share_section',
            'type' => 'select',
            'choices' => [
                'top' => esc_html__('أعلى المقال فقط', 'opentik'),
                'bottom' => esc_html__('أسفل المقال فقط', 'opentik'),
                'both' => esc_html__('في الأعلى والأسفل', 'opentik'),
            ]
        ]);

        $wp_customize->add_setting('opentik_share_alignment', ['default' => 'between', 'sanitize_callback' => 'opentik_sanitize_share_alignment']);
        $wp_customize->add_control('opentik_share_alignment', [
            'label' => esc_html__('محاذاة الأزرار', 'opentik'),
            'section' => 'opentik_social_share_section',
            'type' => 'select',
            'choices' => [
                'start' => esc_html__('جهة اليمين (البداية)', 'opentik'),
                'center' => esc_html__('في المنتصف', 'opentik'),
                'end' => esc_html__('جهة اليسار (النهاية)', 'opentik'),
                'between' => esc_html__('تباعد متساوي (موصى به)', 'opentik'),
            ]
        ]);

        $wp_customize->add_setting('opentik_share_size', ['default' => 'medium', 'sanitize_callback' => 'opentik_sanitize_share_size']);
        $wp_customize->add_control('opentik_share_size', [
            'label' => esc_html__('حجم أيقونات المشاركة', 'opentik'),
            'section' => 'opentik_social_share_section',
            'type' => 'select',
            'choices' => [
                'small' => esc_html__('صغير', 'opentik'),
                'medium' => esc_html__('متوسط', 'opentik'),
                'large' => esc_html__('كبير', 'opentik'),
            ]
        ]);
    }
    add_action('customize_register', 'opentik_customize_register');
}

// Apply Advanced Settings
if (get_theme_mod('opentik_disable_wp_sitemap', false)) {
    add_filter('wp_sitemaps_enabled', '__return_false');
}

/**
 * Sanitize Checkbox
 */
if (!function_exists('opentik_sanitize_checkbox')) {
    function opentik_sanitize_checkbox($checked) {
        return ((isset($checked) && true == $checked) ? true : false);
    }
}

/**
 * Sanitize the featured image position option.
 */
if (!function_exists('opentik_sanitize_image_position')) {
    function opentik_sanitize_image_position($input) {
        $valid = ['below_title', 'behind_title'];
        if (in_array($input, $valid, true)) {
            return $input;
        }
        return 'below_title';
    }
}

/**
 * Sanitize Social Share Position
 */
if (!function_exists('opentik_sanitize_share_position')) {
    function opentik_sanitize_share_position($input) {
        $valid = ['top', 'bottom', 'both'];
        return in_array($input, $valid, true) ? $input : 'bottom';
    }
}

/**
 * Sanitize Social Share Alignment
 */
if (!function_exists('opentik_sanitize_share_alignment')) {
    function opentik_sanitize_share_alignment($input) {
        $valid = ['start', 'center', 'end', 'between'];
        return in_array($input, $valid, true) ? $input : 'between';
    }
}

/**
 * Sanitize Social Share Size
 */
if (!function_exists('opentik_sanitize_share_size')) {
    function opentik_sanitize_share_size($input) {
        $valid = ['small', 'medium', 'large'];
        return in_array($input, $valid, true) ? $input : 'medium';
    }
}

/**
 * Render the site branding for the selective refresh partial.
 */
if (!function_exists('opentik_customize_partial_site_branding')) {
    function opentik_customize_partial_site_branding(): void
    {
        if (has_custom_logo()) {
            echo '<div class="custom-logo-container">' . get_custom_logo() . '</div>';
        } else {
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-capsule flex items-center px-5 py-1.5 rounded-full bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-300 group">
                <span class="text-lg font-extrabold text-slate-900 tracking-tight transition-colors duration-300"><?php bloginfo('name'); ?></span>
            </a>
            <?php
        }
    }
}

/**
 * Inject Analytics Scripts into Head
 */
if (!function_exists('opentik_inject_analytics_scripts')) {
    function opentik_inject_analytics_scripts() {
        // Umami Analytics
        $umami_id = get_theme_mod('opentik_umami_id');
        $umami_url = get_theme_mod('opentik_umami_url', 'https://cloud.umami.is/script.js');
        
        if (!empty($umami_id) && !empty($umami_url)) {
            echo "\n<!-- Umami Analytics -->\n";
            echo sprintf(
                '<script defer src="%s" data-website-id="%s"></script>',
                esc_url($umami_url),
                esc_attr($umami_id)
            );
            echo "\n<!-- End Umami Analytics -->\n";
        }

        // Google Analytics
        $ga_id = get_theme_mod('opentik_ga_id');
        if (!empty($ga_id)) {
            echo "\n<!-- Google Analytics -->\n";
            echo sprintf(
                '<script async src="https://www.googletagmanager.com/gtag/js?id=%s"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());
  gtag(\'config\', \'%s\');
</script>',
                esc_attr($ga_id),
                esc_attr($ga_id)
            );
            echo "\n<!-- End Google Analytics -->\n";
        }
    }
    add_action('wp_head', 'opentik_inject_analytics_scripts', 99);
}

// Removed customizer includes to functions.php
