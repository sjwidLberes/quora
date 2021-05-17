<template>
    <a id="commentForm">
        <button class="btn is-naked delete-button" v-on:click="show_comment_dialog" v-html="text">
        </button>

        <div class="modal fade" :id=comment_dialog tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">评论列表</h4>
                    </div>

                    <div class="modal-body" v-if="comments.length > 0">

                        <div class="media" v-for="comment in comments">
                            <div class="media-left">
                                <img :src="comment.user.avatar" alt="" width="24" class="media-object"/>
                            </div>
                            <div class="media-body">
                                <div>
                                    <span class="media-heading">{{comment.user.name}}</span>
                                    <span class="media-comment-time pull-right">{{comment.created_at}}</span>
                                </div>
                                {{comment.body}}
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <input type="text" class="form-control" v-model="body"/>
                        <button type="button" class="btn btn-primary publish-comment" v-on:click="comment" >发表评论</button>
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>
<style scoped>
    .media-body{
        color:#000;
    }
    .modal-title{
        color:#1e1e1e;
    }
    .media-body .media-heading{
        color:#00b1b3;
        font-weight:600;
    }
    .modal-body{
        padding-top:0 !important;
    }
    .media{
        margin-top:0 !important;
        padding: 12px 0 10px;
        border-bottom: 1px solid #f0f2f7;
    }
    .media:last-child{
        border:none;
    }
    .media-comment-time{
        color: #8590a6;
        floated:right;
    }
    .publish-comment{
        margin-top:10px ;
    }
</style>

<script>
    export default {
        props:['commentable_id','commentable_type','count'],
        data(){
            return{
                body: '',
                comments: [],
                total:this.count,
            }
        },
        computed:{
            comment_dialog(){
                return 'dialog-'+this.commentable_type+'-'+this.commentable_id
            },
            comment_dialog_id(){
                return '#'+this.comment_dialog
            },
            text(){
                return '<i class="fa fa-comment fa-icon-lg"></i>'+this.total+'评论'
            },
        },
        methods:{
            comment(){
                axios.post('/api/comment/',{'commentable_id':this.commentable_id,'commentable_type':this.commentable_type,'body':this.body}).then(response =>{
                    console.log(response.data)
                    let newComment ={
                        user:{
                            name:AuthUser.name,
                            avatar:AuthUser.avatar
                        },
                        body:response.data.body,
                        created_at:response.data.created_at
                    }
                    this.comments.push(newComment)
                    this.body = ''
                    this.total ++

                })
            },
            get_comments(){
                axios.get('/api/'+this.commentable_type+'/'+this.commentable_id+'/comments').then(response =>{
                    this.comments=response.data;

                })
            },
            show_comment_dialog(){
                this.get_comments()
                $(this.comment_dialog_id).modal('show')
            }
        }

    }
</script>
