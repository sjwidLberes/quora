<template>
    <button class="btn btn-default" v-text="text" v-on:click="follow" v-bind:class="{'btn-success':!followed}">

    </button>
</template>

<script>
    export default {
        props:['question'],
        mounted() {
            axios.get('/api/question/'+this.question+'/isfollow').then(response =>{
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
                return this.followed ? '已关注' : '关注问题'
            }
        },
        methods:{
            follow(){
                axios.post('/api/question/'+this.question+'/follow').then(response =>{
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>
