import Vue from 'vue';
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faUserSecret, faExclamationTriangle, faGamepad} from '@fortawesome/free-solid-svg-icons';

library.add(
    faUserSecret,
    faExclamationTriangle,
    faGamepad
);

Vue.component('font-awesome-icon', FontAwesomeIcon);
