<template>
    <div class="buttons">
        <button class="btn btn-info btn-sm btn-block animated bounce" v-if="show" @click="follow">
            <span class="glyphicon glyphicon-plus"></span> 关注 ta
        </button>
        <button class="btn btn-danger btn-sm btn-block animated bounce" v-else @click="unFollow">
            <span class="glyphicon glyphicon-eye-close"></span> 取消关注
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            userId: [String, Number],
            isFollow:[String,Number],
        },
        data() {
            return {

                show: !this.isFollow,
                id:this.userId,
            }
        },
        methods: {
            follow() {
                let userId = this.id;
                if (this.show) {
                    axios.post('/followers/' + userId).then(res => {
                        this.show = false;
                    }).catch(res=>console.log(res));
                }
            },
            unFollow() {
                let userId = this.id;
                if (!this.show) {
                    axios.delete('/followers/' + userId).then(res => {
                        this.show = true;
                    }).catch(res=>console.log(res));
                }

            },
        },
        watch: {}
    }
</script>