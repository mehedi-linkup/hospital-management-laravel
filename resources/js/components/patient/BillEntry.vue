
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Bill Entry</h4>
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
                                                <input type="text" placeholder="Transaction No." class="form-control" v-model="bill.transaction_number" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Bill Date </label>
                                            <div class="col-xs-8">
                                                <input type="date" placeholder="Bill Date" class="form-control" v-model="bill.bill_date" @input="getBills()" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Bill Type </label>
                                            <div class="col-xs-7">
                                                <v-select :options="billtypes" v-model="selectedBilltype" label="name"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/billtype_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Transaction Type </label>
                                            <div class="col-xs-8">
                                                <select class="form-control"  v-model="bill.transaction_type">
                                                    <option value="Bill">Bill</option>
                                                    <option value="Received">Received</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Patient </label>
                                            <div class="col-xs-8">
                                                <v-select :options="patients" v-model="selectedPatient" label="display_name"></v-select>
                                              
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/account_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Amount </label>
                                            <div class="col-xs-9">
                                                <input type="number" step="any" placeholder="Amount"  class="form-control" v-model="bill.amount" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Remark </label>
                                            <div class="col-xs-9">
                                                <textarea name="Remarks" id="" class="form-control" cols="5" rows="3" v-model="bill.remark" placeholder="Remarks"></textarea>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="bills" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.bill_date }}</td>
                                <td>{{ row.transaction_number }}</td>
                                <td>{{ row.patient_display_name }}</td>
                                <td>{{ row.transaction_type }}</td>
                                <td>{{ row.bill_type_name }}</td>
                                <td>{{ row.amount }}</td>
                                <td>{{ row.remark }}</td>
                              
                                <td>
                                    <a href="" title="Bill Invoice" v-bind:href="'/bill_invoice_print/'+ row.id" target="_blank"><i class="fa fa-file-text"></i></a>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editBills(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteBill(row.id)">
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
    props: ['role','code','id'],
    data () {

        return {
            bill: {
                id                : '',
                transaction_number: '',
                account_id        : '',
                bill_type_id      : '',
                patient_id        : '',
                admission_id      : '',
                bill_date         : moment().format('YYYY-MM-DD'),
                transaction_type  : 'Bill',
                amount            : 0,
                remark            : '',
            },
            oldPatientId        : '',
            bills        : [],

            billtypes: [],
            selectedBilltype: null,

            patients: [],
            selectedPatient: null,

            columns     : [
                { label: 'S/L No.', field: 'sl_no', align: 'center'},
                { label: 'Bill date', field: 'bill_date', align: 'center' },
                { label: 'Transaction number', field: 'transaction_number', align: 'center' },
                { label: 'Patient Name', field: 'patient_display_name', align: 'center' },
                { label: 'Transcation Type', field: 'transaction_type', align: 'center' },
                { label: 'Bill Type', field: 'bill_type_name', align: 'center' },
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
        this.bill.transaction_number = this.code;
        this.getPatients();
        this.getBillType();
        this.getBills();
    },
    methods: {
        
        getBillType(){
            axios.get('/get_billtypes').then(res=>{
                this.billtypes = res.data;
            })
        },
      
        getPatients(){
            axios.get('/get_patients').then(res=>{
                this.patients = res.data;
            })
        },
       
      
        getBills(){
            axios.post('/get_bills',{date: this.bill.bill_date}).then(res=>{
                this.bills = res.data;
            })
        },
        save(){
            
            if(this.selectedBilltype == null){
                alert('Select Bill Type');
                return;
            }
            if(this.selectedPatient == null){
                alert('Select Patient');
                return;
            }
            
            
            this.progress = true;

            if(this.admissionType == "Admited"){
                this.bill.admission_id = this.admissionId;
            }else{
                this.bill.admission_id = '';
            }

            this.bill.patient_id = this.selectedPatient.id;
            this.bill.bill_type_id = this.selectedBilltype.id;

            let url = '/store-bill';
            if(this.bill.id != ''){
                url = '/update-bill';
            }

            let fd = new FormData();
            fd.append('bills', JSON.stringify(this.bill));
            axios.post(url, fd).then(async res=>{
                let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/bill_invoice_print/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/bill_entry';
               
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
            this.bill = {
                id                : '',
                transaction_number: '',
                account_id        : '',
                bill_type_id      : '',
                patient_id        : '',
                admission_id      : '',
                bill_date         : moment().format('YYYY-MM-DD'),
                transaction_type  : 'Bill',
                amount            : 0,
                remark            : '',
            };
            this.admissionId      = null;
            this.selectedPatient  = null;
            this.selectedBilltype = null;
        },
        
     
        editBills(row){
            this.bill = {
                id                : row.id,
                transaction_number: row.transaction_number,
                account_id        : row.account_id,
                bill_type_id      : row.bill_type_id,
                admission_id      : row.admission_id,
                bill_date         : row.bill_date,
                transaction_type  : row.transaction_type,
                amount            : row.amount,
                remark            : row.remark,
            }

            this.selectedPatient = {
                id          : row.patient_id,
                display_name: row.patient_display_name
            }
            this.selectedBilltype = {
                id  : row.bill_type_id,
                name: row.bill_type_name
            }
            this.oldPatientId= rom.patient_id;
        },
        deleteBill(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-bill', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.bill.transaction_number = this.code;
                        this.getPatients();
                        this.getBillType();
                        this.getBills();
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