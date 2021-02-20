<template>
    <div class="todolistContainer">
        <div class="heading">
            <h2 id="title">Todo List</h2>
            <add-todo-form/>
        </div>
        <todolist-view :items="items"/>
    </div>
</template>

<script>

import addTodoForm from "./addTodoForm"
import todolistView from "./todolistView"

export default {
    components: {
        addTodoForm,
        todolistView
    },
    data: function(){
        return {
            items: []
        }
    },
    methods: {
        getList(){
            axios.get('todos')
            .then( response => {
                this.items = response.data
            })
            .catch( error => {
                console.log(error)
            })
        }
    },
    created(){
        this.getList();
    }
}
</script>

<style scoped>
.todolistContainer{
    width: 500px;
    margin: auto;
}

.heading{
    background: #e6e6e6;
    padding: 10px;
}

#title{
    text-align: center;
}
</style>