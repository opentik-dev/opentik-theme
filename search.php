<?php
get_header();
?>
<header class="mb-8">
    <h1 class="page-title"><?php esc_html_e('نتائج البحث', 'opentik'); ?></h1>
    <p class="text-slate-400"><?php printf(__('عرض نتائج البحث عن: %s', 'opentik'), '<strong>' . get_search_query() . '</strong>'); ?></p>
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
    echo '<p>' . esc_html__('لم يتم العثور على نتائج. حاول مصطلحات أخرى.', 'opentik') . '</p>';
endif;
get_footer();
