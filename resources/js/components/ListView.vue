<template>
    <div>
        <h2 class="column-header">BeMo</h2>
        <div class="container">
            <div v-for="(column, index) in columns" :key="index">
                <list-column :column="column" v-on:columnChanged="$emit('reloadColumns')"></list-column>
            </div>
        </div>

    </div>

</template>

<script>

import ListColumn from "./ListColumn";

export default {
    props: ['columns'],
    name: "ListColumns",
    components: {
        ListColumn
    }
}
</script>

<style lang="scss" scoped>

.container {
    display: flex;
    padding: 10px;
    justify-content: space-around;
    gap: 0 2em;
}
</style>
