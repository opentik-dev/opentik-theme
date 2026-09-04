<?php
if (!function_exists('opentik_posted_on')) {
    function opentik_posted_on(): void
    {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date())
        );

        echo '<span class="post-meta">' . sprintf(__('نُشر في %s', 'opentik'), $time_string) . '</span>';
    }
}

if (!function_exists('opentik_get_archive_wrapper_class')) {
    /**
     * Get the wrapper class for archive loops based on the customizer setting.
     * @return string
     */
    function opentik_get_archive_wrapper_class(): string
    {
        $layout = get_theme_mod('opentik_archive_layout', 'grid-2');
        
        if ($layout === 'list') {
            return 'flex flex-col gap-8';
        } elseif ($layout === 'masonry') {
            return 'columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8';
        } elseif ($layout === 'grid-3') {
            return 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch';
        }
        
        // Default to grid-2
        return 'grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch';
    }
}

if (!function_exists('opentik_the_excerpt')) {
    function opentik_the_excerpt(): void
    {
        $excerpt_length = get_theme_mod('opentik_excerpt_length', 24);
        $show_read_more = get_theme_mod('opentik_read_more_visibility', false);
        $read_more_text = get_theme_mod('opentik_read_more_text', 'اقرأ المزيد');

        if (has_excerpt()) {
            $excerpt = get_the_excerpt();
        } else {
            $excerpt = wp_trim_words(get_the_content(), $excerpt_length, '...');
        }
        
        echo '<p class="text-sm md:text-base text-slate-400 leading-relaxed mb-4">' . $excerpt . '</p>';
        
        if ($show_read_more) {
            echo '<a href="' . esc_url(get_permalink()) . '" class="inline-flex items-center gap-2 text-sm font-bold text-slate-300 hover:text-yellow-400 transition-colors group">';
            echo esc_html($read_more_text);
            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform rtl:rotate-180 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
            echo '</a>';
        }
    }
}

if (!function_exists('opentik_post_card')) {
    function opentik_post_card(): void
    {
        $layout = get_theme_mod('opentik_archive_layout', 'grid-2');
        
        // Base classes
        $card_class = 'post-card group flex flex-col bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-lg hover:shadow-yellow-400/5 transition-all duration-500 hover:-translate-y-1';
        $link_class = 'block overflow-hidden flex-shrink-0 relative';
        $image_class = 'w-full h-48 md:h-56 object-cover transform group-hover:scale-105 transition-transform duration-700';
        $content_class = 'p-6 flex-grow flex flex-col';
        
        if ($layout === 'grid-2' || $layout === 'grid-3' || $layout === 'grid') {
            $card_class .= ' h-full'; // Grid needs h-full for equal height
        } elseif ($layout === 'list') {
            $card_class = 'post-card group flex flex-col md:flex-row bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-lg hover:shadow-yellow-400/5 transition-all duration-500 hover:-translate-y-1';
            $link_class = 'block w-full md:w-2/5 lg:w-1/3 flex-shrink-0 relative overflow-hidden min-h-[220px] md:min-h-[auto]';
            $image_class = 'absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700';
            $content_class = 'p-6 md:p-8 flex-grow flex flex-col justify-center';
        } elseif ($layout === 'masonry') {
            // Masonry relies on CSS columns. break-inside-avoid prevents cards from splitting across columns
            // h-full should NOT be used here, otherwise it creates huge gaps
            $card_class .= ' mb-8 break-inside-avoid h-auto inline-block w-full';
        }
        ?>
        <article class="<?php echo esc_attr($card_class); ?>">
            <?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($link_class); ?>">
                    <?php the_post_thumbnail('opentik-card', ['class' => $image_class]); ?>
                </a>
            <?php endif; ?>
            <div class="<?php echo esc_attr($content_class); ?>">
                <!-- Category Badge -->
                <div class="mb-3">
                    <span class="bg-slate-800 text-yellow-400 text-[10px] font-extrabold px-2.5 py-1 rounded-full border border-yellow-400/20">
                        <?php 
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo esc_html($categories[0]->name);
                        } else {
                            esc_html_e('تقنية', 'opentik');
                        }
                        ?>
                    </span>
                </div>
                <h2 class="text-xl md:text-2xl font-extrabold text-white mb-3 leading-snug group-hover:text-yellow-400 transition-colors line-clamp-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="post-meta mb-4 flex items-center gap-3 text-xs text-slate-500">
                    <?php opentik_posted_on(); ?>
                    <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                    <span class="flex items-center gap-1">⏱️ <?php echo opentik_estimated_reading_time(); ?> د</span>
                </div>
                <div class="post-excerpt mt-auto"><?php opentik_the_excerpt(); ?></div>
            </div>
        </article>
        <?php
    }
}

