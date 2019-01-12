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

const mix = require('laravel-mix');

mix.setPublicPath('public');

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/backend.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/backend.scss', 'public/css');

mix.copy('logo.png', 'public/images/logo.png');

if (mix.inProduction()) {
    mix.version();
}
