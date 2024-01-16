
<style scoped>

	#searchForm select{
		padding:0;
		border-radius: 4px;
	}
	#searchForm .form-group{
		margin-right: 5px;
	}
	#searchForm *{
		font-size: 13px;
	}
	
</style>
<template>
<div>
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				<div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="room">By Room</option>
						<option value="patient">By Patient</option>
						<option value="doctor">By Doctor</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'patient' && patients.length > 0 ? '' : 'none'}">
					<label class="col-md-2">Patient</label>
                    <div class="col-md-10">
                        <v-select v-bind:options="patients" v-model="selectedPatient" label="display_name"></v-select>
                    </div>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'doctor' && doctors.length > 0 ? '' : 'none'}">
					<label class="col-md-2">Doctor</label>
                    <div class="col-md-10">
                        <v-select v-bind:options="doctors" v-model="selectedDoctor" label="display_name"></v-select>
                    </div>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'room' && rooms.length > 0 ? '' : 'none'}">
					<label class="col-md-2">Room</label>
                    <div class="col-md-10">
                        <v-select v-bind:options="rooms" v-model="selectedRoom" label="room_name"></v-select>
                    </div>
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateTo">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>
    <div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: schedules.length > 0 ? '' : 'none'}">
        <div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
            <div class="col-md-12" id="reportContent">

                <table class="record-table"
                v-if="(searchTypesForRecord.includes(searchType))" 
					style="display:none" 
					v-bind:style="{display: (searchTypesForRecord.includes(searchType)) ? '' : 'none'}"
                >
					<thead>
						<tr>
							<th>Code</th>
							<th>Date</th>
							<th>Doctor Name</th>
							<th>Patinet Name</th>
							<th>Room</th>
							<th>From Date</th>
							<th>To Date</th>
							<th>Bill Amount</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody v-for="(schedule,sl) in schedules" :key='sl'>
						<tr>
                                <td>{{ schedule.schedule_code }}</td>
                                <td>{{ schedule.bill_date }}</td>
                                <td>{{ schedule.doctor_name }}</td>
                                <td>{{ schedule.patient_name }}</td>
                                <td>{{ schedule.room_name }}</td>
                                <td>{{ schedule.time_from }}</td>
                                <td>{{ schedule.time_to }}</td>
                                <td>{{ schedule.amount }}</td>
                                <td>{{ schedule.remark }}</td>
                                <td style="text-align:center;">
									<span v-if="role != 'User'">
									<a href="" title="Complete Schedule" @click.prevent="pendingSchedule(schedule.id)"><i class="fa fa-check-square-o"></i></a>
									</span>
								</td>
						</tr>
					</tbody>
				</table>

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
                schedules: [],
                searchType: '',
                dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
                patients: [],
				selectedPatient: null,
				doctors: [],
				selectedDoctor: null,
				rooms: [],
				selectedRoom: null,
                searchTypesForRecord: ['', 'room', 'patient','doctor'],
            }
        },
        created(){
            // this.getSchedules();
            this.getBranchInfo();
        },
		
        methods: {
            onChangeSearchType(){
				this.schedules = [];
				if(this.searchType == 'doctor'){
					this.getDoctors();
				} 
				else if(this.searchType == 'room'){
					this.getRooms();
				}
				else if(this.searchType == 'patient'){
					this.getPatients();
				}
			},
           
            getDoctors(){
				axios.get('/get_doctors').then(res => {
					this.doctors = res.data;
				})
			},
			getPatients(){
				axios.get('/get_patients').then(res => {
					this.patients = res.data;
				})
			},
			getRooms(){
				axios.get('/get_rooms').then(res => {
					this.rooms = res.data;
				})
			},
            getBranchInfo(){
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
                })
            },

            getSearchResult(){
				if(this.searchType != 'room'){
					this.selectedRoom = null;
				}

				if(this.searchType != 'doctor'){
					this.selectedDoctor = null;
				}


				if(this.searchType != 'patient'){
					this.selectedPatient = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)) {
					this.getSchedules();
				} 
			},
            getSchedules(){
				let filter = {
					roomId: this.selectedRoom == null ? '' : this.selectedRoom.id,
					patientId: this.selectedPatient == null ? '' : this.selectedPatient.id,
					doctorId: this.selectedDoctor == null ? '' : this.selectedDoctor.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo,
                    is_complete:true
				}

				let url = '/get_ot_schedule';
				

				axios.post(url, filter)
				.then(res => {
						this.schedules = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},

        pendingSchedule(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/pending-complete-schedule',{id: id,is_pending:true}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        this.getSchedules();
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
            async print(){
                let dateText = '';
				if(this.dateFrom != '' && this.dateTo != ''){
					dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let roomText = '';
				if(this.selectedRoom != null && this.selectedRoom.id != '' && this.searchType == 'room'){
					roomText = `<strong>Room: </strong> ${this.selectedRoom.room_name}`;
				}

				let patientText = '';
				if(this.selectedPatient != null && this.selectedPatient.id != '' && this.searchType == 'patient'){
					patientText = `<strong>Patient: </strong> ${this.selectedPatient.display_name}<br>`;
				}

				let doctorText = '';
				if(this.selectedDoctor != null && this.selectedDoctor.id != '' && this.searchType == 'doctor'){
					doctorText = `<strong>Doctor: </strong> ${this.selectedDoctor.display_name}`;
				}

			
				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Complete OT Schedule</h3>
							</div>
						</div>
                        <div class="row">
							<div class="col-xs-6">
								${roomText} ${patientText} ${doctorText} 
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
				reportWindow.document.write(`
                <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-2"><img src="${this.branch.logo}" alt="Logo" style="height:80px;" /></div>
                        <div class="col-xs-10" style="padding-top:20px;">
                            <strong style="font-size:18px;">${this.branch.name}</strong><br>
                            <p style="white-space: pre-line;">${this.branch.address}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                        </div>
                    </div>
                </div>
            `);

				reportWindow.document.head.innerHTML += `
					<style>
						.record-table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				
					let rows = reportWindow.document.querySelectorAll('.record-table tr');
					rows.forEach(row => {
						row.lastChild.remove();
					})
				


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}

		
        }
	}

</script>