<template>
    <div>
    <a class="btn" v-on:click="show_modify_password">
        修改密码
    </a>
    <div class="modal fade" id="modify-password-dialog" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">
                        修改密码

                    </h4>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="modify" @keydown="form.errors.clear($event.target.name)" class="form-horizontal">
                        <alert-error :form="form" message="请输入正确的旧密码!"></alert-error>
                        <alert-success :form="form" message="修改密码成功!"></alert-success>

                        <div class="form-group" :class="{ 'has-error': form.errors.has('oldpassword') }">
                            <label for="oldpassword" class="col-md-3 control-label">请输入旧密码</label>
                            <div class="col-md-6">
                                <input v-model="form.oldpassword" type="password" name="oldpassword" id="oldpassword" class="form-control">
                                <has-error :form="form" field="oldpassword"></has-error>
                            </div>
                        </div>

                        <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                            <label for="password" class="col-md-3 control-label">请输入新密码</label>
                            <div class="col-md-6">
                                <input v-model="form.password" type="password" name="password" id="password" class="form-control">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>

                        <div class="form-group" :class="{ 'has-error': form.errors.has('password_confirmation') }">
                            <label for="password" class="col-md-3 control-label">请再次输入新密码</label>
                            <div class="col-md-6">
                                <input v-model="form.password_confirmation" type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                <has-error :form="form" field="password_confirmation"></has-error>
                            </div>
                        </div>

                        <div class="form-group" style="text-align: center">
                            <button :disabled="form.busy" type="submit" class="btn btn-primary">修改</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
</template>

<script>
    import Form from 'vform'

    export default {
        data () {
            return {
                // Create a new form instance
                form:new Form({
                    oldpassword: '',
                    password: '',
                    password_confirmation: '',

                }),

            }
        },

        methods: {
            modify () {
                // Submit the form via a POST request
                this.form.post('/api/changepassword/').then(({ data }) => {
                    console.log(data)
                    setTimeout(function () {
                        $('#modify-password-dialog').modal('hide')
                    },1000)
                })
            },
            show_modify_password(){
                $('#modify-password-dialog').modal('show')
            }
        }
    }
</script>
