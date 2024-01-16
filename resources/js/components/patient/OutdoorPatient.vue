
<template>
    <div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Patient Information</h4>
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
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Name </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Name" class="form-control" v-model="patient.name"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Mobile </label>
                                        <div class="col-xs-8">
                                            <input type="text" placeholder="Patient Mobile" class="form-control" v-model="patient.mobile" autocomplete="off" @input="checkPatient()"/>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -15px;">
                                            <a href="javascript:" class="add-button">{{patients.length}}</a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Exists Patients </label>
                                        <div class="col-xs-9">
                                            <v-select :options="patients" label="display_name" v-model="selectedPatient"></v-select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Age </label>
                                        <div class="col-xs-3">
                                            <input type="number" placeholder="Year" step="1" class="form-control" v-model="patient.year" @input="calculateDateOfBirth()"/>
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="number" step="1" placeholder="Month" class="form-control" v-model="patient.month" @input="calculateDateOfBirth()"/>
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="number" step="1" placeholder="Day" class="form-control" v-model="patient.day" @input="calculateDateOfBirth()"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Date of birth </label>
                                        <div class="col-xs-9">
                                            <input type="date" class="form-control" v-model="patient.date_of_birth" @change="calculateAge()"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Gender </label>
                                        <div class="col-xs-9">
                                            <select class="form-control" v-model="patient.gender">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Address </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Address" class="form-control" v-model="patient.address"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Remark </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Remark" class="form-control" v-model="patient.remark"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Appointment Information</h4>
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
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Tr. ID </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Tracking Number" class="form-control" v-model="appointment.token_number" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Serial Number </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Serial Number" class="form-control" v-model="appointment.serial_number" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Apt. Date </label>
                                        <div class="col-xs-5">
                                            <input type="date" class="form-control" v-model="appointment.appointment_date" @change="aptDateChange()"/>
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="time" class="form-control" v-model="appointment.appointment_time"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Doctor </label>
                                        <div class="col-xs-8">
                                            <v-select :options="doctors" label="display_name" v-model="selectedDoctor"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -15px;">
                                            <a href="/doctor_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Fees </label>
                                        <div class="col-xs-9">
                                            <input type="number" step="1" class="form-control" v-model="appointment.fees"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Reference </label>
                                        <div class="col-xs-8">
                                            <v-select :options="references" label="display_name" v-model="selectedReference"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -15px;">
                                            <a href="/agent_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Remark </label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" v-model="appointment.remark"/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <div class="col-xs-4 col-xs-offset-8">
                                            <input type="button" class="btn btn-primary btn-sm" value="Save" v-on:click="save" v-bind:disabled="progress ? true : false" style="color: #fff!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter">
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="appointments" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.token_number }}</td>
                                <td>{{ row.appointment_date }}</td>
                                <td>{{ row.appointment_time }}</td>
                                <td>{{ row.serial_number }}</td>
                                <td>{{ row.patient_name }}</td>
                                <td>{{ row.patient_mobile }}</td>
                                <td>{{ row.patient_age }}</td>
                                <td>{{ row.patient_gender }}</td>
                                <td>{{ row.doctor_display_name }}</td>
                                <td>{{ row.fees }}</td>
                                <td>{{ row.reference_display_name }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <a target="_blank" :href="'/appointment_token/'+row.id" title="Token">
                                        <i class="ace-icon fa fa-file bigger-130"></i>
                                    </a>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editAppointment(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteAppointment(row.id)">
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
            appointment: {
                id                          : '',
                token_number                : '',
                appointment_date            : moment().format('YYYY-MM-DD'),
                appointment_time            : moment().format('HH:mm'),
                serial_number               : '',
                fees                        : '',
                remark                      : '',
            },
            patient: {
                id           : '',
                name         : '',
                patient_code : '',
                mobile       : '',
                gender       : '',
                address      : '',
                remark       : '',
                date_of_birth: '',
                year         : '',
                month        : '',
                day          : '',
            },

            patients       : [],
            selectedPatient: null,

            doctors       : [],
            selectedDoctor: null,

            references       : [],
            selectedReference: null,

            appointments: [],
            columns: [
                { label: 'Tr. ID', field: 'token_number', align: 'center'},
                { label: 'Date', field: 'appointment_date', align: 'center' },
                { label: 'Time', field: 'appointment_time', align: 'center' },
                { label: 'Sl. No', field: 'serial_number', align: 'center' },
                { label: 'Name', field: 'patient_name', align: 'center' },
                { label: 'Mobile', field: 'patient_mobile', align: 'center' },
                { label: 'Age', field: 'patient_age', align: 'center' },
                { label: 'Gender', field: 'patient_gender', align: 'center' },
                { label: 'Doctor', field: 'doctor_display_name', align: 'center' },
                { label: 'Fees', field: 'fees', align: 'center' },
                { label: 'Reference', field: 'reference_display_name', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false,
            update_process: false,
        }
    },
    watch: {
        selectedPatient(p){
            this.clearPatient();
            if(p != null){
                this.patient = {
                    id           : p.id,
                    name         : p.name,
                    mobile       : p.mobile,
                    patient_code : p.patient_code,
                    gender       : p.gender,
                    address      : p.address,
                    remark       : p.remark,
                    date_of_birth: p.date_of_birth,
                    year         : p.age_year,
                    month        : p.age_month,
                    day          : p.age_day,
                }
            }
        },
        selectedDoctor(d){
            if(!this.update_process){
                this.appointment.fees = d == null ? '' : d.fees;
                this.getSerialNumber();
            }
        }
    },
    created(){
        this.getTrID();
        this.getDoctors();
        this.getReferences();
        this.getPatientCode();
        this.getAppointments();
    },
    methods: {
        save(){
            if(this.patient.name == ''){
                alert('patient name required!');
                return;
            }
            if(this.patient.mobile == ''){
                alert('patient mobile required!');
                return;
            }
            if(this.patient.date_of_birth == ''){
                alert('patient date of birth required!');
                return;
            }
            if(this.patient.gender == ''){
                alert('patient gender required!');
                return;
            }
            if(this.appointment.appointment_date == ''){
                alert('appointment date required!');
                return;
            }
            if(this.selectedDoctor == null){
                alert('doctor required');
                return;
            }

            this.progress = true;

            this.appointment.doctor_id = this.selectedDoctor.id;

            if(this.selectedReference != null){
                this.appointment.reference_id                 = this.selectedReference.id;
                this.appointment.reference_commission_percent = this.selectedReference.commission_percent;
                this.appointment.reference_commission_amount  = (this.selectedReference.commission_percent * this.appointment.fees) / 100;

            }else{
                this.appointment.reference_id                 = null;
                this.appointment.reference_commission_percent = 0;
                this.appointment.reference_commission_amount  = 0;
            }

            let data = {
               appointment: this.appointment,
               patient    : this.patient,
            }

            let url = '/add-appointment';

            if(this.appointment.id != ''){
                url = '/update-appointment';
            }

            axios.post(url, data).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getPatientCode();
                this.getAppointments();
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
            this.appointment = {
                id                          : '',
                token_number                : '',
                appointment_date            : moment().format('YYYY-MM-DD'),
                appointment_time            : moment().format('HH:mm'),
                serial_number               : '',
                fees                        : '',
                remark                      : '',
            };
            this.patient = {
                id           : '',
                name         : '',
                mobile       : '',
                gender       : '',
                address      : '',
                remark       : '',
                date_of_birth: '',
                year         : '',
                month        : '',
                day          : '',
            };

            this.patients       = [];
            this.selectedPatient= null;
            this.selectedDoctor = null;
            this.selectedReference  = null;
        },
        getAppointments(){
            axios.post('/get_appointments', {date: this.appointment.appointment_date}).then(res=>{
                this.appointments = res.data;
            })
        },
        getDoctors(){
            axios.get('/get_doctors').then(res=>{
                this.doctors = res.data;
            })
        },
        getReferences(){
            axios.get('/get_agents').then(res=>{
                this.references = res.data;
            })
        },
        getPatientCode(){
            axios.get('/get_patient_code').then(res=>{
                this.patient.patient_code = res.data;
            })
        },
        getTrID(){
            axios.get('/get_appointment_tr_id').then(res=>{
                this.appointment.token_number = res.data;
            })
        },
        clearPatient(){
            this.patient = {
                id           : '',
                name         : '',
                mobile       : '',
                gender       : '',
                address      : '',
                remark       : '',
                date_of_birth: '',
                year         : '',
                month        : '',
                day          : '',
            }
        },
        calculateDateOfBirth(){
            let year = isNaN(this.patient.year) ? 0 : +this.patient.year;
            let month = isNaN(this.patient.month) ? 0 : +this.patient.month;
            let day = isNaN(this.patient.day) ? 0 : +this.patient.day;

            let total_day = (year * 365) + (month * 30) + day;
            this.patient.date_of_birth = moment().subtract(total_day, 'days').format('YYYY-MM-DD');
        },
        checkPatient(){
            this.patients = [];

            if(this.patient.mobile.length == 11){
                axios.post('/get_patients', {mobile: this.patient.mobile}).then(res=>{
                    this.patients = res.data;
                })
            }
        },
        aptDateChange(){
            if(!this.update_process){
                this.getSerialNumber();
                this.getAppointments();
            }
        },
        getSerialNumber(){
            this.appointment.serial_number = '';

            if(this.selectedDoctor != null && this.appointment.appointment_date != ''){
                axios.post('/get_appointment_serial_number', {date: this.appointment.appointment_date, doctor_id: this.selectedDoctor.id}).then(res=>{
                    this.appointment.serial_number = res.data;
                })
            }
        },
        calculateAge(){
            if(moment().diff(this.patient.date_of_birth) < 0){
                this.patient.date_of_birth = '';
                alert('Invalid date of birth')
                return;
            }

            let total_day = moment().diff(this.patient.date_of_birth, 'days');

            this.patient.year  = '';
            this.patient.month = '';
            this.patient.day   = '';

            if(!isNaN(total_day)){
                let year = Math.floor(total_day / 365);
                let month = Math.floor((total_day - (year * 365)) / 30);
                let day = total_day - ((year * 365) + (month * 30));

                this.patient.year = year;
                this.patient.month = month;
                this.patient.day = day;
            }
        },
        getPatients(){
            axios.get('/get_patients').then(res=>{
                this.patients = res.data;
            })
        },
        editAppointment(row){
            this.update_process = true;

            this.appointment = {
                id              : row.id,
                token_number    : row.token_number,
                appointment_date: row.appointment_date,
                appointment_time: row.appointment_time,
                serial_number   : row.serial_number,
                fees            : row.fees,
                remark          : '',
            };

            this.selectedDoctor = {
                id          : row.doctor_id,
                display_name: row.doctor_display_name,
            }

            if(row.reference_id){
                this.selectedReference = {
                    id                : row.reference_id,
                    display_name      : row.reference_display_name,
                    commission_percent: row.commission_percent,
                }
            }else{
                this.selectedReference = null;
            }

            this.patient = {
                id           : row.patient_id,
                name         : row.patient_name,
                mobile       : row.patient_mobile,
                gender       : row.patient_gender,
                address      : row.patient_address,
                remark       : row.patient_remark,
                date_of_birth: row.patient_date_of_birth,
                year         : row.patient_age_year,
                month        : row.patient_age_month,
                day          : row.patient_age_day,
            }

            setTimeout(() => {
                this.update_process = false;
            }, 1000);
        },
        deleteAppointment(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-appointment', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getAppointments();
                        
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