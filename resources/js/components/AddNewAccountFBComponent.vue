<template>
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
                    <input name="Name" data-vv-validate-on="none" v-validate="{ required: true , min :6 }" type="text" class="form-control"
                           v-model="name" id="InputName" aria-describedby="emailHelp"
                           placeholder="Enter Name Account">
                    <span  v-show="errors.has('Name')" class="help is-danger">{{ errors.first('Name') }}</span>

                </div>
                <div class="form-group row">
                    <label for="InputToken">Access Token:</label>
                    <input name="AccessToken" data-vv-validate-on="none" v-validate="{ required: true, }" type="text" class="form-control"
                           v-model="accesstoken" id="InputToken"
                           placeholder="Enter Access Token">
                    <span v-show="errors.has('AccessToken')"
                          class="help is-danger">{{ errors.first('AccessToken') }}</span>
                </div>
                <button @click="validateBeforeSubmit()" type="button" class="btn btn-primary">Add new Account</button>
            </form>
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
                isDisplay: 0
            }

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
                axios.post('api/account/add', {
                    name: this.name,
                    accesstoken: this.accesstoken
                }).then(response => {
                    if (response.data.status == 200) {
                        this.noti = 'Add new account success !';
                        this.isDisplay = 1;
                    }
                }).catch(error => {
                    this.noti = error.response.data;
                })
                this.emptyFormData();
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
</style>
