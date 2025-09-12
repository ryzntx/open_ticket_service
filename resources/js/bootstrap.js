import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import axios from 'axios';
import TomSelect from 'tom-select';

import 'tom-select/dist/css/tom-select.css';

// Summernote Editor
import 'summernote/dist/summernote-lite.min.js';
import 'summernote/dist/summernote-lite.min.css';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.document.querySelectorAll('select.tom-select').forEach((element) => {
    new TomSelect(element, {
        plugins: ['remove_button'],
        create: true,
        createOnBlur: true,
        persist: false,
        maxItems: null,
        valueField: 'id',
        labelField: 'name',
        searchField: ['name'],
    });
});
