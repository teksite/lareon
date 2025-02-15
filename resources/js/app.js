import axios from 'axios';
import Alpine from 'alpinejs'
import iconSetter from 'tkicon'
import {iconList} from 'tkicon'

window.Alpine = Alpine
window.axios = axios;

Alpine.start();

const iconListContainer = document.getElementById('iconList');
const loader = `<svg class="mr-3 -ml-1 size-5 animate-spin text-white stroke-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10"  stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

if (iconListContainer) {
    const fragment = document.createDocumentFragment();

    Object.entries(iconList).forEach(([key, value]) => {
        const div = document.createElement('li');
        div.className = 'x-box flex items-center justify-between gap-6';
        div.innerHTML = `
                <svg width="24" height="24" viewBox="0 0 24 24" class="tkicon gage" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" data-icon="gage" size="24">${value}</svg>
                <button type="button" class="text-sm copyToClipboardBtn hover:cursor-pointer" data-clipboard="<i class='tkicon fill-none stroke-transparent' data-icon='${key}'>">${key}</button>
            `;
        fragment.appendChild(div);
    });

    iconListContainer.appendChild(fragment);

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('copyToClipboardBtn')) {
            e.preventDefault();
            const basicContent = e.target.innerHTML;
            addToClipboard(e.target.getAttribute('data-clipboard'));
            e.target.innerHTML = basicContent + ' <span class="text-green-600 text-sm copiedTExtEl">copied</span>'

            setTimeout(() => e.target.innerHTML = basicContent, 1500);

        }
    });
}


function addToClipboard(content) {
    navigator.clipboard.writeText(content);
    document.querySelectorAll('.copiedTExtEl').forEach(copiedTExt => copiedTExt.remove());
}

// delete conformation
document.querySelectorAll('.deltfrmItms').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        const targetId = form.getAttribute('data-target');

        const parenEl = targetId ? document.getElementById(targetId) : form.closest('tr') ?? null;
        if (parenEl) {
            parenEl.style.opacity = '0.5';
            parenEl.style.backgroundColor = 'rgba(255,0,0,0.32)';
        }
        setTimeout(() => {
            const answer = confirm('are you sure?');
            if (answer) form.submit();

            if (parenEl) parenEl.removeAttribute('style');

        }, 50)

    })
})

function detectMakeHideBtn() {
    const hideBtns = document.querySelectorAll('.hideBtn')
    if (hideBtns.length) {
        hideBtns.forEach(hideBtn => {
            hideBtn.addEventListener('click', e => {
                e.preventDefault();
                const targetId = hideBtn.getAttribute('data-target')
                const target = targetId ? document.getElementById(targetId) : null
                if (target) {
                    target.style.transition = 'all 250ms linear'
                    target.style.opacity = "0";
                    setTimeout(function () {
                        target.remove();
                    }, 500);
                }
            })
        })
    }
}

async function getSystemUsage() {
    if (document.querySelector('#usageSection')) {
        let usages = await axios.get('/tkadmin/ajax/settings/system_usage');
        console.log(usages)
    }


}

document.addEventListener('DOMContentLoaded', function () {
    detectMakeHideBtn();
    getSystemUsage();
    iconSetter();
});

