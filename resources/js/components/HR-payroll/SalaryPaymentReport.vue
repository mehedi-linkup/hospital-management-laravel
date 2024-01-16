<style scoped>
.v-select{
		margin-bottom: 5px;
        float: right;
        min-width: 200px;
        margin-left: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
        height: 25px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
    #salaryReport label{
        font-size: 13px;
		margin-top: 3px;
    }
    #salaryReport select{
        border-radius: 3px;
        padding: 0px;
		font-size: 13px;
    }
    #salaryReport .form-group{
        margin-right: 10px;
    }
	.pagination {
		margin: 10px 0 !important;
	}
	label {
		padding: 0px 10px;
	}
	td, td input{
		font-size: 10px !important;
	}


</style>
<template>
	<div id="paymentsRecord">
		<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
			<div class="col-md-12">
				<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
					<div class="form-group">
						<label>Search Type</label>
						<select class="form-control" v-model="searchType" @change="onChangeSearchType">
							<option value="">All</option>
							<option value="month">By Month</option>
							<option value="employee">By Employee</option>
						</select>
					</div>

					<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'employee' && employees.length > 0 ? '' : 'none'}">
						<label>Employee</label>
						<v-select v-bind:options="employees" v-model="selectedEmployee" label="display_name"></v-select>
					</div>

					<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'month' || searchType == 'employee' ? '' : 'none'}">
						<label>Month</label>
						<v-select v-bind:options="months" v-model="selectedMonth" label="name"></v-select>
					</div>

					<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
						<label>Record Type</label>
						<select class="form-control" v-model="recordType" @change="payments = []">
							<option value="without_details">Without Details</option>
							<option value="with_details">With Details</option>
						</select>
					</div>

					<div class="form-group" style="margin-top: -5px;">
						<input type="submit" value="Search">
					</div>
				</form>
			</div>
		</div>

		<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: payments.length > 0 ? '' : 'none'}">
			<div class="col-md-12" style="margin-bottom: 10px;">
				<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
			</div>
			<div class="col-md-12">
				<div class="table-responsive" id="reportContent">
					<table 
						class="record-table" 
						v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'with_details'" 
						style="display:none" 
						v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'with_details' ? '' : 'none'}"
						>
						<thead>
							<tr>
								<th>Employee ID</th>
								<th>Employee Name</th>
								<th>Salary</th>
								<th>Overtime / benefit</th>
								<th>Deduction</th>
								<th>Net Payable</th>
								<th>Payment</th>
								<th>Comment</th>
							</tr>
						</thead>
						<tbody v-for="(payment,sl) in payments" :key="sl">
							
								<tr>
									<td colspan="8" style="font-size:13px;text-align:center; background: orange;"> <strong>Month:</strong> {{ payment.month_name }} || <strong>Payment Date:</strong> {{ payment.payment_date }} || <strong>Payment By:</strong> {{ payment.User_Name }} || <strong>Total Amount:</strong> {{ payment.total_payment_amount }}</td>
								</tr>

								<tr v-for="(employee, sl) in payment.details" :key="sl">
									<td>{{ employee.employee_code }}</td>
									<td>{{ employee.employee_name }}</td>
									<td style="text-align:right;">{{ employee.salary }}</td>
									<td style="text-align:center;">{{ employee.benefit }}</td>
									<td style="text-align:right;">{{ employee.deduction }}</td>
									<td style="text-align:right;">{{ employee.net_payable }}</td>
									<td style="text-align:right;">{{ employee.payment }}</td>
									<td>{{ employee.comment }}</td>
								</tr>
						</tbody>
					</table>

					<table 
						class="record-table" 
						v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'without_details'" 
						style="display:none" 
						v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}"
						>
						<thead>
							<tr>
								<th>Month</th>
								<th>Payment Date</th>
								<th>Payment By</th>
								<th>Total Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(payment,sl) in payments" :key="sl">
								<td>{{ payment.month_name }}</td>
								<td>{{ payment.payment_date }}</td>
								<td>{{ payment.User_Name }}</td>
								<td style="text-align:right;">{{ payment.total_payment_amount }}</td>
								<td style="text-align:center;">
									<span v-if="role != 'User'">
									<a href="" title="Delete Payment" @click.prevent="deletePayment(payment.id)"><i class="fa fa-trash"></i></a>
									</span>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr style="font-weight:bold;">
								<td colspan="3" style="text-align:right;">Total=</td>
								<td style="text-align:right;">{{ payments.reduce((prev, curr)=>{return prev + parseFloat(curr.total_payment_amount)}, 0) }}</td>
								<td></td>
							</tr>
						</tfoot>
					</table>

					<template
						v-if="searchTypesForDetails.includes(searchType)" style="display:none;"  v-bind:style="{display: searchTypesForDetails.includes(searchType) ? '' : 'none'}"
					>
						<div class="row" style="margin: unset;margin-bottom: 10px;">
							<div class="col-sm-6">
								<table style="float: left" class="custom_table">
									<tr>
										<th>Employee ID</th>
										<th>:</th>
										<th>{{payments.length > 0 ? payments[0].Employee_ID : ''}}</th>
									</tr>
									<tr>
										<th>Employee Name</td>
										<th>:</th>
										<th>{{payments.length > 0 ? payments[0].Employee_Name : ''}}</th>
									</tr>
								</table>
							</div>
							<div class="col-sm-6">
								<table style="float: right" class="custom_table">
									<tr>
										<th>Department</th>
										<th>:</th>
										<th>{{payments.length > 0 ? payments[0].Department_Name : ''}}</th>
									</tr>
									<tr>
										<th>Designation</th>
										<th>:</th>
										<th>{{payments.length > 0 ? payments[0].Designation_Name : ''}}</th>
									</tr>
								</table>
							</div>
						</div>
						
						<table class="record-table">
							<thead>
								<tr>
									<th>Month</th>
									<th>Payment Date</th>
									<th>Salary</th>
									<th>Ovetime / Other Benefit</th>
									<th>Deduction</th>
									<th>Net Payable</th>
									<th>Payment</th>
									<th>Note</th>
								</tr>
							</thead>
							<tbody> 
								<tr v-for="(payment,sl) in payments" :key="sl">
									<td>{{ payment.month_name }}</td>
									<td>{{ payment.payment_date }}</td>
									<td style="text-align:right;">{{ payment.salary }}</td>
									<td style="text-align:right;">{{ payment.benefit }}</td>
									<td style="text-align:right;">{{ payment.deduction }}</td>
									<td style="text-align:right;">{{ payment.net_payable }}</td>
									<td style="text-align:right;">{{ payment.payment }}</td>
									<td>{{ payment.comment }}</td>
								</tr> 
							</tbody>
							<tfoot>
								<tr style="font-weight:bold;">
									<td colspan="2" style="text-align:right;">Total=</td>
									<td style="text-align:right;">{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.salary)}, 0) | decimal }}</td>
									<td style="text-align:right;">{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.benefit)}, 0) | decimal }}</td>
									<td style="text-align:right;">{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.deduction)}, 0) | decimal }}</td>
									<td style="text-align:right;">{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.net_payable)}, 0) | decimal }}</td>
									<td style="text-align:right;">{{ payments.reduce((prev, curr) => { return prev + parseFloat(curr.payment)}, 0) | decimal }}</td>
									<td></td>
								</tr>
							</tfoot>
						</table>
					</template>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import moment from 'moment';
