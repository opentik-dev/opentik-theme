<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        
        $enable_tabs = get_theme_mod('opentik_enable_page_tabs', true);
        $tabs_title = get_theme_mod('opentik_page_tabs_title', __('معلومات تهمك', 'opentik'));
        ?>

        <!-- Page Hero Banner -->
        <div class="page-hero-header relative w-full rounded-3xl overflow-hidden mb-12 shadow-2xl min-h-[250px] md:min-h-[300px] flex items-center justify-center border border-white/5 bg-slate-900 group">
            <div class="absolute inset-0 z-0">
                <?php 
                if (has_post_thumbnail()) {
                    the_post_thumbnail('full', ['class' => 'w-full h-full object-cover transform scale-100 group-hover:scale-105 transition-transform duration-[2000ms] ease-out opacity-50']);
                } else {
                    echo '<div class="w-full h-full bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900"></div>';
                }
                ?>
            </div>
            <div class="absolute inset-0 z-10 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
            
            <div class="relative z-20 w-full p-8 text-center">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white drop-shadow-lg tracking-tight font-sans">
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <?php if ($enable_tabs) : ?>
                <!-- Unified Tabs Sidebar -->
                <aside class="w-full lg:w-1/4 flex-shrink-0">
                    <div class="bg-[var(--bg-card)] backdrop-blur-xl border border-[var(--border-color)] rounded-3xl p-6 md:p-8 shadow-2xl sticky top-28 transition-colors duration-400">
                        <h3 class="text-lg font-extrabold text-[var(--text-main)] mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-yellow-400/20 text-yellow-400 flex items-center justify-center shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </span>
                            <?php echo esc_html($tabs_title); ?>
                        </h3>
                        
                        <nav class="page-tabs-menu" aria-label="<?php esc_attr_e('دليل الصفحات', 'opentik'); ?>">
                            <?php
                            if (has_nav_menu('footer')) {
                                wp_nav_menu([
                                    'theme_location' => 'footer',
                                    'menu_class' => 'flex flex-col gap-2 text-sm font-bold text-[var(--text-muted)]',
                                    'container' => false,
                                ]);
                            } else {
                                // Fallback to list main pages if no menu is assigned
                                $pages = get_pages(['sort_column' => 'menu_order', 'number' => 8]);
                                echo '<ul class="flex flex-col gap-2 text-sm font-bold text-[var(--text-muted)]">';
                                foreach ($pages as $page_item) {
                                    $active_class = is_page($page_item->ID) ? 'current-menu-item' : '';
                                    echo '<li class="' . esc_attr($active_class) . '"><a href="' . esc_url(get_permalink($page_item->ID)) . '">' . esc_html($page_item->post_title) . '</a></li>';
                                }
                                echo '</ul>';
                                echo '<p class="text-[10px] text-slate-500 mt-5 border-t border-white/5 pt-3 leading-relaxed">' . esc_html__('يمكنك تخصيص هذه الروابط بتعيين قائمة إلى "قائمة روابط الفوتر والصفحات" من المظهر > القوائم.', 'opentik') . '</p>';
                            }
                            ?>
                        </nav>
                    </div>
                </aside>
            <?php endif; ?>

            <!-- Main Content Area -->
            <div class="w-full <?php echo $enable_tabs ? 'lg:w-3/4' : 'max-w-4xl mx-auto'; ?> flex-shrink-0">
                <article class="bg-[var(--bg-card)] backdrop-blur-2xl border border-[var(--border-color)] rounded-3xl p-6 md:p-12 shadow-2xl prose prose-invert max-w-none transition-colors duration-400">
                    <div class="entry-content leading-relaxed text-[var(--text-main)] text-base md:text-lg">
                        <?php the_content(); ?>
                    </div>
                </article>
            </div>
        </div>

        <?php
    endwhile;
else :
    echo '<p class="text-center py-20 text-slate-400">' . esc_html__('الصفحة غير موجودة.', 'opentik') . '</p>';
endif;

get_footer();
