/*
 * Jano Ticketing System
 * Copyright (C) 2016-2017 Andrew Ying
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation. You must preserve all legal
 * notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require('./bootstrap');

window.Vuex = require('vuex');

import Vuetable from 'vuetable-2/src/components/Vuetable.vue';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue';
import vSelect from 'vue-select';

Vue.component("vuetable", Vuetable);
Vue.component("vuetable-pagination", require('./components/VuetablePagination.vue'));
Vue.component("vuetable-pagination-info", VuetablePaginationInfo);
Vue.component("v-select", vSelect);

window.Dropzone = require('dropzone');
window.flatpickr = require("flatpickr");
window.EasyPieChart = require('easy-pie-chart');

$(document).foundation();
