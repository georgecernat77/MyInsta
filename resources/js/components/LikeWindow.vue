<template>
    <div>
        <div class="d-flex">
            <!-- Butonul LikeButton -->
            <LikeButton :postId="postId" :liking="liking" @update-likes="fetchLikes"></LikeButton>
            <!--        Butoul de comment-->
            <button class="btn comment-button" @click="openPostModal">
                <img src="/storage/icons/comment-icon.png" class='comment-icon'/>
            </button>
            <button class="btn share-button" @click="openShareModal">
                <img src="/storage/icons/share-icon.png" class='share-icon'/>
            </button>
        </div>
        <!--        afiseaza nr like uri care prin apasare deschide window ul cu like uri-->
        <div class="d-flex font-weight-bold">
            <a href="#" class="text-decoration-none" @click.prevent="openModal"><span class="text-dark">{{ localLikesCount }} likes</span></a>
        </div>
<!--       se afiseaza window ul care arata pers care au dat like-->
        <div v-if="showModal" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>People who liked this post</h5>
                    <button class="close-button btn" @click="closeModal">X</button>
                </div>
                <div class="modal-body">
                    <div v-if="loading">Loading...</div>
                    <div v-else>
                        <div class="user-list" v-for="like in likes" :key="like.id">
                            <div class="d-flex align-items-center">
                                <div class="pr-3">
                                    <a :href="'/profile/' + like.id">
                                        <img :src="'/storage/' + like.profile.image" alt="" class="w-100 rounded-circle"
                                             style="max-width: 40px">
                                    </a>
                                </div>
                                <div class="font-weight-bold">
                                    <a class="text-decoration-none" :href="'/profile/' + like.id">
                                        <span class="text-dark">{{ like.username }}</span>
                                    </a>
                                    <a class="text-decoration-none pl-2" href="#">
                                        Follow
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LikeButton from "./LikeButton.vue";

export default {
    name: "LikeWindow",

    components: {
        LikeButton
    },

    props: ['postId', 'likesCount', 'liking'],

    data: function () {
        return {
            showModal: false,
            likes: [],
            loading: false,
            localLikesCount: this.likesCount
        };
    },

    methods: {
        openModal() {
            this.showModal = true;
            this.fetchLikes();
        },
        closeModal() {
            this.showModal = false;
        },
        openPostModal() {
          if (typeof window.togglePostModal === "function") {
              window.togglePostModal(this.postId);
          }
        },
        openShareModal() {
          if (typeof window.toggleShareModal === "function") {
              window.toggleShareModal(this.postId);
          }
        },
        fetchLikes() {
            this.loading = true;
            axios.get('/p/' + this.postId + '/likes')
                .then(response => {
                    this.likes = response.data;
                    // this.likesCount = response.data.length;
                    this.localLikesCount = response.data.length;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    window.location = '/p/' + this.postId;
                })
        }
    }
}
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    width: 100%;
}

.modal-header {
    display: flex;
    justify-content: space-between;
}

.modal-body {
    margin-top: 15px;
}

.user-list {
    margin-bottom: 10px;
}
.close-button {
    background-color: white;
    color: black;
    font-size: 20px;
    outline: none;
    box-shadow: none
}
.close-button:active {
    outline: none;
    box-shadow: none
}
.close-button:focus {
    outline: none;
    box-shadow: none
}

.comment-button {
    position: relative;
    right: 25px;
}
.comment-icon{
    width: 24px;
    height: 24px;
}
.share-button {
    position: relative;
    top: -5%;
    left: -40px;
}
.share-icon{
    width: 24px;
    height: 24px;
    transform: rotate(20deg);
}
.btn:focus {
    border: none;
    box-shadow: none;
    outline: none;
}

.btn {
    outline: none;
    border: none;
    transition: none;
}

.btn:active {
    border: none;
    box-shadow: none;
    outline: none;
}

.btn:focus-visible:after {
    border: none;
    box-shadow: none;
    outline: none;
    transition: none;
}

.btn:focus:before {
    border: none;
    box-shadow: none;
    outline: none;
    transition: none;
}

</style>
