<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$current_post_id = get_the_ID();
?>

<!-- Widget: Featured Posts (مختارات المحرر) -->
<?php
$featured_query = new WP_Query([
    'posts_per_page'      => 3,
    'post_status'         => 'publish',
    'post__not_in'        => [$current_post_id],
    'ignore_sticky_posts' => 1
]);

if ($featured_query->have_posts()) :
?>
<div class="sidebar-widget p-6 rounded-2xl bg-slate-950/40 border border-white/5 backdrop-blur-md">
    <h3 class="widget-title text-lg font-bold text-white mb-5 border-r-4 border-yellow-400 pr-3 leading-none">
        <?php esc_html_e('مختارات المحرر', 'opentik'); ?>
    </h3>
    <div class="flex flex-col gap-4">
        <?php while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
            <div class="flex gap-3 group items-center">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 border border-white/5">
                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500']); ?>
                    </a>
                <?php endif; ?>
                <div class="flex-grow">
                    <h4 class="text-sm font-bold text-slate-200 line-clamp-2 leading-snug group-hover:text-yellow-400 transition-colors duration-300">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                    <span class="text-xs text-slate-400 mt-1 block"><?php echo get_the_date(); ?></span>
                </div>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
<?php endif; ?>

<!-- Widget: Trending Posts (الأكثر رواجاً) -->
<?php
$popular_query = new WP_Query([
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'comment_count',
    'order'          => 'DESC',
    'post__not_in'   => [$current_post_id]
]);

if ($popular_query->have_posts()) :
?>
<div class="sidebar-widget p-6 rounded-2xl bg-slate-950/40 border border-white/5 backdrop-blur-md">
    <h3 class="widget-title text-lg font-bold text-white mb-5 border-r-4 border-yellow-400 pr-3 leading-none">
        <?php esc_html_e('الأكثر رواجاً', 'opentik'); ?>
    </h3>
    <div class="flex flex-col gap-4">
        <?php 
        $counter = 1;
        while ($popular_query->have_posts()) : $popular_query->the_post(); 
        ?>
            <div class="flex gap-4 items-start group">
                <div class="w-8 h-8 rounded-lg bg-slate-900 border border-white/5 flex items-center justify-center text-yellow-400 font-extrabold text-sm flex-shrink-0 shadow-inner group-hover:bg-yellow-400 group-hover:text-slate-950 transition-colors duration-300">
                    <?php echo $counter++; ?>
                </div>
                <div class="flex-grow">
                    <h4 class="text-sm font-bold text-slate-200 line-clamp-2 leading-snug group-hover:text-yellow-400 transition-colors duration-300">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                    <div class="flex items-center gap-2 mt-1.5 text-xs text-slate-400">
                        <span>💬 <?php comments_number('0 تعليق', 'تعليق واحد', '% تعليقات'); ?></span>
                    </div>
                </div>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
<?php endif; ?>

<!-- Widget: Categories (تصنيفات تقنية) -->
<?php
$categories = get_categories([
    'orderby'    => 'name',
    'show_count' => true,
    'parent'     => 0
]);

if (!empty($categories)) :
?>
<div class="sidebar-widget p-6 rounded-2xl bg-slate-950/40 border border-white/5 backdrop-blur-md">
    <h3 class="widget-title text-lg font-bold text-white mb-5 border-r-4 border-yellow-400 pr-3 leading-none">
        <?php esc_html_e('تصنيفات تقنية', 'opentik'); ?>
    </h3>
    <ul class="flex flex-col gap-3">
        <?php foreach ($categories as $category) : ?>
            <li>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="flex items-center justify-between text-sm font-medium text-slate-300 hover:text-yellow-400 p-2.5 rounded-xl hover:bg-slate-900/50 border border-transparent hover:border-white/5 transition-all duration-300 group">
                    <div class="flex items-center gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500 group-hover:bg-yellow-400 transition-all duration-300"></span>
                        <span><?php echo esc_html($category->name); ?></span>
                    </div>
                    <span class="bg-slate-900 text-slate-400 group-hover:bg-yellow-400 group-hover:text-slate-950 text-xs font-bold px-2 py-0.5 rounded-md transition-all duration-300">
                        <?php echo esc_html($category->count); ?>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- Widget: Tag Cloud (سحابة الوسوم) -->
<?php
$tags = get_tags([
    'orderby' => 'count',
    'order'   => 'DESC',
    'number'  => 12
]);

if (!empty($tags)) :
?>
<div class="sidebar-widget p-6 rounded-2xl bg-slate-950/40 border border-white/5 backdrop-blur-md">
    <h3 class="widget-title text-lg font-bold text-white mb-5 border-r-4 border-yellow-400 pr-3 leading-none">
        <?php esc_html_e('وسوم شائعة', 'opentik'); ?>
    </h3>
    <div class="flex flex-wrap gap-2">
        <?php foreach ($tags as $tag) : ?>
            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="text-xs font-medium text-slate-300 bg-slate-900/60 border border-white/5 hover:border-yellow-400/50 hover:bg-yellow-400 hover:text-slate-950 px-3 py-1.5 rounded-full transition-all duration-300 shadow-sm">
                # <?php echo esc_html($tag->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Widget: Premium Newsletter (النشرة البريدية) -->
<div class="sidebar-widget p-6 rounded-2xl bg-gradient-to-br from-slate-950/70 to-slate-900/40 border border-yellow-400/10 backdrop-blur-md relative overflow-hidden shadow-2xl">
    <div class="absolute -top-12 -left-12 w-24 h-24 rounded-full bg-yellow-400/10 blur-2xl"></div>
    <div class="absolute -bottom-12 -right-12 w-24 h-24 rounded-full bg-amber-500/10 blur-2xl"></div>
    
    <div class="relative z-10">
        <h3 class="widget-title text-lg font-bold text-white mb-2 leading-none">
            🚀 <?php esc_html_e('كن في قلب الحدث التقني', 'opentik'); ?>
        </h3>
        <p class="text-xs text-slate-400 leading-relaxed mb-5">
            <?php esc_html_e('اشترك في نشرتنا البريدية الأسبوعية لتصلك أحدث المقالات والتحليلات الحصرية مباشرة إلى بريدك الإلكتروني.', 'opentik'); ?>
        </p>
        
        <form class="newsletter-form flex flex-col gap-3">
            <input type="email" placeholder="<?php esc_attr_e('أدخل بريدك الإلكتروني...', 'opentik'); ?>" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950/60 border border-white/10 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-yellow-400/60 focus:ring-1 focus:ring-yellow-400/30 transition-all duration-300">
            <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-yellow-400 to-amber-500 text-slate-950 font-bold text-sm hover:from-yellow-300 hover:to-amber-400 active:scale-[0.98] transition-all duration-300 shadow-lg cursor-pointer">
                <?php esc_html_e('اشترك الآن', 'opentik'); ?>
            </button>
        </form>
        <span class="newsletter-msg hidden text-[11px] text-green-400 mt-2 block text-center"></span>
    </div>
</div>
