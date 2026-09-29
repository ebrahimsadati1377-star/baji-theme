/* Guard BAJI's independent Digikala quick-buy button; Woo checkout is validated separately. */
(function () {
    'use strict';
    function mobile(value) {
        var s = String(value || '').replace(/[۰-۹]/g, function (c) { return String('۰۱۲۳۴۵۶۷۸۹'.indexOf(c)); })
            .replace(/[٠-٩]/g, function (c) { return String('٠١٢٣٤٥٦٧٨٩'.indexOf(c)); })
            .replace(/[\s().-]+/g, '');
        if (/^\+989\d{9}$/.test(s)) s = '0' + s.slice(3);
        else if (/^00989\d{9}$/.test(s)) s = '0' + s.slice(4);
        else if (/^989\d{9}$/.test(s)) s = '0' + s.slice(2);
        else if (/^9\d{9}$/.test(s)) s = '0' + s;
        return /^09\d{9}$/.test(s) ? s : '';
    }
    var originalFetch = window.fetch;
    if (typeof originalFetch === 'function' && !window.__bajiBwdkPhoneFetchGuard) {
        window.__bajiBwdkPhoneFetchGuard = true;
        window.fetch = function (resource, options) {
            if (options && typeof URLSearchParams !== 'undefined' && options.body instanceof URLSearchParams
                && options.body.get('action') === 'bwdk_get_cart') {
                var input = document.querySelector('form.checkout #billing_phone');
                options.body.set('billing_phone', input ? mobile(input.value) : '');
            }
            return originalFetch.apply(this, arguments);
        };
    }
    if (!window.BWDK || typeof window.BWDK.startDigifyCheckout !== 'function'
        || window.BWDK.startDigifyCheckout.__bajiMobileGuard) return;
    var originalStart = window.BWDK.startDigifyCheckout;
    var guarded = function (options) {
        var field = document.querySelector('form.checkout #billing_phone');
        if (!field) {
            window.alert('برای خرید با دیجی‌کالا، ابتدا کالا را به سبد خرید اضافه کنید و در صفحه تسویه‌حساب شماره موبایل را وارد کنید.');
            return;
        }
        var phone = mobile(field.value);
        if (!phone) {
            window.alert('لطفاً شماره موبایل معتبر (مانند 09123456789) را وارد کنید.');
            field.focus();
            return;
        }
        field.value = phone;
        return originalStart.call(this, options);
    };
    guarded.__bajiMobileGuard = true;
    window.BWDK.startDigifyCheckout = guarded;
})();
