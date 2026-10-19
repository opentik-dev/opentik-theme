---
name: OpenTik Theme
description: قالب مجلة تقنية عربية RTL بهوية ليلية كحلية ولمسة ذهبية
colors:
  night-950: "#03060f"
  night-900: "#0a0f24"
  night-800: "#12092b"
  night-850: "#05141c"
  night-925: "#080c16"
  slate-950: "#0f172a"
  paper-50: "#f8fafc"
  white: "#ffffff"
  black: "#000000"
  code-paper: "#f8f8f2"
  slate-500: "#64748b"
  rose-500: "#f43f5e"
  violet-400: "#a78bfa"
  emerald-400: "#34d399"
  sky-400: "#38bdf8"
  indigo-400: "#818cf8"
  print-border: "#dddddd"
  print-code-border: "#e2e8f0"
  shadow-black-50: "rgba(0, 0, 0, 0.5)"
  shadow-black-40: "rgba(0, 0, 0, 0.4)"
  shadow-black-30: "rgba(0, 0, 0, 0.3)"
  overlay-white-15: "rgba(255, 255, 255, 0.15)"
  overlay-white-95: "rgba(241, 245, 249, 0.95)"
  hero-night: "#0c111d"
  text-main-dark: "#f8fafc"
  text-muted-dark: "#94a3b8"
  accent-yellow: "#facc15"
  accent-yellow-hover: "#fde047"
  light-bg: "#f8fafc"
  light-lavender: "#e0e7ff"
  light-pink: "#fae8ff"
  light-sky: "#e0f2fe"
  light-mint: "#ecfdf5"
  text-main-light: "#0f172a"
  text-muted-light: "#475569"
  accent-amber: "#d97706"
  accent-amber-hover: "#b45309"
typography:
  body:
    fontFamily: "Tahoma, Segoe UI, sans-serif"
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.6
  prose:
    fontFamily: "Tahoma, Segoe UI, sans-serif"
    fontSize: "1.125rem"
    lineHeight: 1.8
  nav:
    fontSize: "0.875rem"
  cardTitle:
    fontSize: "1.25rem"
  sectionTitle:
    fontSize: "1.75rem"
  pageTitle:
    fontSize: "clamp(2rem, 4vw, 3rem)"
  caption:
    fontSize: "11px"
  micro:
    fontSize: "10px"
  code:
    fontFamily: "Fira Code, Consolas, Monaco, monospace"
rounded:
  sm: "4px"
  md: "0.75rem"
  lg: "1rem"
  xl: "1.5rem"
  pill: "9999px"
spacing:
  content-max: "1160px"
  content-inline: "1rem"
  section: "2rem"
  card: "1.5rem"
components:
  button-primary:
    backgroundColor: "{colors.accent-yellow}"
    textColor: "{colors.slate-950}"
    rounded: "{rounded.md}"
    padding: "0.625rem 1rem"
  post-card:
    backgroundColor: "rgba(30, 41, 59, 0.4)"
    textColor: "{colors.text-main-dark}"
    rounded: "{rounded.lg}"
    padding: "1rem"
  sidebar-widget:
    backgroundColor: "rgba(30, 41, 59, 0.4)"
    textColor: "{colors.text-main-dark}"
    rounded: "{rounded.xl}"
    padding: "1.5rem"
---

# Design System: OpenTik Theme

## Overview

النظام الحالي ذو طابع “ليلة تقنية مخملية”: خلفية داكنة متدرجة ومتحركة، أسطح شبه شفافة، خطوط رفيعة، ظلال ولمعان أصفر، وواجهات مستديرة. الهوية واضحة وقابلة للتعرف، لكنها تستخدم مؤثرات كثيرة في الوقت نفسه؛ لذلك تبدو بعض الأجزاء أقرب إلى قالب SaaS مولّد منها إلى مجلة تقنية تحريرية.

الاتجاه المعتمد للتوثيق هنا هو حالة النظام الموجودة في الكود، وليس قرارًا نهائيًا لإعادة التصميم. عند التحسين يُحافظ على الكحلي والذهبي وعلى شخصية OpenTik التقنية، مع جعل المحتوى العربي وتسلسل القراءة المصدر الأساسي للتباين والهرمية.

**Key Characteristics:**

