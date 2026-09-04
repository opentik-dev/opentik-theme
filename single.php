<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        ?>
        <!-- Reading Progress Bar -->
        <div id="reading-progress" class="fixed top-0 right-0 h-1 bg-gradient-to-l from-yellow-400 to-amber-500 z-50 transition-all duration-75 w-0"></div>

        <?php
        $featured_image_pos = get_theme_mod('opentik_featured_image_position', 'below_title');
        $has_thumbnail = has_post_thumbnail();
        $is_behind = ($has_thumbnail && $featured_image_pos === 'behind_title');
        
        if ($is_behind) :
        ?>
            <!-- Glassmorphic Header Background -->
            <div class="post-hero-header relative w-full rounded-3xl overflow-hidden mb-12 shadow-2xl min-h-[450px] lg:min-h-[550px] flex flex-col justify-end group border border-white/5">
                <!-- Background Image -->
                <div class="absolute inset-0 z-0">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover transform scale-100 group-hover:scale-105 transition-transform duration-[2000ms] ease-out']); ?>
                </div>
                <!-- Base Dark Overlay for minimum readability -->
                <div class="absolute inset-0 z-10 bg-slate-950/20"></div>
                
                <!-- Glassmorphic Box Overlay -->
                <div class="relative z-20 w-full p-4 sm:p-8 md:p-12 mt-auto">
                    <!-- Frosted Glass Container -->
                    <div class="bg-slate-900/40 backdrop-blur-2xl border border-white/10 rounded-3xl p-6 md:p-10 shadow-2xl overflow-hidden relative mx-auto max-w-5xl">
                        <!-- Subtle inner gradient for glass shine -->
                        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
                        
                        <div class="relative z-10">
                            <!-- Category -->
                            <div class="mb-4">
                                <span class="bg-yellow-400 text-slate-950 text-xs font-extrabold px-3.5 py-1.5 rounded-full shadow-lg inline-block">
                                    <?php echo esc_html(opentik_first_category_name()); ?>
                                </span>
                            </div>
                            
                            <!-- Title -->
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight mb-5 text-white drop-shadow-lg font-sans tracking-tight">
                                <?php the_title(); ?>
                            </h1>
                            
                            <!-- Meta -->
                            <div class="post-meta-hero flex flex-wrap gap-4 items-center text-sm text-slate-200 border-t border-white/10 pt-5 mt-3">
                                <span class="flex items-center gap-1.5"><?php opentik_posted_on(); ?></span>
                                <span class="border-r border-white/20 pr-4 flex items-center gap-1.5">
                                    ⏱️ <?php echo opentik_estimated_reading_time(); ?> <?php esc_html_e('دقائق قراءة', 'opentik'); ?>
                                    <button class="reading-mode-toggle ml-2 flex items-center justify-center w-8 h-8 rounded-full bg-white/10 hover:bg-yellow-400 hover:text-slate-900 transition-all duration-300 cursor-pointer shadow-lg" title="<?php esc_attr_e('تفعيل وضع القراءة المريح', 'opentik'); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                    </button>
                                </span>
                                <span class="border-r border-white/20 pr-4 flex items-center gap-1.5">💬 <?php comments_number(esc_html__('لا توجد تعليقات', 'opentik'), esc_html__('تعليق واحد', 'opentik'), esc_html__('% تعليقات', 'opentik')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-10 mt-4">
            <!-- Main Content Area -->
            <div class="w-full lg:w-2/3 flex-shrink-0">
                <article class="prose prose-invert max-w-none">
                    <?php if (!$is_behind) : ?>
                        <div class="mb-4">
                            <span class="bg-yellow-400 text-slate-950 text-xs font-extrabold px-3 py-1 rounded-full shadow-lg">
                                <?php echo esc_html(opentik_first_category_name()); ?>
                            </span>
                        </div>
                        
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 text-[var(--text-main)] drop-shadow-sm"><?php the_title(); ?></h1>
                        
                        <div class="post-meta mb-6 flex flex-wrap gap-4 items-center text-sm text-slate-400 border-b border-white/5 pb-4">
                            <span><?php opentik_posted_on(); ?></span>
                            <span class="border-r border-white/10 pr-4 flex items-center gap-1">
                                ⏱️ <?php echo opentik_estimated_reading_time(); ?> <?php esc_html_e('دقائق قراءة', 'opentik'); ?>
                                <button class="reading-mode-toggle ml-2 flex items-center justify-center w-8 h-8 rounded-full bg-slate-900 border border-white/10 hover:bg-yellow-400 hover:text-slate-900 transition-all duration-300 cursor-pointer shadow-sm" title="<?php esc_attr_e('تفعيل وضع القراءة المريح', 'opentik'); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                </button>
                            </span>
                            <span class="border-r border-white/10 pr-4 flex items-center gap-1">💬 <?php comments_number(esc_html__('لا توجد تعليقات', 'opentik'), esc_html__('تعليق واحد', 'opentik'), esc_html__('% تعليقات', 'opentik')); ?></span>
                        </div>

                        <?php if ($has_thumbnail): ?>
                            <div class="mb-8 overflow-hidden rounded-2xl border border-white/10 shadow-2xl">
                                <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover transform hover:scale-102 transition-transform duration-700']); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php
                    $share_position = get_theme_mod('opentik_share_position', 'bottom');
                    
                    if ($share_position === 'top' || $share_position === 'both') {
                        get_template_part('parts/social-share');
                    }
                    ?>
                    
                    <div class="entry-content leading-relaxed text-[var(--text-main)] text-base md:text-lg">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php
                    if ($share_position === 'bottom' || $share_position === 'both') {
                        get_template_part('parts/social-share');
                    }
                    ?>
                </article>

                <?php if (get_theme_mod('opentik_single_post_navigation', true)) : 
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    if ($prev_post || $next_post) :
                ?>
                <!-- Post Navigation -->
                <div class="post-navigation mt-10 mb-6 flex flex-col md:flex-row items-center justify-between gap-6 bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl p-6 shadow-xl">
                    
                    <!-- Previous Post -->
                    <div class="w-full md:w-2/5 flex">
                        <?php if ($prev_post) : ?>
                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="group flex items-center gap-4 text-right rtl:text-right w-full">
                                <div class="w-12 h-12 flex-shrink-0 rounded-full bg-slate-800 flex items-center justify-center border border-white/5 group-hover:bg-yellow-400 group-hover:border-yellow-400 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 group-hover:text-slate-900 transform rtl:rotate-180 transition-transform group-hover:-translate-x-1 rtl:group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                </div>
                                <div class="flex-grow">
                                    <span class="block text-xs text-slate-500 mb-1"><?php esc_html_e('المقال السابق', 'opentik'); ?></span>
                                    <h4 class="text-sm md:text-base font-bold text-slate-200 group-hover:text-yellow-400 transition-colors line-clamp-2"><?php echo esc_html(get_the_title($prev_post->ID)); ?></h4>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Home Button -->
                    <div class="flex-shrink-0 order-first md:order-none mb-4 md:mb-0">
                        <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php esc_attr_e('العودة للرئيسية', 'opentik'); ?>" class="w-14 h-14 flex items-center justify-center rounded-full bg-slate-800 border border-white/10 hover:bg-yellow-400 hover:border-yellow-400 group transition-all duration-500 shadow-lg hover:shadow-yellow-400/20 hover:-translate-y-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400 group-hover:text-slate-900 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </a>
                    </div>

                    <!-- Next Post -->
                    <div class="w-full md:w-2/5 flex justify-end">
                        <?php if ($next_post) : ?>
                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="group flex items-center gap-4 text-left rtl:text-left flex-row-reverse w-full">
                                <div class="w-12 h-12 flex-shrink-0 rounded-full bg-slate-800 flex items-center justify-center border border-white/5 group-hover:bg-yellow-400 group-hover:border-yellow-400 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 group-hover:text-slate-900 transform rtl:rotate-180 transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </div>
                                <div class="flex-grow text-right rtl:text-left">
                                    <span class="block text-xs text-slate-500 mb-1"><?php esc_html_e('المقال التالي', 'opentik'); ?></span>
                                    <h4 class="text-sm md:text-base font-bold text-slate-200 group-hover:text-yellow-400 transition-colors line-clamp-2"><?php echo esc_html(get_the_title($next_post->ID)); ?></h4>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                </div>
                <?php 
                    endif;
                endif; 
                ?>

                <!-- Cusdis Comments Section -->
                <?php if (get_theme_mod('opentik_show_comments', true)) : 
                    $cusdis_id = get_theme_mod('opentik_cusdis_app_id');
                    if (!empty($cusdis_id)) :
                ?>
                <div class="comments-container mt-12 mb-8 bg-slate-900/50 backdrop-blur-xl border border-white/5 rounded-3xl p-6 md:p-10 shadow-2xl w-full">
                    <h3 class="text-2xl font-extrabold text-white mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                        <?php esc_html_e('التعليقات', 'opentik'); ?>
                    </h3>
                    <div id="cusdis_thread" class="w-full" style="min-height: 350px;"
                        data-host="https://cusdis.com"
                        data-app-id="<?php echo esc_attr($cusdis_id); ?>"
                        data-page-id="<?php the_ID(); ?>"
                        data-page-url="<?php echo esc_url(get_permalink()); ?>"
                        data-page-title="<?php echo esc_attr(get_the_title()); ?>"
                        data-theme="dark"
                    ></div>
                    <script>
                        (function() {
                            try {
                                var saved = localStorage.getItem('opentik-theme');
                                if (saved === 'light') {
                                    document.getElementById('cusdis_thread').setAttribute('data-theme', 'light');
                                } else {
                                    document.getElementById('cusdis_thread').setAttribute('data-theme', 'dark');
                                }
                            } catch (e) {}
                        })();
                    </script>
                    <script async defer src="https://cusdis.com/js/cusdis.es.js"></script>
                    <script>
                        // Fallback & Enhancement script to guarantee Cusdis iframe resizes perfectly
                        window.addEventListener('message', function(e) {
                            try {
                                const data = typeof e.data === 'string' ? JSON.parse(e.data) : e.data;
                                if (data && data.msg === 'resize' && data.height) {
                                    const cusdisIframe = document.querySelector('#cusdis_thread iframe');
                                    if (cusdisIframe) {
                                        // Force height + extra padding to completely eliminate scrollbars
                                        const newHeight = parseInt(data.height) + 30;
                                        cusdisIframe.style.height = newHeight + 'px';
                                        cusdisIframe.style.minHeight = newHeight + 'px';
                                        cusdisIframe.style.overflow = 'hidden';
                                    }
                                }
                            } catch (err) {}
                        });
                        
                        // Ensure iframe doesn't start too small
                        const checkIframe = setInterval(() => {
                            const iframe = document.querySelector('#cusdis_thread iframe');
                            if (iframe) {
                                iframe.style.minHeight = '350px';
                                iframe.style.overflow = 'hidden';
                                clearInterval(checkIframe);
                            }
                        }, 500);
                    </script>
                </div>
                <?php 
                    endif;
                endif; 
                ?>
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-1/3 flex flex-col gap-8">
                <?php get_template_part('parts/sidebar-single'); ?>
            </aside>
        </div>
        <?php
    endwhile;
else :
    echo '<p>' . esc_html__('المقال غير موجود.', 'opentik') . '</p>';
endif;

get_footer();

