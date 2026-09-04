import '../css/style.css';

const toggleMenu = () => {
  const button = document.querySelector('.menu-toggle');
  const drawer = document.getElementById('mobile-drawer');
  const backdrop = document.getElementById('drawer-backdrop');
  const closeBtn = document.getElementById('drawer-close-btn');

  if (!button || !drawer || !backdrop) {
    return;
  }

  const openDrawer = () => {
    drawer.classList.add('is-active');
    backdrop.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  };

  const closeDrawer = () => {
    drawer.classList.remove('is-active');
    backdrop.classList.remove('is-active');
    document.body.style.overflow = '';
  };

  button.addEventListener('click', (e) => {
    e.preventDefault();
    openDrawer();
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      closeDrawer();
    });
  }

  backdrop.addEventListener('click', (e) => {
    e.preventDefault();
    closeDrawer();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('is-active')) {
      closeDrawer();
    }
  });
};

const initSlider = () => {
  const slider = document.getElementById('opentik-hero-slider');
  if (!slider) return;

  const slides = slider.querySelectorAll('.slider-slide');
  const dots = slider.querySelectorAll('.slider-dot');
  const prevBtn = slider.querySelector('.slider-arrow.prev');
  const nextBtn = slider.querySelector('.slider-arrow.next');

  if (slides.length === 0) return;

  let currentIndex = 0;
  let timer = null;
  const intervalTime = 5000;

  const showSlide = (index) => {
    if (index >= slides.length) {
      currentIndex = 0;
    } else if (index < 0) {
      currentIndex = slides.length - 1;
    } else {
      currentIndex = index;
    }

    slides.forEach((slide, idx) => {
      if (idx === currentIndex) {
        slide.classList.add('active');
      } else {
        slide.classList.remove('active');
      }
    });

    dots.forEach((dot, idx) => {
      if (idx === currentIndex) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  };

  const nextSlide = () => {
    showSlide(currentIndex + 1);
  };

  const prevSlide = () => {
    showSlide(currentIndex - 1);
  };

  const startAutoPlay = () => {
    if (timer) clearInterval(timer);
    timer = setInterval(nextSlide, intervalTime);
  };

  const stopAutoPlay = () => {
    if (timer) clearInterval(timer);
  };

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      prevSlide();
      startAutoPlay();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      nextSlide();
      startAutoPlay();
    });
  }

  dots.forEach((dot) => {
    dot.addEventListener('click', (e) => {
      e.preventDefault();
      const index = parseInt(dot.getAttribute('data-index'), 10);
      showSlide(index);
      startAutoPlay();
    });
  });

  slider.addEventListener('mouseenter', stopAutoPlay);
  slider.addEventListener('mouseleave', startAutoPlay);

  showSlide(0);
  startAutoPlay();
};

const initReadingProgress = () => {
  const progressBar = document.getElementById('reading-progress');
  if (!progressBar) return;

  const updateProgress = () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

    if (docHeight > 0) {
      const scrollPercent = (scrollTop / docHeight) * 100;
      progressBar.style.width = scrollPercent + '%';
    } else {
      progressBar.style.width = '0%';
    }
  };

  window.addEventListener('scroll', updateProgress);
  window.addEventListener('resize', updateProgress);
  updateProgress();
};

const initNewsletter = () => {
  const forms = document.querySelectorAll('.newsletter-form');
  forms.forEach((form) => {
    const input = form.querySelector('input[type="email"]');
    const button = form.querySelector('button[type="submit"]');
    const msg = form.nextElementSibling;

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!input || !button) return;

      const email = input.value.trim();
      if (!email) return;

      const originalText = button.textContent;
      button.disabled = true;
      button.textContent = 'جاري الاشتراك...';

      setTimeout(() => {
        button.textContent = originalText;
        button.disabled = false;

        if (msg) {
          msg.textContent = '✓ شكراً لاهتمامك! تم تسجيل بريدك الإلكتروني بنجاح.';
          msg.classList.remove('hidden');
          setTimeout(() => {
            msg.classList.add('hidden');
          }, 6000);
        }

        form.reset();
      }, 1000);
    });
  });
};

