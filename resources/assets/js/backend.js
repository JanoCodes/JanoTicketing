/*
 * Jano Ticketing System
 * Copyright (C) 2016-2019 Andrew Ying and other contributors.
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public License
 * v3.0 supplemented by additional permissions and terms as published at
 * COPYING.md.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 */

require('./bootstrap');

import Vuex from 'vuex';
import Vuetable from 'vuetable-2/src/components/Vuetable.vue';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue';
import vSelect from 'vue-select';
import VuetablePagination from './components/VuetablePagination.vue';

import Dropzone from 'dropzone';
import flatpickr from 'flatpickr';
import Quill from 'quill';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';

window.Vuex = Vuex;
window.Dropzone = Dropzone;
window.flatpickr = flatpickr;
window.Quill = Quill;
window.MapboxGeocoder = MapboxGeocoder;

Vue.component("vuetable", Vuetable);
Vue.component("vuetable-pagination", VuetablePagination);
Vue.component("vuetable-pagination-info", VuetablePaginationInfo);
Vue.component("v-select", vSelect);