if (!function_exists('opentik_pagination')) {
    function opentik_pagination(): void
    {
        $links = paginate_links([
            'type' => 'array',
            'prev_text' => __('السابق', 'opentik'),
            'next_text' => __('التالي', 'opentik'),
            'mid_size' => 1,
        ]);

        if (empty($links)) {
            return;
        }

        echo '<nav class="pagination mt-16 mb-8 w-full border-t border-white/5 pt-8 flex justify-center" aria-label="' . esc_attr__('Navigation', 'opentik') . '">';
        echo '<ul class="flex items-center gap-3 flex-wrap justify-center">';
        foreach ($links as $link) {
            $link = str_replace('page-numbers', 'page-numbers flex items-center justify-center w-12 h-12 rounded-full font-bold text-sm md:text-base transition-all duration-300', $link);
            
            if (strpos($link, 'current') !== false) {
                $link = str_replace('current', 'current bg-yellow-400 text-slate-900 shadow-lg shadow-yellow-400/20 scale-110 border border-yellow-400', $link);
            } else {
                $link = str_replace('page-numbers', 'page-numbers bg-slate-800/80 text-slate-400 border border-white/5 hover:bg-slate-700 hover:text-white hover:border-white/20 hover:-translate-y-1 shadow-sm', $link);
            }
            
            if (strpos($link, 'prev') !== false || strpos($link, 'next') !== false) {
                $link = str_replace('w-12 h-12 rounded-full', 'px-6 py-2 rounded-full h-12 w-auto', $link);
            }

            echo '<li>' . $link . '</li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
}

if (!function_exists('opentik_estimated_reading_time')) {
    function opentik_estimated_reading_time(): int
    {
        $content = get_post_field('post_content', get_the_ID());
        $clean_content = strip_tags($content);
        $words = preg_split('/\s+/u', $clean_content);
        $word_count = is_array($words) ? count($words) : 0;
        $reading_time = ceil($word_count / 150);
        return $reading_time > 0 ? $reading_time : 1;
    }
}

if (!function_exists('opentik_render_post_loop')) {
    function opentik_render_post_loop(string $empty_message): void
    {
        if (have_posts()) :
            echo '<div class="' . esc_attr(opentik_get_archive_wrapper_class()) . '">';
            while (have_posts()) : the_post();
                get_template_part('parts/content', 'card');
            endwhile;
            echo '</div>';
            opentik_pagination();
        else :
            echo '<p>' . esc_html($empty_message) . '</p>';
        endif;
    }
}

if (!function_exists('opentik_first_category_name')) {
    function opentik_first_category_name(): string
    {
        $categories = get_the_category();
        if (!empty($categories)) {
            return $categories[0]->name;
        }
        return __('تقنية', 'opentik');
    }
}

if (!function_exists('opentik_fallback_menu_items')) {
    function opentik_fallback_menu_items(int $limit = 5): array
    {
        $items = [
            [
                'url' => home_url('/'),
                'title' => __('الرئيسية', 'opentik'),
                'active' => is_front_page(),
            ],
        ];

        $pages = get_pages([
            'sort_column' => 'menu_order',
            'sort_order' => 'ASC',
            'number' => max(1, $limit),
            'hierarchical' => false,
        ]);

        foreach ($pages as $page) {
            $items[] = [
                'url' => get_permalink($page->ID),
                'title' => $page->post_title,
                'active' => is_page($page->ID),
            ];
        }

        return $items;
    }
}

if (!function_exists('opentik_needs_prism')) {
    function opentik_needs_prism(): bool
    {
        if (!is_singular()) {
            return false;
        }
        $content = get_post_field('post_content', get_queried_object_id());
        if (empty($content)) {
            return false;
        }
        return (bool) preg_match('/<pre\b|\[code\]|language-/', $content);
    }
}

