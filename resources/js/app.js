import axios from 'axios';
import iconSetter, {iconList} from "tkicon";
import Alpine from 'alpinejs'
import {copyToClipboard, loader} from './utilities.js'

window.axios = axios;
window.Alpine = Alpine

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Alpine.start();


(async () => {
    const iconListEl = document.getElementById('iconList');
    if (!iconListEl) return;

    const {iconList} = await import("tkicon");
    const fragment = document.createDocumentFragment();

    // Create template once and reuse
    const createIconItem = (name) => {
        const li = document.createElement('li');
        li.className = 'x-box flex items-center justify-between gap-3 relative';

        li.innerHTML = `${name}
            <i class="tkicon" data-icon="${name}"></i>
            <button type="button" role="button" title="copy to clipboard"
                class="text-xs absolute top-0 end-0 p-1 shadow clipboardBtn"
                data-text="&lt;i class='tkicon' data-icon='${name}' size='24'&gt;&lt;/i&gt;">
                copy
            </button>`;

        return li;
    };

    // Build items efficiently
    Object.entries(iconList).forEach(([name]) =>
        fragment.appendChild(createIconItem(name))
    );

    // Single DOM update
    iconListEl.appendChild(fragment);
    iconSetter();

    // Event delegation for clipboard buttons
    iconListEl.addEventListener('click', (e) => {
        const btn = e.target.closest('.clipboardBtn');
        if (btn) {
            const primaryText = btn.innerHTML;
            btn.disable = true;
            if (btn.disable !== false) {
                btn.innerHTML = `<span class="text-green-600">copied!</span>`
            }
            copyToClipboard(btn.dataset.text);
            setTimeout(() => {
                btn.innerHTML = primaryText;
                btn.disable = false;
            }, 500);
        }
    });
})();


document.addEventListener("DOMContentLoaded", function (event) {
    iconSetter();
});
