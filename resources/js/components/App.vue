<template>
    <div class="container">
        <list-view :columns="columns" v-on:reloadColumns="getColumns"></list-view>
        <add-column v-on:reloadColumns="getColumns"></add-column>
        <button class="add-card" @click="exportDb()">Export DB</button>
    </div>
</template>

<script>

import ListView from "./ListView";
import AddColumn from "./AddColumn";


export default {
    components: {
        ListView, AddColumn
    },

    data: function () {
        return {
            columns: []
        }
    },
    methods: {
        getColumns() {
            axios.get('api/columns')
                .then(response => {
                    this.columns = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
        exportDb() {
            axios.get('api/export-db',).then(response => {
                if (response.status === 200) {
                    console.log('success')
                    alert('Exported successfully')
                }
            }).catch(error => {
                alert('Exported Failed')
                this.errors = error.response.data.errors
            })
        }
    },
    created() {
        this.getColumns();
    }
}
</script>

<style lang="scss" scoped>
$bg-button: #000066;
$button-color: #ffffff;

.add-card{
    color: $button-color;
    background: $bg-button;
    margin-left: 28%;
    margin-bottom: 6%;
}
.container {
    width: auto;
    margin: auto;
    background-color: aliceblue;
}
</style>
