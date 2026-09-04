<?php
get_header();
?>
<header class="mb-8">
    <h1 class="page-title"><?php the_archive_title(); ?></h1>
</header>
<?php opentik_render_post_loop(__('لا توجد نتائج لهذا الأرشيف.', 'opentik')); ?>
<?php get_footer();