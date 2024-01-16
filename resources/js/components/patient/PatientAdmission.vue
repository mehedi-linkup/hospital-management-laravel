
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
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Code </label>
                                        <div class="col-xs-9">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Patient Code" type="text" autocomplete="off" v-model="patient.patient_code"/>
                                                <span class="input-group-addon" @click="checkPatient()">Find</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Name </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Name" class="form-control" v-model="patient.name" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Mobile </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Mobile" class="form-control" v-model="patient.mobile" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Date of birth </label>
                                        <div class="col-xs-9">
                                            <input type="date" class="form-control" v-model="patient.date_of_birth" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Age </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Age" class="form-control" v-model="patient.age" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Gender </label>
                                        <div class="col-xs-9">
                                            <select class="form-control" v-model="patient.gender" disabled>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Address </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Address" class="form-control" v-model="patient.address" disabled/>
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
                        <h4 class="widget-title">Admission Information</h4>
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
                                        <label class="col-xs-3 control-label no-padding-right"> Admission ID </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Admission id" v-model="admission.admission_code" class="form-control" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Admission Date </label>
                                        <div class="col-xs-9">
                                            <input type="date" class="form-control" v-model="admission.admission_date" v-on:input="getAdmissions()"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Admission Date </label>
                                        <div class="col-xs-9">
                                            <input type="time" class="form-control" v-model="admission.admission_time"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Doctor </label>
                                        <div class="col-xs-8">
                                            <v-select :options="doctors" label="display_name" class="select" v-model="selectedDoctor"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                                            <a href="/doctor_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Room </label>
                                        <div class="col-xs-8">
                                            <v-select :options="rooms" label="room_name" v-model="selectedRoom" class="select" @input="getSeats()"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                                            <a href="/room_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Seat </label>
                                        <div class="col-xs-8">
                                            <v-select :options="seats" label="bed_number" v-model="selectedSeat" class="select" @input="getSeatsAmount()"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                                            <a href="/seat_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Reference </label>
                                        <div class="col-xs-8">
                                            <v-select :options="references" label="display_name" class="select" v-model="selectedReference"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                                            <a href="/agent_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Admission Fees </label>
                                        <div class="col-xs-9">
                                            <input type="number" step="any" class="form-control" v-model="admission.admission_fees"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Seat Rent </label>
                                        <div class="col-xs-9">
                                            <input type="number" step="any" class="form-control" v-model="admission.bed_rent"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Received Amount </label>
                                        <div class="col-xs-9">
                                            <input type="number" step="any" class="form-control" v-model="admission.received_amount"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Remark </label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" v-model="admission.remark"/>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="admissions" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.admission_code }}</td>
                                <td>{{ row.admission_date }}</td>
                                <td>{{ row.admission_time }}</td>
                                <td>{{ row.patient_name }}</td>
                                <td>{{ row.patient_mobile }}</td>
                                <td>{{ row.patient_age }}</td>
                                <td>{{ row.patient_gender }}</td>
                                <td>{{ row.room_name }}</td>
                                <td>{{ row.bed_number }}</td>
                                <td>{{ row.doctor_display_name }}</td>
                                <td>{{ row.reference_display_name }}</td>
                                <td>{{ row.admission_fees }}</td>
                                <td>{{ row.bed_rent }}</td>
                                <td>{{ row.received_amount }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User' && row.is_shift == 0">
                                        <a class="blue" href="javascript:" @click="editAdmission(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteAdmission(row.id)">
                                            <i class="ace-icon fa fa-trash bigger-130"></i>
                                        </a>
                                    </span>
                                    <span v-if="role != 'User' && row.is_shift == 1">
                                        <a class="blue" href="javascript:" @click="editAdmission(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
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
    props: ['role','code'],
    data () {
        return {
            admission: {
                id             : '',
                admission_code : '',
                admission_date : moment().format('YYYY-MM-DD'),
                admission_time : moment().format('HH:mm'),
                doctor_id      : '',
                patient_id     : '',
                bed_id         : '',
                room_id        : '',
                reference_id   : '',
                received_amount: '',
                admission_fees: '',
                bed_rent       : '',
                status       : 'Admited',
                remark         : '',
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
                age          : '',
                year         : '',
                month        : '',
                day          : '',
            },
            filterseats   : [],
            doctors       : [],
            selectedDoctor: null,

            rooms       : [],
            selectedRoom: null,

            seats       : [],
            selectedSeat: null,

            references       : [],
            selectedReference: null,


            admissions: [],
            columns: [
                { label: 'Admission ID', field: 'admission_code', align: 'center'},
                { label: 'Date', field: 'admission_date', align: 'center' },
                { label: 'Time', field: 'admission_time', align: 'center' },
                { label: 'Name', field: 'patient_name', align: 'center' },
                { label: 'Mobile', field: 'patient_mobile', align: 'center' },
                { label: 'Age', field: 'patient_age', align: 'center' },
                { label: 'Gender', field: 'patient_gender', align: 'center' },
                { label: 'Room', field: 'room_name', align: 'center' },
                { label: 'Seat', field: 'bed_number', align: 'center' },
                { label: 'Doctor', field: 'doctor_display_name', align: 'center' },
                { label: 'Reference', field: 'reference_display_name', align: 'center' },
                { label: 'Admission Fees', field: 'admission_fees', align: 'center' },
                { label: 'Seat Rent', field: 'bed_rent', align: 'center' },
                { label: 'Advance', field: 'received_amount', align: 'center' },
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
    // watch: {
    //     selectedRoom(rooms) {
	// 			if (rooms == undefined) return;
	// 			let seat = this.seats.filter(item => item.room_id == rooms.id)
    //                 this.filterseats = seat;
               
	// 		}        
    //     },
    async created(){
        this.admission.admission_code = this.code;
        this.getDoctors();
        this.getRooms();
        await this.getSeats();
        this.getReferences();
        this.getAdmissions();
    },
    methods: {

        checkPatient(){
            //console.log(this.patient.patient_code);
            if(this.patient.patient_code == ''){
                alert('Patient Code required');
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
            
            if(this.selectedDoctor == null){
                alert('doctor required');
                return;
            }
            if(this.selectedRoom == null){
                alert('Room required');
                return;
            }
            if(this.selectedSeat == null){
                alert('Seat required');
                return;
            }
            if(this.patient.id == ''){
                alert('Patient required');
                return;
            }

            this.progress = true;

            this.admission.doctor_id = this.selectedDoctor.id;
            this.admission.room_id = this.selectedRoom.id;
            this.admission.bed_id = this.selectedSeat.id;
            this.admission.patient_id = this.patient.id;

            if(this.selectedReference == null){
                this.admission.reference_id  = null;
            }else{
                this.admission.reference_id = this.selectedReference.id;
            }

            let data = {
               admission : this.admission
            }

            let url = '/store-admission';

            if(this.admission.id != ''){
                url = '/update-admission';
            }

            axios.post(url, data).then(res=>{
                if(res.data.success == false){
                    this.progress = false;
                    this.$toaster.error(res.data.message);
                    return;
                }else if(res.data.success == true){
                    this.progress = false;
                    this.$toaster.success(res.data.message);
                    this.clear();
                    this.getAdmissions();
                }
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
            this.admission = {
                id             : '',
                admission_code : '',
                admission_date : moment().format('YYYY-MM-DD'),
                admission_time : moment().format('HH:mm'),
                doctor_id      : '',
                patient_id     : '',
                bed_id         : '',
                room_id        : '',
                reference_id   : '',
                received_amount: '',
                admission_fees : '',
                bed_rent       : '',
                remark         : '',
            }
            this.patient = {
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
            };

            this.selectedDoctor    = null;
            this.selectedRoom      = null;
            this.selectedSeat      = null;
            this.selectedReference = null;
        },
        getAdmissions(){
            axios.post('/get_admissions',{date:this.admission.admission_date}).then(res=>{
                this.admissions = res.data;
            })
        },
        getDoctors(){
            axios.get('/get_doctors').then(res=>{
                this.doctors = res.data;
            })
        },
        getRooms(){
            axios.post('/get_rooms',{is_operation:false}).then(res=>{
                this.rooms = res.data;
            })
        },
       async getSeats(){
            this.seats = [];
            this.selectedSeat=null;
            if(this.selectedRoom!=null){
                await axios.post('/get_seats',{roomId:this.selectedRoom.id,is_book:true}).then(res=>{
                    this.seats = res.data;
                    this.admission.bed_rent = '';
                })
            }else{
                this.seats = [];
                this.selectedSeat=null;
                this.admission.bed_rent = '';
            }
                
            },
        getSeatsAmount(){
            if(this.selectedSeat!=null){
                axios.post('/get_seats',{id:this.selectedSeat.id}).then(res=>{
                    this.admission.bed_rent = res.data[0].amount;
                })
            }else{
                this.admission.bed_rent = '';
            }
            },
        getReferences(){
            axios.get('/get_agents').then(res=>{
                this.references = res.data;
            })
        },
      
        calculateDateOfBirth(){
            let year = isNaN(this.patient.year) ? 0 : +this.patient.year;
            let month = isNaN(this.patient.month) ? 0 : +this.patient.month;
            let day = isNaN(this.patient.day) ? 0 : +this.patient.day;

            let total_day = (year * 365) + (month * 30) + day;
            this.patient.date_of_birth = moment().subtract(total_day, 'days').format('YYYY-MM-DD');
        },
       
        aptDateChange(){
            if(!this.update_process){
                this.getSerialNumber();
                this.getAdmissions();
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
       
        editAdmission(row){
            this.update_process = true;
          
            this.admission = {
                id             : row.id,
                admission_code : row.admission_code,
                admission_date : row.admission_date,
                admission_time : row.admission_time,
                doctor_id      : row.doctor_id,
                patient_id     : row.patient_id,
                bed_id         : row.bed_id,
                room_id        : row.room_id,
                reference_id   : row.reference_id,
                bed_rent       : row.bed_rent,
                received_amount: row.received_amount,
                admission_fees : row.admission_fees,
                remark         : row.remark
            };

            this.selectedDoctor = {
                id          : row.doctor_id,
                display_name: row.doctor_display_name
            }
            

            this.selectedRoom = {
                id       : row.room_id,
                room_name: row.room_name
            }
            
            this.selectedSeat = {
                id        : row.bed_id,
                bed_number: row.bed_number
            }
                
            if(row.reference_id){
                this.selectedReference = {
                    id                : row.reference_id,
                    display_name      : row.reference_display_name,
                    commission_percent: row.commission_percent
                }
            }else{
                this.selectedReference = null;
            }

            this.patient = {
                id           : row.patient_id,
                name         : row.patient_name,
                patient_code : row.patient_code,
                mobile       : row.patient_mobile,
                gender       : row.patient_gender,
                address      : row.patient_address,
                remark       : row.patient_remark,
                date_of_birth: row.patient_date_of_birth,
                age          : row.patient_age,
                year         : row.patient_age_year,
                month        : row.patient_age_month,
                day          : row.patient_age_day
            }

            setTimeout(() => {
                this.update_process = false;
            }, 1000);
        },
        clearPatient(){
            this.patient = {
                id           : '',
                name         : '',
                mobile       : '',
                gender       : '',
                address      : '',
                remark       : '',
                age          : '',
                date_of_birth: '',
                year         : '',
                month        : '',
                day          : '',
            }
        },
        deleteAdmission(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-admission', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getAdmissions();
                        
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