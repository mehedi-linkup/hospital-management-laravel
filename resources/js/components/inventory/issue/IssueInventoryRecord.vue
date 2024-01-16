
<style scoped>
.v-select{
		margin-top:1.5px;
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
						<option value="employee">By Employee</option>
						<option value="category">By Category</option>
						<option value="quantity">By Quantity</option>
						<option value="user">By User</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'employee' && employees.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">Employee</label>
					<v-select v-bind:options="employees" v-model="selectedEmployee" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'quantity' && products.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">Instrument</label>
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'category' && categories.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">Category</label>
					<v-select v-bind:options="categories" v-model="selectedCategory" label="name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' && users.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">User</label>
					<v-select v-bind:options="users" v-model="selectedUser" label="name"></v-select>
				</div>

				<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
					<label>Record Type</label>
					<select class="form-control" v-model="recordType" @change="issues = []">
						<option value="without_details">Without Details</option>
						<option value="with_details">With Details</option>
					</select>
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

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: issues.length > 0 ? '' : 'none'}">
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
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Employee Name</th>
							<th>Product Name</th>
							<th>Unit Name</th>
							<th>Quantity</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody v-for="(issue,sl) in issues" :key='sl'>
							<tr>
								<td>{{ issue.invoice_number }}</td>
								<td>{{ issue.issue_date }}</td>
								<td>{{ issue.display_name }}</td>
								<td>{{ issue.issueDetails[0].display_text }}</td>
								<td>{{ issue.issueDetails[0].unit_name }}</td>
								<td style="text-align:center;">{{ issue.issueDetails[0].quantity }}</td>
								<td style="text-align:center;">
									<a href="" title="Issue Invoice" v-bind:href="'/issue_invoice_print/'+ issue.id" target="_blank"><i class="fa fa-file-text"></i></a>
									<span v-if="role != 'User'">
									<a href="javascript:" title="Edit Issue" @click="checkReturnAndEdit(issue)"><i class="fa fa-edit"></i></a>
									<a href="" title="Delete Issue" @click.prevent="deleteIssue(issue.id)"><i class="fa fa-trash"></i></a>
									</span>
								</td>
							</tr>
							<tr v-for="(product, sl) in issue.issueDetails.slice(1)" :key='sl'>
								<td colspan="3" v-bind:rowspan="issue.issueDetails.length - 1" v-if="sl == 0"></td>
								<td>{{ product.display_text }}</td>
								<td style="text-align:center;">{{ product.unit_name }}</td>
								<td style="text-align:center;">{{ product.quantity }}</td>
								<td></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="5" style="font-weight:normal;"><strong>Note: </strong>{{ issue.remark }}</td>
								<td style="text-align:center;">Total Quantity<br>{{ issue.issueDetails.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0) }}</td>
								<td></td>
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
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Employee Name</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(issue,sl) in issues" :key='sl'>
							<td>{{ issue.invoice_number }}</td>
							<td>{{ issue.issue_date }}</td>
							<td>{{ issue.display_name }}</td>
							<td style="text-align:left;">{{ issue.remark }}</td>
							<td style="text-align:center;">
								<a href="" title="Issue Invoice" v-bind:href="'/issue_invoice_print/'+ issue.id" target="_blank"><i class="fa fa-file-text"></i></a>
								<span v-if="role != 'User'">
								<a href="javascript:" title="Edit Issue" @click="checkReturnAndEdit(issue)"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Issue" @click.prevent="deleteIssue(issue.id)"><i class="fa fa-trash"></i></a>
								</span>
							</td>
						</tr>
					</tbody>
					
				</table>

				<table 
					class="record-table" 
					v-if="searchTypesForDetails.includes(searchType)"  
					style="display:none;" 
					v-bind:style="{display: searchTypesForDetails.includes(searchType) ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Employee Name</th>
							<th>Product Name</th>
							<th>Unit</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<tr  v-for="(issue,sl) in issues" :key='sl'>
							<td>{{ issue.invoice_number }}</td>
							<td>{{ issue.issue_date }}</td>
							<td>{{ issue.display_name }}</td>
							<td>{{ issue.display_text }}</td>
							<td style="">{{ issue.unit_name }}</td>
							<td style="text-align:right;">{{ issue.quantity }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total Quantity</td>
							<td style="text-align:right;">{{ issues.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
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
    props: ['role'],
    data(){
			return {
				searchType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				employees: [],
				selectedEmployee: null,
				products: [],
				selectedProduct: null,
				users: [],
				selectedUser: null,
				categories: [],
				selectedCategory: null,
				issues: [],
				searchTypesForRecord: ['', 'user', 'employee'],
				searchTypesForDetails: ['quantity', 'category']
			}
		},
        created(){
            this.getBranchInfo();
        },
		methods: {
			checkReturnAndEdit(issue){
				axios.get('/check_issue_inventroy_return/' + issue.invoice_number).then(res=>{
					if(res.data.found){
						alert('Unable to edit. Issue return found!');
					}else{
						location.replace('/issue_inventory/'+issue.id);
					}
				})
			},
			onChangeSearchType(){
				this.issues = [];
				if(this.searchType == 'quantity'){
					this.getProducts();
				} 
				else if(this.searchType == 'user'){
					this.getUsers();
				}
				else if(this.searchType == 'category'){
					this.getCategories();
				}
				else if(this.searchType == 'employee'){
					this.getEmployees();
				}
			},
            getBranchInfo(){
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
                })
            },
			getProducts(){
				axios.get('/get_instruments').then(res => {
					this.products = res.data;
				})
			},
			getEmployees(){
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getUsers(){
				axios.get('/get_users').then(res => {
					this.users = res.data;
				})
			},
			getCategories(){
				axios.get('/get_categories_inventory').then(res => {
					this.categories = res.data;
				})
			},
			getSearchResult(){
				if(this.searchType != 'user'){
					this.selectedUser = null;
				}

				if(this.searchType != 'quantity'){
					this.selectedProduct = null;
				}

				if(this.searchType != 'category'){
					this.selectedCategory = null;
				}

				if(this.searchType != 'employee'){
					this.selectedEmployee = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)) {
					this.getIssueRecord();
				} else {
					this.getIssueDetails();
				}
			},
			getIssueRecord(){
				let filter = {
					userId: this.selectedUser == null || this.selectedUser.name == '' ? '' : this.selectedUser.id,
					employee_id: this.selectedEmployee == null ? '' : this.selectedeEmployee.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

                if(this.recordType == 'with_details'){
                    filter.with_details = true;
                }

				let url = '/get_issue_inventory';
				

				axios.post(url, filter)
				.then(res => {
						this.issues = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			getIssueDetails(){
				let filter = {
					categoryId: this.selectedCategory == null || this.selectedCategory.id == '' ? '' : this.selectedCategory.id,
					productId: this.selectedProduct == null || this.selectedProduct.id == '' ? '' : this.selectedProduct.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_issue_inventory_details', filter)
				.then(res => {
					this.issues = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},

        deleteIssue(issueId){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-issue-inventory',{id: issueId}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        this.getIssueRecord();
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

				let employeeText = '';
				if(this.selectedEmployee != null && this.selectedEmployee.id != '' && this.searchType == 'employee'){
					employeeText = `<strong>Employee: </strong> ${this.selectedEmployee.name}<br>`;
				}

				let productText = '';
				if(this.selectedProduct != null && this.selectedProduct.id != '' && this.searchType == 'quantity'){
					productText = `<strong>Product: </strong> ${this.selectedProduct.name}`;
				}

				let categoryText = '';
				if(this.selectedCategory != null && this.selectedCategory.id != '' && this.searchType == 'category'){
					categoryText = `<strong>Category: </strong> ${this.selectedCategory.name}`;
				}


				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Issue Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText} ${employeeText} ${productText} ${categoryText}
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