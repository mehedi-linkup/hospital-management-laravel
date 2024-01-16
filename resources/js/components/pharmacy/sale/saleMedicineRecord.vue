
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
						<option value="patient">By Patient</option>
						<option value="category">By Category</option>
						<option value="quantity">By Quantity</option>
						<option value="user">By User</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'patient' && patients.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">Patient</label>
					<v-select v-bind:options="patients" v-model="selectedPatient" label="display_name"></v-select>
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
					<select class="form-control" v-model="recordType" @change="sales = []">
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

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: sales.length > 0 ? '' : 'none'}">
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
							<th>Patient Name</th>
							<th>Product Name</th>
							<th>Unit Name</th>
							<th>Quantity</th>
							<th>Rate</th>
							<th>Total Sale</th>
							<th>Discount</th>
							<th>Total Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody v-for="(sale,sl) in sales" :key='sl'>
							<tr>
								<td>{{ sale.invoice_number }}</td>
								<td>{{ sale.order_date }}</td>
								<td>{{ sale.display_name }}</td>
								<td>{{ sale.saleDetails[0].display_text }}</td>
								<td>{{ sale.saleDetails[0].unit_name }}</td>
								<td style="text-align:center;">{{ sale.saleDetails[0].quantity }}</td>
								<td style="text-align:center;">{{ sale.saleDetails[0].sale_rate }}</td>
								<td style="text-align:center;">{{ sale.saleDetails[0].total_sale_rate }}</td>
								<td style="text-align:center;">{{ sale.saleDetails[0].discount_amount }}</td>
								<td style="text-align:right;">{{ sale.saleDetails[0].total_amount }}</td>
								<td style="text-align:center;">
									<a title="Sale Invoice" v-bind:href="'/sale_medicine_invoice_print/'+ sale.id" target="_blank"><i class="fa fa-file-text"></i></a>
									<span v-if="role != 'User'">
									<a href="javascript:" title="Edit Sale" @click="checkReturnAndEdit(sale)"><i class="fa fa-edit"></i></a>
									<a href="" title="Delete Sale" @click.prevent="deleteIssue(sale.id)"><i class="fa fa-trash"></i></a>
									</span>
								</td>
							</tr>
							<tr v-for="(product, sl) in sale.saleDetails.slice(1)" :key='sl'>
								<td colspan="3" v-bind:rowspan="sale.saleDetails.length - 1" v-if="sl == 0"></td>
								<td>{{ product.display_text }}</td>
								<td style="text-align:center;">{{ product.unit_name }}</td>
								<td style="text-align:center;">{{ product.quantity }}</td>
								<td style="text-align:center;">{{ product.sale_rate }}</td>
								<td style="text-align:center;">{{ product.total_sale_rate.toFixed(2) }}</td>
								<td style="text-align:center;">{{ product.discount_amount.toFixed(2) }}</td>
								<td style="text-align:right;">{{ product.total_amount.toFixed(2) }}</td>
								<td></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="5" style="font-weight:normal;"><strong>Note: </strong>{{ sale.remark }}</td>
								<td style="text-align:center;">Total Quantity<br>{{ sale.saleDetails.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0) }}</td>
								<td></td>
								<td></td>
								<td></td>
								<td style="text-align:right;">
									Total: {{ sale.total.toFixed(2) }}<br>
									Paid: {{ sale.paid.toFixed(2) }}<br>
									Due: {{ sale.due.toFixed(2) }}
								</td>
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
							<th>Patient Name</th>
							<th>Sub Total</th>
							<th>VAT</th>
							<th>Discount</th>
							<th>Transport Cost</th>
							<th>Total</th>
							<th>Paid</th>
							<th>Due</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(sale,sl) in sales" :key='sl'>
							<td>{{ sale.invoice_number }}</td>
							<td>{{ sale.order_date }}</td>
							<td>{{ sale.display_name }}</td>
							<td style="text-align:right;">{{ sale.subtotal }}</td>
							<td style="text-align:right;">{{ sale.vat_amount }}</td>
							<td style="text-align:right;">{{ sale.discount_amount }}</td>
							<td style="text-align:right;">{{ sale.transport_cost }}</td>
							<td style="text-align:right;">{{ sale.total }}</td>
							<td style="text-align:right;">{{ sale.paid }}</td>
							<td style="text-align:right;">{{ sale.due }}</td>
							<td style="text-align:left;">{{ sale.remark }}</td>
							<td style="text-align:center;">
								<a title="Sale Invoice" v-bind:href="'/sale_medicine_invoice_print/'+ sale.id" target="_blank"><i class="fa fa-file-text"></i></a>
								<span v-if="role != 'User'">
								<a href="javascript:" title="Edit Sale" @click="checkReturnAndEdit(sale)"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Sale" @click.prevent="deleteSale(sale.id)"><i class="fa fa-trash"></i></a>
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
							<th>Patient Name</th>
							<th>Product Name</th>
							<th>Unit</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<tr  v-for="(sale,sl) in sales" :key='sl'>
							<td>{{ sale.invoice_number }}</td>
							<td>{{ sale.order_date }}</td>
							<td>{{ sale.display_name }}</td>
							<td>{{ sale.display_text }}</td>
							<td style="">{{ sale.unit_name }}</td>
							<td style="text-align:right;">{{ sale.quantity }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total Quantity</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
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
				patients: [],
				selectedPatient: null,
				products: [],
				selectedProduct: null,
				users: [],
				selectedUser: null,
				categories: [],
				selectedCategory: null,
				sales: [],
				searchTypesForRecord: ['', 'user', 'patient'],
				searchTypesForDetails: ['quantity', 'category']
			}
		},
        created(){
            this.getBranchInfo();
        },
		methods: {
			checkReturnAndEdit(sale){
				// axios.get('/check_issue_inventroy_return/' + sale.invoice_number).then(res=>{
				// 	if(res.data.found){
				// 		alert('Unable to edit. Sale return found!');
				// 	}else{
						location.replace('/sale_medicine/'+sale.id);
				// 	}
				// })
			},
			onChangeSearchType(){
				this.sales = [];
				if(this.searchType == 'quantity'){
					this.getProducts();
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
			getProducts(){
				axios.get('/get_medicines').then(res => {
					this.products = res.data;
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
			getCategories(){
				axios.get('/get_categories_medicine').then(res => {
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

				if(this.searchType != 'patient'){
					this.selectedPatient = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)) {
					this.getSaleRecord();
				} else {
					this.getSaleDetails();
				}
			},
			getSaleRecord(){
				let filter = {
					userId: this.selectedUser == null || this.selectedUser.name == '' ? '' : this.selectedUser.id,
					patient_id: this.selectedPatient == null ? '' : this.selectedPatient.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

                if(this.recordType == 'with_details'){
                    filter.with_details = true;
                }

				let url = '/get_sale_medicine';
				

				axios.post(url, filter)
				.then(res => {
						this.sales = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			getSaleDetails(){
				let filter = {
					categoryId: this.selectedCategory == null || this.selectedCategory.id == '' ? '' : this.selectedCategory.id,
					productId: this.selectedProduct == null || this.selectedProduct.id == '' ? '' : this.selectedProduct.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_sale_medicine_details', filter)
				.then(res => {
					this.sales = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},

		deleteSale(saleId){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-sale-medicine',{id: saleId}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        this.getSaleRecord();
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
				if(this.selectedPatient != null && this.selectedPatient.id != '' && this.searchType == 'patient'){
					employeeText = `<strong>Patient: </strong> ${this.selectedPatient.name}<br>`;
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
								<h3>Sale Record</h3>
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