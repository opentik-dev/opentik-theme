PROJECT: قالب ووردبريس إخباري عربي — OpenTik.win
DATE_VERIFIED: 2026-05

[TECH_STACK]
- WordPress core: 6.9.4 (تم التحقق عبر WordPress API)
- WP-CLI: v2.12.0 (GitHub release)
- Build tools:
  - webpack: 5.106.2
  - esbuild: 0.28.0
  - rollup: 4.60.4
  - gulp: 5.0.1 (أدوات مساعدة اختياري)
- CSS / Utility:
  - tailwindcss: 4.3.0
  - postcss: 8.5.15
  - autoprefixer: 10.5.0
- Lint / QA:
  - eslint: 10.4.0

[SYSTEM_FLOW]
- هدف المستخدم (Reader): فتح الصفحة الرئيسية → تحميل HTML مبدئي من Theme templates (server-side rendering) → lazy-load للمحتوى الديناميكي عبر WP REST API أو endpoints مخصّصة.
- مشغلات المحتوى (Editor): تحرير المقالات عبر لوحة WP، استخدام custom fields إن لزم (ACF أو native meta) → عمليات النشر تُحدِث cache purge عبر hooks.
- سلسلة الأحداث القابلة للاختبار:
  1) صفحة رئيسية تعرض آخر 20 مقطعًا ضمن صفحات محمّلة في <2s> عند 3G المحاكاة (MVP هدف قابل للقياس).
  2) فتح مقال يؤدي إلى تحميل الصورة البادئة والصيغة النصية + structured data (JSON-LD) خلال الطلب الأساسي.
  3) البحث يعيد نتائج عبر REST API في <500ms> للطلبات المخبّأة.

[ARCHITECTURE]
- مبدأ عام: تقسيم معتمد على الميزة (Feature-based). كل ميزة تحتوي على: templates/, parts/, assets/, hooks/.
- بنية مجلدات مقترحة (داخل theme):
  - inc/ (core helpers: image, seo, structured-data, queries)
  - templates/
    - home.php, single.php, archive.php, search.php, header.php, footer.php
  - parts/ (reusable partials: card, list, pagination)
  - assets/
    - js/ (bundles حسب feature)
    - css/ (tailwind-generated + utilities)
  - build/ (webpack/esbuild config, postcss)
- Shared/Core: فقط ما يُعاد استخدامه عبر خاصيتين أو أكثر — مثال: image optimization, responsive picture sources, canonical URL, breadcrumbs, excerpt rules.
- منع التفتيت: تجنّب micro-files؛ ملفات PHP ذات مسؤولية واضحة ومجمّعة في `inc/`

[SAFE_LOGGING]
- Non-blocking asynchronous logging pipeline:
  - كتابة محلية غير حظري (buffered writes) إلى /wp-content/uploads/logs/*.log بتنسيق JSON مختصر
  - مستويات: ERROR, WARN, INFO
  - خيار إرسال مجموعات السجلات إلى remote endpoint عبر cron/queue (non-blocking)
  - قيود: لا تُسجل المحتوى الحساس أو بيانات المستخدم.

[ORPHANS & PENDING]
- لا يوجد عناصر معلقة في نطاق تنفيذ القالب الأساسي. تم تطبيق البنية، نظام البناء، قالب RTL، ودعم القالب العام.
- المتطلبات البيئية مثل استضافة PHP/MySQL وإعدادات الإعلان تبقى على مستوى النشر ولا تؤثر على قالب الـMVP.

[MILESTONES]
1) Scaffold & Build System — مكتمل
   - نتائج قابلة للتحقق:
     - `npm install` نجح.
     - `npm run build` أنتج `assets/dist/css/main.css` و `assets/dist/js/main.js`.
     - Tailwind utility pipeline يعمل مع RTL.
2) Theme Skeleton & Core Templates — مكتمل
   - نتائج قابلة للتحقق:
     - `home.php`, `single.php`, `archive.php`, `search.php`, `header.php`, `footer.php` موجودة وتمتلك تدفق عرض ديناميكي.
     - partials قابلة لإعادة الاستخدام (`parts/content-card.php`).
3) Content Types & CMS Mapping — مكتمل
   - نتائج قابلة للتحقق:
     - دعم العنوان، الملخص، المحتوى، الصورة المميزة، وبيانات الميتا الأساسية عبر `inc/template-tags.php`.
4) RTL & Accessibility — مكتمل
   - نتائج قابلة للتحقق:
     - مخرجات HTML/CSS مصممة لـ RTL.
     - تخطي إلى المحتوى ووسوم الترجمة موجودة.
5) Performance & Caching — جاهزية تنفيذ
   - نتائج قابلة للتحقق:
     - نظام إصدار الأصول يعتمد `filemtime()` لتحميل موارد مُعدّلة فقط.
     - الأصول النهائية مضغوطة عبر Webpack.
6) Packaging & Release — جاهز
   - نتائج قابلة للتحقق:
     - Theme ready for packaging with complete WordPress headers and README.

[ASKS / CLARIFY]
- تأكيد بيئة الاستضافة (PHP 7.4+/MySQL 8+/MariaDB 10.4+) لتثبيت القالب وإطلاقه.
- هل تريد تضمين ACF أو Yoast/RankMath كمتطلبات اختيارية رسمية أم تُحتفظ بها كدعم مكمّل؟

[NOTES]
- تم تنفيذ القالب الأساسي الكامل بدون `TODO` أو placeholders.
- تم إضافة `verify-build.js` لتأكيد وجود ملفات البناء النهائية.
- القالب جاهز للنشر على أي موقع WordPress 6.9+ مع دعم RTL وTheme asset pipeline.
