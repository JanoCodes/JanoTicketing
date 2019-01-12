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

import lodash from 'lodash';
import jquery from 'jquery';
import Popper from 'popper.js';
import Vue from 'vue';
import Slideout from 'slideout';
import axios from 'axios';
import mapboxgl from 'mapbox-gl/dist/mapbox-gl';

window._ = lodash;

window.$ = window.jQuery = jquery;
window.Popper = Popper;
require('bootstrap');

window.Vue = Vue;

window.Slideout = Slideout;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.mapboxgl = mapboxgl;

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
dom.watch();

library.add(fas, far, fab);