const initLiveClock = () => {
  const clockElement = document.getElementById('live-arabic-clock');
  if (!clockElement) return;

  const updateClock = () => {
    const now = new Date();
    
    // Formatting day name in Arabic
    const dayFormatter = new Intl.DateTimeFormat('ar-EG', { weekday: 'long' });
    const day = dayFormatter.format(now);

    // Formatting date (day of month, month name, year) in Arabic
    const dateFormatter = new Intl.DateTimeFormat('ar-EG', {
      day: 'numeric',
      month: 'long',
      year: 'numeric'
    });
    const dateStr = dateFormatter.format(now);

    // Formatting time with AM/PM in Arabic
    const timeFormatter = new Intl.DateTimeFormat('ar-EG', {
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric',
      hour12: true
    });
    const timeStr = timeFormatter.format(now);

    clockElement.textContent = `${day}، ${dateStr} | ${timeStr}`;
  };

  updateClock();
  setInterval(updateClock, 1000);
};

const initSearchOverlay = () => {
  const openBtns = document.querySelectorAll('.search-toggle-btn');
  const closeBtn = document.getElementById('search-close-btn');
  const overlay = document.getElementById('fullscreen-search-overlay');
  const input = document.getElementById('search-input-overlay');

  if (!overlay || !input) return;

  const openOverlay = () => {
    overlay.classList.add('is-active');
    setTimeout(() => {
      input.focus();
    }, 100);
  };

  const closeOverlay = () => {
    overlay.classList.remove('is-active');
    input.value = '';
  };

  openBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openOverlay();
    });
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      closeOverlay();
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && overlay.classList.contains('is-active')) {
      closeOverlay();
    }
  });
};

const initThemeSwitcher = () => {
  const toggleBtn = document.getElementById('theme-toggle-btn');
  if (!toggleBtn) return;

  toggleBtn.addEventListener('click', () => {
    const htmlElement = document.documentElement;
    const currentTheme = htmlElement.classList.contains('light') ? 'light' : 'dark';
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';

    htmlElement.className = newTheme;
    localStorage.setItem('opentik-theme', newTheme);
  });
};

