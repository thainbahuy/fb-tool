<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-0">System infor</h4>
                        <h2 class="font-light"></h2>
                        <div class="m-t-30">
                            <div class="row text-center">
                                <div class="col-6 border-right">
                                    <h4 class="m-b-0">{{totalUser}}</h4>
                                    <span class="font-14 text-muted">Users</span>
                                </div>
                                <div class="col-6">
                                    <h4 class="m-b-0">{{totalPostLike}}</h4>
                                    <span class="font-14 text-muted">Post Liked</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div v-if="isDisplay == 1" class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{noti}}</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="InputName">Name:</label>
                                <input name="Name" data-vv-validate-on="none" v-validate="{ required: true , min :6 }"
                                       type="text" class="form-control"
                                       v-model="name" id="InputName" aria-describedby="emailHelp"
                                       placeholder="Enter Name Account">
                                <span v-show="errors.has('Name')"
                                      class="help is-danger">{{ errors.first('Name') }}</span>

                            </div>
                            <div class="form-group row">
                                <label for="InputToken">Access Token:</label>
                                <input name="AccessToken" data-vv-validate-on="none" v-validate="{ required: true, }"
                                       type="text" class="form-control"
                                       v-model="accesstoken" id="InputToken"
                                       placeholder="Enter Access Token">
                                <span v-show="errors.has('AccessToken')"
                                      class="help is-danger">{{ errors.first('AccessToken') }}</span>
                            </div>
                            <button @click="validateBeforeSubmit()" type="button" class="btn btn-primary">Add Token
                            </button>
                            <button type="button" class="btn btn-fb"><i class="fab fa-facebook-f pr-1"></i> Facebook</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    //isDisplay = 1 (show), = 0 (hidden)
    export default {
        data() {
            return {
                name: '',
                accesstoken: '',
                noti: '',
                isDisplay: 0,
                totalUser: 0,
                totalPostLike: 0
            }

        },
        created() {
            this.getTotalUser();
            this.getTotalPostliked();
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validate().then((result) => {
                    if (result) {
                        this.addNewAccountFb();
                    }

                });
            },
            addNewAccountFb() {
                axios.post('account/add', {
                    name: this.name,
                    accesstoken: this.accesstoken
                }).then(response => {
                    if (response.data.code == 200) {
                        this.noti = 'Add new account success !';
                        this.isDisplay = 1;
                    }
                }).catch(error => {
                    this.noti = error.response.data;
                });
                this.emptyFormData();
                this.getTotalUser();
            },
            getTotalUser() {
                axios.get('account/get-total')
                    .then(response => {
                        if (response.data.code == 200) {
                            this.totalUser = response.data.total;
                        }
                    }).catch(error => {
                    console.log(error);
                });
            },
            getTotalPostliked() {
                axios.get('post/get-total')
                    .then(response => {
                        if (response.data.code == 200) {
                            this.totalPostLike = response.data.totalPost;
                        }
                    }).catch(error => {
                    console.log(error);
                });
            },
            emptyFormData() {
                this.name = '';
                this.accesstoken = '';
            }
        }
    }
</script>

<style scoped>
    .is-danger {
        color: red;
    }

    .container {
        padding-right: 0;
        padding-left: 0;
    }
</style>