export default {
    props: ['role','code'],
    data(){
			return {
				searchType: '',
				recordType: 'without_details',
				months: [],
				selectedMonth: null,
				employees: [],
				selectedEmployee: null,
				payments: [],
				searchTypesForRecord: ['', 'month'],
				searchTypesForDetails: ['employee']
			}
		},
		filters: {
            decimal(value) {
                return value == null || value == '' ? '0.00' : parseFloat(value).toFixed(2);
            }
        },
		methods: {
			onChangeSearchType(){
				this.payments = [];
				if(this.searchType == 'month'){
					this.getMonths();
				}else if(this.searchType == 'employee'){
					this.getMonths();
					this.getEmployees();
				}
			},
			getMonths() {
				axios.get('/get_months').then(res => {
					this.months = res.data;
				})
			},
			getEmployees(){
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getSearchResult(){
				if(this.searchType == ''){
					this.selectedMonth = null;
				}

				if(this.searchType != 'employee'){
					this.selectedEmployee = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)){
					this.getPaymentsRecord();
				} else {
					this.getPaymentDetails();
				}
			},
			getPaymentsRecord(){
				if( this.searchType == 'month' && this.selectedMonth == null){
					alert('Select Month');
					return;
				}

				let filter = {
					month_id: this.selectedMonth == null ? '' : this.selectedMonth.id
				}

				if(this.recordType == 'with_details'){
					filter.with_details = true;
				}

				let url = '/get_salary_payment';

				axios.post(url, filter)
				.then(res => {
					this.payments = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			getPaymentDetails(){
				if(this.selectedEmployee == null){
					alert('Select Employee');
					return;
				}
				let filter = {
					month_id: this.selectedMonth == null ? '' : this.selectedMonth.id,
					employee_id: this.selectedEmployee.id
				}

				axios.post('/get_salary_details', filter)
				.then(res => {
					this.payments = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			deletePayment(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-salary-payment',{id: id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getPaymentsRecord();
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
								<h3>Employee Payment Record</h3>
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
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
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
						.custom_table th{
							padding: 5px;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				if(this.searchType == '' && this.searchType == 'month' && this.recordType == 'without_details'){
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