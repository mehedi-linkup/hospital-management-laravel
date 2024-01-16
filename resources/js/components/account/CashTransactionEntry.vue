
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Cash Transaction Information</h4>
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
                                            <label class="col-xs-4 control-label no-padding-right"> Transaction No. </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Transaction No." class="form-control" v-model="cashtransaction.transaction_number" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Transaction Date </label>
                                            <div class="col-xs-8">
                                                <input type="date" placeholder="Transaction Date" class="form-control" v-model="cashtransaction.transaction_date" @change="getCashTransaction()" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Account </label>
                                            <div class="col-xs-7">
                                                <v-select :options="cashaccounts" v-model="selectedCashAccount" label="display_name"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/account_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Transaction Type </label>
                                            <div class="col-xs-8">
                                                <select class="form-control"  v-model="cashtransaction.transaction_type">
                                                    <option value="Received">Received</option>
                                                    <option value="Payment" selected>Payment</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                         <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Note </label>
                                            <div class="col-xs-9">
                                                <textarea name="Remarks" id="" class="form-control" cols="5" rows="3" v-model="cashtransaction.remark" placeholder="Remarks"></textarea>
                                            </div>
                                        </div>
                                          <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Amount </label>
                                            <div class="col-xs-9">
                                                <input type="number" step="any" placeholder="Amount"  class="form-control" v-model="cashtransaction.amount" />
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="cashtransactions" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.transaction_date }}</td>
                                <td>{{ row.transaction_number }}</td>
                                <td>{{ row.display_text }}</td>
                                <td>{{ row.transaction_type }}</td>
                                <td>{{ row.amount }}</td>
                                <td>{{ row.remark }}</td>
                              
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editCashTransaction(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteCashTransaction(row.id)">
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
            cashtransaction: {
                id                : '',
                transaction_number: '',
                account_id        : '',
                transaction_date  : moment().format('YYYY-MM-DD'),
                transaction_type  : 'Payment',
                amount            : 0,
                remark            : '',
            },

            cashtransactions: [],
            cashaccounts: [],
            selectedCashAccount: null,
            columns     : [
                { label: 'S/L No.', field: 'sl_no', align: 'center'},
                { label: 'Transaction date', field: 'transaction_date', align: 'center' },
                { label: 'Transaction number', field: 'transaction_number', align: 'center' },
                { label: 'Account Name', field: 'display_text', align: 'center' },
                { label: 'Account Type', field: 'transaction_type', align: 'center' },
                { label: 'Amount', field: 'amount', align: 'center' },
                { label: 'Note', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
   
    created(){
        this.getCashAccount();
        this.getCashTransaction();
        this.getCashTransactionCode();
    },
    methods: {
        
        getCashAccount(){
            axios.get('/get_accounts').then(res=>{
                this.cashaccounts = res.data;
            })
        },
      
        getCashTransaction(){
            axios.post('/get_cashtransactions',{date: this.cashtransaction.transaction_date}).then(res=>{
                this.cashtransactions = res.data;
            })
        },
        getCashTransactionCode(){
            axios.get('/get_cash_transaction_code').then(res=>{
                this.cashtransaction.transaction_number = res.data;
            })
        },
      


        save(){
            
            
            if(this.selectedCashAccount == ''){
                alert('Select Account');
                return;
            }
            this.progress = true;

            this.cashtransaction.account_id = this.selectedCashAccount.id;

            let url = '/store-cashtransaction';
            if(this.cashtransaction.id != ''){
                url = '/update-cashtransaction';
            }

            let fd = new FormData();
            fd.append('cashtransactions', JSON.stringify(this.cashtransaction));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getCashAccount();
                this.getCashTransaction();
                this.getCashTransactionCode();
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
            this.cashtransaction = {
                 id                : '',
                 transaction_number: '',
                 account_id        : '',
                 transaction_date  : moment().format('YYYY-MM-DD'),
                 transaction_type  : 'Payment',
                 amount            : 0,
                 remark            : '',
            };
            this.cashaccounts        = [];
            this.selectedCashAccount = null;
        },
        
     
        editCashTransaction(row){
            this.cashtransaction = {
                id                : row.id,
                transaction_number: row.transaction_number,
                transaction_date  : row.transaction_date,
                transaction_type  : row.transaction_type,
                amount            : row.amount,
                remark            : row.remark,
            }

            this.selectedCashAccount = {
                id          : row.account_id,
                display_name: row.display_text,
            }

        },
        deleteCashTransaction(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                customClass: 'swal-wide',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-cashtransaction', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getCashAccount();
                        this.getCashTransaction();
                        this.getCashTransactionCode();
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