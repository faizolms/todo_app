<template>
    <div class="addtodo">
        <input type="text" v-model="body" />
        <button @click="addTodo()">Add</button>
    </div>
</template>

<script>
import axios from "axios"
export default {
    data: function(){
        return {
            body : ""
        }
    },
    methods:{
        addTodo(){
            console.log('ok')
            if(this.body == '')
            {
                return;
            }
            $token = this.isLogged.apiToken;
            axios.post('create-todo', {
                body : this.body
            },{
                headers:{
                    'Authorization': 'Bearer ' + $token
                }
            })
            .then(response => {
                if(response.status == 201){
                    this.body == "";
                }
            })
            .catch(error => {
                console.log(error);
            })
        }
    }
}
</script>

<style scoped>
.addtodo{
    display: flex;
    justify-content: center;
    align-items: center;
}

.input{
    border:0px;
    outline: none;
    padding: 5px;
    margin-right: 10px;
    width: 100%;
}
</style>