- RTL أولًا مع قوالب WordPress قابلة لإعادة الاستخدام.
- وضع داكن افتراضي ووضع فاتح اختياري.
- أصفر/ذهبي للروابط، الحالات النشطة، وأزرار الإجراء.
- بطاقات، سلايدر، شريط جانبي، بحث ملء الشاشة، وقائمة هاتف جانبية.
- تباين عالٍ نسبيًا في النص الأساسي، مع اعتماد زائد على blur/glow في العمق.

## Colors

اللون الأساسي ليلي كحلي، والذهبي إشارة تحريرية/تفاعلية. الوضع الفاتح يستبدل الخلفية الليلية بدرجات فاتحة ويستخدم amber أغمق للحفاظ على التباين.

### Primary

- **Deep Night** (`#03060f` إلى `#12092b`): خلفية الوضع الداكن، حاليًا عبر gradient متحرك.
- **Warm Signal** (`#facc15`): الروابط، الحالة النشطة، reading progress، والعناصر الأساسية.

### Neutral

- **Main Dark** (`#f8fafc`): النص الرئيسي في الوضع الداكن.
- **Muted Dark** (`#94a3b8`): النص الثانوي والبيانات الوصفية في الوضع الداكن.
- **Main Light** (`#0f172a`): النص الرئيسي في الوضع الفاتح.
- **Muted Light** (`#475569`): النص الثانوي في الوضع الفاتح.
- **Border** (`rgba(255,255,255,.08)` أو `rgba(0,0,0,.08)`): الفواصل والحدود الهادئة.

### Named Rules

**قاعدة الندرة الذهبية.** يجب أن يبقى اللون الذهبي إشارة لا خلفية عامة؛ يفضّل ألا يملأ أكثر من مساحة صغيرة من الشاشة إلا في زر الإجراء الأساسي.

## Typography

**Display/Body Font:** `Tahoma, Segoe UI, sans-serif` بعد جولة المعالجة الأولى.

**Code Font:** `Fira Code, Consolas, Monaco, Andale Mono, Ubuntu Mono, monospace`.

**Character:** الخط الحالي متاح على نطاق واسع وواضح للعربية، لكنه ليس قرارًا نهائيًا للهوية. يجب اختبار خط عربي/ثنائي اللغة مرخّص ومقروء قبل اعتماد بديل، مع ضبط الوزن والارتفاع لا الاكتفاء بتغيير الاسم.

### Hierarchy

- **Page title:** `clamp(2rem, 4vw, 3rem)`، وزن ثقيل، للصفحة أو الأرشيف.
- **Card title:** `1.25rem`، وزن 700، مع إبراز العنوان لا النص الوصفي.
- **Article prose:** `1.125rem`، line-height `1.8` لقراءة المقالات الطويلة.
- **Metadata/labels:** أحجام صغيرة، لون muted، ويجب ألا يعتمد فهمها على اللون وحده.
- **Code:** monospace فقط داخل الأكواد والبيانات التقنية، وليس كزينة عامة.

### Named Rules

**قاعدة القراءة قبل التقنية.** لا تستخدم وزنًا أو glow أو animation لإظهار أهمية لا يثبتها المحتوى أو مسار القراءة.

## Layout

- الحاوية الأساسية `min(1160px, 100%)` مع padding جانبي `1rem`.
- الرأس sticky، وشريط الأدوات العلوي يسبقه عند تفعيله.
- الصفحة الرئيسية تعرض slider ثم عنوان الأخبار وشبكة البطاقات.
- الصفحات المفردة تستخدم عمود محتوى رئيسيًا مع aside sticky، ويتحول التخطيط إلى عمود واحد على الشاشات الأصغر.
- السلايدر والبحث والقائمة الهاتفية طبقات تفاعلية منفصلة؛ يجب أن تظل قابلة للاستخدام عند تعطيل الحركة.
- يجب اعتماد spacing rhythm ثابت بدل مزج utility classes كثيرة مع overrides متكررة في CSS.

## Elevation & Depth

النظام الحالي hybrid: حدود شفافة، ظلال متعددة، وglow ذهبي وbackdrop blur. هذا يمنح حضورًا بصريًا لكنه يرفع التكلفة البصرية والأدائية ويكرر نمط “كل شيء بطاقة”. الاتجاه الموصى به هو depth طبقي هادئ: سطح واحد واضح، border أو shadow واحد بحسب العنصر، وblur فقط للطبقات التي تحتاج فصلًا وظيفيًا مثل overlay.

### Shadow Vocabulary

