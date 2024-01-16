<template>
    <div>
        <form @submit.prevent="saveMonth">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Name:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="month.name" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-7 col-md-offset-4">
                            <input type="submit" class="btn btn-success btn-sm" value="Save">
                        </div>
                    </div>
                </div>	
            </div>
        </form>

        <div class="row">
            <div class="col-sm-12 form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter">
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="months" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.name }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editMonth(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteMonth(row.id)">
                                            <i class="ace-icon fa fa-trash bigger-130"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </datatable>
                    <datatable-pager class="datatable-pagination" v-model="page" type="abbreviated"></datatable-pager>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
export default {
    props: ['role'],
    data () {
        return {
            month: {
                id                : '',
                name              : ''
            },
            months: [],

            columns: [
                { label: 'SL No', field: 'sl', align: 'center'},
                { label: 'Name', field: 'name', align: 'center'},
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getMonths();
    },
    methods: {
        clearForm(){
            this.month = {
                id                : '',
                name              : ''
            }
        },
        getMonths(){
            axios.get('/get_months').then(res=>{
                this.months = res.data;
            })
        },
        saveMonth(){

            let url = '/store-month';
            if(this.month.id != ''){
                url = '/update-month';
            }

            axios.post(url, this.month).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getMonths();
                this.clearForm();
            }).catch(error => {
                let e = error.response.data;
                if(e.hasOwnProperty('message')){
                    if(e.hasOwnProperty('errors')){
                        Object.entries(e.errors).forEach(([key, val])=>{
                            this.$toaster.error(val[0]);
                        })
                    }else{
                        this.$toaster.error(e.message);
                    }
                }else{
                    this.$toaster.error(e);
                }
            })
        },
        editMonth(row){
            this.month = {
                id                : row.id,
                name              : row.name
            }
        },
        deleteMonth(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-month', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getMonths();
                        
                    }).catch(error => {
                        let e = error.response.data;

                        if(e.hasOwnProperty('message')){
                            if(e.hasOwnProperty('errors')){
                                Object.entries(e.errors).forEach(([key, val])=>{
                                    this.$toaster.error(val[0]);
                                })
                            }else{
                                this.$toaster.error(e.message);
                            }
                        }else{
                            this.$toaster.error(e);
                        }
                    })
                }
            })
        }
    }
}
</script>