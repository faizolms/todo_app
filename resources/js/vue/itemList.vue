 <template>
        <div class="item">

            <input type="checkbox" @change="updateCheck" v-model="item.complete" />
            <span :class="[item.is_complete ? 0:1]">{{item.body}}</span>
        </div>
</template>

<script>
export default {
    props:[items]
}
</script>