import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus'
import lightbox from 'alpine-tailwind-lightbox'
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';

window.Alpine = Alpine;

Alpine.plugin(focus)
Alpine.plugin(lightbox)
Alpine.start();


window.FilePond = FilePond;
