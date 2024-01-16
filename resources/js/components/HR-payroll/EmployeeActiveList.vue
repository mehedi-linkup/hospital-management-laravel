
<template>
    <div>
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		    </div>
            <div class="col-md-12">
                <div class="table-responsive" id="reportContent">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>Emp. Code</th>
                                <th>Bio ID</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Name</th>
                                <th>Father`s Name</th>
                                <th>Mother`s Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Merital Status</th>
                                <th>Present Address</th>
                                <th>Permanent Address</th>
                                <th>Salary </th>
                                <th>Image</th>
                                <th>Status</th>
                            </tr>
                        </thead>        
                        <tbody>
                            <tr v-for="(row,sl) in employees" :key='sl'>
                                <td>{{ row.employee_code }}</td>
                                <td>{{ row.bio_id }}</td>
                                <td>{{ row.department_name }}</td>
                                <td>{{ row.designation_name }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.father_name }}</td>
                                <td>{{ row.mother_name }}</td>
                                <td>{{ row.mobile_number }}</td>
                                <td>{{ row.email }}</td>
                                <td>{{ row.gender }}</td>
                                <td>{{ row.merital_status }}</td>
                                <td>{{ row.present_address }}</td>
                                <td>{{ row.permanent_address }}</td>
                                <td>{{ row.salary_range }}</td>
                                <td>
                                    <img id="employeeImage" v-if="row.image == '' || row.image == null" src="/images/no_image.jpg" style="height: 50px; width: 50px;" />
                                    <img id="employeeImage" v-if="row.image != '' && row.image != null" v-bind:src="row.image" style="height: 50px; width: 50px;" />
                                </td>
                                <td v-if="row.status == 'a'" style="color:darkgreen"><b>Active</b></td>
                                <td v-if="row.status == 'd'" style="color:darkred"><b>Deactive</b></td>

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
    data () {
        return {
         
            employees: [],
            selectedStatus: 'a',
        }
    },
    created(){
        this.getEmployee();
        this.getBranchInfo();
    },
    methods: {
       
        getEmployee(){
            axios.post('/get_employees',{status:this.selectedStatus}).then(res=>{
                this.employees = res.data;
            })
        },
        getBranchInfo(){
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
                })
            },
        async print(){
				
				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Patient List</h3>
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