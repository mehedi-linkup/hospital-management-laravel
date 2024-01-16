
<style scoped>
 
.no-padding-right{
	padding: 0px !important;
}
.widget-box{
	margin-top:0px !important;
	margin-bottom:5px !important;
	border: 0px solid #fff !important;
}
.widget-header{
	border: 1px solid #ccc !important; 
	min-height: 26px !important; 
	background: #146C94 !important; 
	color:aliceblue !important; 
	font-weight: bolder !important;
}
.widget-title{
	line-height: 25px !important;
}
.widget-main{
	padding: 5px;
}
</style>
<template>
    <div class="row" id="purchase">

	<div class="col-xs-12 col-md-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Supplier & Product Information</h4>
			
			</div>

			<div class="widget-body">
				<div class="widget-main" style="border:1px solid #ccc">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Supplier </label>
								<div class="col-xs-7">
									<v-select v-bind:options="suppliers" class="select" v-model="selectedSupplier" v-on:input="onChangeSupplier" label="display_name"></v-select>
								</div>
								<div class="col-xs-1" style="padding: 0;">
									<a href="/supplier_inventory_entry" title="Add New Supplier" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
								</div>
							</div>

							<div class="form-group" style="display:none;" v-bind:style="{display: selectedSupplier.Supplier_Type == 'G' ? '' : 'none'}">
								<label class="col-xs-4 control-label no-padding-right"> Name </label>
								<div class="col-xs-8">
									<input type="text" placeholder="Supplier Name" class="form-control" v-model="selectedSupplier.name" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Mobile No </label>
								<div class="col-xs-8">
									<input type="text" placeholder="Mobile No" class="form-control" v-model="selectedSupplier.mobile" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Address </label>
								<div class="col-xs-8">
									<textarea class="form-control" v-model="selectedSupplier.address" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true"></textarea>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<form v-on:submit.prevent="addToCart">
								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Product </label>
									<div class="col-xs-7">
										<v-select v-bind:options="products" class="select"  v-model="selectedProduct" label="display_text" v-on:input="onChangeProduct"></v-select>
									</div>
									<div class="col-xs-1" style="padding: 0;">
										<a href="/instrument_entry" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>


								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Pur. Rate </label>
									<div class="col-xs-3">
										<input type="text" id="purchaseRate" name="purchaseRate" class="form-control" placeholder="Pur. Rate" v-model="selectedProduct.purchase_price" v-on:input="productTotal" required/>
									</div>

									<label class="col-xs-2 control-label no-padding-right"> Quantity </label>
									<div class="col-xs-3">
										<input type="text" step="0.01" id="quantity" name="quantity" class="form-control" placeholder="Quantity" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" required/>
									</div>
								</div>

								<div class="form-group" style="display:none;">
									<label class="col-xs-4 control-label no-padding-right"> Cost </label>
									<div class="col-xs-3">
										<input type="text" id="cost" name="cost" class="form-control" placeholder="Cost" readonly />
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Total Amount </label>
									<div class="col-xs-8">
										<input type="text" id="productTotal" name="productTotal" class="form-control" readonly v-model="selectedProduct.total"/>
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
						<tr style="background: #526D82;">
							<th style="width:4%;color:#fff;font-weight: 500">SL</th>
							<th style="width:20%;color:#fff;font-weight: 500">Product Name</th>
							<th style="width:8%;color:#fff;font-weight: 500">Pur. Rate</th>
							<th style="width:5%;color:#fff;font-weight: 500">Quantity</th>
							<th style="width:13%;color:#fff;font-weight: 500">Total Amount</th>
							<th style="width:5%;color:#fff;font-weight: 500">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart" :key="sl">
							<td>{{ sl + 1}}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.purchase_price }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.total }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>

						<tr>
							<td colspan="7"></td>
						</tr>

						<tr style="font-weight: bold;">
							<td colspan="4">Note</td>
							<td colspan="3">Total</td>
						</tr>

						<tr>
							<td colspan="4"><textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="purchase.note"></textarea></td>
							<td colspan="3" style="padding-top: 15px;font-size:18px;">{{ purchase.total }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-md-3 col-lg-3" style="
    	border: 1px solid #d1d1d1;
    	padding: 0px;
		margin-bottom: 5px;
		">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Invoice Details</h4>
			
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
												<label class="col-xs-4 control-label no-padding-right">Invoice no</label>
												<div class="col-xs-8">
													<input type="text" id="invoice" class="form-control" name="invoice" v-model="purchase.invoice_number" readonly/>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-4 control-label no-padding-right"> Date </label>
												<div class="col-xs-8">
													<input class="form-control" id="purchaseDate" name="purchaseDate" type="date" v-model="purchase.order_date" v-bind:disabled="role == 'User' ? true : false" />
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



	<div class="col-xs-12 col-md-3 col-lg-3" style="
    	border: 1px solid #d1d1d1;
    	padding: 0px;
		margin-bottom: 2px;
		">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Amount Details</h4>
			
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
												<label class="col-xs-4 control-label no-padding-right">Sub Total </label>
												<div class="col-xs-8">
													<input type="number" id="subTotal" name="subTotal" class="form-control" v-model="purchase.subtotal" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-4 control-label no-padding-right"> Vat </label>
												<div class="col-xs-8">
													<input type="number" id="vatPercent" name="vatPercent" v-model="vatPercent" v-on:input="calculateTotal" style="width:50px;height:25px;" />
													<span style="width:20px;"> % </span>
													<input type="number" id="vat" name="vat" v-model="purchase.vat_amount" readonly style="width:75px;height:25px;" />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group" style="padding-top:5px;">
												<label class="col-xs-4 control-label no-padding-right"> Discount </label>
												<div class="col-xs-8">
													<input type="number" id="discountPercent" v-model="discountPercent" v-on:input="calculateTotal" style="width:50px;height:25px;"/>
													<span style="width:20px;"> % </span>
													<input type="number" id="discount" v-model="purchase.discount_amount" v-on:input="calculateDiscountPercentage" style="width:75px;height:25px;"/>
												</div>
											</div>
					
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group" style="padding-top:5px;">
												<label class="col-xs-4 control-label no-padding-right">Other`s</label>
												<div class="col-xs-8">
													<input type="number" id="transport_cost" name="transport_cost" class="form-control" v-model="purchase.transport_cost" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-4 control-label no-padding-right">Total</label>
												<div class="col-xs-8">
													<input type="number" id="total" class="form-control" v-model="purchase.total" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-4 control-label no-padding-right">Paid</label>
												<div class="col-xs-8">
													<input type="number" id="paid" class="form-control" v-model="purchase.paid" v-on:input="calculateTotal"/>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-4 control-label no-padding-right">Due</label>
												<div class="col-xs-8">
													<input type="number" id="due" name="due" class="form-control" v-model="purchase.due" readonly />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-4 control-label no-padding-right">Previous Due</label>
												<div class="col-xs-8">
													<input type="number" id="previous_due" name="previous_due" class="form-control" v-model="purchase.previous_due" readonly style="color:red;" />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<div class="col-xs-6" style="padding-left:0px">
													<input type="button" class="btn btn-success" value="Purchase" v-on:click="savePurchase" v-bind:disabled="purchaseOnProgress == true ? true : false" style="background:#000;color:#fff;padding:3px;width:100%;">
												</div>
												<div class="col-xs-6" style="padding-right:0px">
													<input type="button" class="btn btn-info" onclick="window.location = '/purchase_inventory'" value="New Purch.." style="background:#000;color:#fff;padding:3px;width:100%;">
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
				purchase: {
					id              : '',
					invoice_number  : '',
					order_date      : moment().format('YYYY-MM-DD'),
					supplier_id     : '',
					subtotal        : 0.00,
					vat_percent     : 0.00,
					vat_amount      : 0.00,
					discount_amount : 0.00,
					discount_percent: 0.00,
					transport_cost  : 0.00,
					total           : 0.00,
					paid            : 0.00,
					due             : 0.00,
					previous_due     : 0.00,
					note            : ''
				},
				vatPercent: 0.00,
				discountPercent: 0.00,
				branches: [],
				
				suppliers: [],
				selectedSupplier: {
					id              : null,
					display_name    : 'Select Supplier',
					Supplier_Mobile : '',
					Supplier_Address: ''
				},
				oldSupplierId: null,
                oldPreviousDue: 0,
				products: [],
				selectedProduct: {
					id            : '',
					display_text  : 'Select Product',
					name          : '',
					quantity      : '',
					purchase_price: '',
					total         : ''
				},
				cart: [],
				purchaseOnProgress: false
			}
		},
		async created(){
			this.purchase.id= this.id;
			this.purchase.invoice_number = this.invoice;
			await this.getSuppliers();
			this.getProducts();
			if(this.id != 0){
            	this.getPurchase();
        	}
		},
		methods:{
			
			async getSuppliers(){
				await axios.get('/get_supplierinventorys').then(res => {
					this.suppliers = res.data;
				})
			},
			getProducts(){
				axios.post('/get_instruments').then(res=>{
					this.products = res.data;
				})
			},
			
				onChangeSupplier(){
				if(this.selectedSupplier.id == null){
					return;
				}


                if(this.purchase.id != 0 && this.oldSupplierId != parseInt(this.selectedSupplier.id)){
					let changeConfirm = confirm('Changing supplier will set previous due to current due amount. Do you really want to change supplier?');
					if(changeConfirm == false){
						return;
					}
				} else if(this.purchase.id != 0 && this.oldSupplierId == parseInt(this.selectedSupplier.id)){
					this.purchase.previous_due = this.oldPreviousDue;
					return;
				}

				axios.post('/get_supplier_due', {supplierId: this.selectedSupplier.id}).then(res => {
					if(res.data.getDues.length > 0){
						this.purchase.previous_due = res.data.getDues[0].dueAmount;
					} else {
						this.purchase.previous_due = 0;
					}
				})

				this.calculateTotal();
			},
					
			onChangeProduct(){
				this.$refs.quantity.focus();
			},
			productTotal(){
				this.selectedProduct.total = this.selectedProduct.quantity * this.selectedProduct.purchase_price;
			},
			addToCart(){
				// let cartInd = this.cart.findIndex(p => p.productId == this.selectedProduct.id);
				// if(cartInd > -1){
				// 	alert('Product exists in cart');
				// 	return;
				// }
				let product = {
					productId     : this.selectedProduct.id,
					name          : this.selectedProduct.name,
					purchase_price: this.selectedProduct.purchase_price,
					quantity      : this.selectedProduct.quantity,
					total         : this.selectedProduct.total
				}
				let cartInd = this.cart.findIndex(p => p.productId == product.productId);
				if(cartInd > -1){
					this.cart.splice(cartInd, 1);
				}

				this.cart.unshift(product);
				// this.cart.push(product);
				this.clearSelectedProduct();
				this.calculateTotal();
			},
			async removeFromCart(ind){
				if(this.cart[ind].id) {
					let stock = await axios.post('/get_instrument_stock', { productId: this.cart[ind].productId }).then(res => res.data);
					if(this.cart[ind].quantity > stock) {
						alert('Stock unavailable');
						return;
					}
				}
				this.cart.splice(ind, 1);
				this.calculateTotal();
			},
			clearSelectedProduct(){
				this.selectedProduct = {
					id            : '',
					display_text  : 'Select Product',
					name          : '',
					quantity      : '',
					purchase_price: '',
					total         : ''
				}
			},
			calculateTotal(){
				this.purchase.subtotal = this.cart.reduce((prev, curr) => { return prev + parseFloat(curr.total); }, 0).toFixed(2);
				this.purchase.vat_amount = ((this.purchase.subtotal * parseFloat(this.vatPercent)) / 100).toFixed(2);
				
				this.purchase.discount_amount = ((parseFloat(this.purchase.subtotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
				
				this.purchase.total = ((parseFloat(this.purchase.subtotal) + parseFloat(this.purchase.vat_amount) + parseFloat(this.purchase.transport_cost)) - parseFloat(this.purchase.discount_amount)).toFixed(2);
				
				if(event.target.id != 'paid') {
						this.purchase.paid = 0;
					}
						
				this.purchase.due = (parseFloat(this.purchase.total) - parseFloat(this.purchase.paid)).toFixed(2);
				console.log(this.purchase.due);
				
			},
			calculateDiscountPercentage(){
				this.purchase.subtotal = this.cart.reduce((prev, curr) => { return prev + parseFloat(curr.total); }, 0).toFixed(2);
				this.purchase.vat_amount = ((this.purchase.subtotal * parseFloat(this.vatPercent)) / 100).toFixed(2);
				
				this.discountPercent = (parseFloat(this.purchase.discount_amount) / parseFloat(this.purchase.subtotal) * 100).toFixed(2);
				
				this.purchase.total = ((parseFloat(this.purchase.subtotal) + parseFloat(this.purchase.vat_amount) + parseFloat(this.purchase.transport_cost)) - parseFloat(this.purchase.discount_amount)).toFixed(2);
				
				if(event.target.id != 'paid') {
						this.purchase.paid = 0;
					}
						
				this.purchase.due = (parseFloat(this.purchase.total) - parseFloat(this.purchase.paid)).toFixed(2);
				
			},
			savePurchase(){
				if(this.selectedSupplier.id == null){
					alert('Select supplier');
					return;
				}

				if(this.purchase.order_date == ''){
					alert('Enter purchase date');
					return;
				}

				if(this.cart.length == 0){
					alert('Cart is empty');
					return;
				}

				this.purchase.supplier_id      = this.selectedSupplier.id;
				this.purchase.vat_percent      = this.vatPercent;
				this.purchase.discount_percent = this.discountPercent;

				this.purchaseOnProgress = true;

				let data = {
					purchase: this.purchase,
					cartProducts: this.cart
				}

				

				let url = '/store-purchase-inventory';
				if(this.purchase.id != 0){
					console.log(this.purchase.id);
					url = '/update-purchaseinventory';
				}

				axios.post(url, data).then(async res=>{
					let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/purchase_invoice_print/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/purchase_inventory';
					
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

			getPurchase(){
				axios.post('/get_purchase_inventory', {purchaseId: this.id,with_details: true}).then(res => {
					let purchases = res.data[0];
					//console.log(purchase);
					this.selectedSupplier.id           = purchases.supplier_id;
					this.selectedSupplier.display_name = purchases.display_name;
					this.selectedSupplier.mobile       = purchases.supplier_mobile;
					this.selectedSupplier.address      = purchases.supplier_address;
					this.purchase.invoice_number       = purchases.invoice_number;
					this.purchase.order_date           = purchases.order_date;
					this.purchase.supplier_id          = purchases.supplier_id;
					this.purchase.subtotal             = purchases.subtotal;
					this.purchase.vat_amount           = purchases.vat_amount;
					this.vatPercent                    = purchases.vat_percent;
					this.discountPercent               = purchases.discount_percent;
					this.purchase.discount_amount      = purchases.discount_amount;
					this.purchase.transport_cost       = purchases.transport_cost;
					this.purchase.total                = purchases.total;
					this.purchase.paid                 = purchases.paid;
					this.purchase.due                  = purchases.due;
					this.purchase.previous_due         = purchases.previous_due;
					this.purchase.note                 = purchases.remark;

					this.oldSupplierId = purchase.supplier_id;

					//this.vatPercent = (this.purchases.vat_amount * 100) / this.purchases.subtotal;
					//console.log(purchases.supplier_id);
					
                purchases.purchaseDetails.forEach(item => {
                    let cart = {
					id            : item.id,
					productId     : item.item_id,
					name          : item.product_name,
					quantity      : item.quantity,
					purchase_price: item.purchase_rate,
					total         : item.total_amount
                    }
                    this.cart.push(cart);
                })
				})
			}
		
		}
	}

</script>