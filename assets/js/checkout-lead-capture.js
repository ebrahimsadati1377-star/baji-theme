/* BAJI: pre-order abandoned checkout contact capture. No card or address data. */
(function () {
    'use strict';
    if (!window.bajiCheckoutLead || !window.crypto || !window.crypto.getRandomValues) return;
    var endpoint = window.bajiCheckoutLead.endpoint;
    var storageKey = 'baji_checkout_lead_session_v1';
    var token;
    try {
        token = window.sessionStorage.getItem(storageKey);
        if (!/^[a-f0-9]{32}$/.test(token || '')) {
            var bytes = new Uint8Array(16);
            window.crypto.getRandomValues(bytes);
            token = Array.from(bytes, function (byte) { return byte.toString(16).padStart(2, '0'); }).join('');
            window.sessionStorage.setItem(storageKey, token);
        }
    } catch (e) { return; }
    var lastPhone = '';
    var timeout;
    var digits = function (s) {
        return String(s || '').replace(/[۰-۹]/g, function (c) { return String('۰۱۲۳۴۵۶۷۸۹'.indexOf(c)); })
            .replace(/[٠-٩]/g, function (c) { return String('٠١٢٣٤٥٦٧٨٩'.indexOf(c)); })
            .replace(/[\s().-]/g, '');
    };
    function getPhone() {
        var el = document.querySelector('form.checkout #billing_phone');
        if (!el) return '';
        var val = digits(el.value);
        if (/^\+989\d{9}$/.test(val)) val = '0' + val.slice(3);
        else if (/^00989\d{9}$/.test(val)) val = '0' + val.slice(4);
        else if (/^989\d{9}$/.test(val)) val = '0' + val.slice(2);
        else if (/^9\d{9}$/.test(val)) val = '0' + val;
        return /^09\d{9}$/.test(val) ? val : '';
    }
    function post(action, phone) {
        var name = document.querySelector('form.checkout #billing_first_name');
        return fetch(endpoint, {
            method: 'POST', mode: 'cors', credentials: 'omit', keepalive: true,
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({action: action, session: token, phone: phone || '', name: name ? name.value.slice(0, 38) : ''})
        }).catch(function () {});
    }
    function capture() {
        var phone = getPhone();
        if (!phone) return;
        lastPhone = phone;
        post('capture', phone);
    }
    document.addEventListener('input', function (event) {
        if (!event.target || !event.target.matches('form.checkout #billing_phone, form.checkout #billing_first_name')) return;
        clearTimeout(timeout);
        timeout = setTimeout(capture, 800);
    });
    document.addEventListener('change', function (event) {
        if (!event.target || !event.target.matches('form.checkout #billing_phone, form.checkout #billing_first_name')) return;
        clearTimeout(timeout);
        capture();
    });
    // Keep the lead fresh while the customer is actively on the checkout page.
    window.setInterval(function () {
        if (document.visibilityState === 'visible' && lastPhone) capture();
    }, 60000);
    // Order completion suppresses the pre-order reminder; paid/unpaid orders use their own flow.
    document.addEventListener('submit', function (event) {
        if (event.target && event.target.matches('form.checkout')) {
            clearTimeout(timeout);
            if (getPhone()) post('completed', getPhone());
        }
    });
    capture();
})();
