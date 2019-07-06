<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Actions</h4>
                </div>
                <div class="comment-widgets" style="height:430px;">
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row m-t-0">
                        <div class="p-2">
                            <img :src="'web/assets/images/users/2.jpg'" alt="user" width="50"
                                 class="rounded-circle">
                        </div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium">James Anderson</h6>
                            <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                            <div class="comment-footer">
                                <span class="text-muted float-right">April 14, 2016</span>
                                <span class="label label-success label-rounded">Liked</span>

                            </div>
                        </div>
                    </div><!-- Comment Row -->

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
                    name : '',
                    postIdLike : '',
                    time : '',
                }
            }
        },
        methods :{
            getListRecentAction (){

            }
        }
    }
</script>

<style scoped>

</style>
