<!doctype html>
<html <?php language_attributes(); ?> class="dark">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('opentik-theme');
                if (savedTheme === 'light') {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.classList.add('light');
                }
            } catch (e) {}
        })();
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class('site-wrapper'); ?>>
<a class="screen-reader-text" href="#content"><?php esc_html_e('تخطي إلى المحتوى', 'opentik'); ?></a>

<!-- Top Utility Date & Clock Bar -->
<?php if (get_theme_mod('opentik_show_top_bar', true)) : ?>
<div class="top-utility-bar px-4 py-2 border-b border-white/5 bg-slate-950/40 text-xs text-slate-400">
    <div class="site-content flex justify-between items-center flex-wrap md:flex-nowrap gap-4">
        <div class="clock-display flex items-center gap-1.5 font-medium flex-shrink-0">
            <span>📅</span>
            <span id="live-arabic-clock"><?php echo esc_html(date_i18n('l، j F Y')); ?></span>
        </div>

        <div class="ticker-text font-light text-slate-400/80 flex-shrink-0">
            ✨ <?php 
            $default_text = sprintf(esc_html__('أهلاً بك في %s - تغطيتك التقنية الموثوقة', 'opentik'), get_bloginfo('name'));
            echo esc_html(get_theme_mod('opentik_top_bar_text', $default_text)); 
            ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Primary Header -->
