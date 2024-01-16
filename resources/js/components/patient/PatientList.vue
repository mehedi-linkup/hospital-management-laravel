
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
                                <th>Code</th>
                                <th>Patient Name</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>Date of birth</th>
                                <th>Age</th>
                                <th>Address</th>
                                <th>Remark</th>
                            </tr>
                        </thead>        
                        <tbody>
                            <tr v-for="(row,sl) in patients" :key='sl'>
                                    <td>{{ row.patient_code }}</td>
                                    <td>{{ row.name }}</td>
                                    <td>{{ row.mobile }}</td>
                                    <td>{{ row.gender }}</td>
                                    <td>{{ row.date_of_birth }}</td>
                                    <td>{{ row.age }}</td>
                                    <td>{{ row.address }}</td>
                                    <td>{{ row.remark }}</td>
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
         
            patients: [],
        }
    },
    created(){
        this.getPatients();
        this.getBranchInfo();
    },
    methods: {
       
        getPatients(){
            axios.get('/get_patients').then(res=>{
                this.patients = res.data;
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