<?php
get_header();

// Display the premium animated slider
get_template_part('parts/slider');
?>
<section class="hero-banner mb-8 border-b border-white/5 pb-5">
    <div>
        <h1 class="text-2xl font-extrabold text-[var(--text-main)] mb-2"><?php esc_html_e('آخر الأخبار التقنية', 'opentik'); ?></h1>
        <p class="max-w-2xl text-slate-400 text-sm md:text-base"><?php esc_html_e('تغطية دقيقة ومباشرة لأحدث الأخبار التقنية العربية والعالمية.', 'opentik'); ?></p>
    </div>
</section>
<?php
if (have_posts()) :
    echo '<div class="' . esc_attr(opentik_get_archive_wrapper_class()) . '">';
    while (have_posts()) : the_post();
        get_template_part('parts/content', 'card');
    endwhile;
    echo '</div>';
    opentik_pagination();
else :
    echo '<p>' . esc_html__('لم يتم العثور على مقالات.', 'opentik') . '</p>';
endif;
get_footer();