<?php
$header_py = get_theme_mod('opentik_header_padding_y', 3);
?>
<header class="site-header sticky top-0 z-40 backdrop-blur-md px-4 py-<?php echo esc_attr($header_py); ?> border-b border-white/5 transition-all duration-300">
    <div class="site-content">
        <div class="site-navigation flex items-center justify-between gap-4 py-0">
            <!-- Branding & Logo -->
            <?php
            $logo_size = get_theme_mod('opentik_header_logo_size', 40);
            $title_size = get_theme_mod('opentik_header_title_size', 18);
            $title_pos = get_theme_mod('opentik_header_title_position', 'left');
            $title_gap = get_theme_mod('opentik_header_title_gap', 3);
            $title_vis = get_theme_mod('opentik_header_title_visibility', 'show');
            $desc_vis = get_theme_mod('opentik_header_desc_visibility', 'hide');
            $title_style = get_theme_mod('opentik_header_title_style', 'transparent');
            $title_bg_color = get_theme_mod('opentik_header_title_bg_color', '#facc15');
            
            $flex_dir = 'flex-row'; // right to left
            if ($title_pos === 'right') $flex_dir = 'flex-row-reverse';
            if ($title_pos === 'top') $flex_dir = 'flex-col-reverse';
            if ($title_pos === 'bottom') $flex_dir = 'flex-col';

            $title_wrapper_class = "transition-all duration-500 ease-in-out ";
            if ($title_vis === 'hover') {
                $title_wrapper_class .= "opacity-0 invisible max-w-0 md:group-hover:max-w-xs md:group-hover:opacity-100 md:group-hover:visible overflow-hidden ";
                if ($title_pos === 'left' || $title_pos === 'right') $title_wrapper_class .= "translate-x-4 md:group-hover:translate-x-0 ";
                else $title_wrapper_class .= "translate-y-2 md:group-hover:translate-y-0 ";
                // On mobile, keep it hidden to save space if it's set to hover
                $title_wrapper_class .= "hidden md:block ";
            } elseif ($title_vis === 'hide') {
                $title_wrapper_class .= "hidden ";
            }

            // --- Title Styling Logic ---
            $title_span_class = "font-extrabold tracking-tight drop-shadow-md whitespace-nowrap transition-all duration-300 inline-block ";
            $title_span_style = "font-size: " . esc_attr($title_size) . "px; ";
            
            // Hex to RGBA for glass effect & brightness for text color
            $hex = ltrim($title_bg_color, '#');
            if (strlen($hex) == 3) { $hex = str_repeat(substr($hex,0,1), 2) . str_repeat(substr($hex,1,1), 2) . str_repeat(substr($hex,2,1), 2); }
            $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
            $rgba_glass = "rgba($r, $g, $b, 0.15)";
            
            $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
            $text_color_over_bg = ($brightness > 125) ? '#0f172a' : '#ffffff';

            if ($title_style === 'transparent') {
                $title_span_class .= "text-[var(--text-main)] ";
            } else {
                $title_span_class .= "px-4 py-1.5 rounded-2xl ";
                if ($title_style === 'solid') {
                    $title_span_style .= "background-color: " . esc_attr($title_bg_color) . "; color: " . esc_attr($text_color_over_bg) . ";";
                } elseif ($title_style === 'glass') {
                    $title_span_class .= "text-[var(--text-main)] border backdrop-blur-xl shadow-lg ";
                    $title_span_style .= "background-color: " . esc_attr($rgba_glass) . "; border-color: " . esc_attr($title_bg_color) . ";";
                } elseif ($title_style === 'outline') {
                    $title_span_class .= "text-[var(--text-main)] border-2 bg-transparent shadow-sm ";
                    $title_span_style .= "border-color: " . esc_attr($title_bg_color) . ";";
                }
            }

            $desc_class = "transition-all duration-500 ease-in-out text-xs text-slate-400 mt-1 ";
            if ($desc_vis === 'hover') {
                $desc_class .= "opacity-0 max-h-0 md:group-hover:max-h-20 md:group-hover:opacity-100 overflow-hidden translate-y-2 md:group-hover:translate-y-0 ";
                $desc_class .= "hidden md:block ";
            } elseif ($desc_vis === 'hide') {
                $desc_class .= "hidden ";
            }
            ?>
            <div class="site-branding group flex flex-col justify-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-link flex <?php echo esc_attr($flex_dir); ?> items-center gap-<?php echo esc_attr($title_gap); ?>">
                    <?php if (has_custom_logo()) : ?>
                        <div class="custom-logo-wrapper transition-all duration-500 md:group-hover:scale-105 md:group-hover:drop-shadow-[0_0_10px_rgba(250,204,21,0.3)] flex-shrink-0" style="max-height: <?php echo esc_attr($logo_size); ?>px;">
                            <?php 
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo) {
                                echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="h-full w-auto object-contain transition-all" style="max-height: ' . esc_attr($logo_size) . 'px;" />';
                            }
                            ?>
                        </div>
                    <?php else : ?>
                        <div class="logo-fallback bg-gradient-to-br from-white to-slate-200 rounded-full flex items-center justify-center shadow-lg transition-all duration-500 md:group-hover:scale-110 md:group-hover:shadow-white/50 flex-shrink-0" style="width: <?php echo esc_attr($logo_size); ?>px; height: <?php echo esc_attr($logo_size); ?>px;">
                            <span class="font-black text-slate-900" style="font-size: <?php echo esc_attr($logo_size * 0.5); ?>px;"><?php echo mb_substr(get_bloginfo('name'), 0, 1); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="site-title-wrapper <?php echo esc_attr($title_wrapper_class); ?>">
                        <span class="<?php echo esc_attr($title_span_class); ?>" style="<?php echo esc_attr($title_span_style); ?>">
                            <?php bloginfo('name'); ?>
                        </span>
                    </div>
                </a>

                <?php if ($desc_vis !== 'hide' && get_bloginfo('description')) : ?>
                    <div class="site-description-wrapper <?php echo ($title_pos === 'right' || $title_pos === 'left') ? 'text-start' : 'text-center'; ?> <?php echo esc_attr($desc_class); ?>">
                        <?php bloginfo('description'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation Menu -->
            <nav class="main-navigation hidden md:block" aria-label="Primary Menu">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class' => 'flex flex-wrap gap-6 text-sm font-semibold text-slate-300',
                        'container' => false,
                    ]);
                } else {
                    ?>
                    <ul class="flex flex-wrap gap-6 text-sm font-semibold">
                        <li>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>">
                                <?php esc_html_e('الرئيسية', 'opentik'); ?>
                            </a>
                        </li>
                        <?php
                        $pages = get_pages([
                            'sort_column' => 'menu_order',
                            'sort_order' => 'ASC',
                            'number' => 5
                        ]);
                        foreach ($pages as $page) {
                            $active_class = is_page($page->ID) ? 'active' : '';
                            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '" class="' . $active_class . '">' . esc_html($page->post_title) . '</a></li>';
                        }
                        ?>
                    </ul>
                    <?php
                }
                ?>
            </nav>

            <!-- Actions Panel -->
            <div class="actions-panel flex items-center gap-3">
                <!-- Search Button -->
                <button class="search-toggle-btn w-9 h-9 rounded-xl flex items-center justify-center border border-white/5 hover:border-yellow-400/30 bg-slate-900/40 hover:bg-slate-900/80 text-slate-300 hover:text-yellow-400 transition-all duration-300 shadow-sm cursor-pointer" aria-label="<?php esc_attr_e('البحث', 'opentik'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" />
                    </svg>
                </button>

                <!-- Theme Switcher Button -->
                <button id="theme-toggle-btn" class="w-9 h-9 rounded-xl flex items-center justify-center border border-white/5 hover:border-yellow-400/30 bg-slate-900/40 hover:bg-slate-900/80 text-slate-300 hover:text-yellow-400 transition-all duration-300 shadow-sm cursor-pointer" aria-label="<?php esc_attr_e('تبديل المظهر', 'opentik'); ?>">
                    <svg class="sun-icon hidden w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.93 4.93l1.591 1.591m10.954 10.954l1.591 1.591M3 12h2.25m13.5 0H21m-16.07 4.93l1.591-1.591M16.07 4.93l-1.591 1.591M12 7.5a4.5 4.5 0 110 9 4.5 4.5 0 010-9z" />
                    </svg>
                    <svg class="moon-icon hidden w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>

                <!-- Mobile Menu Button -->
                <button class="menu-toggle md:hidden w-9 h-9 rounded-xl flex items-center justify-center border border-white/5 bg-slate-900/40 text-slate-300 hover:text-white transition-all duration-300" type="button" aria-label="<?php esc_attr_e('القائمة', 'opentik'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Full-screen Search Overlay -->
