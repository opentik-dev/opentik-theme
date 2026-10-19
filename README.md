# OpenTik WordPress Theme

قالب ووردبريس إخباري عربي RTL مصمم لموقع OpenTik.win.

## بنية المشروع

- `assets/src/` يحتوي على ملفات CSS و JavaScript المصدرية.
- `assets/dist/` ينتجها أمر `npm run build` ويحتوي على الأصول النهائية.
- `inc/` يحتوي على إعدادات السمات ووظائف القالب المساعدة.
- `parts/` يحتوي على القوالب الجزئية القابلة لإعادة الاستخدام.

## أوامر

```bash
npm install
npm run build
npm run package
```

## متطلبات

- WordPress 6.9+
- PHP 7.4+
- MySQL 8+ أو MariaDB 10.4+

## إجراءات التحقق

- `npm install` يجب أن يكتمل بدون أخطاء.
- `npm run build` يجب أن ينتج `assets/dist/css/main.css` و `assets/dist/js/main.js`.
- `npm run verify` يؤكد وجود الملفات النهائية.
- `npm run package` يعيد بناء مجلد `build/opentik-theme/` وينشئ الحزمة القابلة للرفع في `build/opentik-theme.zip`.

## ملاحظات إضافية

- القالب جاهز للعمل كقالب RTL عربي أساسي دون اعتماد خارجي على إضافات.
- يدعم القالب التشغيل في بيئات WordPress القياسية، ويمكن توسيعه لاحقًا ليدعم ACF أو Yoast/RankMath دون كسر البنية الأساسية.

## التقييم والتوثيق

- [تقرير تقييم القالب وخطة إعادة الهيكلة](docs/THEME-AUDIT.md)
- [سياق المنتج](PRODUCT.md)
- [نظام التصميم الحالي وقواعده](DESIGN.md)
- [دليل استئناف العمل على جهاز جديد](docs/ONBOARDING.md)
- إعداد Impeccable وامتداد فحص قوالب PHP: `.agents/skills/impeccable/` و`.impeccable/config.json`
- `PROJECT_MAP.md` يصف الخريطة الحالية والأهداف المعمارية؛ يجب تحديثه مع كل تغيير جوهري.

## ملاحظات

- تم تصميم النظام لتكون شجرة الملفات بسيطة ومركزة على تجربة المستخدم.
- تم تطبيق RTL وتصميم CSS بنظام Tailwind.
