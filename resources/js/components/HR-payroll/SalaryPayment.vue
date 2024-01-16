<style scoped>
.v-select{
		margin-top:-2.5px;
        float: right;
        min-width: 180px;
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
<template>
    <div id="employeeSalary">
	<div class="row" style="border-bottom:1px solid #ccc;padding: 10px 0;">
		<div class="col-md-12">
			<form class="form-inline" @submit.prevent="getEmployees">

				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right"> Month </label>
					<div class="col-sm-7">
					<v-select v-bind:options="months" label="name" v-model="month" v-on:input="employees = []"></v-select>
					</div>
					<div class="col-sm-1" style="padding: 0;">
						<a href="/month_entry" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Month"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
					</div>
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" class="search-button" value="Show">
				</div>
			</form>
		</div>
	</div>
	<br>
	<div class="row" v-if="employees.length > 0">
		<div class="col-md-12">
            
            <div  style="margin-top: -15px; margin-bottom: 2px;">
                <div class="form-group col-sm-4">
				    <label>Salary Date</label>
				    <input style="height: 25px;" type="date" v-model="salaryPayment.payment_date">
                </div>
                <div class="form-group col-sm-4">
				    <label>Transaction No.</label>
				    <input style="height: 25px;" type="text" v-model="salaryPayment.transaction_number ">
                </div>
			</div>
            </div>
        <div class="col-md-12">

			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>SL</th>
							<th>Employee Id</th>
							<th>Name</th>
							<th>Department</th>
							<th>Designation</th>
							<th>Salary</th>
							<th>Ovetime / Other Benefit</th>
							<th>Deduction</th>
							<th>Net Payable</th>
							<th>Paid</th>
							<th>Comment</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(employee, sl) in employees" :key="sl" v-bind:style="{background: employee.net_payable != employee.payment ? 'orange' : ''}">
							<td>{{ ++sl }}</td>
							<td>{{ employee.employee_code }}</td>
							<td>{{ employee.employee_name }}</td>
							<td>{{ employee.department_name }}</td>
							<td>{{ employee.designation_name }}</td>
							<td style="text-align: center;">{{ employee.salary }}</td>
							<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="employee.benefit" v-on:input="calculateNetPayable(employee)"></td>
							<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="employee.deduction" v-on:input="calculateNetPayable(employee)"></td>
							<td style="text-align: center;">{{employee.net_payable}}</td>
							<td><input style="width: 100px;height: 20px; text-align:center;" type="number" v-model="employee.payment" v-on:input="checkPayment(employee)"></td>
							<td><textarea style="height: 23px;" cols="" rows="1" v-model="employee.comment"></textarea></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="9" style="text-align: right;">Total=</td>
							<td>{{ employees.reduce((prev, curr)=>{ return prev + parseFloat(curr.payment) }, 0) }}</td>
							<td></td>
						</tr>
						<tr>
							<td colspan="11">
								<button type="button" @click="SaveSalaryPayment" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-right">
									Save
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
</template>
<script>
import moment from 'moment';
export default {
    props: ['role','code'],
    data() {
			return {
				salaryPayment: {
					id: null,
					payment_date: moment().format("YYYY-MM-DD"),
					month_id: null,
				},
				employees: [],
				months: [],
				month: null,
				payment: false,
			}
		},
		created() {
            if(!this.payment) {
            this.salaryPayment.transaction_number = this.code;
            }
			this.getMonths();
		},
		methods: {
			checkPayment(employee){
				if(parseFloat(employee.payment) > parseFloat(employee.net_payable)){
					alert("Can not paid greater than net payable");
					employee.payment = employee.net_payable;
				}
			},
			calculateNetPayable(employee){
				let payable = ((parseFloat(employee.salary) + parseFloat(employee.benefit)) - parseFloat(employee.deduction)).toFixed(2);

				employee.net_payable = payable;
				employee.payment     = payable;
			},
			async getEmployees() {
				if(this.month == null){
					alert("Select Month");
					return;
				}
				let month_id = this.month.id;

				this.salaryPayment.month_id = month_id;

				await axios.post('/check_payment_month', {month_id:this.month.id})
				.then(res=>{
					this.payment = false;
					if(res.data.success){
						this.payment = true;
					}
				})
				
				if(this.payment){
					await axios.post('/get_salary_payment', {month_id: month_id, with_details: true}).then(res => {
						let payment = res.data[0];
						this.salaryPayment.id = payment.id;
						this.salaryPayment.payment_date = payment.payment_date;
						this.salaryPayment.transaction_number = payment.transaction_number ;
						this.salaryPayment.month_id = payment.month_id;
						this.employees = payment.details;
					})
				} else {
					await axios.post('/get_employees',{status:'a'}).then(res => {
						let employees = res.data;

						employees.map(employee=>{
							employee.salary = employee.salary_range;
							employee.benefit = 0;
							employee.deduction = 0;
							employee.net_payable = employee.salary_range;
							employee.payment = employee.salary_range;
							employee.comment = '';
							return employee;
						});

						this.employees = employees;
						this.salaryPayment.payment_date = moment().format("YYYY-MM-DD");
					})

					.catch(function (error) {
						console.log(error);
					});
				}	
			},

			getMonths() {
				axios.get('/get_months').then(res => {
					this.months = res.data;
				})
			},

			SaveSalaryPayment() {
				
				let data = {
					payment: this.salaryPayment,
					employees: this.employees,
					
				}
				let url = '/store-salary-payment';
				if(this.payment) {
					url = '/update-salary-payment';
				}
				

                axios.post(url, data).then(res=>{
                    let r = res.data;
                    this.$toaster.success(r.message);
                    this.getMonths();
                    this.resetForm();
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
                
			},

			resetForm(){
				this.salaryPayment = {
					id: null,
					payment_date: moment().format("YYYY-MM-DD"),
					month_id: null,
				},
				this.month = null,
				this.employees = [];
			}
		}
}
</script>