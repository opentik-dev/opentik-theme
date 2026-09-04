</main>
<?php
// Retrieve columns order
$cols = [];
for ($i = 1; $i <= 5; $i++) {
    $default = 'none';
    if ($i == 1) $default = 'brand';
    if ($i == 2) $default = 'links';
    if ($i == 3) $default = 'popular';
    if ($i == 4) $default = 'tags';
    
    $col_type = get_theme_mod("opentik_footer_col_$i", $default);
    if ($col_type !== 'none') {
        $cols[] = $col_type;
    }
}
$num_cols = count($cols);

$layout_style = get_theme_mod('opentik_footer_layout_style', 'equal_grid');
$bg_type = get_theme_mod('opentik_footer_bg_type', 'dark');
$bg_color = get_theme_mod('opentik_footer_bg_color', '#0f172a');
$text_type = get_theme_mod('opentik_footer_text_type', 'light');

// Footer Classes & Styling
$footer_class = "site-footer relative mt-16 pt-16 pb-8 border-t overflow-hidden text-sm transition-colors duration-300 ";
$footer_style = "";

if ($bg_type === 'dark') {
    $footer_class .= "bg-slate-950 border-white/5 ";
} elseif ($bg_type === 'dynamic') {
    $footer_class .= "bg-[var(--bg-card)] border-[var(--border-color)] ";
} elseif ($bg_type === 'custom') {
    $footer_style .= "background-color: " . esc_attr($bg_color) . "; ";
    // Calculate brightness for border
    $hex = ltrim($bg_color, '#');
    if (strlen($hex) == 3) { $hex = str_repeat(substr($hex,0,1), 2) . str_repeat(substr($hex,1,1), 2) . str_repeat(substr($hex,2,1), 2); }
    $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
    $rgba_border = "rgba(255, 255, 255, 0.1)";
    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    if ($brightness > 125) $rgba_border = "rgba(0, 0, 0, 0.1)";
    $footer_style .= "border-color: " . $rgba_border . "; ";
}

$text_base_class = ($text_type === 'light') ? "text-slate-400" : "text-slate-600";
$heading_class = ($text_type === 'light') ? "text-white" : "text-slate-900";
$link_hover_class = ($text_type === 'light') ? "group-hover:text-yellow-400" : "group-hover:text-yellow-600";
$link_hover_text = ($text_type === 'light') ? "hover:text-yellow-400" : "hover:text-yellow-600";
$title_class = ($text_type === 'light') ? "text-white" : "text-slate-900";
$bg_overlay = ($text_type === 'light') ? "bg-gradient-to-b from-slate-900/50 to-transparent" : "bg-gradient-to-b from-white/30 to-transparent";

// Helper function for alignment
if (!function_exists('opentik_get_align_classes')) {
    function opentik_get_align_classes($align, $type = 'text') {
        if ($type === 'text') {
            if ($align === 'center') return 'text-center';
            if ($align === 'left') return 'text-left';
            return 'text-right';
        }
        if ($type === 'flex') {
            if ($align === 'center') return 'items-center';
            if ($align === 'left') return 'items-end';
            return 'items-start';
        }
        if ($type === 'justify') {
            if ($align === 'center') return 'justify-center';
            if ($align === 'left') return 'justify-end';
            return 'justify-start';
        }
        return '';
    }
}

// Function to calculate grid class
function opentik_get_grid_class($count) {
    if ($count == 1) return 'grid-cols-1';
    if ($count == 2) return 'md:grid-cols-2';
    if ($count == 3) return 'md:grid-cols-3';
    return 'md:grid-cols-2 lg:grid-cols-' . $count;
}

