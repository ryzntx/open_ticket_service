import axios from 'axios';
import TomSelect from 'tom-select';

import 'tom-select/dist/css/tom-select.css';

// froala editor
import FroalaEditor from 'froala-editor';
import 'froala-editor/css/froala_editor.min.css';

// froala plugins
import 'froala-editor/js/plugins/align.min.js';
// image
import 'froala-editor/js/plugins/image.min.js';

window.FroalaEditor = FroalaEditor;

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
