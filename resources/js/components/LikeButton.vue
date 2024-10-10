<template>
    <div>
        <button class="btn " @click="likePost">
            <img :src="status ? '/storage/icons/heart-full.png' : '/storage/icons/heart-empty.png'" class='like-icon'/>
        </button>
    </div>
</template>

<script>
export default {
    name: "LikeButton",

    props: ['postId', 'liking'],

    data: function () {
        return {
            status: this.liking,
        }
    },

    methods: {
        likePost() {
            axios.post('/like/' + this.postId)
                .then(response => {
                    this.status = !this.status;
                    this.$emit('update-likes');
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                });
        }
    },

}
</script>

<style scoped>
.like-icon{
    width: 24px;
    height: 24px;
}

.btn:focus {
    border: none;
    box-shadow: none;
}
</style>
