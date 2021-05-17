<template>
    <button class="btn btn-default" v-text="text" v-on:click="vote" v-bind:class="{'btn-primary': voted}">

    </button>
</template>

<script>
    export default {
        props:['answer','count'],
        mounted() {
            axios.get('/api/answer/'+this.answer+'/isvote').then(response =>{
                this.voted = response.data.voted
            })
        },
        data(){
            return{
                voted:false,
                mycount:this.count,
            }
        },
        computed:{
            text(){
                return this.mycount
            }
        },
        methods:{
            vote(){
                axios.post('/api/answer/'+this.answer+'/vote').then(response =>{
                    this.voted = response.data.voted;
                    response.data.voted ? this.mycount++ : this.mycount--
                })
            }
        }

    }
</script>