const initInteractiveCodeBlocks = () => {
  const codeBlocks = document.querySelectorAll('pre code');
  if (codeBlocks.length === 0) return;

  codeBlocks.forEach((codeEl) => {
    const preEl = codeEl.parentElement;
    if (preEl.tagName.toLowerCase() !== 'pre') return;

    // Prevent double initialization
    if (preEl.parentElement.classList.contains('code-block-wrapper')) return;

    // Detect language from class (e.g., language-bash, wp-block-code)
    let lang = 'Code';
    const classList = Array.from(codeEl.classList).concat(Array.from(preEl.classList));
    for (let cls of classList) {
      if (cls.startsWith('language-')) {
        lang = cls.replace('language-', '').toUpperCase();
        break;
      }
    }

    // Create wrapper
    const wrapper = document.createElement('div');
    wrapper.className = 'code-block-wrapper relative rounded-xl overflow-hidden mb-6 border border-white/10 bg-slate-950/80 shadow-xl transition-all duration-300';
    
    // Create header
    const header = document.createElement('div');
    header.className = 'code-block-header flex items-center justify-between px-4 py-2 bg-slate-900 border-b border-white/5';
    
    const langLabel = document.createElement('span');
    langLabel.className = 'text-xs font-bold text-slate-400 tracking-wider flex items-center gap-1.5';
    langLabel.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" /></svg> ${lang}`;
    
    const actions = document.createElement('div');
    actions.className = 'flex items-center gap-2';

    // Helper for buttons
    const createBtn = (icon, title, onClick) => {
      const btn = document.createElement('button');
      btn.className = 'flex items-center justify-center w-7 h-7 rounded bg-white/5 hover:bg-yellow-400/20 text-slate-400 hover:text-yellow-400 transition-all duration-300 cursor-pointer';
      btn.title = title;
      btn.innerHTML = icon;
      btn.addEventListener('click', onClick);
      return btn;
    };

    // Copy Button
    const copyIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" /></svg>`;
    const checkIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-green-400"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>`;
    
    const copyBtn = createBtn(copyIcon, 'نسخ الكود', (e) => {
      e.preventDefault();
      const text = codeEl.innerText;
      navigator.clipboard.writeText(text).then(() => {
        copyBtn.innerHTML = checkIcon;
        setTimeout(() => copyBtn.innerHTML = copyIcon, 2000);
      });
    });

    // Download Button
    const downloadIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>`;
    const downloadBtn = createBtn(downloadIcon, 'تنزيل كملف', (e) => {
      e.preventDefault();
      const text = codeEl.innerText;
      const blob = new Blob([text], { type: 'text/plain' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `code-${lang.toLowerCase()}.txt`;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    });

    // Edit Button
    const editIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>`;
    let isEditing = false;
    const editBtn = createBtn(editIcon, 'تحرير الكود قبل النسخ', (e) => {
      e.preventDefault();
      isEditing = !isEditing;
      codeEl.contentEditable = isEditing;
      if (isEditing) {
        wrapper.classList.add('ring-2', 'ring-yellow-400', 'shadow-[0_0_15px_rgba(250,204,21,0.2)]');
        editBtn.classList.add('bg-yellow-400/20', 'text-yellow-400');
        codeEl.focus();
      } else {
        wrapper.classList.remove('ring-2', 'ring-yellow-400', 'shadow-[0_0_15px_rgba(250,204,21,0.2)]');
        editBtn.classList.remove('bg-yellow-400/20', 'text-yellow-400');
        if (window.Prism) {
          Prism.highlightElement(codeEl);
        }
      }
    });

    actions.appendChild(editBtn);
    actions.appendChild(copyBtn);
    actions.appendChild(downloadBtn);

    header.appendChild(langLabel);
    header.appendChild(actions);

    // DOM restructuring
    preEl.parentNode.insertBefore(wrapper, preEl);
    wrapper.appendChild(header);
    
    // Add custom classes to pre
    preEl.classList.add('custom-scrollbar', 'p-4', 'text-sm', 'overflow-x-auto');
    preEl.style.margin = '0';
    preEl.style.backgroundColor = 'transparent';
    wrapper.appendChild(preEl);
  });
};

const initReadingMode = () => {
  const toggleBtns = document.querySelectorAll('.reading-mode-toggle');
  if (!toggleBtns.length) return;

  toggleBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      document.body.classList.toggle('reading-mode');
      
      // Update icon based on state
      const isReadingMode = document.body.classList.contains('reading-mode');
      if (isReadingMode) {
        btn.classList.add('bg-yellow-400', 'text-slate-900');
        btn.classList.remove('bg-white/10', 'bg-slate-900', 'text-slate-200', 'text-slate-400');
        btn.title = 'إلغاء وضع القراءة';
      } else {
        btn.classList.remove('bg-yellow-400', 'text-slate-900');
        // We restore original classes depending if it was the hero layout or standard
        if (btn.closest('.post-meta-hero')) {
          btn.classList.add('bg-white/10', 'text-slate-200');
        } else {
          btn.classList.add('bg-slate-900', 'text-slate-400');
        }
        btn.title = 'تفعيل وضع القراءة المريح';
      }
    });
  });
};

window.addEventListener('DOMContentLoaded', () => {
  toggleMenu();
  initSlider();
  initReadingProgress();
  initNewsletter();
  initLiveClock();
  initSearchOverlay();
  initThemeSwitcher();
  initInteractiveCodeBlocks();
  initReadingMode();
});
