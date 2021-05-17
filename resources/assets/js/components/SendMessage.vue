<template>
    <div class="aboutauthorpanelbutton">
        <button class="btn btn-default" v-on:click="show_send_message">
            发送私信
        </button>

        <div class="modal fade" id="send-message-dialog" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            发送私信给{{user_name}}
                        </h4>
                    </div>

                    <div class="modal-body">
                        <textarea class="form-control" name="body" v-model="body" v-if="!status"></textarea>
                        <div class="alert alert-success" v-if="status">
                            <strong>私信发送成功</strong>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" v-on:click="send" >发送</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user_id','user_name'],
        data(){
          return{
              body: '',
              status: false
          }
        },
        methods:{
            send(){
                axios.post('/api/sendmessage/',{'user_id':this.user_id,'body':this.body}).then(response =>{
                    this.status = response.data.status
                    this.body = ''
                    setTimeout(function () {
                        $('#send-message-dialog').modal('hide')
                    },1000)
                })
            },
            show_send_message(){
                $('#send-message-dialog').modal('show')
            }
        }

    }
</script>
