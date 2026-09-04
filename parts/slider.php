<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$slider_query = new WP_Query([
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'ignore_sticky_posts' => 1
]);

if ($slider_query->have_posts()) :
    $post_count = $slider_query->post_count;
?>
<div class="opentik-slider mb-10 relative overflow-hidden rounded-2xl h-[360px] md:h-[460px] bg-slate-950 group" id="opentik-hero-slider" aria-label="<?php esc_attr_e('آخر الأخبار المعروضة', 'opentik'); ?>">
    <!-- Slides -->
    <div class="slider-slides h-full w-full relative">
        <?php 
        $idx = 0;
        while ($slider_query->have_posts()) : $slider_query->the_post(); 
            $active_class = ($idx === 0) ? 'active' : '';
            $thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : 'https://picsum.photos/1200/600';
        ?>
            <div class="slider-slide absolute inset-0 w-full h-full opacity-0 pointer-events-none transition-all duration-700 ease-in-out flex items-end <?php echo $active_class; ?>" data-index="<?php echo $idx; ?>">
                <!-- Background Image with Ken Burns Scale Effect -->
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[1200ms] scale-100 slide-bg" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/45 to-transparent"></div>
                </div>
                
                <!-- Slide Content -->
                <div class="relative z-10 p-6 md:p-12 w-full max-w-3xl text-right">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="bg-yellow-400 text-slate-950 text-xs font-extrabold px-3 py-1 rounded-full shadow-lg">
                            <?php 
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo esc_html($categories[0]->name);
                            } else {
                                esc_html_e('تقنية', 'opentik');
                            }
                            ?>
                        </span>
                        <span class="text-xs text-slate-300 font-semibold backdrop-blur-sm bg-slate-900/30 px-2 py-0.5 rounded border border-white/5"><?php echo get_the_date(); ?></span>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-extrabold text-white leading-tight mb-4 hover:text-yellow-400 transition-colors duration-300 drop-shadow-md">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="text-slate-300 text-sm md:text-base line-clamp-2 max-w-2xl font-light leading-relaxed drop-shadow">
                        <?php echo wp_strip_all_tags(get_the_excerpt()); ?>
                    </div>
                </div>
            </div>
        <?php 
            $idx++;
        endwhile; 
        wp_reset_postdata(); 
        ?>
    </div>

    <!-- Navigation Arrows -->
    <button class="slider-arrow prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/40 backdrop-blur-md border border-white/10 flex items-center justify-center text-white transition-all duration-300 opacity-0 group-hover:opacity-100 hover:bg-yellow-400 hover:text-slate-950 hover:border-yellow-400 hover:scale-105 cursor-pointer shadow-lg" aria-label="<?php esc_attr_e('السابق', 'opentik'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    </button>
    <button class="slider-arrow next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/40 backdrop-blur-md border border-white/10 flex items-center justify-center text-white transition-all duration-300 opacity-0 group-hover:opacity-100 hover:bg-yellow-400 hover:text-slate-950 hover:border-yellow-400 hover:scale-105 cursor-pointer shadow-lg" aria-label="<?php esc_attr_e('التالي', 'opentik'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </button>

    <!-- Navigation Dots -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2">
        <?php for ($i = 0; $i < $post_count; $i++) : 
            $active_dot = ($i === 0) ? 'active' : '';
        ?>
            <button class="slider-dot w-2.5 h-2.5 rounded-full bg-white/30 border border-white/10 transition-all duration-300 hover:bg-white/60 cursor-pointer <?php echo $active_dot; ?>" data-index="<?php echo $i; ?>" aria-label="<?php echo sprintf(esc_attr__('شريحة %d', 'opentik'), $i + 1); ?>"></button>
        <?php endfor; ?>
    </div>
</div>
<?php
endif;
?>
