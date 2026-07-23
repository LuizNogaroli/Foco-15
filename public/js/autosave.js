/**
 * Autosave - Foco Draft System
 * Detecta mudanças nos formulários das abas 1, 2, 3 e 7,
 * salva automaticamente via AJAX após 2s de inatividade.
 */
(function () {
    'use strict';

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('input[name="_token"]')?.value
        || document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]?.replace(/%3D/g, '=');

    const PROCESSO_ID = window.ProcessoID || null;
    const ABA = window.AbaAtual || null;

    if (!PROCESSO_ID || !ABA) return;

    let debounceTimer = null;
    let lastSaved = null;
    let statusEl = null;
    let indicatorEl = null;
    let hasChanges = false;

    function init() {
        statusEl = document.createElement('div');
        statusEl.id = 'autosave-status';
        statusEl.style.cssText = 'position:fixed;bottom:16px;right:16px;padding:6px 14px;border-radius:6px;font-size:0.78rem;font-weight:500;z-index:9999;transition:all 0.3s;opacity:0;pointer-events:none;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;';
        document.body.appendChild(statusEl);

        indicatorEl = document.getElementById('autosave-indicator');

        if (!CSRF_TOKEN) {
            console.warn('[autosave] Token CSRF não encontrado. Salvamento de rascunho desativado.');
            return;
        }

        loadDraft();
    }

    function onFieldChange() {
        hasChanges = true;
    }

    function getFormData() {
        const form = document.querySelector('form[id^="form0' + ABA + '"]');
        if (!form) return {};

        const data = {};
        const elements = form.querySelectorAll('input, select, textarea');

        elements.forEach(function (el) {
            const name = el.name;
            if (!name || name === '_token' || name === 'next_aba') return;

            const isArray = name.endsWith('[]');
            const cleanName = isArray ? name.slice(0, -2) : name;

            if (el.type === 'radio') {
                if (el.checked) data[cleanName] = el.value;
            } else if (el.type === 'checkbox') {
                if (!data[cleanName]) data[cleanName] = [];
                if (el.checked) data[cleanName].push(el.value);
            } else {
                if (isArray) {
                    if (!data[cleanName]) data[cleanName] = [];
                    data[cleanName].push(el.value);
                } else {
                    data[cleanName] = el.value;
                }
            }
        });

        return data;
    }

    function saveDraft() {
        const data = getFormData();
        if (Object.keys(data).length === 0) return;

        setIndicator('saving');
        showStatus('Salvando rascunho...', '#fefce8', '#a16207', '#fef9c3');

        fetch('/draft/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                processo_id: PROCESSO_ID,
                aba: String(ABA),
                data: data,
            }),
        })
        .then(function (res) {
            if (!res.ok) {
                return res.text().then(function (text) {
                    console.error('[autosave] HTTP ' + res.status + ':', text);
                    throw new Error('HTTP ' + res.status);
                });
            }
            return res.json();
        })
        .then(function (json) {
            if (json.ok) {
                hasChanges = false;
                lastSaved = json.saved_at;
                setIndicator('saved');
                showStatus('Rascunho salvo', '#f0fdf4', '#166534', '#bbf7d0');
            }
        })
        .catch(function (err) {
            console.error('[autosave] Erro ao salvar:', err);
            setIndicator('error');
            showStatus('Erro ao salvar', '#fef2f2', '#b91c1c', '#fecaca');
            setTimeout(function () { setIndicator(null); }, 5000);
        });
    }

    function loadDraft() {
        fetch('/draft/load?processo_id=' + PROCESSO_ID + '&aba=' + ABA, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
        .then(function (res) { return res.json(); })
        .then(function (json) {
            if (json.data) {
                restoreData(json.data);
                lastSaved = json.saved_at;
                setIndicator('saved');
                showStatus('Rascunho restaurado (' + formatTime(json.saved_at) + ')', '#eff6ff', '#1e40af', '#bfdbfe');
                setTimeout(function () { statusEl.style.opacity = '0'; }, 5000);
            }
        })
        .catch(function () {});
    }

    function restoreData(data) {
        const form = document.querySelector('form[id^="form0' + ABA + '"]');
        if (!form) return;

        Object.keys(data).forEach(function (name) {
            const value = data[name];
            let elements = form.querySelectorAll('[name="' + CSS.escape(name) + '"]');
            
            if (!elements.length) {
                elements = form.querySelectorAll('[name="' + CSS.escape(name + '[]') + '"]');
            }

            if (!elements.length) return;

            elements.forEach(function (el) {
                if (el.type === 'radio') {
                    el.checked = (el.value === value);
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                } else if (el.type === 'checkbox') {
                    el.checked = Array.isArray(value) && value.includes(el.value);
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                } else {
                    el.value = value;
                    el.dispatchEvent(new Event('input', { bubbles: true }));
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });
    }

    function clearDraft() {
        fetch('/draft/clear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                processo_id: PROCESSO_ID,
                aba: ABA,
            }),
        }).catch(function () {});
    }

    function setIndicator(state) {
        if (!indicatorEl) return;
        indicatorEl.classList.remove('saving', 'saved', 'error');
        if (state) indicatorEl.classList.add(state);
    }

    function showStatus(msg, bg, fg, border) {
        if (!statusEl) return;
        statusEl.textContent = msg;
        statusEl.style.background = bg;
        statusEl.style.color = fg;
        statusEl.style.borderColor = border;
        statusEl.style.opacity = '1';
        clearTimeout(statusEl._hideTimer);
        statusEl._hideTimer = setTimeout(function () {
            statusEl.style.opacity = '0';
        }, 3000);
    }

    function formatTime(iso) {
        try {
            const d = new Date(iso);
            return d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        } catch (e) {
            return '';
        }
    }

    window._autosaveClear = clearDraft;
    window._saveDraft = saveDraft;

    document.addEventListener('DOMContentLoaded', init);
})();
