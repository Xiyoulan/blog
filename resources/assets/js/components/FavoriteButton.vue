<template>
    <div class="buttons">
        <button class="btn btn-default animated bounce" v-if="show" @click="favorite">
            <span class=" glyphicon glyphicon-thumbs-up"></span> 点赞
        </button>
        <button class="btn btn-default animated bounce" v-else @click="unFavorite">
            <span class="glyphicon glyphicon-thumbs-up"></span> 已赞
        </button>
    </div>
</template>

<script>
    export default {
        props: ['isFavorite','articleId'],
        data() {
            return {
                show:!this.isFavorite,
                id:this.articleId,
            }
        },
        mounted(){
          console.log(this.isFavorite);
        },
        methods: {
            favorite(){
                let articleId = this.id;
                console.log(this.show);
                this.$nextTick(()=>{
                    if (this.show) {
                        axios.post('/favorites/' + articleId).then(res => {
                            this.show = false;
                        }).catch(res=> swal('您点击得太快了!','','error'));
                    }
                });

            },
            unFavorite(){
                let articleId = this.id;
                console.log(this.show);
                this.$nextTick(()=>{
                if (!this.show) {
                    axios.delete('/favorites/' + articleId).then(res => {
                        this.show = true;
                    }).catch(res=> swal('您点击得太快了!','','error'));
                }
                });
            },
        },
    }
</script>