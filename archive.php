<?php
get_header();
?>
<header class="mb-8">
    <h1 class="page-title"><?php the_archive_title(); ?></h1>
</header>
<?php
if (have_posts()) :
    echo '<div class="' . esc_attr(opentik_get_archive_wrapper_class()) . '">';
    while (have_posts()) : the_post();
        get_template_part('parts/content', 'card');
    endwhile;
    echo '</div>';
    opentik_pagination();
else :
    echo '<p>' . esc_html__('لا توجد نتائج لهذا الأرشيف.', 'opentik') . '</p>';
endif;
get_footer();
