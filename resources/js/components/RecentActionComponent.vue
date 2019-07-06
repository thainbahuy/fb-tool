<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Actions</h4>
                </div>
                <div v-if="Object.keys(listActionAccount).length != 0" class="comment-widgets" style="height:430px;">
                    <!-- Comment Row -->
                    <div v-for="(item,key) in listActionAccount[0]" class="d-flex flex-row comment-row m-t-0">
                        <div class="p-2">
                            <img :src="'web/assets/images/users/2.jpg'" alt="user" width="50"
                                 class="rounded-circle">
                        </div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium">{{item.name_account}}</h6>
                            <a target="_blank" class="m-b-15 d-block" :href="'https://facebook.com/'+item.object_id">facebook.com/{{item.object_id}}</a>
<!--                            <span class="m-b-15 d-block">Post Id : {{item.object_id}}</span>-->
                            <div class="comment-footer">
                                <span class="text-muted float-right">{{item.created_at}}</span>
                                <span class="label label-success label-rounded">Liked</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                listActionAccount : [],
                Account :{
                    account_id : '',
                    name_account : '',
                    object_id : '',
                    created_at : '',
                }
            }
        },
        created(){
            //setInterval(()=> this.getListRecentAction() , 3000);
            this.getListRecentAction();
        },
        methods :{
            getListRecentAction (){
                console.log('thuc hien cap nhat');
                this.listActionAccount = [];
                axios.get('api/post/get-list-recent-actions')
                    .then(response => {
                        if (response.data.status == 200) {
                            this.listActionAccount.push(response.data.listAction);
                        }
                    }).catch(error => {
                        console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>
