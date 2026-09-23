(function () {
  'use strict';

  const toFaDigits = (value) => String(value).replace(/[0-9]/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[d]);

  function initBajiShopPremium() {
    const main = document.querySelector('.baji-shop-main');
    if (!main) return;

    document.body.classList.add('baji-shop-premium-v2');

    const header = main.querySelector(':scope > .baji-shop-header, :scope > .baji-shop-hero');
    const result = main.querySelector('.woocommerce-result-count');
    const toolbar = main.querySelector('.baji-shop-toolbar');
    const layout = main.querySelector('.baji-shop-layout');
    const sidebar = main.querySelector('#baji-shop-filters');

    if (result) {
      result.textContent = toFaDigits(result.textContent.trim());
    }

    if (header) {
      const kicker = header.querySelector(':scope > span');
      const title = header.querySelector('.baji-shop-title');
      if (kicker) kicker.textContent = 'BAJI COLLECTION';

      if (title && !header.querySelector('.baji-shop-live-subtitle') && !header.querySelector('.baji-shop-hero__subtitle')) {
        const sub = document.createElement('p');
        sub.className = 'baji-shop-live-subtitle';
        sub.textContent = 'انتخاب‌های تازه باجی برای استایل روزمره و خاص تو';
        title.insertAdjacentElement('afterend', sub);
      }

      if (result && !header.querySelector('.baji-shop-live-count')) {
        const match = result.textContent.match(/از\s+([۰-۹0-9]+)/);
        if (match) {
          const pill = document.createElement('span');
          pill.className = 'baji-shop-live-count';
          pill.innerHTML = '<i class="fa-regular fa-bag-shopping" aria-hidden="true"></i><span>' + match[1] + ' محصول</span>';
          header.appendChild(pill);
        }
      }
    }

    const categories = [
      { label: 'همه', href: '/shop/' },
      { label: 'جدیدترین', href: '/shop/?orderby=date' },
      { label: 'شومیز', href: '/product-category/شومیز/' },
      { label: 'شلوار', href: '/product-category/شلوار/' },
      { label: 'دامن', href: '/product-category/دامن/' },
      { label: 'بارانی', href: '/product-category/بارانی/' },
      { label: 'اورشرت', href: '/product-category/اورشرت/' },
      { label: 'کراپ', href: '/product-category/کراپ/' },
      { label: 'اورال', href: '/product-category/اورال/' }
    ];

    if (header && !main.querySelector('.baji-shop-quick-cats')) {
      const nav = document.createElement('nav');
      nav.className = 'baji-shop-quick-cats';
      nav.setAttribute('aria-label', 'دسته‌بندی سریع محصولات');

      const current = decodeURIComponent(window.location.pathname).replace(/\/+$/, '') || '/';
      categories.forEach((item, index) => {
        const a = document.createElement('a');
        a.href = item.href;
        a.textContent = item.label;

        const targetPath = decodeURIComponent(new URL(a.href, window.location.origin).pathname).replace(/\/+$/, '') || '/';
        const isAll = index === 0 && (current === '/shop' || current === '/shop/');
        const isCategory = index > 1 && current === targetPath;
        if (isAll || isCategory) a.classList.add('is-active');

        nav.appendChild(a);
      });

      header.insertAdjacentElement('afterend', nav);
    }

    if (sidebar) {
      const hasCommerceFilter = !!sidebar.querySelector(
        '.widget_price_filter,.woocommerce-widget-layered-nav,.widget_layered_nav,.widget_product_categories,.wc-block-product-categories,.wc-block-attribute-filter'
      );
      const hasBlogWidgets = !!sidebar.querySelector(
        '.wp-block-archives,.wp-block-categories-taxonomy-category,.widget_archive,.widget_categories'
      );

      if (!hasCommerceFilter && hasBlogWidgets) {
        sidebar.classList.add('baji-shop-filters--invalid');
        if (layout) layout.classList.add('baji-shop-layout--full');
      }
    }

    const orderSelect = main.querySelector('.woocommerce-ordering select');
    if (orderSelect) {
      const labels = {
        menu_order: 'پیش‌فرض',
        popularity: 'محبوب‌ترین',
        rating: 'بالاترین امتیاز',
        date: 'جدیدترین',
        price: 'ارزان‌ترین',
        'price-desc': 'گران‌ترین'
      };
      Array.from(orderSelect.options).forEach((option) => {
        if (labels[option.value]) option.textContent = labels[option.value];
      });
      orderSelect.setAttribute('aria-label', 'مرتب‌سازی محصولات');
    }

    if (toolbar && !toolbar.querySelector('.baji-shop-toolbar-live-label')) {
      const label = document.createElement('span');
      label.className = 'baji-shop-toolbar-live-label';
      label.innerHTML = '<i class="fa-regular fa-arrow-down-wide-short" aria-hidden="true"></i><span>مرتب‌سازی</span>';
      const ordering = toolbar.querySelector('.baji-catalog-ordering');
      if (ordering) ordering.prepend(label);
    }

    document.querySelectorAll('.woocommerce ul.products li.product').forEach((card) => {
      card.classList.add('baji-shop-product-card');
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBajiShopPremium);
  } else {
    initBajiShopPremium();
  }
})();