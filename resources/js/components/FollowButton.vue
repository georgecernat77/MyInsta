<template>
    <div>
<!--        <button class="btn btn-primary ml-4" style="background-color:rgb(0,149,246,1)" @click="followUser" v-text="buttonText"></button>-->
        <button
            :class="[isLinkStyle ? 'btn-as-text' : 'btn btn-primary ml-4']"
            :style="isLinkStyle ? '' : { backgroundColor: 'rgb(0,149,246,1)' }"
            @click="followUser"
            v-text="buttonText"
        ></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows', 'isLinkStyle'],

        mounted() {
            console.log('Component mounted.')
        },

        data : function ()
        {
            return {
                status: this.follows,
            }
        },

        methods: {
            followUser(){
                axios.post('/follow/' + this.userId)
                    .then(response => {
                        this.status = ! this.status;

                        console.log(response.data);
                    })
                    .catch(errors => {
                        if (errors.response.status == 401)
                        {
                            window.location = '/login';
                        }
                    });
            }
        },

        computed: {
            buttonText(){
                return (this.status) ? 'Unfollow' : 'Follow'
            }
        },
    }
</script>

<style scoped>

.btn:focus {
    outline: none;
    border: none;
    box-shadow: none;
}
.btn-as-text {
    background: none;
    border: none;
    padding: 0;
    color: #007bff; /* Culoarea specifica unui link */
    text-decoration: none; /* Linie sub text, pentru a imita stilul de link */
    cursor: pointer;
    /*position: relative;*/
    /*top: -5px;*/
    font-weight: 700;
    outline: none;
    box-shadow: none;
}

.btn-as-text:hover {
    color: #0056b3; /* Culoare de hover, pentru a da efectul link-ului */
    text-decoration: none;
}

</style>
