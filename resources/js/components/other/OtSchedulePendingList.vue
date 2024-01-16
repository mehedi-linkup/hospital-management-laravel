
<template>
    <div>
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
            <div class="col-md-12" id="reportContent">

                <table class="record-table">
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
									<a href="" title="Complete Schedule" @click.prevent="completeSchedule(schedule.id)"><i class="fa fa-check-square-o"></i></a>
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
            }
        },
        created(){
            this.getSchedules();
            this.getBranchInfo();
        },
		
        methods: {
            getSchedules(){
                axios.post('/get_ot_schedule',{is_pending:true}).then(res => {
                    this.schedules = res.data;
                })
            },
            getBranchInfo(){
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
                })
            },
        completeSchedule(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/pending-complete-schedule',{id: id,is_complete:true}).then(res=>{
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
					
				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Pending OT Schedule</h3>
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