<?php
require_once __DIR__ . '/inc/setup.php';
require_once __DIR__ . '/inc/template-tags.php';
require_once __DIR__ . '/inc/logging.php';
require_once __DIR__ . '/inc/color-utils.php';

// Customizer
require_once __DIR__ . '/inc/customizer-header.php';
require_once __DIR__ . '/inc/customizer-footer.php';
require_once __DIR__ . '/inc/customizer-single.php';
require_once __DIR__ . '/inc/customizer-archive.php';

add_action('wp_enqueue_scripts', 'opentik_enqueue_assets');
function opentik_enqueue_assets(): void
{
    $css_path = get_template_directory() . '/assets/dist/css/main.css';
    $js_path = get_template_directory() . '/assets/dist/js/main.js';

    if (file_exists($css_path)) {
        wp_enqueue_style(
            'opentik-style',
            get_template_directory_uri() . '/assets/dist/css/main.css',
            [],
            filemtime($css_path)
        );
    }

    // PrismJS loaded only for posts/pages that actually contain code
    $prism_dependencies = [];
    if (opentik_needs_prism()) {
        wp_enqueue_style(
            'prismjs-theme',
            'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css',
            [],
            '1.29.0'
        );

        wp_enqueue_script(
            'prismjs-core',
            'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js',
            [],
            '1.29.0',
            true
        );

        wp_enqueue_script(
            'prismjs-autoloader',
            'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js',
            ['prismjs-core'],
            '1.29.0',
            true
        );

        $prism_dependencies = ['prismjs-autoloader'];
    }

    if (file_exists($js_path)) {
        wp_enqueue_script(
            'opentik-main',
            get_template_directory_uri() . '/assets/dist/js/main.js',
            $prism_dependencies,
            filemtime($js_path),
            true
        );
    }
}

// Modify Main Query for Posts Per Page
add_action('pre_get_posts', 'opentik_modify_main_query');
function opentik_modify_main_query($query) {
    if (!is_admin() && $query->is_main_query() && (is_home() || is_archive() || is_search())) {
        $posts_per_page = get_theme_mod('opentik_posts_per_page', get_option('posts_per_page'));
        if ($posts_per_page) {
            $query->set('posts_per_page', absint($posts_per_page));
        }
    }
}
