
<style scoped>
    .widget-main{
        background: #224079;
    }
    .white-text{
        color: #fff;
    }

    .widget-title{
        color: #224079;
    }
    table th{
        color: #000;
    }
</style>
<template>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> Tr. ID </label>
                    <div class="col-sm-2">
                        <input type="text" id="invoiceNo" class="form-control" v-model="pres.prescription_code" readonly />
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> Date </label>
                    <div class="col-sm-2">
                        <input class="form-control" type="date" v-model="pres.prescription_date"/>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
            <div class="row">

                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">Patient ID </label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input class="form-control" type="text" autocomplete="off" v-model="patient.patient_code"/>
                            <span class="input-group-addon" @click="checkPatient()">Find</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">P. Name </label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" v-model="patient.name" readonly/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">Age </label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" v-model="patient.age" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">Gender </label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" v-model="patient.gender" readonly/>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">Height </label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" v-model="pres.body_height"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">Weight </label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" v-model="pres.body_weight"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">BP </label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" v-model="pres.blood_pressure"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-left: unset; margin-right: unset;">
            <!-- Start Chief Complain -->
            <div class="col-xs-12 col-md-5 col-md-offset-1">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Chief Complain</h4>
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <v-select v-bind:options="complains" placeholder="Select Chief Complain" label="chief_complain" v-model="selectedComplain" @input="complainChange"></v-select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="text" placeholder="Chief Complain" class="form-control" v-model="complain"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> </label>
                                        <div class="col-xs-9">
                                            <button type="submit" class="btn btn-default pull-right" @click="complainCart">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                            <thead>
                                <tr class="">
                                    <th>Sl</th>
                                    <th>Chief Complain</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="display:none;" v-bind:style="{display: cart_complains.length > 0 ? '' : 'none'}">
                                <tr v-for="(complain, sl) in cart_complains" :key="sl">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ complain }}</td>
                                    <td><a href="" v-on:click.prevent="removeComplain(sl)"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Chief Complain -->
            
            <!-- Start Medicine  -->
            <div class="col-xs-12 col-md-5">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Medicine Information</h4>
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <v-select v-bind:options="medicines" placeholder="Select Medicine" label="name" v-model="selectedMedicine"></v-select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-4" style="padding-left: unset;">
                                            <v-select placeholder="Select Doses" v-bind:options="doses_list" label="doses" v-model="selectedDoses" @input="dosesChange"></v-select>
                                        </div>
                                        <div class="col-sm-8" style="padding-left: unset; padding-right: unset;">
                                            <input type="text" placeholder="Doses. (Ex: 1+1+1)" class="form-control" v-model="doses"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-4" style="padding-left: unset;">
                                            <v-select placeholder="Select Duration" v-bind:options="durations" label="duration" v-model="selectedDuration" @input="durationChange"></v-select>
                                        </div>
                                        <div class="col-sm-8" style="padding-left: unset; padding-right: unset;">
                                            <input type="text" placeholder="Duration. (Ex: 7 Days)" class="form-control" v-model="duration"/>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="radio" value="After Meals" v-model="medicine_advice" id="after_meals"> <label class="white-text" for="after_meals">After Meals</label> &nbsp;&nbsp;
                                        <input type="radio" value="Before Meals" v-model="medicine_advice" id="before_meals"> <label class="white-text" for="before_meals">Before Meals</label> 
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-9 col-xs-offset-3">
                                            <button type="submit" class="btn btn-default pull-right" @click="addToCart">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                            <thead>
                                <tr class="">
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Doses</th>
                                    <th>Duration</th>
                                    <th>Advice</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="display:none;" v-bind:style="{display: cart_medicines.length > 0 ? '' : 'none'}">
                                <tr v-for="(product, sl) in cart_medicines" :key="sl">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.doses }}</td>
                                    <td>{{ product.duration }}</td>
                                    <td>{{ product.advice }}</td>
                                    <td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Medicine -->
        </div>

        <div class="row" style="margin-left: unset; margin-right: unset;">
            <!-- Start Test  -->
            <div class="col-xs-12 col-md-5 col-md-offset-1">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Test/Investigation</h4>
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <v-select placeholder="Select Test" v-bind:options="tests" label="name" v-model="selectedTest" @input="testChange"></v-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                            <thead>
                                <tr class="">
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="display:none;" v-bind:style="{display: cart_tests.length > 0 ? '' : 'none'}">
                                <tr v-for="(test, sl) in cart_tests" :key="sl">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ test.name }}</td>
                                    <td><a href="" v-on:click.prevent="removeTest(sl)"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Test -->

            <!-- Start Advice -->
            <div class="col-xs-12 col-md-5">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Advice</h4>
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <v-select v-bind:options="advices" placeholder="Select Advice" label="advice" v-model="selectedAdvice" @input="adviceChange"></v-select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="text" placeholder="Advice" class="form-control" v-model="advice"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> </label>
                                        <div class="col-xs-9">
                                            <button type="submit" class="btn btn-default pull-right" @click="adviceCart">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                            <thead>
                                <tr class="">
                                    <th>Sl</th>
                                    <th>Advice</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="display:none;" v-bind:style="{display: cart_advices.length > 0 ? '' : 'none'}">
                                <tr v-for="(advice, sl) in cart_advices" :key="sl">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ advice }}</td>
                                    <td><a href="" v-on:click.prevent="removeAdvice(sl)"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Chief Complain -->
        </div>

        <div class="col-md-12">
            <h3>Remark</h3>
            <textarea v-model="pres.remark" style="width: 100%"></textarea>
            <button type="submit" class="btn btn-default pull-right" :disabled="progress ? true : false" @click="save">Save</button>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
