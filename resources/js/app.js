import axios from 'axios';
import iconSetter from "./icon.js";
import Alpine from 'alpinejs'
import {copyToClipboard, loader} from './utilities.js'
import TomSelect from "tom-select";
import 'tom-select/dist/css/tom-select.css';
// import "@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css";
// import "@majidh1/jalalidatepicker";

window.axios = axios;
window.Alpine = Alpine

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Alpine.start();


(async () => {
    const iconListEl = document.getElementById('iconList');
    if (!iconListEl) return;

    const {iconList} = await import("./icon.js");
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

function initSelectBox() {

    document.querySelectorAll('.select-box').forEach(el => {
        let create = el.getAttribute('data-creation') ?? false;
        let settings = {
            create: create,
            plugins: ['no_backspace_delete', 'remove_button',],

            sortField: {
                field: "text",
                direction: "asc"
            }
        };
        new TomSelect(el, settings);
    });
}


//     Seo meta Detector     //
class MetaDetector {
    constructor(selector, min, max) {
        this.metaDetector = document.querySelector(selector);
        this.min = min;
        this.max = max;

        if (this.metaDetector) {
            const targetId = this.metaDetector.getAttribute('data-target');
            this.inputEl = document.getElementById(targetId);

            if (this.inputEl) {
                this.updateMetaDetector();

                this.inputEl.addEventListener('input', this.debounce(this.updateMetaDetector, 100));
            }
        }
    }

    // Function to update the metaDetector text and background color
    updateMetaDetector() {
        const valueLength = this.inputEl.value.length;
        this.metaDetector.innerText = `${valueLength} / (${this.min} - ${this.max})`;

        if (valueLength < this.min) {
            this.updateClasses('bg-gray-600', ['bg-red-600', 'bg-green-600']);
        } else if (valueLength > this.max) {
            this.updateClasses('bg-red-600', ['bg-gray-600', 'bg-green-600']);
        } else {
            this.updateClasses('bg-green-600', ['bg-gray-600', 'bg-red-600']);
        }
    }

    updateClasses(addClass, removeClasses) {
        this.metaDetector.classList.add(addClass);
        removeClasses.forEach(removeClass => this.metaDetector.classList.remove(removeClass));
    }

    debounce(func, delay) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }
}

//        Seo Section        //
let SeoTypeSelector = document.getElementById('seo_type');
const SchemaDetailsSec = document.getElementById('schemaDetails');

if (!!SeoTypeSelector) {

    let seoType = SeoTypeSelector.value;
    let seoNameSpace = document.getElementById('instance') ? document.getElementById('instance').value : null;
    let seoNameSpaceId = document.getElementById('instanceId') ? document.getElementById('instanceId').value : null;
    let schemaUrl = document.getElementById('schema_loader__url') ? document.getElementById('schema_loader__url').value : null;
    getSchema(seoType, seoNameSpace, seoNameSpaceId, schemaUrl)

    SeoTypeSelector.addEventListener('change', () => {
        SchemaDetailsSec.innerHTML = '';
        seoType = SeoTypeSelector.value;
        getSchema(seoType, seoNameSpace, seoNameSpaceId, schemaUrl)
    });
}

function getSchema(seoType = 'WebPage', instance = null, id = null, schemaUrl) {
    let waitEl = document.getElementById('waitEl');
    try {
        waitEl.innerHTML = loader
        axios.get(`${schemaUrl}/?seoType=${seoType}&instance=${instance}&id=${id}`, {

                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'content-type': 'text/json',
                }
            }
        )
            .then(function (response) {
                SchemaDetailsSec.innerHTML = response.data.data
            })
            .catch(function (res) {
                console.error(res)
            }).finally(() => {
            waitEl.innerHTML = '';
        });
    } catch (e) {
        console.error(e);
    }
}


document.addEventListener("DOMContentLoaded", function (event) {
    new MetaDetector('#metaTitleIndicator', 50, 60);
    new MetaDetector('#metaDescriptionIndicator', 150, 165);
    initSelectBox()
    iconSetter();
});