- **Small:** `var(--shadow-sm)` للفواصل الخفيفة.
- **Medium:** `var(--shadow-md)` لأزرار التحكم والسلايدر.
- **Large:** `var(--shadow-lg)` للبطاقات والـ drawer.
- **Glow:** `var(--shadow-glow)` حاليًا للـ hover/active فقط؛ لا يضاف تلقائيًا إلى كل بطاقة.

### Named Rules

**قاعدة سطح واحد.** لا تجمع border + shadow + glow + blur إلا إذا كانت الطبقة overlay أو حالة تفاعلية تبرر ذلك.

## Shapes

اللغة الحالية مستديرة: `0.75rem` لعناصر الإدخال والأزرار، `1rem` للبطاقات، `1.5rem` لبعض الوحدات، وpill للوسوم والنقاط. الدوائر مناسبة للأيقونات الصغيرة فقط. يوصى في إعادة الهيكلة بتقليل المزج إلى ثلاث درجات radius واضحة، وإبقاء pills للوسوم لا للحاويات الكبيرة.

## Components

### Buttons

- **Primary:** خلفية yellow/amber، نص slate داكن، padding عمودي يقارب `0.625rem`، وhover أفتح.
- **Secondary/Icon:** سطح card شفاف وحد رفيع، ويجب أن يكون الهدف اللمسي 44px على الأقل حتى إن كان الرسم الداخلي أصغر.
- **Focus:** يجب أن يكون focus ring ظاهرًا ومفصولًا عن hover؛ لا يعتمد على glow فقط.
- **Motion:** استبدال bounce/elastic بـ ease-out هادئ وتوفير prefers-reduced-motion.

### Cards / Containers

- **Post cards:** سطح شبه شفاف، حد، radius `1rem`، ورفع بسيط عند hover.
- **Sidebar widgets:** padding `1.5rem`، radius `1.5rem` حاليًا، وعنوان بخط accent سفلي دقيق بعد المعالجة الأولى.
- **Newsletter:** حاليًا widget زخرفي بgradient وblur، والنموذج غير موصول بخدمة اشتراك؛ يجب وسمه أو ربطه قبل اعتباره ميزة حقيقية.

### Inputs / Fields

- خلفية card، حد `1px`، radius `0.75rem`، النص من `--text-main`.
- focus يغير border ويضيف glow حاليًا؛ يجب ضمان outline/focus ring واضح وتباين placeholder كافٍ.
- كل input يجب أن يمتلك label قابلًا للقراءة أو accessible name صريحًا ورسالة خطأ/نجاح حقيقية.

### Navigation

- الرأس sticky مع brand، navigation رئيسي، search toggle، theme toggle، وmobile menu.
- العنصر النشط يستخدم اللون الذهبي وunderline بعرض متحرك.
- drawer الهاتف من اليمين، ويحتاج focus trap، إغلاق بـ Escape، وإرجاع focus للزر الفاتح.

### Reading Surface

- المقال يستخدم `.prose` بحجم `1.125rem` وline-height `1.8`.
- العناوين تحمل accent جانبي سميكًا حاليًا؛ البديل المقترح علامة أقل صخبًا تحافظ على RTL.
- الأكواد تستخدم PrismJS وFira Code، مع تمرير أفقي مضبوط وطباعة قابلة للقراءة.

## Do's and Don'ts

### Do:

- **Do** حافظ على RTL، القراءة الطويلة، وحدود المحتوى العربي عند كل breakpoint.
- **Do** استخدم tokens من `:root` بدل ألوان hard-coded داخل القوالب.
- **Do** اجعل الحركة مرتبطة بحالة أو وظيفة: drawer، search، progress، لا بزخرفة مستمرة.
- **Do** اختبر light/dark، keyboard، reduced motion، وprint بعد أي تغيير.
- **Do** استخدم أيقونات SVG متسقة بدل emoji كعناصر واجهة.

### Don't:

- **Don't** تكرر glassmorphism وbackdrop blur وglow على كل بطاقة أو زر.
- **Don't** تستخدم حدًا ذهبيًا جانبيًا بسماكة 3–4px كعلامة عامة للعناوين والبطاقات.
- **Don't** تعتمد على Tahoma كقرار نهائي للهوية العربية دون اختبار بديل مميز ومقروء.
- **Don't** تستخدم bounce/elastic easing أو انتقالات `all` عندما يكفي transform/opacity.
- **Don't** تعرض نموذج النشرة أو أي claim خارجي كأنه يعمل دون endpoint موثوق.
- **Don't** تعتمد على اللون وحده لبيان الحالة أو التركيز أو الخطأ.