export default {
    props: ['code', 'id'],
    data () {
        return {
            pres:{
                id               : '',
                prescription_code: '',
                prescription_date: moment().format('YYYY-MM-DD'),
                remark           : '',
                blood_pressure   : '',
                body_weight      : '',
                body_height      : '',
            },
            patient: {
                id          : '',
                patient_code: '',
                name        : '',
                age         : '',
                gender      : '',
            },

            complains       : [],
            selectedComplain: null,
            complain        : '',
            cart_complains  : [],

            advices       : [],
            selectedAdvice: null,
            advice        : '',
            cart_advices  : [],

            tests       : [],
            selectedTest: null,
            cart_tests  : [],

            doses_list   : [],
            selectedDoses: null,

            durations       : [],
            selectedDuration: null,

            medicines       : [],
            selectedMedicine: null,
            doses           : '',
            duration        : '',
            medicine_advice : '',
            cart_medicines  : [],
            progress        : false,
        }
    },
    created(){
        this.pres.id = this.id;
        this.pres.prescription_code = this.code;
        if(this.id != 0){
            this.getPrescription();
        }
        this.getChiefComplains();
        this.getAdvices();
        this.getTests();
        this.getMedicines();
        this.getDoses();
        this.getDurations();
    },
    methods: {
        getPrescription(){
            axios.post('/get_prescriptions', {id: this.id, with_details: true}).then(res=>{
                let prescription = res.data[0];

                this.pres.prescription_date = prescription.prescription_date;
                this.pres.remark            = prescription.remark;
                this.pres.blood_pressure    = prescription.blood_pressure;
                this.pres.body_weight       = prescription.body_weight;
                this.pres.body_height       = prescription.body_height;

                this.patient = {
                    id          : prescription.patient_id,
                    patient_code: prescription.patient_code,
                    name        : prescription.patient_name,
                    age         : prescription.patient_age,
                    gender      : prescription.patient_gender,
                }

                prescription.chief_complains.forEach(item => {
                    this.cart_complains.push(item.chief_complain);
                })

                prescription.advices.forEach(item => {
                    this.cart_advices.push(item.advice);
                })

                prescription.tests.forEach(item => {
                    let cart = {
                        id: item.test_id,
                        name: item.test_name
                    }
                    this.cart_tests.push(cart);
                })

                prescription.medicines.forEach(item => {
                    let cart = {
                        id      : item.medicine_id,
                        name    : item.medicine_name,
                        doses   : item.doses,
                        duration: item.duration,
                        advice  : item.advice,
                    }
                    this.cart_medicines.push(cart);
                })
            })
        },
        getDoses(){
            axios.get('/get_doses').then(res=>{
                this.doses_list = res.data;
            })
        },
        getDurations(){
            axios.get('/get_durations').then(res=>{
                this.durations = res.data;
            })
        },
        dosesChange(){
            if(this.selectedDoses != null){
                this.doses = this.selectedDoses.doses;
            }
        },
        durationChange(){
            if(this.selectedDuration != null){
                this.duration = this.selectedDuration.duration;
            }
        },
        getMedicines(){
            axios.get('/get_medicines').then(res=>{
                this.medicines = res.data;
            })
        },
        removeFromCart(sl){
            this.cart_medicines.splice(sl, 1);
        },
        addToCart(){
            if(this.selectedMedicine == null){
                alert('select medicine');
                return;
            }

            if(this.doses == ''){
                alert('doses required');
                return;
            }

            let medicine = {
                id      : this.selectedMedicine.id,
                name    : this.selectedMedicine.name,
                doses   : this.doses,
                duration: this.duration,
                advice  : this.medicine_advice,
            }

            let cartInd = this.cart_medicines.findIndex(p => p.id == medicine.id);
            if(cartInd > -1){
                alert('Already exist in cart');
                return;
            }

            this.cart_medicines.unshift(medicine);

            this.selectedMedicine = null;
            this.selectedDoses    = null;
            this.selectedDuration = null;
            this.doses            = '';
            this.duration         = '';
            this.medicine_advice  = '';
        },
        getChiefComplains(){
            axios.get('/get_cheif_complains').then(res=>{
                this.complains = res.data;
            })
        },
        complainChange(){
            if(this.selectedComplain != null){
                this.complain = this.selectedComplain.chief_complain;
            }
        },
        complainCart(){
            if(this.complain == ''){
                alert('chief complain required');
                return;
            }

            this.cart_complains.unshift(this.complain);

            this.complain         = '';
            this.selectedComplain = null;
        },
        removeComplain(sl){
            this.cart_complains.splice(sl, 1);
        },
        getAdvices(){
            axios.get('/get_advices').then(res=>{
                this.advices = res.data;
            })
        },
        adviceChange(){
            if(this.selectedAdvice != null){
                this.advice = this.selectedAdvice.advice;
            }
        },
        adviceCart(){
            if(this.advice == ''){
                alert('advice required');
                return;
            }

            this.cart_advices.unshift(this.advice);

            this.advice         = '';
            this.selectedAdvice = null;
        },
        removeAdvice(sl){
            this.cart_advices.splice(sl, 1);
        },
        getTests(){
            axios.get('/get_tests').then(res=>{
                this.tests = res.data;
            })
        },
        testChange(){
            if(this.selectedTest != null){
                let test ={
                    id: this.selectedTest.id,
                    name: this.selectedTest.name
                }
                let cartInd = this.cart_tests.findIndex(p => p.id == test.id);
                if(cartInd > -1){
                    alert('Already exist in cart');
                    return;
                }

                this.cart_tests.unshift(test);
            }
        },
        removeTest(ind){
            this.cart_tests.splice(ind, 1);
        },
        checkPatient(){
            if(this.patient.patient_code == ''){
                alert('Patient ID required');
                return;
            }

            axios.post('/get_patients', {patient_code: this.patient.patient_code}).then(res=>{
                let r = res.data;

                if(r.length == 0){
                    Swal.fire({
                        icon: 'warning',
                        title: 'No patient found!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.patient.id     = '';
                    this.patient.name   = '';
                    this.patient.age    = '';
                    this.patient.gender = '';
                }else{
                    this.patient = r[0]
                }
            })
        },
        save(){
            if(this.patient.id == ''){
                alert('Patient Required');
                return;
            }

            let data = {
                prescription  : this.pres,
                patient       : this.patient,
                cart_advices  : this.cart_advices,
                cart_complains: this.cart_complains,
                cart_tests    : this.cart_tests,
                cart_medicines: this.cart_medicines,
            }

            let url = '/prescription-store';

            if(this.pres.id != 0){
                url = '/prescription-update';
            }
            this.progress = true;
            axios.post(url, data).then(async res=>{
                let conf = confirm('Prescribed, Do you want to view prescription?');
                if(conf){
                    window.open('/prescription_invoice/'+res.data.id, '_blank');
                    await new Promise(r => setTimeout(r, 1000));
                }

                window.location = '/prescription';
                
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
        }
    }
}
</script>