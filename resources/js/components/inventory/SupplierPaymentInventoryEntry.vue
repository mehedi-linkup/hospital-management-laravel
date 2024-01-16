<style scoped>
  
    .no-padding-right{
        padding: 0px !important;
    }
    .widget-box{
        border: 0px solid #fff !important;
    }
    .widget-header{
        min-height: 26px !important; 
        background: #146C94 !important; 
        color:aliceblue !important; 
        font-weight: bolder !important;
    }
    .widget-title{
        line-height: 25px !important;
    }
    .widget-body{
        padding: 6px !important;
        background-color: #FFF !important;
        border-bottom: 1px solid gray !important;
        border-left: 1px solid gray !important;
        border-right: 1px solid gray !important;
        margin-top: 0px !important;
    }
</style>
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-10 col-md-offset-1">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h5 class="widget-title">Supplier Payment Information</h5>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Transaction No. </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Transaction No." class="form-control" v-model="supplierpayment.transaction_number" readonly/>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Payment Type </label>
                                            <div class="col-xs-8">
                                                        <select class="form-control" v-model="supplierpayment.payment_type" required>
                                                            <option value="Cash">Cash</option>
                                                            <option value="Bank">Bank</option>
                                                        </select>
                                            </div>
                                            </div>
                                            <div class="form-group row" style="display:none;" v-bind:style="{display: supplierpayment.payment_type == 'Bank' ? '' : 'none'}">
                                                    <label class="col-xs-4 control-label no-padding-right">Bank Account</label>
                                                    <div class="col-xs-7">
                                                        <v-select v-bind:options="bankaccounts" class="select"  v-model="selectedBankAccount" label="display_name" placeholder="Select account"></v-select>
                                                    </div>
                                                    <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                        <a href="/bank_account_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                                    </div>
                                            </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Supplier </label>
                                            <div class="col-xs-7">
                                                <v-select :options="suppliers" class="select" v-model="selectedSupplier" label="display_name" v-on:input="onChangeSupplier"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                        <a href="/supplier_inventory_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Transaction Type </label>
                                            <div class="col-xs-8">
                                                <select class="form-control"  v-model="supplierpayment.transaction_type">
                                                    <option value="Received">Received</option>
                                                    <option value="Payment" selected>Payment</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Due </label>
                                            <div class="col-xs-8">
                                                <input type="number" step="any" placeholder="Due"  class="form-control" v-model="supplierpayment.previous_due" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Date </label>
                                            <div class="col-xs-9">
                                                <input type="date" placeholder="Transaction Date" class="form-control" v-model="supplierpayment.payment_date" @change="getSupplierPaymentTransaction()" />
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Note </label>
                                            <div class="col-xs-9">
                                                <textarea name="Remarks" id="" class="form-control" cols="5" rows="2" v-model="supplierpayment.remark" placeholder="Remarks"></textarea>
                                            </div>
                                        </div>
                                          <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Amount </label>
                                            <div class="col-xs-9">
                                                <input type="number" step="any" placeholder="Amount"  class="form-control" v-model="supplierpayment.amount" />
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="supplierpayments" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.payment_date }}</td>
                                <td>{{ row.transaction_number }}</td>
                                <td>{{ row.supplier_text }}</td>
                                <td>{{ row.payment_type }}</td>
                                <td>
                                    <span v-if="row.display_text == ''"> N/A  </span>
                                    <span v-else>  {{ row.display_text}} </span>
                                </td>
                                <td>{{ row.transaction_type }}</td>
                                <td>{{ row.amount }}</td>
                                <td>{{ row.remark }}</td>
                              
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editSupplierPayment(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteSupplierPayment(row.id)">
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
            supplierpayment: {
                id                : '',
                transaction_number: '',
                account_id        : '',
                supplier_id       : '',
                payment_date      : moment().format('YYYY-MM-DD'),
                transaction_type  : 'Payment',
                payment_type      : 'Cash',
                amount            : 0,
                previous_due      : 0,
                remark            : '',
            },

            supplierpayments: [],
            bankaccounts: [],
            selectedBankAccount: null,
            suppliers: [],
            selectedSupplier: null,
            columns     : [
                { label: 'S/L No.', field: 'sl_no', align: 'center'},
                { label: 'Transaction date', field: 'payment_date', align: 'center' },
                { label: 'Transaction number', field: 'transaction_number', align: 'center' },
                { label: 'Supplier', field: 'supplier_text', align: 'center' },
                { label: 'Payment Type', field: 'payment_type', align: 'center' },
                { label: 'Account Name', field: 'display_text', align: 'center' },
                { label: 'Transaction Type', field: 'transaction_type', align: 'center' },
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
        this.getBankAccount();
        this.getSuppliers();
        this.getSupplierPaymentTransaction();
        this.getSupplierPaymentTransactionCode();
    },
    methods: {
        
        getBankAccount(){
            axios.get('/get_bankaccounts').then(res=>{
                this.bankaccounts = res.data;
            })
        },
        getSuppliers(){
            axios.get('/get_supplierinventorys').then(res=>{
                this.suppliers = res.data;
            })
        },

        onChangeSupplier(){

				axios.post('/get_supplier_due', {supplierId: this.selectedSupplier.id}).then(res => {
					if(res.data.getDues.length > 0){
						this.supplierpayment.previous_due = res.data.getDues[0].dueAmount;
					} else {
						this.supplierpayment.previous_due = 0;
					}
				})

			},
      
        getSupplierPaymentTransaction(){
            axios.post('/get_supplierpaymentinventorys',{date: this.supplierpayment.payment_date}).then(res=>{
                this.supplierpayments = res.data;
            })
        },
        getSupplierPaymentTransactionCode(){
            axios.get('/get_supplier_payment_inventory_code').then(res=>{
                this.supplierpayment.transaction_number = res.data;
            })
        },

        save(){

            if(this.selectedSupplier == null){
                alert('Select Supplier');
                return;
            }
            if(this.supplierpayment.previous_due < this.supplierpayment.amount || this.supplierpayment.amount==0){
                alert('Please Amount is over due OR Zero Amount');
                return;
            }

            this.progress = true;

            if(this.supplierpayment.payment_type == 'Cash'){

                this.supplierpayment.account_id  = null;
            }else{
                this.supplierpayment.account_id  = this.selectedBankAccount.id;
            }


            this.supplierpayment.supplier_id = this.selectedSupplier.id;

            let url = '/store-supplierpayment';
            if(this.supplierpayment.id != ''){
                url = '/update-supplierpayment';
            }
            let data = {
                supplierpayment: this.supplierpayment
			}
            
            axios.post(url, data).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getSuppliers();
                this.getBankAccount();
                this.getSupplierPaymentTransaction();
                this.getSupplierPaymentTransactionCode();
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
            this.supplierpayment = {
                 id                : '',
                 transaction_number: '',
                 account_id        : '',
                 payment_date      : moment().format('YYYY-MM-DD'),
                 transaction_type  : 'Payment',
                 amount            : 0,
                 previous_due      : 0,
                 remark            : '',
            };
            this.bankaccounts        = [];
            this.selectedBankAccount = null;
            this.selectedSupplier    = null;
        },
        
     
        editSupplierPayment(row){
            this.supplierpayment = {
                id                : row.id,
                transaction_number: row.transaction_number,
                supplier_id       : row.supplier_id,
                account_id        : row.account_id,
                payment_date      : row.payment_date,
                payment_type      : row.payment_type,
                transaction_type  : row.transaction_type,
                amount            : row.amount,
                previous_due      : row.previous_due,
                remark            : row.remark,
            }

            this.selectedBankAccount = {
                id          : row.account_id,
                display_name: row.display_text,
            }
            this.selectedSupplier = {
                id          : row.supplier_id,
                display_name: row.supplier_text,
            }

        },
        deleteSupplierPayment(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                customClass: 'swal-wide',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-supplierpayment', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getSuppliers();
                        this.getBankAccount();
                        this.getSupplierPaymentTransaction();
                        this.getSupplierPaymentTransactionCode();
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