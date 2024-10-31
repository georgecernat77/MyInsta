<template>
    <div>
        <button class="btn" @click="likeComment">
            <img :src="status ? '/storage/icons/heart-full.png' : '/storage/icons/heart-empty.png'" class='like-icon'/>
        </button>
    </div>
</template>

<script>
export default {
    name: "CommentLikeButton",

    props: ['commentId', 'liking'],

    data: function () {
        return {
            status: this.liking,
        }
    },

    methods: {
        likeComment() {
            axios.post('/likeComment/' + this.commentId)
                .then(response => {
                    this.status = !this.status;
                    // this.$emit('update-comment-likes');
                })
                .catch(errors => {
                    if(errors.response.status == 401) {
                        window.location = '/login';
                    }
                })
        }
    }
}
</script>

<style scoped>
.like-icon{
    width: 13px;
    height: 13px;
    position: absolute;
    right: 0;
}

.btn:focus {
    border: none;
    box-shadow: none;
}
</style>
