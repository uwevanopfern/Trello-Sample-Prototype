<template>
    <div>
        <div class="container">
            <div>
                <div class="column">
                    <div>{{ column.title }}</div>
                    <button class="close-button" @click="deleteColumn(column.id)">X</button>
                </div>
                <div v-for="(card, index) in column.cards" :key="index">
                    <list-card :card="card" v-on:columnChanged="$emit('columnChanged')"></list-card>
                </div>
            </div>
            <div v-if="showCardForm" v-model="showCardForm">
                <button class="add-card" @click="showCardFormFunc(id)" :key="column.id">Hide Card Form</button>
                <hr>
                <label>Title</label>
                <input type="text" v-model="card.title"/>
                <label>Description</label>
                <input type="text" v-model="card.description"/>
                <button class="add-card" @click="addCard(column.id)">Add</button>
                <div v-for="(errorArray, index) in errors" :key="index">
                    <div v-for="(allErrors, index) in errorArray" :key="index">
                        <span>{{ allErrors }} </span>
                    </div>
                </div>
            </div>
            <div v-else>
                <hr>
                <button class="add-card" @click="showCardFormFunc(column.id)" :key="column.id">Add Card</button>
            </div>
        </div>
    </div>

</template>

<script>

import ListCard from "./ListCard";

export default {
    name: "ListColumn",
    props: {
        column: '',
        showCardForm: false
    },
    components: {
        ListCard
    },
    data: function () {
        return {
            card: {
                title: "",
                description: ""
            },
            id: {
                type: String | Number
            },
            errors: {}
        }
    },
    methods: {
        showCardFormFunc() {
            this.showCardForm = !this.showCardForm;
        },
        deleteColumn(id) {
            axios.delete(`api/columns/${id}`).then(response => {
                if (response.status === 204) {
                    this.$emit("columnChanged")
                }
            }).catch(error => {
                console.log(error)
            })
        },
        addCard(id) {
            axios.post('api/cards', {
                column_id: id,
                title: this.card.title,
                description: this.card.description,
            }).then(response => {
                if (response.status === 201) {
                    this.card.title = "";
                    this.card.description = "";
                    this.$emit("columnChanged")
                }
            }).catch(error => {
                this.errors = error.response.data.errors
            })
        }
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

.close-button{
    margin-left: 30%;
    background: $bg-button;
    color: $button-color;
}
.container {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.column {
    display: flex;
    padding: 10px;
    width: 150px;
}
</style>
