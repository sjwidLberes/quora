<template>
    <div>
        <a class="btn" v-on:click="show_edit_profile">
            编辑个人资料
        </a>
        <div class="modal fade" id="edit-profile-dialog" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            编辑个人资料
                        </h4>
                    </div>

                    <div class="modal-body">
                        <form @submit.prevent="modify" @keydown="form.errors.clear($event.target.name)" class="form-horizontal">
                            <alert-error :form="form" message="请输入正确的个人资料!"></alert-error>
                            <alert-success :form="form" message="修改成功!"></alert-success>

                            <div class="form-group">
                                <label for="place" class="col-md-3 control-label">居住地</label>
                                <div class="col-md-6">
                                    <input v-model="form.place" type="text"  id="place" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="github" class="col-md-3 control-label">GitHub</label>
                                <div class="col-md-6">
                                    <input v-model="form.github" type="text"  id="github" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="site" class="col-md-3 control-label">Site</label>
                                <div class="col-md-6">
                                    <input v-model="form.site" type="text"  id="site" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="introduction" class="col-md-3 control-label">个人简介</label>
                                <div class="col-md-6">
                                    <textarea v-model="form.introduction" class="form-control" id="introduction">

                                    </textarea>
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
        props:['place','github','site','introduction'],
        data () {
            return {
                // Create a new form instance
                form:new Form({
                    place: this.place,
                    github: this.github,
                    site: this.site,
                    introduction: this.introduction,
                }),
            }
        },

        methods: {
            modify () {
                // Submit the form via a POST request
                this.form.post('/api/editprofile/').then(({ data }) => {
                    console.log(data)
                    setTimeout(function () {
                        $('#edit-profile-dialog').modal('hide')
                    },1000)
                })
            },
            show_edit_profile(){
                $('#edit-profile-dialog').modal('show')
            }
        }
    }
</script>
