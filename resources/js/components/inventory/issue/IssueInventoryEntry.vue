
<template>
    <div class="row" id="purchase">
	

	<div class="col-xs-12 col-md-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Employee & Instrument Information</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Employee </label>
								<div class="col-xs-7">
									<v-select :options="employees" name="department_id" label="display_name" v-model="selectedEmployee"></v-select>
									
								</div>
								<div class="col-xs-1" style="padding: 0; margin-left: -10px;">
									<a href="/employee_entry" target="_blank" title="Add New Supplier" class="add-button"><i class="fa fa-plus"></i></a>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Mobile No </label>
								<div class="col-xs-8">
									<input v-if="selectedEmployee" type="text" placeholder="Mobile No" class="form-control" v-model="selectedEmployee.mobile_number" disabled />
									<input v-else type="text" placeholder="Mobile No" class="form-control" disabled />
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Address </label>
								<div class="col-xs-8">
									<textarea v-if="selectedEmployee" class="form-control" v-model="selectedEmployee.present_address" disabled></textarea>
									<textarea v-else class="form-control" disabled></textarea>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<form v-on:submit.prevent="addToCart">
								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Instrument </label>
									<div class="col-xs-7">
										<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="onChangeProduct"></v-select>
									</div>
									<div class="col-xs-1" style="padding: 0;">
										<a href="/instrument_entry" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Stock </label>
									<div class="col-xs-8">
										<div class="text-center" v-if="selectedProduct" v-bind:style="{color: productStock > 0 ? 'green' : 'red'}" style="border:none;height:23px;text-align: left; font-size:16px; background-color: #E4E6E9;width:100%; padding-left:5px; margin-bottom: 5px; ">{{ productStock }}</div>
										<div class="text-center" v-else v-bind:style="{color: productStock > 0 ? 'green' : 'red'}" style="border:none;height:23px;text-align: left; font-size:16px; background-color: #E4E6E9;width:100%; padding-left:5px; margin-bottom: 5px; ">0</div>
										
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Quantity </label>
									<div class="col-xs-8">
										<input type="text" v-if="selectedProduct" step="0.01" id="quantity" name="quantity" class="form-control" placeholder="Quantity" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" required/>
										<input v-else type="text" placeholder="Quantity" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> </label>
									<div class="col-xs-8">
										<button type="submit" class="btn btn-default pull-right">Add Cart</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
					<thead>
						<tr>
							<th style="width:4%;color:#000;">SL</th>
							<th style="width:40%;color:#000;">Instrument Name</th>
							<th style="width:10%;color:#000;">Unit</th>
							<th style="width:10%;color:#000;">Quantity</th>
							<th style="width:5%;color:#000;">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart" :key="sl">
							<td>{{ sl + 1}}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.unit_name }}</td>
							<td>{{ product.quantity }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align: right;">Total: </td>
							<td>{{ cart.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0) }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="col-xs-12 col-md-3 col-lg-3">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Invoice Details</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive">
								<table style="color:#000;margin-bottom: 0px;">
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Invoice no</label>
												<div class="col-xs-12">
													<input type="text" id="invoice" name="invoice" class="form-control" v-model="issue.invoice_number" readonly />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Date</label>
												<div class="col-xs-12">
													<input class="form-control" id="purchaseDate" name="purchaseDate" type="date" v-model="issue.issue_date" v-bind:disabled="role == 'User' ? true : false"/>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Note</label>
												<div class="col-xs-12">
													<textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="issue.note"></textarea>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<div class="col-xs-6">
													<input type="button" class="btn btn-success" value="Issue" v-on:click="saveIssue" v-bind:disabled="purchaseOnProgress == true ? true : false" style="background:#000;color:#fff;padding:3px;width:100%;">
												</div>
												<div class="col-xs-6">
													<input type="button" class="btn btn-info" onclick="window.location = '/issue_inventory'" value="New Issue" style="background:#000;color:#fff;padding:3px;width:100%;">
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</template>
<script>
import moment from 'moment';
export default {
    props: ['role','id','invoice'],
    data(){
		
			return{
				issue: {
					id              : '',
					invoice_number  : '',
					issue_date      : moment().format('YYYY-MM-DD'),
					employee_id     : '',
					note            : ''
				},
				branches: [],
				
				employees: [],
				selectedEmployee: {
					id             : null,
					display_text   : 'Select Employee',
					mobile_number  : '',
					present_address: ''
				},
				oldEmployeeId: null,
                oldPreviousDue: 0,
				products: [],
				selectedProduct: {
					id            : '',
					display_name  : 'Select Instrument',
					product_Name  : '',
					unit_Name     : '',
					quantity      : 0,
					purchase_price: 0,
				},
				
				cart: [],
				productStockText: '',
				productStock : '',
				purchaseOnProgress: false
			}
		},
		async created(){
			this.issue.id= this.id;
			this.issue.invoice_number = this.invoice;
			await this.getEmployees();
			this.getProducts();
			if(this.id != 0){
            	this.getIssue();
        	}
		},
		methods:{
			
			async getEmployees(){
				await axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getProducts(){
				axios.post('/get_instruments').then(res=>{
					this.products = res.data;
				})
			},
			
			async onChangeProduct(){
				if(this.selectedProduct !=null){
					this.productStock = await axios.post('/get_instrument_stock', {productId: this.selectedProduct.id}).then(res => {
						return res.data;
					})
					this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";
				}
				this.$refs.quantity.focus();
			},
			productTotal(){
				this.selectedProduct.total = this.selectedProduct.quantity * this.selectedProduct.purchase_price;
			},

			toggleProductPurchaseRate(){
				//this.productPurchaseRate = this.productPurchaseRate == '' ? this.selectedProduct.purchase_price : '';
				this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' : 'text';
			},

			addToCart(){
				
				let product = {
					productId     : this.selectedProduct.id,
					name          : this.selectedProduct.name,
					unit_name     : this.selectedProduct.unit_name,
					quantity      : this.selectedProduct.quantity,
					purchase_price: this.selectedProduct.purchase_price
				}

				if(product.quantity > this.productStock){
					alert('Stock unavailable');
					return;
				}
				let cartInd = this.cart.findIndex(p => p.productId == product.productId);
				if(cartInd > -1){
					this.cart.splice(cartInd, 1);
				}

				this.cart.unshift(product);
				this.clearSelectedProduct();
			},

			removeFromCart(ind){
				this.cart.splice(ind, 1);
			},
		
			clearSelectedProduct(){
				this.selectedProduct = {
					id          : '',
					display_text: 'Select Instrument',
					product_Name: '',
					unit_Name   : '',
					quantity    : 0,
				}
				this.productStock = '';
				this.productStockText = '';
			},
			
			
			saveIssue(){
				if(this.selectedEmployee == null){
					alert('Select supplier');
					return;
				}

				if(this.issue.issue_date == ''){
					alert('Enter Issue date');
					return;
				}

				if(this.cart.length == 0){
					alert('Cart is empty');
					return;
				}

				this.issue.employee_id      = this.selectedEmployee.id;
				
				
				let data = {
					issues      : this.issue,
					cartProducts: this.cart
				}

				

				let url = '/store-issue-inventory';
				if(this.issue.id != 0){
					url = '/update-issue-inventory';
				}

				axios.post(url, data).then(async res=>{
					let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/issue_invoice_print/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/issue_inventory';
					
				}).catch(error=>{
					this.progress = false;
					let e = error.response.data;
					if(e.hasOwnProperty('message')){
						this.$toaster.error(e.message);
					}else{
						Object.entries(e).forEach(([key, val])=>{
							this.$toaster.error(val[0]);
						})
					}
				})
			},

			getIssue(){
				axios.post('/get_issue_inventory', {issueId: this.id,with_details: true}).then(res => {
					let issues = res.data[0];
					console.log(issues.employee_id);
					this.selectedEmployee.id              = issues.employee_id;
					this.selectedEmployee.display_name    = issues.display_name;
					this.selectedEmployee.mobile_number   = issues.employee_mobile;
					this.selectedEmployee.present_address = issues.employee_address;
					this.issue.invoice_number             = issues.invoice_number;
					this.issue.issue_date                 = issues.issue_date;
					this.issue.employee_id                = issues.employee_id;
					this.issue.note                       = issues.remark;

					this.oldEmployeeId = issues.employee_id;

					//this.vatPercent = (this.purchases.vat_amount * 100) / this.purchases.subtotal;
					//console.log(purchases.supplier_id);
					
					issues.issueDetails.forEach(item => {
                    let cart = {
					id            : item.id,
					productId     : item.instrument_id,
					name          : item.product_name,
					unit_name     : item.unit_name,
					purchase_price: item.purchase_rate,
					quantity      : item.quantity
                    }
                    this.cart.push(cart);
                })
				})
			}
		
		}
	}

</script>