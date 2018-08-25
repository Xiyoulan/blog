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
            isFollow:false,
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
                        this.$message.show('成功关注!','success');
                    }).catch(res=> this.$message.show('关注失败','warning'));
                }
            },
            unFollow() {
                let userId = this.id;
                if (!this.show) {
                    axios.delete('/followers/' + userId).then(res => {
                        this.show = true;
                        this.$message.show('取消关注成功!','success');
                    }).catch(res=> this.$message.show('取消失败','warning'));
                }

            },
        },
    }
</script>