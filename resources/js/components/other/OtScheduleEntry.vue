<style scoped>
    .v-select{
		margin-top:-2.5px;
        min-width: 180px;
	}
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
                <div class="col-xs-10 col-md-10 col-lg-10 col-md-offset-1">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Schedule Information</h4>
                          
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right"> Bill Date: </label>
                                            <div class="col-sm-9">
                                                <input type="date" placeholder="Date" class="form-control" v-model="schedule.bill_date" required/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right"> Doctor: </label>
                                            <div class="col-sm-8">
                                                <v-select v-bind:options="doctors" v-model="selectedDoctor" label="display_name" class="select"></v-select>
                                                </div>
                                            <div class="col-sm-1">
                                                <a href="/doctor_entry" title="Add New Doctor" class="btn btn-xs btn-danger" style="height: 22px; border: 0; width: 30px; margin-left: -18px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                                            </div>
                                            <!-- <div class="col-xs-1" style="padding: 0;">
                                            </div> -->
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right"> Patient: </label>
                                            <div class="col-xs-8">
                                                <v-select v-bind:options="patients" v-model="selectedPatient" label="display_text" class="select"></v-select>
                                            </div>
                                            <div class="col-xs-1">
                                                <a href="/patient_entry" title="Add New Patient" class="btn btn-xs btn-danger" style="height: 22px; border: 0; width: 30px; margin-left: -18px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                                            </div>
                                            <!-- <div class="col-xs-1" style="padding: 0;">
                                            </div> -->
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right"> Date form </label>
                                            <div class="col-xs-9">
                                                <input type="datetime-local" placeholder="Rate" class="form-control" v-model="schedule.fromdate" @input="checkRooms()" required/>
                                            </div>
                                            <!-- <div class="col-xs-1" style="padding: 0;">
                                            </div> -->
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right">  Date To : </label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" placeholder="Rate" class="form-control" v-model="schedule.todate" @input="checkRooms()" required/>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right"> Room : </label>
                                            <div class="col-xs-8">
                                                <v-select v-bind:options="rooms" v-model="selectedRoom" @input="getSeats()" label="room_name" class="select"></v-select>
                                                 </div>
                                            <div class="col-xs-1">
                                                <a href="/room_entry" title="Add New Room" class="btn btn-xs btn-danger"  style="height: 22px; border: 0; width: 30px; margin-left: -18px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                                            </div>
                                            <!-- <div class="col-xs-1" style="padding: 0;">
                                            </div> -->
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> To Seat </label>
                                            <div class="col-xs-8">
                                                <v-select :options="filterseats" label="bed_number" v-model="selectedSeat" @input="checkRooms()" class="select"></v-select>
                                            </div>
                                            <div class="col-xs-1">
                                                <a href="/seat_entry" title="Add New Seat" class="btn btn-xs btn-danger"  style="height: 22px; border: 0; width: 30px; margin-left: -18px;" target="_blank">
                                                    <i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right">Bill Amount</label>
                                            <div class="col-sm-9">
                                                <input type="number" placeholder="Amount" class="form-control" v-model="schedule.amount"  required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right"> Note </label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="Description" v-model="schedule.remark"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label no-padding-right"></label>
                                            <label class="col-sm-5 control-label no-padding-right">
                                                <div class="form-group">
                                                    <div  style="display:none;text-align:center; border: 1px solid gray; padding:3px;margin-top: 5px; margin-left: 15px;" v-bind:style="{color: roomCheck == 0 ? 'green' : 'red', display: selectedRoom == null? 'none' : ''}">
                                                                {{ roomCheckText }}
                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-sm btn-success" :disabled="roomCheck > 0 && schedule.id == 0">
                                                    Submit
                                                    <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                                                </button>
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

    <div class="row">
            <div class="col-sm-12 form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="schedules" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.schedule_code }}</td>
                                <td>{{ row.bill_date }}</td>
                                <td>{{ row.doctor_name }}</td>
                                <td>{{ row.patient_name }}</td>
                                <td>{{ row.room_name }}</td>
                                <td>{{ row.bed_number }}</td>
                                <td>{{ row.time_from }}</td>
                                <td>{{ row.time_to }}</td>
                                <td>{{ row.amount }}</td>
                                <td v-if="row.is_done == 0"><span style="color:brown;font-weight: bolder;">Pending</span></td>
                                <td v-if="row.is_done == 1"><span style="color:darkgreen;font-weight: bolder;">Complete</span></td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editOtSchedule(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteOtSchedule(row.id)">
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
    data(){
            return {
                schedule: {
                    id           : 0,
                    schedule_code: '',
                    bill_date    : moment().format('YYYY-MM-DD'),
                    doctor_id    : '',
                    patient_id   : '',
                    room_id      : '',
                    bed_id      : '',
                    amount       : '',
                    fromdate     : '',
                    todate       : '',
                    is_done      : 0,
                    remark       : '',
                },

                filterseats    : [],
                seats       : [],
                selectedSeat: null,
                doctors: [],
                selectedDoctor: null,
                patients: [],
                selectedPatient: null,
				rooms: [],
				selectedRoom: null,
                roomCheckText : '',
                roomCheck : '',
                productStockOld : 0,
                schedules: [],
                oldSeat: '',
				columns: [
                    { label: 'Code', field: 'schedule_code', align: 'center', filterable: false },
                    { label: 'Date', field: 'bill_date', align: 'center' },
                    { label: 'Doctor Name', field: 'doctor_name', align: 'center' },
                    { label: 'Patinet Name', field: 'patient_name', align: 'center' },
                    { label: 'Room', field: 'room_name', align: 'center' },
                    { label: 'Seat', field: 'bed_number', align: 'center' },
                    { label: 'From Date', field: 'time_from', align: 'center' },
                    { label: 'To Date', field: 'time_to', align: 'center' },
                    { label: 'Bill Amount', field: 'amount', align: 'center' },
                    { label: 'Status', field: 'is_done', align: 'center' },
                    { label: 'Note', field: 'remark', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page    : 1,
                per_page: 10,
                filter  : '',
                progress: false,
            }
        },
        created(){
            this.getDoctors();
            this.getPatients();
            this.getRooms();
            this.getSchedules();
            this.getScheduleCode();
        },
		watch: {
        selectedRoom(rooms) {
				if (rooms == undefined) return;
				let seat = this.seats.filter(item => item.room_id == rooms.id)
                    this.filterseats = seat;
               
			}        
        },
        methods: {
            getDoctors() {
				axios.get('/get_doctors').then(res => {
					this.doctors = res.data;
				})
			},
           getPatients(){
					axios.get('/get_patients').then(res=>{
						this.patients = res.data;
					})
			},
            getScheduleCode(){
                axios.get('/get_schedule_code').then(res=>{
                    this.schedule.schedule_code = res.data;
                })
            },
           getRooms(){
					axios.post('/get_rooms',{is_operation:true}).then(res=>{
						this.rooms = res.data;
					})
			},
            getSeats(){
            this.filterseats = [];
            this.selectedSeat=null;
                if(this.selectedRoom!=null){
                    axios.post('/get_seats',{roomId:this.selectedRoom.id,is_book:false}).then(res=>{
                        this.seats = res.data;
                        this.filterseats = res.data;
                    })
                }
                
            },

            async checkRooms(){

                    if(this.selectedSeat != null && this.selectedRoom != null && this.schedule.fromdate != this.schedule.todate){
                        this.roomCheckText = "";

                        this.roomCheck = await axios.post('/get_ot_room_status', {roomId: this.selectedRoom.id,seatId:this.selectedSeat.id,fromdate:this.schedule.fromdate, todate:this.schedule.todate})
                        .then(res => {
                            return res.data;
                        })
                            this.roomCheckText = this.roomCheck > 0 ? "Seat Unavailable" : "Available Seat";
                            
                    }
            },
			save(){
				
                if(this.selectedDoctor == null){
                    alert('Select Doctor');
					return;
				}
				if(this.selectedPatient == null){
                    alert('Select Patient');
					return;
				}
                if(this.schedule.fromdate == ''){
					alert('Select From Date');
					return;
				}
				
				if(this.schedule.todate == ''){
					alert('Select To Date');
					return;
				}
                if(this.selectedRoom == null){
                    alert('Select Room');
                    return;
                }
                if(this.selectedSeat == null){
                    alert('Select Seat');
                    return;
                }
                this.progress = true;


				this.schedule.doctor_id  = this.selectedDoctor.id;
				this.schedule.patient_id = this.selectedPatient.id;
				this.schedule.room_id    = this.selectedRoom.id;
				this.schedule.bed_id    = this.selectedSeat.id;

                let url = '/store-ot-schedule';
                if(this.schedule.id != 0){
                    url = '/update-ot-schedule';
                }

                let data = {
					schedules: this.schedule,
					oldSeat: this.oldSeat
				}
                axios.post(url, data).then(res=>{
                    this.progress = false;
                    this.$toaster.success(res.data.message);
                    this.resetForm();
                    this.getScheduleCode();
                    this.getSchedules();
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

            editOtSchedule(row){
                

				this.selectedRoom = {
					id       : row.room_id,
					room_name: row.room_name,
            	}
				this.selectedSeat = {
					id       : row.bed_id,
					bed_number: row.bed_number,
            	}

                this.selectedDoctor = {
                    id         : row.doctor_id,
                    display_name: row.doctor_name,
                }
                this.selectedPatient = {
                    id          : row.patient_id,
                    display_text: row.patient_name,
                }
                
                this.schedule = {
                    id           : row.id,
                    schedule_code: row.schedule_code,
                    bill_date    : row.bill_date,
                    doctor_id    : row.doctor_id,
                    patient_id   : row.patient_id,
                    room_id      : row.room_id,
                    bed_id       : row.bed_id,
                    amount       : row.amount,
                    fromdate     : row.time_from,
                    todate       : row.time_to,
                    is_done      : row.is_done,
                    remark       : row.remark
                }
                this.oldSeat= row.bed_id;
                this.checkRooms();
            },

           

            deleteOtSchedule(id){
                Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: 'Want to delete this?',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/delete-ot-schedule', {id}).then(res=>{
                            let r = res.data;
                            Swal.fire({
                                icon: 'success',
                                title: r.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            this.resetForm();
                            this.getPatients();
                            this.getSchedules();
                            this.getDoctors();
                            this.getRooms();
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
            },

            getSchedules(){
                axios.get('/get_ot_schedule').then(res => {
                    this.schedules = res.data;
                })
            },

			resetForm(){

                this.schedule = {
                    id           : 0,
                    schedule_code: '',
                    bill_date    : moment().format('YYYY-MM-DD'),
                    doctor_id    : '',
                    patient_id   : '',
                    room_id      : '',
                    amount       : '',
                    fromdate     : '',
                    todate       : '',
                    is_done      : 0,
                    remark       : '',
                },

				this.selectedRoom = null,
				this.selectedSeat = null,
                this.selectedPatient= null,
                this.selectedDoctor     = null;
			}
        }
	}

</script>