<div id="fullscreen-search-overlay" class="search-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-950/95 backdrop-blur-xl opacity-0 pointer-events-none transition-all duration-300">
    <button id="search-close-btn" class="absolute top-6 left-6 w-12 h-12 rounded-full border border-white/10 hover:border-yellow-400/30 flex items-center justify-center text-white hover:text-yellow-400 hover:rotate-90 transition-all duration-300 cursor-pointer" aria-label="<?php esc_attr_e('إغلاق', 'opentik'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="w-full max-w-2xl px-6 text-center">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <label>
                <span class="screen-reader-text"><?php esc_html_e('البحث عن:', 'opentik'); ?></span>
                <input type="search" id="search-input-overlay" class="search-field w-full text-center bg-transparent border-b-2 border-white/15 focus:border-yellow-400 text-2xl md:text-4xl text-white font-extrabold focus:outline-none py-4 transition-all duration-300 placeholder-slate-600" placeholder="<?php esc_attr_e('اكتب ما تبحث عنه...', 'opentik'); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
            </label>
            <p class="text-xs text-slate-500 mt-4"><?php esc_html_e('اضغط Enter للبحث أو ESC للإلغاء', 'opentik'); ?></p>
        </form>
    </div>
</div>

<!-- Mobile Navigation Drawer (Off-canvas) -->
<div id="mobile-drawer" class="mobile-drawer flex flex-col shadow-2xl">
    <!-- Close Button & Header -->
    <div class="flex items-center justify-between p-6 border-b border-white/5">
        <div class="drawer-branding flex items-center">
            <?php if (has_custom_logo()) : ?>
                <div class="custom-logo-container max-h-8">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo_img = wp_get_attachment_image_src($custom_logo_id, 'thumbnail');
                    if ($logo_img) : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="block">
                            <img src="<?php echo esc_url($logo_img[0]); ?>" alt="<?php bloginfo('name'); ?>" class="max-h-8 w-auto object-contain transition-transform duration-300 hover:scale-105" />
                        </a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="block">
                    <span class="text-sm font-extrabold tracking-tight text-white"><?php bloginfo('name'); ?></span>
                </a>
            <?php endif; ?>
        </div>
        <button id="drawer-close-btn" class="w-9 h-9 rounded-xl border border-white/5 hover:border-yellow-400/30 flex items-center justify-center text-slate-300 hover:text-yellow-400 transition-all duration-300 cursor-pointer" aria-label="<?php esc_attr_e('إغلاق القائمة', 'opentik'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <!-- Drawer Menu Content -->
    <div class="flex-grow overflow-y-auto px-6 py-8">
        <nav class="mobile-navigation" aria-label="<?php esc_attr_e('قائمة الجوال', 'opentik'); ?>">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class' => 'flex flex-col gap-4 text-base font-bold',
                    'container' => false,
                ]);
            } else {
                ?>
                <ul class="flex flex-col gap-4 text-base font-bold">
                    <li>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>">
                            <?php esc_html_e('الرئيسية', 'opentik'); ?>
                        </a>
                    </li>
                    <?php
                    $mobile_pages = get_pages([
                        'sort_column' => 'menu_order',
                        'sort_order' => 'ASC',
                        'number' => 5
                    ]);
                    foreach ($mobile_pages as $page) {
                        $active_class = is_page($page->ID) ? 'active' : '';
                        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '" class="' . $active_class . '">' . esc_html($page->post_title) . '</a></li>';
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </nav>

        <!-- Categories Section -->
        <?php
        $categories = get_categories([
            'orderby' => 'count',
            'order'   => 'DESC',
            'parent'  => 0,
            'number'  => 8,
        ]);
        if (!empty($categories)) : ?>
            <div class="drawer-section mt-8 pt-6 border-t border-white/5">
                <h3 class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-4 pr-2 border-r-2 border-yellow-400">
                    <?php esc_html_e('أقسام الموقع', 'opentik'); ?>
                </h3>
                <ul class="flex flex-wrap gap-2">
                    <?php foreach ($categories as $cat) : ?>
                        <li>
                            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="text-xs font-bold px-3 py-2 rounded-xl bg-slate-900/40 border border-white/5 hover:border-yellow-400/30 text-slate-300 hover:text-yellow-400 transition-all duration-300 block">
                                <?php echo esc_html($cat->name); ?>
                                <span class="text-[10px] text-slate-500 font-normal mr-1">(<?php echo esc_html($cat->count); ?>)</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Popular Tags Section -->
        <?php
        $tags = get_tags([
            'orderby' => 'count',
            'order'   => 'DESC',
            'number'  => 12,
        ]);
        if (!empty($tags)) : ?>
            <div class="drawer-section mt-8 pt-6 border-t border-white/5">
                <h3 class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-4 pr-2 border-r-2 border-yellow-400">
                    <?php esc_html_e('أبرز الوسوم', 'opentik'); ?>
                </h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-slate-900/20 hover:bg-yellow-400/10 border border-transparent hover:border-yellow-400/10 text-slate-400 hover:text-yellow-400 transition-all duration-300">
                            # <?php echo esc_html($tag->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Drawer Footer -->
    <div class="p-6 border-t border-white/5 text-center bg-slate-950/20">
        <div class="text-[10px] text-slate-500">
            © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('جميع الحقوق محفوظة.', 'opentik'); ?>
        </div>
    </div>
</div>

<!-- Backdrop Overlay for Mobile Drawer -->
<div id="drawer-backdrop" class="drawer-backdrop fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-500"></div>

<main id="content" class="site-content" role="main">

