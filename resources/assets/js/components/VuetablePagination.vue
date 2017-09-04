<template>
    <ul v-if="tablePagination && tablePagination.last_page > 1" class="pagination" role="navigation">
        <li class="pagination-previous" :class="{ disabled: isOnFirstPage }">
            <a v-if="!isOnFirstPage" @click="loadPage('prev')"></a>
        </li>
        <template v-if="notEnoughPages">
            <template v-for="n in totalPage">
                <li :class="{ current: isCurrentPage(n) }">
                    <template v-if="isCurrentPage(n)">
                        {{ n }}
                    </template>
                    <template v-else>
                        <a @click="loadPage(n)" v-html="n"></a>
                    </template>
                </li>
            </template>
        </template>
        <template v-else>
            <template v-for="n in windowSize">
                <li :class="{ current: isCurrentPage(windowStart+n-1) }">
                    <template v-if="isCurrentPage(windowStart+n-1)">
                        {{ windowStart+n-1 }}
                    </template>
                    <template v-else>
                        <a @click="loadPage(windowStart+n-1)" v-html="windowStart+n-1"></a>
                    </template>
                </li>
            </template>
        </template>
        <li class="pagination-next" :class="{ disabled: isOnLastPage }">
            <a v-if="!isOnLastPage" @click="loadPage('next')"></a>
        </li>
    </ul>
</template>

<script>
    import PaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin.vue'

    export default {
        mixins: [PaginationMixin],
    }
</script>