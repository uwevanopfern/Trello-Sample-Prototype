<template>
    <div>
        <button class="add-card" @click="show()">Add column</button>
        <modal name="add-column">
            <label>Provide Column Title</label>
            <input type="text" v-model="column.title"/>
            <button @click="addColumn()">Add</button>
            <div v-for="(errorArray, index) in errors" :key="index">
                <div v-for="(allErrors, index) in errorArray" :key="index">
                    <span>{{ allErrors }} </span>
                </div>
            </div>
        </modal>
    </div>

</template>

<script>
export default {
    name: "AddColumn",
    data: function () {
        return {
            column: {
                title: ""
            },
            errors: {}
        }
    },
    methods: {
        show() {
            this.$modal.show('add-column');
        },
        hide() {
            this.$modal.hide('add-column');
        },
        addColumn() {
            axios.post('api/columns', {
                title: this.column.title
            }).then(response => {
                if (response.status === 201) {
                    this.column.title = "";
                    this.$emit("reloadColumns")
                    this.hide();
                }

            }).catch(error => {
                this.errors = error.response.data.errors
            })
        }
    },
    mount() {
        this.show()
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
}

</style>
