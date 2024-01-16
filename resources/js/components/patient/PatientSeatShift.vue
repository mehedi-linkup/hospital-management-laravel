
<style scoped>
    .no-padding-right{
        padding: 0px !important;
    }
    .widget-box{
        border: 0px solid #fff !important;
    }
    .widget-header{
        border: 1px solid #ccc !important; 
        min-height: 26px !important; 
        background: #146C94 !important; 
        color:aliceblue !important; 
        font-weight: bolder !important;
    }
    .widget-title{
        line-height: 25px !important;
    }
</style>
<template>
    <div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h5 class="widget-title">Admission Information</h5>
                       
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Admission ID </label>
                                        <div class="col-xs-8">
                                            <v-select :options="admissions" label="admission_name"  class="select" v-model="selectedAdmission" @input="getAdmissionsSeatShift()"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                                            <a href="/patient_admission" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Name </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Name" class="form-control" v-model="selectedAdmission.patient_name" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Mobile </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Mobile" class="form-control" v-model="selectedAdmission.patient_mobile" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Patient Address </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Patient Address" class="form-control" v-model="selectedAdmission.patient_address" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> From Room  </label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" v-model="cheatSheatShift.room_name" placeholder="From Room" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> From Seat </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="From Seat" class="form-control" v-model="cheatSheatShift.bed_number" disabled/>
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
                        <h5 class="widget-title">Seat Shift Information</h5>
                       
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Shift Date </label>
                                        <div class="col-xs-9">
                                            <input type="date" class="form-control" v-model="seatshift.shift_date" v-on:input="getAdmissions()"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Shift Time </label>
                                        <div class="col-xs-9">
                                            <input type="time" class="form-control" v-model="seatshift.shift_time"/>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> To Room </label>
                                        <div class="col-xs-8">
                                            <v-select :options="rooms" label="room_name" v-model="selectedRoom" class="select" @input="getSeats()"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                                            <a href="/room_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> To Seat </label>
                                        <div class="col-xs-8">
                                            <v-select :options="filterseats" label="bed_number" v-model="selectedSeat" class="select" @input="getSeatsAmount()"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                                            <a href="/seat_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Seat Rent </label>
                                        <div class="col-xs-9">
                                            <input type="number" step="any" class="form-control" v-model="seatshift.bed_rent"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xs-3 control-label no-padding-right"> Remark </label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" v-model="seatshift.remark"/>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="admissionsShift" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.admission_code }}</td>
                                <td>{{ row.shift_date }}</td>
                                <td>{{ row.shift_time }}</td>
                                <td v-if="row.bed_release_date">{{ row.bed_release_date   }}</td>
                                <td v-else>N/A</td>
                                <td>{{ row.no_of_day }}</td>
                                <td>{{ row.patient_name }}</td>
                                <td>{{ row.patient_mobile }}</td>
                                <td>{{ row.from_room_name }}</td>
                                <td>{{ row.from_bed_name }}</td>
                                <td>{{ row.to_room_name }}</td>
                                <td>{{ row.to_bed_name }}</td>
                                <td>{{ row.bed_rent }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    
                                    <span v-if="role != 'User' && row.is_shift==0" >
                                        <a class="blue" href="javascript:" @click="editSeatShift(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteSeatShift(row.id)" >
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
    props: ['role','code'],
    data () {
        return {
            seatshift: {
                id          : '',
                admission_id: '',
                shift_date  : moment().format('YYYY-MM-DD'),
                shift_time  : moment().format('HH:mm'),
                patient_id  : '',
                from_room_id: '',
                from_bed_id : '',
                to_room_id  : '',
                to_bed_id   : '',
                bed_rent    : '',
                remark      : '',
            },
           
            filterseats    : [],
            cheatSheatShift  : [],

            rooms       : [],
            selectedRoom: null,

            seats       : [],
            selectedSeat: null,

            
            admissions: [],
            admissionsShift: [],
            selectedAdmission:{
                id             : '',
                admission_name : '',
                patient_name   : '',
                patient_mobile : '',
                patient_address: '',
                bed_id         : '',
                room_id        : ''
            },
            columns: [
                { label: 'Admission ID', field: 'admission_ID', align: 'center'},
                { label: 'Date', field: 'shift_date', align: 'center' },
                { label: 'Time', field: 'shift_time', align: 'center' },
                { label: 'Seat Release Date', field: 'bed_release_date', align: 'center' },
                { label: 'Days', field: 'no_of_day', align: 'center' },
                { label: 'Name', field: 'patient_name', align: 'center' },
                { label: 'Mobile', field: 'patient_mobile', align: 'center' },
                { label: 'From Room', field: 'from_room_name', align: 'center' },
                { label: 'From Seat', field: 'from_bed_name', align: 'center' },
                { label: 'To Room', field: 'to_room_name', align: 'center' },
                { label: 'To Seat', field: 'to_bed_name', align: 'center' },
                { label: 'Seat Rent', field: 'bed_rent', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            oldAdmissionId: '',
            filter: '',
            progress: false,
            update_process: false,
        }
    },
    watch: {
        selectedRoom(rooms) {
				if (rooms == undefined) return;
				let seat = this.seats.filter(item => item.room_id == rooms.id)
                    this.filterseats = seat;
               
			}        
        },
    async created(){
        this.getRooms();
        this.getSeats();
        this.getAdmissions();
        this.getAdmissionsShift();
    },
    methods: {

        save(){
            if(this.selectedAdmission == null){
                alert('Admission required');
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
            //console.log(this.cheatSheatShift.bed_id);
            this.progress = true;

            this.seatshift.admission_id = this.selectedAdmission.id;
            this.seatshift.patient_id   = this.selectedAdmission.patient_id;
            this.seatshift.from_room_id = this.cheatSheatShift.room_id;
            this.seatshift.from_bed_id  = this.cheatSheatShift.bed_id;
            this.seatshift.to_room_id   = this.selectedRoom.id;
            this.seatshift.to_bed_id    = this.selectedSeat.id;

            let data = {
                seatshift : this.seatshift
            }

            let url = '/store-seatshift';

            if(this.seatshift.id != ''){
                url = '/update-seatshift';
            }

            axios.post(url, data).then(res=>{

                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getRooms();
                this.getSeats();
                this.getAdmissions();
                this.getAdmissionsShift();
                
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
            this.seatshift = {
                id          : '',
                admission_id: '',
                shift_date  : moment().format('YYYY-MM-DD'),
                shift_time  : moment().format('HH:mm'),
                patient_id  : '',
                from_room_id: '',
                from_bed_id : '',
                to_room_id  : '',
                to_bed_id   : '',
                bed_rent    : '',
                remark      : '',
            };
    
            this.selectedRoom      = null;
            this.selectedSeat      = null;

            this.selectedAdmission={
                id             : '',
                admission_name : '',
                patient_name   : '',
                patient_mobile : '',
                patient_address: '',
                bed_id         : '',
                room_id        : ''
            };
            this.cheatSheatShift = [];
            
        },
        getAdmissions(){
            axios.post('/get_admissions',{status:'Admited'}).then(res=>{
                this.admissions = res.data;
            })
        },
        getAdmissionsShift(){
            axios.post('/get_seat_shift',{status:'Admited'}).then(res=>{
                this.admissionsShift = res.data;
            })
        },
        getAdmissionsSeatShift(){
            axios.post('/get_admission_seat_shift', {id:this.selectedAdmission.id}).then(res=>{
                this.cheatSheatShift = res.data[0];
            })
        },
       
     
        getRooms(){
            axios.post('/get_rooms',{is_operation:false}).then(res=>{
                this.rooms = res.data;
            })
        },
        getSeats(){
            this.filterseats = [];
            this.selectedSeat=null;
                if(this.selectedRoom!=null){
                    axios.post('/get_seats',{roomId:this.selectedRoom.id,is_book:true}).then(res=>{
                        this.seats = res.data;
                        this.filterseats = res.data;
                        this.seatshift.bed_rent = '';
                    })
                }else{
                    this.seatshift.bed_rent = '';
                }
                
            },
        getSeatsAmount(){
                if(this.selectedSeat!=null){
                    axios.post('/get_seats',{id:this.selectedSeat.id}).then(res=>{
                        this.seatshift.bed_rent = res.data[0].amount;
                    })
                }else{
                    this.seatshift.bed_rent = '';
                }
            },
      
        editSeatShift(row){
            this.update_process = true;
           
            this.seatshift = {
                id          : row.id,
                admission_id: row.admission_id,
                shift_date  : row.shift_date,
                shift_time  : row.shift_time,
                patient_id  : row.patient_id,
                from_room_id: row.from_room_id,
                from_bed_id : row.from_bed_id,
                to_room_id  : row.to_room_id,
                to_bed_id   : row.to_bed_id,
                bed_rent    : row.bed_rent,
                remark      : row.remark
            };

            this.selectedAdmission={
                id             : row.admission_id,
                patient_id     : row.patient_id,
                admission_name : row.admission_name,
                patient_name   : row.patient_name,
                patient_mobile : row.patient_mobile,
                patient_address: row.patient_address,

            },

            this.cheatSheatShift.bed_id     = row.from_bed_id;
            this.cheatSheatShift.room_id    = row.from_room_id;
            this.cheatSheatShift.bed_number = row.from_room_name;
            this.cheatSheatShift.room_name  = row.from_bed_name;
            this.oldAdmissionId             = row.admission_id;

            this.selectedRoom = {
                id       : row.to_room_id,
                room_name: row.to_room_name
            }
            
            this.selectedSeat = {
                id        : row.to_bed_id,
                bed_number: row.to_bed_name
            }
                
            setTimeout(() => {
                this.update_process = false;
            }, 1000);
        },

        deleteSeatShift(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-seat-shift', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getRooms();
                        this.getSeats();
                        this.getAdmissions();
                        this.getAdmissionsShift();
                        
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