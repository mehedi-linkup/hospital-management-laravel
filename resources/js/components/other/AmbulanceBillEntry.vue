<style scoped>

#brandImage {
		height: 100%;
		width: 100%;
	}
    #driver .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 30px;
        margin-left: 50px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#driver .custom-file-upload:hover{
		background-color: #41add6;
	}
    #driver .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 20px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#driver .custom-file-upload:hover{
		background-color: #41add6;
	}
    #driver input[type="file"] {
		display: none;
	}
    #driverImage{
		height: 100%;
	}


</style>
<template>
    <div id="driver">
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-10 col-md-10 col-lg-10 col-md-offset-1">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Ambulance Bill  Information</h4>
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
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Invoice No. </label>
                                            <div class="col-xs-9">
                                                <input type="text" name="employee_code" class="form-control" v-model="ambulancebill.invoice_number" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Date </label>
                                            <div class="col-xs-9">
                                                <input type="date" placeholder="Name" name="name" class="form-control" v-on:input="getAmulanceBill" v-model="ambulancebill.bill_date" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Driver </label>
                                            <div class="col-xs-8">
                                                <v-select :options="drivers"  label="display_name" v-model="selectedDriver" @input="getAmbulacne()"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -5px;">
                                                <a href="/driver_entry" target="_blank" class="add-button" style="width:32px;"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Ambulance </label>
                                            <div class="col-xs-8">
                                                <v-select :options="filterambulances"  label="display_text" v-model="selectedAmbulance"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -5px;">
                                                <a href="/ambulance_entry" target="_blank" class="add-button" style="width:32px;"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Patient </label>
                                            <div class="col-xs-8">
                                                <v-select :options="patients"  label="display_name" v-model="selectedPatient"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -5px;">
                                                <a href="/patient_entry" target="_blank" class="add-button" style="width:32px;"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Bill Amount </label>
                                            <div class="col-xs-9">
                                                <input type="number" step="any" placeholder="Amount"  class="form-control" v-on:input="calculateTotalDue" v-model="ambulancebill.bill_amount" />
                                            </div>
                                            
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Paid </label>
                                            <div class="col-xs-9">
                                                <input type="number" step="any" placeholder="Paid" class="form-control" v-on:input="calculateTotalDue" v-model="ambulancebill.paid" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Due </label>
                                            <div class="col-xs-9">
                                                <input type="number" step="any" placeholder="Due" readonly class="form-control" v-model="ambulancebill.due" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Destination </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Destination" class="form-control" v-model="ambulancebill.destination" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Note </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Note" class="form-control" v-model="ambulancebill.remark" />
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="ambulancebills" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.invoice_number }}</td>
                                <td>{{ row.bill_date }}</td>
                                <td>{{ row.driver_name }}</td>
                                <td>{{ row.ambulance_name }}</td>
                                <td>{{ row.patient_name }}</td>
                                <td>{{ row.bill_amount }}</td>
                                <td>{{ row.paid }}</td>
                                <td>{{ row.due }}</td>
                                <td>{{ row.destination }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <a href="" title="Purchase Bill Invoice" v-bind:href="'/ambulancebill_invoice_print/'+ row.id" target="_blank"><i class="fa fa-file-text"></i></a>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editAmbulanceBill(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteAmbulanceBill(row.id)">
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
    props: ['role','id','code'],
    data () {
        return {
            ambulancebill: {
                id            : '',
                invoice_number: '',
                bill_date     : moment().format('YYYY-MM-DD'),
                driver_id     : '',
                ambulance_id  : '',
                patient_id    : '',
                bill_amount   : 0,
                paid          : 0,
                due           : 0,
                destination   : '',
                remark        : '',
            },
            filterambulances: [],
            ambulancebills: [],
            selectedDriver: null,
            drivers       : [],
            selectedAmbulance: null,
            ambulances       : [],
            selectedPatient: null,
            patients       : [],
            columns       : [
                { label: 'Invoice No.', field: 'invoice_number', align: 'center'},
                { label: 'Bill Date', field: 'bill_date', align: 'center' },
                { label: 'Driver', field: 'driver_name', align: 'center' },
                { label: 'Ambulance', field: 'ambulance_name', align: 'center' },
                { label: 'Patient Name', field: 'patient_name', align: 'center' },
                { label: 'Bill Amount', field: 'bill_amount', align: 'center' },
                { label: 'Paid', field: 'paid', align: 'center' },
                { label: 'Due', field: 'due', align: 'center' },
                { label: 'Destination', field: 'destination', align: 'center' },
                { label: 'Remarks', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
    watch: {
        selectedDriver(drivers) {
				if (drivers == undefined) return;
				let ambulance = this.ambulances.filter(item => item.driver_id == drivers.id)
                    this.filterambulances = ambulance;
			}        
        },
    created(){
        this.ambulancebill.invoice_number = this.code;
        this.getDriver();
        //this.getAmbulacne();
        this.getPatient();
        this.getAmulanceBill();
    },
    methods: {
        
        getAmulanceBill(){
            axios.post('/get_ambulancesbill',{date:this.ambulancebill.bill_date}).then(res=>{
                this.ambulancebills = res.data;
            })
        },
        getDriver(){
            axios.get('/get_drivers').then(res=>{
                this.drivers = res.data;
            })
        },
        getAmbulacne(){
            this.ambulances   = [];
            this.selectedAmbulance= null;
            if(this.selectedDriver !=null){
                axios.post('/get_ambulances',{driverId:this.selectedDriver.id}).then(res=>{
                    this.ambulances = res.data;
                    this.filterambulances = res.data;
                })
            }
        },
        getPatient(){
            axios.get('/get_patients').then(res=>{
                this.patients = res.data;
            })
        },

        calculateTotalDue(){
				this.ambulancebill.due =  (+this.ambulancebill.bill_amount - +this.ambulancebill.paid).toFixed(2);
		},

        save(){
            if(this.selectedDriver ==null){
                alert('Select Driver');
                return;
            }

            if(this.selectedAmbulance ==null){
                alert('Select Ambulance');
                return;
            }
            if(this.selectedPatient == null){
                alert('Select Patient');
                 return;
            }

            this.progress = true

            this.ambulancebill.driver_id = this.selectedDriver.id;
            this.ambulancebill.ambulance_id = this.selectedAmbulance.id;
            this.ambulancebill.patient_id = this.selectedPatient.id;

            let url = '/store-ambulance-bill';

            if(this.ambulancebill.id != ''){
                url = '/update-ambulance-bill';
            }
            let data = {
                ambulancebill: this.ambulancebill
				}
            axios.post(url, data).then(async res=>{

                let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/ambulancebill_invoice_print/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/ambulance_bill';
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
            this.selectedDriver =null;
            this.selectedAmbulance = null;
            this.selectedPatient = null;

            this.ambulancebill = {
                id            : '',
                bill_date     : '',
                invoice_number: '',
                driver_id     : '',
                ambulance_id  : '',
                patient_id    : '',
                bill_amount   : 0,
                paid          : 0,
                due           : 0,
                destination   : '',
                remark        : '',
            }
        },
        
     
        editAmbulanceBill(row){
           
            this.selectedDriver = {
                id          : row.driver_id,
                display_name: row.driver_name,
            }
            this.selectedAmbulance = {
                id          : row.ambulance_id,
                display_text: row.ambulance_name,
            }
            this.selectedPatient = {
                id          : row.patient_id,
                display_name: row.patient_name,
            }


            this.ambulancebill = {
                id            : row.id,
                invoice_number: row.invoice_number,
                bill_date     : row.bill_date,
                driver_id     : row.driver_id,
                ambulance_id  : row.ambulance_id,
                patient_id    : row.patient_id,
                bill_amount   : row.bill_amount,
                paid          : row.paid,
                due           : row.due,
                destination   : row.destination,
                remark        : row.remark,
            }

        },
        deleteAmbulanceBill(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-ambulance-bill', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.ambulancebill.invoice_number = this.code;
                        this.getDriver();
                        this.getPatient();
                        this.getAmulanceBill();
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