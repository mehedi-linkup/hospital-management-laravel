<style scoped>
    .v-select{
		margin-top:4px;
        float: right;
        min-width: 180px;
        margin-left: 5px;
	}
</style>

<template>
<div>
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" @submit.prevent="getSearchResult">
				<div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="supplier">By Supplier</option>
						<option value="quantity">By Quantity</option>
						<option value="user">By User</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'supplier' && suppliers.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">Supplier</label>
					<v-select v-bind:options="suppliers" v-model="selectedSupplier" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'quantity' && products.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">Medicine</label>
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' && users.length > 0 ? '' : 'none'}">
					<label style="margin-top:5px;">User</label>
					<v-select v-bind:options="users" v-model="selectedUser" label="name"></v-select>
				</div>

				<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
					<label>Record Type</label>
					<select class="form-control" v-model="recordType" @change="purchaseReturns = []">
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

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: purchaseReturns.length > 0 ? '' : 'none'}">
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
							<th>Supplier Name</th>
							<th>Product Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody v-for="(purchaseReturn,sl) in purchaseReturns" :key='sl'>
							<tr>
								<td>{{ purchaseReturn.invoice_number }}</td>
								<td>{{ purchaseReturn.return_date }}</td>
								<td>{{ purchaseReturn.display_name }}</td>
								<td>{{ purchaseReturn.purchaseReturnDetails[0].display_text }}</td>
								<td style="text-align:right;">{{ purchaseReturn.purchaseReturnDetails[0].return_rate | decimal }}</td>
								<td style="text-align:center;">{{ purchaseReturn.purchaseReturnDetails[0].quantity }}</td>
								<td style="text-align:right;">{{ purchaseReturn.purchaseReturnDetails[0].total_amount | decimal }}</td>
								<td style="text-align:center;">
									<a title="Purchase Return Invoice" v-bind:href="'/purchase_return_medicine_invoice/'+ purchaseReturn.id" target="_blank"><i class="fa fa-file-text"></i></a>
									<span v-if="role != 'User'">
									<a  title="Edit" v-bind:href="'/purchase_return_medicine/'+ purchaseReturn.id"><i class="fa fa-edit"></i></a>
									<a href="" title="Delete Purchase Return" @click.prevent="deletePurchase(purchaseReturn.id)"><i class="fa fa-trash"></i></a>
									</span>
								</td>
							</tr>
							<tr v-for="(product, sl) in purchaseReturn.purchaseReturnDetails.slice(1)" :key='sl'>
								<td colspan="3" v-bind:rowspan="purchaseReturn.purchaseReturnDetails.length - 1" v-if="sl == 0"></td>
								<td>{{ product.display_text }}</td>
								<td style="text-align:right;">{{ product.return_rate | decimal }}</td>
								<td style="text-align:center;">{{ product.quantity }}</td>
								<td style="text-align:right;">{{ product.total_amount | decimal }}</td>
								<td></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="5" style="font-weight:normal;"><strong>Note: </strong>{{ purchaseReturn.remark }}</td>
								<td style="text-align:center;">Total Quantity<br>{{ purchaseReturn.purchaseReturnDetails.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0)}}</td>
								<td style="text-align:right;">
									Total: {{ purchaseReturn.total_amount | decimal }}<br>
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
							<th>Supplier Name</th>
							<th>Total Amount</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(purchaseReturn,sl) in purchaseReturns" :key='sl'>
							<td>{{ purchaseReturn.invoice_number }}</td>
							<td>{{ purchaseReturn.return_date }}</td>
							<td>{{ purchaseReturn.display_name }}</td>
							<td style="text-align:right;">{{ purchaseReturn.total_amount | decimal }}</td>
							<td style="text-align:left;">{{ purchaseReturn.remark }}</td>
							<td style="text-align:center;">
								<a title="Purchase Return Invoice" v-bind:href="'/purchase_return_medicine_invoice/'+ purchaseReturn.id" target="_blank"><i class="fa fa-file-text"></i></a>
								<span v-if="role != 'User'">
								<a  title="Edit" v-bind:href="'/purchase_return_medicine/'+ purchaseReturn.id"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Purchase Return" @click.prevent="deletePurchase(purchaseReturn.id)"><i class="fa fa-trash"></i></a>
								</span>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ purchaseReturns.reduce((prev, curr)=>{return prev + parseFloat(curr.total_amount)}, 0) | decimal }}</td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
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
							<th>Supplier Name</th>
							<th>Product Name</th>
							<th>Purchases Rate</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<tr  v-for="(purchaseReturn,sl) in purchaseReturns" :key='sl'>
							<td>{{ purchaseReturn.invoice_number }}</td>
							<td>{{ purchaseReturn.return_date }}</td>
							<td>{{ purchaseReturn.display_name }}</td>
							<td>{{ purchaseReturn.display_text }}</td>
							<td style="text-align:right;">{{ purchaseReturn.return_rate }}</td>
							<td style="text-align:right;">{{ purchaseReturn.quantity }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total Quantity</td>
							<td style="text-align:right;">{{ purchaseReturns.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
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
	filters: {
			decimal(value) {
				return parseFloat(value).toFixed(2) ?? '0.00';
			}
		},
    data(){
			return {
				searchType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				suppliers: [],
				selectedSupplier: null,
				products: [],
				selectedProduct: null,
				users: [],
				selectedUser: null,
				purchaseReturns: [],
				searchTypesForRecord: ['', 'user', 'supplier'],
				searchTypesForDetails: ['quantity']
			}
		},
        created(){
            this.getBranchInfo();
        },
		methods: {
			onChangeSearchType(){
				this.purchaseReturns = [];
				if(this.searchType == 'quantity'){
					this.getProducts();
				} 
				else if(this.searchType == 'user'){
					this.getUsers();
				}
				else if(this.searchType == 'supplier'){
					this.getSuppliers();
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
			getSuppliers(){
				axios.get('/get_supplierpharmacys').then(res => {
					this.suppliers = res.data;
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

				if(this.searchType != 'quantity'){
					this.selectedProduct = null;
				}

				if(this.searchType != 'supplier'){
					this.selectedSupplier = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)) {
					this.getPurchaseReturnRecord();
				} else {
					this.getPurchaseDetails();
				}
			},
			getPurchaseReturnRecord(){
				let filter = {
					userId: this.selectedUser == null || this.selectedUser.name == '' ? '' : this.selectedUser.id,
					supplier_id: this.selectedSupplier == null ? '' : this.selectedSupplier.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

                if(this.recordType == 'with_details'){
                    filter.with_details = true;
                }

				let url = '/get_purchase_return_medicine';
				

				axios.post(url, filter)
				.then(res => {
						this.purchaseReturns = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			getPurchaseDetails(){
				let filter = {
					productId: this.selectedProduct == null || this.selectedProduct.id == '' ? '' : this.selectedProduct.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_return_madicine_details', filter)
				.then(res => {
					this.purchaseReturns = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},

        deletePurchase(purchaseReturnId){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: 'Want to delete this?',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-purchase-return-medicine',{id: purchaseReturnId}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        this.getPurchaseReturnRecord();
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

				let supplierText = '';
				if(this.selectedSupplier != null && this.selectedSupplier.id != '' && this.searchType == 'quantity'){
					supplierText = `<strong>Supplier: </strong> ${this.selectedSupplier.name}<br>`;
				}

				let productText = '';
				if(this.selectedProduct != null && this.selectedProduct.id != '' && this.searchType == 'quantity'){
					productText = `<strong>Product: </strong> ${this.selectedProduct.name}`;
				}


				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Purchase Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText} ${supplierText} ${productText} 
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