// Render Columns
$rendered_cols = [];
foreach ($cols as $col) {
    ob_start();
    
    if ($col === 'brand') : 
        $align = get_theme_mod('opentik_footer_brand_align', 'right');
        $logo_width = get_theme_mod('opentik_footer_logo_width', 150);
        $show_title = get_theme_mod('opentik_footer_title_visibility', true);
        $title_pos = get_theme_mod('opentik_footer_title_position', 'bottom');
        $show_desc = get_theme_mod('opentik_footer_description_visibility', true);
        $desc_pos = get_theme_mod('opentik_footer_description_position', 'bottom');
        $desc = get_theme_mod('opentik_footer_description', get_bloginfo('description'));
        $desc_style = get_theme_mod('opentik_footer_description_style', 'expanded');
        
        $title_style = get_theme_mod('opentik_footer_title_style', 'transparent');
        $title_bg_color = get_theme_mod('opentik_footer_title_bg_color', '#facc15');
        
        // Brand Container Flex Direction (Logo+Title VS Description)
        $brand_flex_dir = 'flex-col';
        if ($desc_pos === 'top') $brand_flex_dir = 'flex-col-reverse';
        if ($desc_pos === 'right') $brand_flex_dir = 'flex-row-reverse';
        if ($desc_pos === 'left') $brand_flex_dir = 'flex-row';
        
        // Logo+Title Container Flex Direction (Logo VS Title)
        $title_flex_dir = 'flex-col';
        if ($title_pos === 'top') $title_flex_dir = 'flex-col-reverse';
        if ($title_pos === 'right') $title_flex_dir = 'flex-row-reverse';
        if ($title_pos === 'left') $title_flex_dir = 'flex-row';
        if ($title_pos === 'side') $title_flex_dir = 'flex-row items-center'; // fallback for old setting
        
        $align_class = opentik_get_align_classes($align, 'text');
        
        // Main Container Alignment
        if ($brand_flex_dir === 'flex-row' || $brand_flex_dir === 'flex-row-reverse') {
            $brand_align_class = 'items-center ' . opentik_get_align_classes($align, 'justify');
        } else {
            $brand_align_class = opentik_get_align_classes($align, 'flex');
        }

        // Inner Logo+Title Alignment
        if ($title_flex_dir === 'flex-row' || $title_flex_dir === 'flex-row-reverse') {
            $logo_align_class = 'items-center ' . opentik_get_align_classes($align, 'justify');
        } else {
            $logo_align_class = opentik_get_align_classes($align, 'flex');
        }
    ?>
    <div class="footer-brand flex gap-6 <?php echo esc_attr($brand_flex_dir . ' ' . $brand_align_class); ?>">
        <div class="brand-logo-title flex gap-4 <?php echo esc_attr($title_flex_dir . ' ' . $logo_align_class); ?> flex-shrink-0">
            <?php if (has_custom_logo()) : ?>
                <div class="custom-logo-container opacity-90 hover:opacity-100 transition-opacity" style="max-width: <?php echo esc_attr($logo_width); ?>px;">
                    <?php the_custom_logo(); ?>
                </div>
            <?php else : ?>
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center border shadow-sm">
                    <span class="text-xl font-bold text-slate-900"><?php echo substr(get_bloginfo('name'), 0, 1); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($show_title) : 
                $title_span_class = "text-lg font-extrabold tracking-tight transition-all duration-300 inline-block ";
                $title_span_style = "";
                
                $hex = ltrim($title_bg_color, '#');
                if (strlen($hex) == 3) { $hex = str_repeat(substr($hex,0,1), 2) . str_repeat(substr($hex,1,1), 2) . str_repeat(substr($hex,2,1), 2); }
                $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
                $rgba_glass = "rgba($r, $g, $b, 0.15)";
                
                $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
                $text_color_over_bg = ($brightness > 125) ? '#0f172a' : '#ffffff';

                if ($title_style === 'transparent') {
                    $title_span_class .= esc_attr($title_class) . " " . esc_attr($link_hover_text) . " ";
                } else {
                    $title_span_class .= "px-4 py-1.5 rounded-full ";
                    if ($title_style === 'solid') {
                        $title_span_style .= "background-color: " . esc_attr($title_bg_color) . "; color: " . esc_attr($text_color_over_bg) . ";";
                    } elseif ($title_style === 'glass') {
                        $title_span_class .= esc_attr($title_class) . " border backdrop-blur-xl shadow-lg hover:shadow-yellow-400/20 ";
                        $title_span_style .= "background-color: " . esc_attr($rgba_glass) . "; border-color: " . esc_attr($title_bg_color) . ";";
                    } elseif ($title_style === 'outline') {
                        $title_span_class .= esc_attr($title_class) . " border-2 bg-transparent shadow-sm ";
                        $title_span_style .= "border-color: " . esc_attr($title_bg_color) . ";";
                    }
                }
            ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-title-wrapper inline-flex items-center transition-all group hover:-translate-y-1">
                    <span class="<?php echo esc_attr($title_span_class); ?>" style="<?php echo esc_attr($title_span_style); ?>"><?php bloginfo('name'); ?></span>
                </a>
            <?php endif; ?>
        </div>
        
        <?php if ($show_desc && !empty($desc)) : ?>
            <p class="<?php echo esc_attr($align_class . ' ' . $text_base_class); ?> opacity-80 mt-2 <?php echo ($desc_style === 'compact') ? 'text-xs line-clamp-2' : 'text-sm md:text-base leading-relaxed'; ?>">
                <?php echo wp_kses_post($desc); ?>
            </p>
        <?php endif; ?>
    </div>
    <?php 
    endif;

    if ($col === 'links') : 
        $title = get_theme_mod('opentik_footer_links_title', 'روابط تهمك');
        $align = get_theme_mod('opentik_footer_links_align', 'right');
        $style = get_theme_mod('opentik_footer_links_style', 'expanded');
        
        $align_class = opentik_get_align_classes($align, 'text');
        $flex_align = opentik_get_align_classes($align, 'flex');
        $gap_class = ($style === 'compact') ? 'gap-1' : 'gap-3';
    ?>
    <div class="footer-links flex flex-col <?php echo esc_attr($align_class . ' ' . $flex_align); ?>">
        <?php if (!empty($title)) : ?>
            <h4 class="<?php echo esc_attr($heading_class); ?> font-extrabold mb-6 flex items-center gap-2 <?php echo ($align === 'center') ? 'justify-center' : (($align === 'left') ? 'justify-end flex-row-reverse' : ''); ?>">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                <?php echo esc_html($title); ?>
            </h4>
        <?php endif; ?>
        
        <?php
        if (has_nav_menu('footer')) {
            wp_nav_menu([
                'theme_location' => 'footer',
                'menu_class' => 'footer-menu flex flex-col ' . $gap_class . ' font-medium ' . (($style === 'compact') ? 'text-xs' : 'text-sm'),
                'container' => false,
            ]);
        } else {
            echo '<p class="text-xs opacity-60">' . esc_html__('قم بتعيين قائمة للفوتر من لوحة التحكم.', 'opentik') . '</p>';
        }
        ?>
    </div>
    <?php 
    endif;

    if ($col === 'popular') : 
        $title = get_theme_mod('opentik_footer_popular_title', 'الأكثر رواجاً');
        $count = get_theme_mod('opentik_footer_popular_count', 3);
        $show_thumb = get_theme_mod('opentik_footer_popular_thumbnails', true);
        $align = get_theme_mod('opentik_footer_popular_align', 'right');
        $style = get_theme_mod('opentik_footer_popular_style', 'expanded');
        
        $align_class = opentik_get_align_classes($align, 'text');
        $flex_align = opentik_get_align_classes($align, 'flex');
        $gap_class = ($style === 'compact') ? 'gap-2' : 'gap-4';
    ?>
    <div class="footer-popular flex flex-col <?php echo esc_attr($align_class . ' ' . $flex_align); ?>">
        <?php if (!empty($title)) : ?>
            <h4 class="<?php echo esc_attr($heading_class); ?> font-extrabold mb-6 flex items-center gap-2 <?php echo ($align === 'center') ? 'justify-center' : (($align === 'left') ? 'justify-end flex-row-reverse' : ''); ?>">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                <?php echo esc_html($title); ?>
            </h4>
        <?php endif; ?>
        
        <div class="flex flex-col <?php echo esc_attr($gap_class . ' ' . $flex_align); ?>">
            <?php
            $popular_query = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => $count,
                'orderby'        => 'comment_count',
                'order'          => 'DESC',
                'ignore_sticky_posts' => 1
            ]);

            if ($popular_query->have_posts()) :
                while ($popular_query->have_posts()) : $popular_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="popular-post-item group flex items-start gap-3 <?php echo ($align === 'center') ? 'text-center flex-col items-center' : (($align === 'left') ? 'flex-row-reverse text-left' : ''); ?>">
                        <?php if ($show_thumb && has_post_thumbnail()) : ?>
                            <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 relative shadow-md">
                                <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500']); ?>
                                <div class="absolute inset-0 bg-slate-950/20 group-hover:bg-transparent transition-colors duration-300"></div>
                            </div>
                        <?php endif; ?>
                        <h5 class="<?php echo ($style === 'compact') ? 'text-[11px]' : 'text-xs'; ?> font-bold <?php echo esc_attr($text_base_class); ?> <?php echo esc_attr($link_hover_class); ?> transition-colors duration-300 line-clamp-2 leading-relaxed">
                            <?php the_title(); ?>
                        </h5>
                    </a>
                <?php 
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs opacity-60">' . esc_html__('لا توجد مقالات رائجة.', 'opentik') . '</p>';
            endif;
            ?>
        </div>
    </div>
    <?php 
    endif;

    if ($col === 'tags') : 
        $title = get_theme_mod('opentik_footer_tags_title', 'أبرز الوسوم');
        $type = get_theme_mod('opentik_footer_tags_type', 'tags');
        $count = get_theme_mod('opentik_footer_tags_count', 12);
        $align = get_theme_mod('opentik_footer_tags_align', 'right');
        $style = get_theme_mod('opentik_footer_tags_style', 'expanded');
        
        $align_class = opentik_get_align_classes($align, 'text');
        $justify_class = opentik_get_align_classes($align, 'justify');
        $gap_class = ($style === 'compact') ? 'gap-1.5' : 'gap-2';
        
        $badge_bg = ($bg_type === 'dynamic') ? 'bg-[var(--bg-main)]' : (($bg_type === 'dark') ? 'bg-slate-900/60' : 'bg-black/5');
        $badge_border = ($bg_type === 'dynamic') ? 'border-[var(--border-color)]' : (($bg_type === 'dark') ? 'border-white/5' : 'border-black/5');
    ?>
    <div class="footer-tags flex flex-col <?php echo esc_attr($align_class); ?>">
        <?php if (!empty($title)) : ?>
            <h4 class="<?php echo esc_attr($heading_class); ?> font-extrabold mb-6 flex items-center gap-2 <?php echo ($align === 'center') ? 'justify-center' : (($align === 'left') ? 'justify-end flex-row-reverse' : ''); ?>">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                <?php echo esc_html($title); ?>
            </h4>
        <?php endif; ?>
        
        <div class="flex flex-wrap <?php echo esc_attr($gap_class . ' ' . $justify_class); ?>">
            <?php
            $taxonomy = ($type === 'categories') ? 'category' : 'post_tag';
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'orderby'  => 'count',
                'order'    => 'DESC',
                'number'   => $count,
                'hide_empty' => true,
            ]);

            if (!empty($terms) && !is_wp_error($terms)) :
                foreach ($terms as $term) : ?>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>" class="footer-badge inline-block px-3 py-1.5 <?php echo esc_attr($badge_bg . ' ' . $badge_border); ?> hover:border-yellow-400/40 hover:bg-yellow-400/5 <?php echo ($style === 'compact') ? 'text-[10px] px-2 py-1' : 'text-[11px]'; ?> font-bold <?php echo esc_attr($text_base_class); ?> <?php echo esc_attr($link_hover_text); ?> rounded-lg transition-all duration-300 shadow-sm">
                        <?php echo ($type === 'tags' ? '# ' : '') . esc_html($term->name); ?>
                    </a>
                <?php 
                endforeach;
            else :
                echo '<p class="text-xs opacity-60">' . esc_html__('لا توجد عناصر لعرضها.', 'opentik') . '</p>';
            endif;
            ?>
        </div>
    </div>
    <?php 
    endif;

    if ($col === 'custom') : 
        $title = get_theme_mod('opentik_footer_custom_title', 'عنصر مخصص');
        $html = get_theme_mod('opentik_footer_custom_html', '');
        $align = get_theme_mod('opentik_footer_custom_align', 'right');
        
        $align_class = opentik_get_align_classes($align, 'text');
    ?>
    <div class="footer-custom flex flex-col <?php echo esc_attr($align_class); ?>">
        <?php if (!empty($title)) : ?>
            <h4 class="<?php echo esc_attr($heading_class); ?> font-extrabold mb-6 flex items-center gap-2 <?php echo ($align === 'center') ? 'justify-center' : (($align === 'left') ? 'justify-end flex-row-reverse' : ''); ?>">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                <?php echo esc_html($title); ?>
            </h4>
        <?php endif; ?>
        
        <div class="custom-content text-sm opacity-90 leading-relaxed">
            <?php echo do_shortcode(wp_kses_post($html)); ?>
        </div>
    </div>
    <?php 
    endif;

    $rendered_cols[] = ob_get_clean();
}
?>

