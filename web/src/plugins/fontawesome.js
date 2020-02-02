import Vue from 'vue';
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

import {
    faUserSecret,
    faExclamationTriangle,
    faGamepad,
    faCog,
    faRobot,
    faTimes,
    faCircle,
    faSync
} from '@fortawesome/free-solid-svg-icons';

library.add(
    faUserSecret,
    faExclamationTriangle,
    faGamepad,
    faCog,
    faRobot,
    faTimes,
    faCircle,
    faSync
);

Vue.component('font-awesome-icon', FontAwesomeIcon);
