<template>
    <div>
        <div v-for="(item,index) in items" :key="index">

            <list-item :item="item" class="item" />

        </div>
    </div>
</template>

<script>

import itemList from './itemList'

export default {
     props: ['items'],
     components: {
         itemList
     }
}
</script>
<style scoped>
    .item{
        background: #e6e6e6;
        padding: 5px;
        margin-top: 5px;

    }
</style>