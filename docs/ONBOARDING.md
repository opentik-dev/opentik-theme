# دليل استئناف العمل على جهاز جديد

هذا الدليل يشرح كيف يستأنف المطوّر العمل على قالب OpenTik WordPress من آخر حالة مرفوعة إلى GitHub.

## نقطة البداية الحالية

- المستودع: `git@github.com:opentik-dev/opentik-theme.git`
- الفرع الرئيسي: `main`
- التقنية: قالب WordPress عربي RTL مع Webpack/PostCSS وJavaScript/CSS مصدرية داخل `assets/src/`.
- الأصول النهائية داخل `assets/dist/` لا تُحفظ في Git؛ يتم توليدها محليًا.
- حزم الإصدار داخل `build/` ولا تُحفظ في Git؛ يتم توليدها عبر `npm run package`.
- قبل البدء، راجع `README.md` و`PROJECT_MAP.md` و`docs/THEME-AUDIT.md` و`PRODUCT.md` و`DESIGN.md`.

## المتطلبات على الجهاز الجديد

1. Git مع إمكانية المصادقة على GitHub عبر SSH أو HTTPS.
2. Node.js وnpm. يستخدم المشروع `package-lock.json`، لذلك يُفضّل استخدام `npm ci`.
3. PHP 7.4 أو أحدث لفحص ملفات PHP محليًا.
4. WordPress 6.9 أو أحدث عند تشغيل القالب داخل موقع فعلي.
5. MySQL 8 أو MariaDB 10.4 أو أحدث عند إعداد بيئة WordPress كاملة.

لم يُثبت المشروع إصدارًا محددًا لـ Node.js حتى الآن. إذا استُخدم إصدار جديد جدًا وظهرت مشكلة في Webpack أو Tailwind، ثبّت إصدار Node.js LTS وسجّل القرار في هذا الملف.

## الاستنساخ والإعداد

```bash
git clone git@github.com:opentik-dev/opentik-theme.git
cd opentik-theme
git switch main
npm ci
```

إذا لم تُستخدم SSH:

```bash
git clone https://github.com/opentik-dev/opentik-theme.git
```

تحقق من أن النسخة المحلية نظيفة وأنها على آخر commit:

```bash
git status --short --branch
git pull --ff-only origin main
```

## إعادة بناء المشروع والتحقق منه

شغّل الأوامر التالية بعد الاستنساخ، وبعد أي تعديل في CSS أو JavaScript:

```bash
npm run build
npm run lint
npm run verify
npm run package
```

النتائج المتوقعة:

- `assets/dist/css/main.css` و`assets/dist/js/main.js` موجودان.
- `npm run verify` ينجح.
- `build/opentik-theme.zip` يحتوي الحزمة القابلة للرفع إلى WordPress.

ولفحص صياغة PHP:

```bash
find . -type f -name '*.php' -not -path './node_modules/*' -print0 \
  | xargs -0 -n1 php -l
```

## سير العمل اليومي

```bash
git switch main
git pull --ff-only origin main
# عدّل الملفات
npm run build
npm run lint
npm run verify
git status
git add <الملفات المتغيرة>
git commit -m "وصف مختصر للتغيير"
git push origin main
```

للتغييرات الكبيرة، أنشئ فرعًا يبدأ بـ `codex/` أو باسم feature واضح، ثم افتح Pull Request بدل الدفع المباشر إلى `main`.

## تشغيل القالب داخل WordPress

1. انسخ مجلد المشروع إلى `wp-content/themes/opentik-theme`، أو ارفع `build/opentik-theme.zip` من لوحة WordPress.
2. فعّل القالب من **المظهر → القوالب**.
3. اختبر الصفحة الرئيسية، الأرشيف، البحث، المقال المفرد، الوضع الداكن، القائمة الجانبية، المشاركة، والطباعة على الهاتف وسطح المكتب.
4. لا تعتبر النشرة البريدية تكاملًا فعليًا قبل ربطها بخدمة أو endpoint حقيقي؛ هذه فجوة موثقة في `docs/THEME-AUDIT.md`.

## نقطة الاستئناف الفنية

التوثيق الحالي يصف قالبًا في مرحلة MVP بصري متقدم، وليس إطلاقًا إنتاجيًا مكتملًا. قبل النشر النهائي راجع أولويات `P0/P1` في `docs/THEME-AUDIT.md`، خصوصًا النشرة البريدية، تزامن حزمة الإصدار مع المصدر، الوصولية، SEO، والاختبارات داخل WordPress فعلي.

عند بدء مهمة جديدة:

1. اقرأ `docs/THEME-AUDIT.md` لتحديد المخاطر المعروفة.
2. اقرأ `PROJECT_MAP.md` لفهم الملفات والمسارات المقصودة.
3. حدّث `DESIGN.md` و`PRODUCT.md` عند تغيير سلوك بصري أو منتج.
4. نفّذ أوامر التحقق قبل الالتزام.
5. اكتب قرارًا أو ملاحظة جديدة في `docs/` إذا تغيّر عقد معماري أو مسار إصدار.

## استكشاف الأعطال السريع

- فشل `npm ci`: تحقق من إصدار Node.js واتصال npm، ثم أعد المحاولة دون حذف `package-lock.json`.
- فشل `npm run build`: تأكد من وجود `node_modules` ثم افحص أول خطأ في مخرجات Webpack.
- غياب ملفات `assets/dist`: شغّل `npm run build`؛ فهي مستثناة من Git عمدًا.
- فشل `npm run package`: شغّل `npm run build` أولًا وتأكد من وجود جميع ملفات القالب المطلوبة.
- ظهور ملفات معدّلة بعد البناء: راجع `git status`؛ يجب ألا تُضاف `assets/dist/` أو `build/` إلا إذا تغيّرت سياسة الإصدار.

