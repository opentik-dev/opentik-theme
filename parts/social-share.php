<?php
/**
 * Template part for displaying social share buttons
 */

if (!get_theme_mod('opentik_share_visibility', true)) {
    return;
}

$alignment = get_theme_mod('opentik_share_alignment', 'between');
$size = get_theme_mod('opentik_share_size', 'medium');

// Alignment Classes
$align_class = 'justify-between';
if ($alignment === 'start') {
    $align_class = 'justify-start';
} elseif ($alignment === 'center') {
    $align_class = 'justify-center';
} elseif ($alignment === 'end') {
    $align_class = 'justify-end';
}

// Size Classes
$btn_class = 'w-10 h-10';
$icon_class = 'w-5 h-5';
$x_icon_class = 'w-4 h-4'; // X icon needs to be slightly smaller visually
if ($size === 'small') {
    $btn_class = 'w-8 h-8';
    $icon_class = 'w-4 h-4';
    $x_icon_class = 'w-3 h-3';
} elseif ($size === 'large') {
    $btn_class = 'w-12 h-12';
    $icon_class = 'w-6 h-6';
    $x_icon_class = 'w-5 h-5';
}

$post_url = urlencode(get_permalink());
$post_title = urlencode(get_the_title());
?>

<!-- Native Social Share & Print Block -->
<div class="post-share-block my-8 py-6 border-t border-b border-white/5 flex flex-col sm:flex-row items-center gap-6 <?php echo esc_attr($align_class); ?>">
    <?php if ($alignment === 'between') : ?>
        <h4 class="text-sm font-extrabold text-slate-400 uppercase tracking-wider mb-0 flex-shrink-0">
            <?php esc_html_e('شارك هذا المقال:', 'opentik'); ?>
        </h4>
    <?php endif; ?>
    
    <div class="flex flex-wrap items-center gap-3">
        <!-- WhatsApp -->
        <a href="https://api.whatsapp.com/send?text=<?php echo $post_title; ?>%20<?php echo $post_url; ?>" target="_blank" rel="noopener noreferrer" class="share-btn whatsapp <?php echo esc_attr($btn_class); ?> rounded-xl bg-slate-900/60 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-[#25D366] hover:border-[#25D366] transition-all duration-300 shadow-sm hover:shadow-[0_0_15px_rgba(37,211,102,0.4)] hover:-translate-y-1" title="<?php esc_attr_e('مشاركة عبر واتس آب', 'opentik'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr($icon_class); ?>" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2C6.506 2 2.023 6.475 2.023 11.981c0 1.76.458 3.483 1.332 5.004L2 22l5.163-1.344a9.988 9.988 0 004.849 1.258c5.503 0 9.984-4.475 9.984-9.981S17.518 2 12.012 2zm.006 16.27a8.23 8.23 0 01-4.2-1.153l-.302-.178-3.123.815.833-3.036-.197-.31a8.216 8.216 0 01-1.256-4.382c0-4.542 3.696-8.238 8.245-8.238s8.24 3.696 8.24 8.238c0 4.542-3.696 8.246-8.24 8.246zm4.518-6.173c-.247-.123-1.464-.72-1.691-.803-.228-.083-.394-.124-.56.124-.165.247-.642.802-.786.967-.145.165-.29.186-.537.062-.247-.124-1.045-.385-1.99-1.23-.736-.657-1.232-1.469-1.377-1.716-.145-.248-.016-.38.107-.504.111-.111.247-.289.37-.433.124-.144.165-.247.247-.413.083-.165.042-.31-.02-.433-.062-.124-.56-1.352-.767-1.85-.2-.485-.405-.42-.56-.427-.145-.008-.31-.01-.476-.01-.165 0-.434.062-.66.31-.227.248-.868.847-.868 2.065s.888 2.395 1.012 2.56c.124.165 1.743 2.66 4.22 3.674.588.24 1.046.384 1.405.492.59.188 1.127.16 1.55.097.472-.07 1.464-.598 1.67-1.176.207-.578.207-1.074.145-1.176-.062-.103-.227-.165-.474-.29z"/></svg>
        </a>
        
        <!-- X (Twitter) -->
        <a href="https://twitter.com/intent/tweet?text=<?php echo $post_title; ?>&url=<?php echo $post_url; ?>" target="_blank" rel="noopener noreferrer" class="share-btn x-twitter <?php echo esc_attr($btn_class); ?> rounded-xl bg-slate-900/60 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-black hover:border-slate-800 transition-all duration-300 shadow-sm hover:shadow-[0_0_15px_rgba(255,255,255,0.2)] hover:-translate-y-1" title="<?php esc_attr_e('مشاركة عبر X', 'opentik'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr($x_icon_class); ?>" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        
        <!-- LinkedIn -->
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $post_url; ?>&title=<?php echo $post_title; ?>" target="_blank" rel="noopener noreferrer" class="share-btn linkedin <?php echo esc_attr($btn_class); ?> rounded-xl bg-slate-900/60 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-[#0A66C2] hover:border-[#0A66C2] transition-all duration-300 shadow-sm hover:shadow-[0_0_15px_rgba(10,102,194,0.4)] hover:-translate-y-1" title="<?php esc_attr_e('مشاركة عبر لينكد إن', 'opentik'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr($icon_class); ?>" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
        </a>

        <!-- Facebook -->
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" target="_blank" rel="noopener noreferrer" class="share-btn facebook <?php echo esc_attr($btn_class); ?> rounded-xl bg-slate-900/60 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-[#1877F2] hover:border-[#1877F2] transition-all duration-300 shadow-sm hover:shadow-[0_0_15px_rgba(24,119,242,0.4)] hover:-translate-y-1" title="<?php esc_attr_e('مشاركة عبر فيسبوك', 'opentik'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr($icon_class); ?>" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        
        <!-- Separator -->
        <div class="w-px h-6 bg-white/10 mx-2"></div>

        <!-- Print / PDF Button -->
        <button onclick="window.print()" class="share-btn print <?php echo esc_attr($btn_class); ?> rounded-xl bg-slate-900 border border-white/10 flex items-center justify-center text-slate-400 hover:text-slate-950 hover:bg-yellow-400 hover:border-yellow-400 transition-all duration-300 shadow-sm hover:shadow-[0_0_15px_rgba(250,204,21,0.4)] hover:-translate-y-1" title="<?php esc_attr_e('طباعة أو تصدير كملف PDF', 'opentik'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="<?php echo esc_attr($icon_class); ?>"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.724.092m6.524-4.318c.24-.03.48-.062.724-.092m-6.524 4.318a1.625 1.625 0 11-3.25 0V9.829c0-.898.727-1.625 1.625-1.625h14.5c.898 0 1.625.727 1.625 1.625v3.99c0 .898-.727 1.625-1.625 1.625H16.89m-6.524 4.318A1.625 1.625 0 018.741 21h6.518a1.625 1.625 0 001.625-1.625V13.829m-10.143 0h10.143m-10.143 0v4.318m10.143 0v-4.318m-10.143-4.318h.008v.008h-.008v-.008zm10.135 0h.008v.008h-.008v-.008z" /></svg>
        </button>
    </div>
</div>
