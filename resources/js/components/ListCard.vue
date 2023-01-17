<template>
    <draggable v-model="draggableColumns" group="people" :options="{animation:200}" @start="drag=true"
               @end="drag=false" @change="updateOrder()">
        <div @click="show()" class="container">
            {{ card.title }}
        </div>
        <modal name="edit-card-11">
            <label>Title</label>
            <input type="text" v-model="cardObj.title"/>
            <label>Description</label>
            <input type="text" v-model="cardObj.description"/>
            <button @click="editCard(card.id)">Edit</button>
        </modal>
    </draggable>
</template>

<script>

import draggable from 'vuedraggable'

export default {
    props: ['card'],
    name: "ListCard",
    components: {
        draggable
    },
    data: function () {
        return {
            draggableColumns: this.columns,
            cardObj: {
                title: this.card.title,
                description: this.card.description
            },
            errors: {}
        }
    },
    methods: {
        show() {
            this.$modal.show('edit-card-11');

        },
        hide() {
            this.$modal.hide('edit-card-11');
        },
        editCard(id) {
            axios.put(`api/cards/${id}`, {
                title: this.cardObj.title,
                description: this.cardObj.description
            }).then(response => {
                if (response.status === 200) {
                    this.$emit("columnChanged")
                    this.hide();
                }
            }).catch(error => {
                console.log(error)
            })
        },

        updateOrder() {
            // this.draggableColumns.map((column, index) => {
            //     column.order = index + 1;
            // })

            axios.put(`api/cards/updateOrder/${id}`, {
                columns: this.draggableColumns
            }).then(response => {
                if (response.status === 200) {
                    this.$emit("columnChanged")
                    this.hide();
                }
            }).catch(error => {
                console.log(error)
            })
        }

    },
    // mounted() {
    //     this.show()
    // }
}
</script>

<style lang="scss" scoped>
.container {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    height: 40px;
    width: 175px;
    padding-top: 15px;
    text-align: center;
}
</style>
