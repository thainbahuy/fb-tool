<template>
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <div v-if="isDisplay == 1" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>{{noti}}</strong>
                        </div>
                        <form action="" method="">
                            <div class="form-group row">
                                <label for="email_address"
                                       class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input v-model="username" v-validate="{ required: true}" data-vv-validate-on="none"
                                           type="text" id="email_address" class="form-control" name="username"
                                           autofocus>
                                    <span v-show="errors.has('username')"
                                          class="help is-danger">{{ errors.first('username') }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input v-model="password" v-validate="{ required: true }" data-vv-validate-on="none"
                                           type="password" id="password" class="form-control" name="password">
                                    <span v-show="errors.has('password')"
                                          class="help is-danger">{{ errors.first('password') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button @click="validateBeforeSubmit" type="button" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                username: '',
                password: '',
                noti: '',
                isDisplay: 0,
            }
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validate().then((result) => {
                    if (result) {
                        this.loginInto();
                    }

                });
            },

            loginInto() {
                axios.post('api/authentication/login',
                    {
                        username: this.username,
                        password: this.password,
                    }
                ).then(response => {
                        if (response.data.code == 200) {
                            window.location.href = 'http://127.0.0.1:8000/home';
                        }
                    }).catch(error => {
                        this.isDisplay = 1;
                        this.noti = 'Username or Password Incorrect';
                });
            }

        }
    }
</script>

<style scoped>
    .is-danger {
        color: red;
    }
</style>
