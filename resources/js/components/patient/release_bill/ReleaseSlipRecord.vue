
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
    <div id="issueRecord">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				<div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="admission">By Admission</option>
						<option value="patient">By Patient</option>
						<option value="doctor">By Doctor</option>
						<option value="room">By Room</option>
						<option value="bed">By Seat</option>
						<option value="user">By User</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'patient' && patients.length > 0 ? '' : 'none'}">
					<label style="margin-top:0px;" class="col-lg-3">Patient</label>
					<v-select v-bind:options="patients"   v-model="selectedPatient" label="display_name"></v-select>
				</div>
				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'admission' && admissions.length > 0 ? '' : 'none'}">
					<label style="margin-top:2px;" class="col-lg-4">Admission</label>
					<v-select v-bind:options="admissions"   v-model="selectedAdmission" label="admission_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'doctor' && doctors.length > 0 ? '' : 'none'}">
					<label style="margin-top:0px;" class="col-lg-3">Doctor</label>
					<v-select v-bind:options="doctors"   v-model="selectedDoctor" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'room' && rooms.length > 0 ? '' : 'none'}">
					<label style="margin-top:0px;" class="col-lg-3">Room</label>
					<v-select v-bind:options="rooms"   v-model="selectedRoom" label="room_name"></v-select>
				</div>
				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'bed' && beds.length > 0 ? '' : 'none'}">
					<label style="margin-top:0px;" class="col-lg-3">Seat</label>
					<v-select v-bind:options="beds" v-model="selectedBed" label="seat_name"></v-select>
				</div>
				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' && users.length > 0 ? '' : 'none'}">
					<label style="margin-top:0px;" class="col-lg-3">User</label>
					<v-select v-bind:options="users" v-model="selectedUser" label="name"></v-select>
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

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: releaseslips.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				
				<table 
					class="record-table" 
					v-if="(searchTypesForRecord.includes(searchType))" 
					style="display:none" 
					v-bind:style="{display: (searchTypesForRecord.includes(searchType)) ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Slip Code</th>
							<th>Date</th>
							<th>Admission</th>
							<th>Patient Name</th>
							<th>Doctor Name</th>
							<th>Room</th>
							<th>Seat</th>
							<th>Due</th>
							<th>Discount</th>
							<th>Paid</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(releaseslip,sl) in releaseslips" :key='sl'>
							<td>{{ releaseslip.releaseslip_code }}</td>
							<td>{{ releaseslip.slip_date }}</td>
							<td>{{ releaseslip.admission_code }}</td>
							<td>{{ releaseslip.patient_name }}</td>
							<td>{{ releaseslip.doctor_name }}</td>
							<td>{{ releaseslip.room_name }}</td>
							<td>{{ releaseslip.seat_name }}</td>
							<td style="text-align:right;">{{ releaseslip.due }}</td>
							<td style="text-align:right;">{{ releaseslip.discount }}</td>
							<td style="text-align:right;">{{ releaseslip.amount }}</td>
							<td style="text-align:left;">{{ releaseslip.remark }}</td>
							<td style="text-align:center;">
								<a title="Release Slip Invoice" v-bind:href="'/release_slip_print/'+ releaseslip.id" target="_blank"><i class="fa fa-file-text"></i></a>
								<span v-if="role != 'User'">
								<a title="Edit Release Slip" v-bind:href="'/release_slip/'+ releaseslip.id"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Release Slip" @click.prevent="deleteReleaseSlip(releaseslip.id)"><i class="fa fa-trash"></i></a>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
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
				searchType: '',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				admissions: [],
				selectedAdmission: null,
				patients: [],
				selectedPatient: null,
				doctors: [],
				selectedDoctor: null,
				users: [],
				selectedUser: null,
				rooms: [],
				selectedRoom: null,
				beds: [],
				selectedBed: null,
				releaseslips: [],
				searchTypesForRecord: ['', 'user', 'patient','doctor','admission','bed','room']
			}
		},
        created(){
            this.getBranchInfo();
        },
		methods: {
			
			onChangeSearchType(){
				this.releaseslips = [];
				if(this.searchType == 'admission'){
					this.getAdmission();
				} 
				if(this.searchType == 'room'){
					this.getRoom();
				} 
				if(this.searchType == 'bed'){
					this.getBed();
				} 
				if(this.searchType == 'doctor'){
					this.getDoctor();
				} 
				else if(this.searchType == 'user'){
					this.getUsers();
				}
				else if(this.searchType == 'category'){
					this.getCategories();
				}
				else if(this.searchType == 'patient'){
					this.getPatients();
				}
			},
            getBranchInfo(){
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
                })
            },
			getAdmission(){
				axios.get('/get_admissions').then(res => {
					this.admissions = res.data;
				})
			},
			getRoom(){
				axios.get('/get_rooms').then(res => {
					this.rooms = res.data;
				})
			},
			getBed(){
				axios.get('/get_seats').then(res => {
					this.beds = res.data;
				})
			},
			getDoctor(){
				axios.get('/get_doctors').then(res => {
					this.doctors = res.data;
				})
			},
			getPatients(){
				axios.get('/get_patients').then(res => {
					this.patients = res.data;
				})
			},
			getUsers(){
				axios.get('/get_users').then(res => {
					this.users = res.data;
				})
			},
		
			getSearchResult(){
				if(this.searchType != 'user'){
					this.selectedUser = null;
				}

				if(this.searchType != 'doctor'){
					this.selectedDoctor = null;
				}
				if(this.searchType != 'admission'){
					this.selectedAdmission = null;
				}
				if(this.searchType != 'patient'){
					this.selectedPatient = null;
				}
				if(this.searchType != 'room'){
					this.selectedRoom = null;
				}
				if(this.searchType != 'bed'){
					this.selectedBed = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)) {
					this.getReleaseSlipRecord();
				}
			},
			getReleaseSlipRecord(){
				let filter = {
					userId: this.selectedUser == null || this.selectedUser.name == '' ? '' : this.selectedUser.id,
					patient_id: this.selectedPatient == null ? '' : this.selectedPatient.id,
					doctor_id: this.selectedDoctor == null ? '' : this.selectedDoctor.id,
					admission_id: this.selectedAdmission == null ? '' : this.selectedAdmission.id,
					room_id: this.selectedRoom == null ? '' : this.selectedRoom.id,
					seat_id: this.selectedBed == null ? '' : this.selectedBed.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

              

				let url = '/get_release_slip';
				

				axios.post(url, filter)
				.then(res => {
						this.releaseslips = res.data.releaseSlip;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},

			deleteReleaseSlip(releaseId){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-release-slip',{id: releaseId}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        this.getReleaseSlipRecord();
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

				let userText = '';
				if(this.selectedUser != null && this.selectedUser.id != '' && this.searchType == 'user'){
					userText = `<strong>Sold by: </strong> ${this.selectedUser.name}`;
				}

				let doctorText = '';
				if(this.selectedDoctor != null && this.selectedDoctor.id != '' && this.searchType == 'doctor'){
					doctorText = `<strong>Product: </strong> ${this.selectedDoctor.name}`;
				}



				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Sale Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText} ${doctorText}
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

				if(this.searchType == '' || this.searchType == 'user'){
					let rows = reportWindow.document.querySelectorAll('.record-table tr');
					rows.forEach(row => {
						row.lastChild.remove();
					})
				}


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}

}
</script>