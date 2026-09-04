# Tasks: 001-theme-hardening

**Input**: Design documents from `/specs/001-theme-hardening/spec.md`
**Prerequisites**: spec.md (plan.md مستبعد عمدًا لضمان الحد الأدنى من التوثيق)
**Organization**: ميزة واحدة US1 تُنفَّذ بالتسلسل حسب الأولوية.

## Format: `[ID] [P?] [Story] Description` — جميع المهام تابعة لـ US1

## Phase 1: دوال المساعدة المشتركة (Foundation)

- [x] T001 [P1] [US1] إنشاء `inc/color-utils.php` (opentik_hex_to_rgb/opentik_hex_to_rgba/opentik_contrast_text) وتضمينه في `functions.php`
- [x] T002 [P1] [US1] إضافة helpers في `inc/template-tags.php`: `opentik_render_post_loop()` + `opentik_first_category_name()` + `opentik_fallback_menu_items()` + `opentik_needs_prism()`

## Phase 2: استبدال التكرارات

- [x] T003 [US1] تحديث `header.php` (80-86) و`footer.php` (35-41, 144-150) لاستخدام `inc/color-utils.php` ثم حذف المنطق المكرر
- [x] T004 [US1] استبدال حلقات `have_posts()` في `home.php` و `archive.php` و `search.php` و `index.php` بـ `opentik_render_post_loop()`
- [x] T005 [US1] استبدال مقتطفات التصنيف الأول في `single.php` و `parts/slider.php` بـ `opentik_first_category_name()`
- [x] T006 [US1] استبدال get_pages fallback في `header.php` (156-170 و 268-283) بـ `opentik_fallback_menu_items()`

## Phase 3: إصلاح فئات Tailwind غير المولّدة

- [x] T007 [US1] `header.php:45` `py-{$header_py}` → `style="padding-block:{n*4}px"` مع تسوية `$header_py_px`
- [x] T008 [US1] `header.php:112` `gap-{$title_gap}` → `style="gap:{n*4}px"`
- [x] T009 [US1] `opentik_get_grid_class()` → نصوص حرفية ثابتة، و`single.php` `border-white/8` → `border-white/10`
- [x] T010 [US1] إعادة `npm run build` والتحقق: `py-5`, `lg:grid-cols-4`, `gap-*` المطلوبة موجودة في `assets/dist/css/main.css`

## Phase 4: السلايدر

- [x] T011 [US1] إضافة إعداد `opentik_show_home_slider` (default true) في `inc/customizer-archive.php` وربطه في `home.php`
- [x] T012 [US1] `parts/slider.php`: إزالة picsum.photos، تمرير background-image فقط عند وجود مصغّرة، بديل تدرّج CSS

## Phase 5: PrismJS مشروط + logging آمن

- [x] T013 [US1] `functions.php`: تحميل PrismJS (theme+core+autoloader) مشروطًا بـ `opentik_needs_prism()`، وتعديل اعتماد `opentik-main`
- [x] T014 [US1] `inc/logging.php`: استبدال `shell_exec` بكتابة ملف مباشرة (wp_mkdir_p + file_put_contents + LOCK_EX)

## Phase 6: i18n + Cusdis

- [x] T015 [US1] `single.php` + `parts/sidebar-single.php`: `comments_number(esc_html__…)` مترجمة
- [x] T016 [US1] `single.php` سطر 194: JS قبل نصوص Cusdis يضبط `data-theme` من `localStorage['opentik-theme']`

## Phase 7: Build/Verify/تنظيف الميت

- [x] T017 [US1] تعزيز `verify-build.js` (وجود dist + حداثة mtime مقارنة بـ src)
- [x] T018 [US1] إنشاء `package-build.js` وربط سكربت `package` في `package.json` لبناء zip نظيف في `build/`
- [x] T019 [US1] حذف التعليقات الميتة في `inc/setup.php` (72-74 و 332)
- [x] T020 [US1] `npm run lint && npm run build && npm run verify && npm run package` تُنجز النهائي

---

## Notes

- لا plan.md عمدًا (الحد الأدنى من التوثيق).
- كل مكتملة تُوثَّق بعلامة `[x]` وتُلتزم برسالة واضحة.
- التحقق من كل مرحلة: `php -l` على الملفات المعدلة وإعادة البناء.