# Spec: 001-theme-hardening — تحصين القالب وإزالة الانتفاخ

**Feature**: Theme hardening | **Branch**: 001-theme-hardening | **Spec version**: 1.0.0

## User Story (واحدة مترابطة)

**US1 — قالب قابل للصيانة وخالٍ من الانتفاخ**: أريد تحسين كود قالب OpenTik
(WordPress إخباري RTL) بحيث لا يحتوي تكرارًا أو ملفات/خصائص ميتة، ويُبنى عبر
أدوات معايرة دون فئات CSS مفقودة أو أصول خارجية غير ضرورية.

**Priority**: P1 (MVP) — تعمل كميزة واحدة تُسلم كاملة.

---

## Requirements

### FR-001: استخراج منطق الألوان المكرر
استخراج تحويل hex→rgb و rgba و contrast إلى `inc/color-utils.php` واستخدامه في
`header.php` (منطق rgba/contrast عند السطور 80-86) و`footer.php` (35-41 و 144-150).
**قابل للاختبار**: `php -l` نظيف، و `rg "hexdec" header.php footer.php` لا يُرجع نتائج.

### FR-002: قالب موحّد لحلقة المقالات
إنشاء دالة `opentik_render_post_loop(string $empty_message)` في
`inc/template-tags.php` تعرض `wrapper` + `parts/content-card.php` + ترقيم
الصفحات، واستخدامها في `index.php` و `archive.php` و `search.php` و `home.php`.
**قابل للاختبار**: لا وجود لـ `have_posts()` خارج `template-tags.php`.

### FR-003: helpers للتصنيف الأول والقائمة الافتراضية
- `opentik_first_category_name(): string` يعيد اسم أول تصنيف (أو افتراضي) وتستخدمها
  `single.php` و `parts/slider.php`.
- `opentik_fallback_menu_items(int $limit): array` يعيد قائمة صفحات افتراضية،
  وتستخدمها القوائم الثلاث في `header.php` (سطر ~156 و ~268).
**قابل للاختبار**: `rg "get_the_category" single.php parts/` لا يُرجع غير helper.

### FR-004: إصلاح فئات Tailwind غير المولّدة (Tailwind v4 CSS-first)
- `py-$header_py` في `header.php:45` → `style="padding-block:{n*4}px"`.
- `gap-$title_gap` في `header.php:112` → `style="gap:{n*4}px"`.
- `opentik_get_grid_class()` يعيد نصوصًا حرفية ثابتة (`md:grid-cols-2 lg:grid-cols-4`…).
- `border-white/8` في `single.php` → `border-white/10`.
**قابل للاختبار**: إعادة `npm run build` ثم `rg "py-5|lg:grid-cols-4|padding-block" assets/dist/css/main.css`.

### FR-005: السلايدر — خيار إيقاف وإزالة المصدر الخارجي
- إضافة إعداد كستمايزر `opentik_show_home_slider` (افتراضي true) في
  `inc/customizer-archive.php`، واستخدامه في `home.php`.
- في `parts/slider.php`: إزالة picsum.photos؛ عدم تمرير `background-image` عند
  غياب الصورة المصغّرة (استخدام تدرّج CSS بدلًا من HTTP خارجي) مع منع إخفاء
  الشريحة إن ضاعت صورة مُرفقة طبقًا لـ ARIA/semantics.
**قابل للاختبار**: `rg "picsum" assets/ parts/` لا يُرجع نتائج.

### FR-006: تحميل PrismJS مشروط + إصلاح logging بدون shell_exec
- `functions.php`: `opentik_needs_prism()` في `inc/template-tags.php` تفحص
  `is_singular()` ومحتوى المقال (`<pre`|`[code`|`language-`) قبل تحميل stylesheet
  والسكربتات؛ `opentik-main` تُنشأ بدون اعتماد على prism إلا عند الحاجة.
- `inc/logging.php`: استبدال `shell_exec('php -r …')` بكتابة ملف مباشرة
  (`wp_mkdir_p` + `file_put_contents` مع `LOCK_EX`).
**قابل للاختبار**: `rg "prism|cusdis" functions.php` تُظهر شرطًا؛ `rg "shell_exec" inc/` صفر.

### FR-007: إصلاح i18n وتعليقات Cusdis
- `single.php` و `parts/sidebar-single.php`: استخدام
  `comments_number(esc_html__…)` بدل `comments_number()` الخام.
- `single.php:194`: `data-theme` ديناميكي عبر JS قصير قبل تحميل نصوص Cusdis
  يقرأ `localStorage['opentik-theme']`.
**قابل للاختبار**: `rg "comments_number\(\)" .` (سلسلة فارغة) لا يُرجع نتائج.

### FR-008: verify + package نظيف وحذف الميت نهائيًا
- `verify-build.js`: التحقق من وجود ملفات dist وتحدّثها بعد آخر بناء src
  (مقارنة mtime).
- تغيير سكربت `package` في `package.json` إلى `node package-build.js` يبني zip
  نظيفًا في `build/` (مستثنى من git) بدون zips/صور قديمة.
- حُذف مسبقًا: `opentik-theme*.zip`، `screenshot22.png`، `assets/logo.png`،
  `.agent.md`؛ وإزالة التعليقات الميتة في `inc/setup.php` (72-74 و 332).
**قابل للاختبار**: `npm run lint && npm run build && npm run verify && npm run package` ينجح.

---

## Scope Boundaries

- لا أسماء/تصاميم جديدة، لا مكوّنات جديدة خارج ما ذكر، لا REST/JSON-LD هنا.
- لا أدوات توثيق إضافية: spec.md + tasks.md فقط (بلا plan.md).

## Out of Scope

- إعادة تصميم بصرية، تحويل لإضافات خارجية، SSH/SFTP، أداء الخادم الحقيقي.