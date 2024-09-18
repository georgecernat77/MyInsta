<template>
    <div>
        <button class="btn btn-primary ml-4" style="background-color:rgb(0,149,246,1)" @click="followUser">Follow</button>
    </div>
</template>

<script>
    export default {
        props: ['userId'],

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            followUser(){
                axios.post('/follow/' + this.userId)
                    .then(response => {
                        console.log(this.userId)
                        alert(response.data);
                    });
            }
        }
    }
</script>
