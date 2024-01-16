
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Bank Account Information</h4>
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
                                    <div class="col-sm-5 col-md-offset-1">
                                        
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Account Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Account Name" name="name" class="form-control" v-model="bankaccount.account_name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Account No. </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Account No." name="name" class="form-control" v-model="bankaccount.account_number" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Account Type </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Account Type" name="name" class="form-control" v-model="bankaccount.account_type" />
                                            </div>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="col-sm-5">
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Bank Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Bank Name" name="name" class="form-control" v-model="bankaccount.bank_name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Branch Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Branch Name" name="name" class="form-control" v-model="bankaccount.branch_name" />
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Remarks </label>
                                            <div class="col-xs-9">
                                                <textarea name="Remarks" id="" class="form-control" cols="5" rows="3" v-model="bankaccount.remark" placeholder="Remarks"></textarea>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="bankaccounts" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.account_name }}</td>
                                <td>{{ row.account_number }}</td>
                                <td>{{ row.account_type }}</td>
                                <td>{{ row.bank_name }}</td>
                                <td>{{ row.branch_name }}</td>
                                <td>{{ row.remark }}</td>
                              
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editBnakAccount(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteBankAccount(row.id)">
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
            bankaccount: {
                id            : '',
                account_name  : '',
                account_number: '',
                account_type  : '',
                bank_name     : '',
                branch_name   : '',
                remark        : '',
            },

            bankaccounts: [],
            columns     : [
                { label: 'S/L No.', field: 'sl_no', align: 'center'},
                { label: 'Account Name', field: 'account_name', align: 'center' },
                { label: 'Account Number', field: 'account_number', align: 'center' },
                { label: 'Account Type', field: 'account_type', align: 'center' },
                { label: 'Bank Name', field: 'bank_name', align: 'center' },
                { label: 'Branch Name', field: 'branch_name', align: 'center' },
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
        this.getBankAccount();
    },
    methods: {
        
        getBankAccount(){
            axios.get('/get_bankaccounts').then(res=>{
                this.bankaccounts = res.data;
            })
        },
      


        save(){

            this.progress = true;

            let url = '/store-bankaccount';

            if(this.bankaccount.id != ''){
                url = '/update-bankaccount';
            }

            let fd = new FormData();
            fd.append('bankaccounts', JSON.stringify(this.bankaccount));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getBankAccount();
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
            this.bankaccount = {
                id          : '',
                account_name  : '',
                account_number: '',
                account_type  : '',
                bank_name     : '',
                branch_name   : '',
                remark      : ''
            };
        },
        
     
        editBnakAccount(row){
            this.bankaccount = {
                id            : row.id,
                account_name  : row.account_name,
                account_number: row.account_number,
                account_type  : row.account_type,
                bank_name     : row.bank_name,
                branch_name   : row.branch_name,
                remark        : row.remark,
            }

        },
        deleteBankAccount(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-bankaccount', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getBankAccount();
                        
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