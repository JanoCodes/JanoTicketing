<!--
  - Jano Ticketing System
  - Copyright (C) 2016-2018 Andrew Ying and other contributors.
  -
  - This file is part of Jano Ticketing System.
  -
  - Jano Ticketing System is free software: you can redistribute it and/or
  - modify it under the terms of the GNU General Public License v3.0 as
  - published by the Free Software Foundation. You must preserve all legal
  - notices and author attributions present.
  -
  - Jano Ticketing System is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU General Public License for more details.
  -
  - You should have received a copy of the GNU General Public License
  - along with this program.  If not, see <http://www.gnu.org/licenses/>.
  -->

<template>
    <ul v-if="tablePagination && tablePagination.last_page > 1" class="pagination justify-content-end" role="navigation">
        <li class="page-item" :class="{ disabled: isOnFirstPage }">
            <a class="page-link" @click="loadPage('prev')">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <template v-if="notEnoughPages">
            <template v-for="n in totalPage">
                <li class="page-item" :class="{ active: isCurrentPage(n) }">
                    <template v-if="isCurrentPage(n)">
                        <a href="#" class="page-link">{{ n }} <span class="sr-only">(current)</span></a>
                    </template>
                    <template v-else>
                        <a class="page-link" @click="loadPage(n)" v-html="n"></a>
                    </template>
                </li>
            </template>
        </template>
        <template v-else>
            <template v-for="n in windowSize">
                <li class="page-item" :class="{ active: isCurrentPage(windowStart+n-1) }">
                    <template v-if="isCurrentPage(windowStart+n-1)">
                        <a href="#" class="page-link">{{ windowStart+n-1 }} <span class="sr-only">(current)</span></a>
                    </template>
                    <template v-else>
                        <a class="page-link" @click="loadPage(windowStart+n-1)" v-html="windowStart+n-1"></a>
                    </template>
                </li>
            </template>
        </template>
        <li class="page-item" :class="{ disabled: isOnLastPage }">
            <a class="page-link" v-if="!isOnLastPage" @click="loadPage('next')">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</template>

<script>
    import PaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin.vue'

    export default {
        mixins: [PaginationMixin],
    }
</script>