<template>
    <div class="aboutauthorpanelbutton">
    <button class="btn btn-default" v-text="text" v-on:click="follow" v-bind:class="{'btn-success':!followed}">

    </button>
    </div>
</template>

<script>
    export default {
        props:['user_id'],
        mounted() {
            axios.get('/api/user/'+this.user_id+'/isfollow').then(response =>{
                this.followed = response.data.followed
            })
        },
        data(){
            return{
                followed:false
            }
        },
        computed:{
            text(){
                return this.followed ? '已关注' : '关注他'
            }
        },
        methods:{
            follow(){
                axios.post('/api/user/'+this.user_id+'/follow').then(response =>{
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>
