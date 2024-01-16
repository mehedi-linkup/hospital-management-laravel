
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Account Information</h4>
                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                                <a href="#" data-action="close">
                                    <i class="ace-icon fa fa-times"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-sm-6 col-md-offset-3">
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Account Id </label>
                                            <div class="col-xs-9">
                                                <input type="text" name="employee_code" class="form-control" v-model="account.account_code" readonly />
                                            </div>
                                            
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Account Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Name" name="name" class="form-control" v-model="account.account_name" />
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Remarks </label>
                                            <div class="col-xs-9">
                                                <textarea name="Remarks" id="" class="form-control" cols="5" rows="3" v-model="account.remark" placeholder="Remarks"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xs-4 col-xs-offset-8">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary btn-sm"
                                                    value="Save"
                                                    v-bind:disabled="progress ? true : false"
                                                    style="color: #fff !important; margin-top: 0px; width: 100%; padding: 5px; font-weight: bold;"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br />
        <div class="row">
            <div class="col-sm-12 form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="accounts" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.account_code }}</td>
                                <td>{{ row.account_name }}</td>
                                <td>{{ row.remark }}</td>
                              
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editAccount(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteAccount(row.id)">
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
            account: {
                id          : '',
                account_code: '',
                account_name: '',
                remark      : '',
            },

            accounts     : [],
            columns     : [
                { label: 'S/L No.', field: 'sl_no', align: 'center'},
                { label: 'Account Id', field: 'account_code', align: 'center'},
                { label: 'Account Name', field: 'account_name', align: 'center' },
                { label: 'Remarks', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
   
    created(){
        this.getAccountCode();
        this.getAccount();
    },
    methods: {
        
        getAccount(){
            axios.get('/get_accounts').then(res=>{
                this.accounts = res.data;
            })
        },
        getAccountCode(){
            axios.get('/get_account_code').then(res=>{
                this.account.account_code = res.data;
            })
        },
       


        save(){

            this.progress = true;

            let url = '/store-account';

            if(this.account.id != ''){
                url = '/update-account';
            }

            let fd = new FormData();
            fd.append('accounts', JSON.stringify(this.account));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getAccount();
                this.getAccountCode();
            }).catch(error=>{
                this.progress = false;
                let e = error.response.data;
                if(e.hasOwnProperty('message')){
                    this.$toaster.error(e.message);
                }else{
                    Object.entries(e).forEach(([key, val])=>{
                        this.$toaster.error(val[0]);
                    })
                }
            })
        },
        clear(){
            this.account = {
                id          : '',
                account_code: '',
                account_name: '',
                remark      : ''
            };
        },
        
     
        editAccount(row){
            this.account = {
                id          : row.id,
                account_code: row.account_code,
                account_name: row.account_name,
                remark      : row.remark,
            }

        },
        deleteAccount(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-account', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getAccountCode();
                        this.getAccount();
                        
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