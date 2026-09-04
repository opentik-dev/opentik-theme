<?php
get_header();
?>
<header class="mb-8">
    <h1 class="page-title"><?php esc_html_e('نتائج البحث', 'opentik'); ?></h1>
    <p class="text-slate-400"><?php printf(__('عرض نتائج البحث عن: %s', 'opentik'), '<strong>' . get_search_query() . '</strong>'); ?></p>
</header>
<?php opentik_render_post_loop(__('لم يتم العثور على نتائج. حاول مصطلحات أخرى.', 'opentik')); ?>
<?php get_footer();