<footer class="<?php echo esc_attr($footer_class . ' ' . $text_base_class); ?>" style="<?php echo esc_attr($footer_style); ?>">
    <div class="absolute inset-0 <?php echo esc_attr($bg_overlay); ?> pointer-events-none"></div>
    <div class="site-content relative z-10">
        <?php if ($num_cols > 0) : ?>
            
            <?php if ($layout_style === 'equal_grid') : ?>
                <div class="grid <?php echo esc_attr(opentik_get_grid_class($num_cols)); ?> gap-8 mb-12">
                    <?php foreach ($rendered_cols as $c) echo '<div>' . $c . '</div>'; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($layout_style === 'top_1_grid') : ?>
                <?php if ($num_cols > 0) : ?>
                    <div class="w-full mb-12 pb-8 border-b border-current border-opacity-10">
                        <?php echo $rendered_cols[0]; ?>
                    </div>
                <?php endif; ?>
                <?php if ($num_cols > 1) : ?>
                    <div class="grid <?php echo esc_attr(opentik_get_grid_class($num_cols - 1)); ?> gap-8 mb-12">
                        <?php for ($i = 1; $i < $num_cols; $i++) echo '<div>' . $rendered_cols[$i] . '</div>'; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($layout_style === 'grid_bottom_1') : ?>
                <?php if ($num_cols > 1) : ?>
                    <div class="grid <?php echo esc_attr(opentik_get_grid_class($num_cols - 1)); ?> gap-8 mb-12 pb-8 border-b border-current border-opacity-10">
                        <?php for ($i = 0; $i < $num_cols - 1; $i++) echo '<div>' . $rendered_cols[$i] . '</div>'; ?>
                    </div>
                <?php endif; ?>
                <?php if ($num_cols > 0) : ?>
                    <div class="w-full mb-12">
                        <?php echo $rendered_cols[$num_cols - 1]; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($layout_style === 'top_1_grid_bottom_1') : ?>
                <?php if ($num_cols > 0) : ?>
                    <div class="w-full mb-12 pb-8 border-b border-current border-opacity-10">
                        <?php echo $rendered_cols[0]; ?>
                    </div>
                <?php endif; ?>
                <?php if ($num_cols > 2) : ?>
                    <div class="grid <?php echo esc_attr(opentik_get_grid_class($num_cols - 2)); ?> gap-8 mb-12 pb-8 border-b border-current border-opacity-10">
                        <?php for ($i = 1; $i < $num_cols - 1; $i++) echo '<div>' . $rendered_cols[$i] . '</div>'; ?>
                    </div>
                <?php endif; ?>
                <?php if ($num_cols > 1) : ?>
                    <div class="w-full mb-12">
                        <?php echo $rendered_cols[$num_cols - 1]; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        <?php endif; ?>
        
        <!-- Copyright -->
        <div class="border-t border-current border-opacity-10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="<?php echo esc_attr($text_base_class); ?> opacity-80 text-xs text-center md:text-right w-full">
                &copy; <?php echo esc_html(date('Y')); ?> <span class="<?php echo esc_attr($heading_class); ?> font-bold"><?php bloginfo('name'); ?></span>. <?php echo esc_html(get_theme_mod('opentik_footer_copyright', __('جميع الحقوق محفوظة.', 'opentik'))); ?>
            </p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
