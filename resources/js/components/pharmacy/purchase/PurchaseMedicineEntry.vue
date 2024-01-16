
<template>
    <div class="row" id="purchase">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
		<div class="row">
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> Invoice no </label>
				<div class="col-sm-2">
					<input type="text" id="invoice" name="invoice" v-model="purchase.invoice_number" readonly style="height:26px;"/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> Date </label>
				<div class="col-sm-3">
					<input class="form-control" id="purchaseDate" name="purchaseDate" type="date" v-model="purchase.order_date" v-bind:disabled="role == 'User' ? true : false" style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 230px;" />
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-md-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">Supplier & Product Information</h5>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Supplier </label>
								<div class="col-xs-7">
									<v-select v-bind:options="suppliers" v-model="selectedSupplier" v-on:input="onChangeSupplier" label="display_name"></v-select>
								</div>
								<div class="col-xs-1" style="padding: 0;">
									<a href="/supplier_pharmacy_entry" title="Add New Supplier" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Mobile No </label>
								<div class="col-xs-8">
									<input v-if="selectedSupplier" type="text" placeholder="Mobile No" class="form-control" v-model="selectedSupplier.mobile"/>
									<input v-else type="text" placeholder="Mobile No" class="form-control" disabled />
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Address </label>
								<div class="col-xs-8">
									<textarea v-if="selectedSupplier" class="form-control" v-model="selectedSupplier.address"></textarea>
									<textarea v-else class="form-control" disabled></textarea>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<form v-on:submit.prevent="addToCart">
								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Category </label>
									<div class="col-xs-7">
										<v-select v-bind:options="categories" v-model="selectedCategory" label="name" v-on:input="getProducts"></v-select>
									</div>
									<div class="col-xs-1" style="padding: 0;">
										<a href="/category_entry_medicine" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Product </label>
									<div class="col-xs-7">
										<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
									</div>
									<div class="col-xs-1" style="padding: 0;">
										<a href="/medicine_entry" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>


								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Pur. Rate </label>
									<div class="col-xs-8">
										<input type="text" v-if="selectedProduct" id="purchaseRate" name="purchaseRate" class="form-control" placeholder="Pur. Rate" v-model="selectedProduct.purchase_price" v-on:input="productTotal" required/>
										<input type="text" v-else  class="form-control" placeholder="Pur. Rate" required/>
									</div>
								</div>

								<div class="form-group" v-if="selectedProduct && selectedProduct.is_convert ==  1">
									<label class="col-xs-4 control-label no-padding-right"> {{ selectedProduct.converter_name ? selectedProduct.converter_name : "Unit" }} </label>
									<div class="col-xs-3">
										<input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Quantity" ref="quantity" v-model="selectedProduct.unitQty" v-on:input="productTotal"/>
										
									</div>
									<label class="col-xs-1 control-label no-padding-right"> {{ selectedProduct.unit_name ? selectedProduct.unit_name : "Unit" }} </label>
									<div class="col-xs-4">
										<input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Quantity" v-model="selectedProduct.qty" v-on:input="productTotal"/>
									</div>
								</div>

								<div class="form-group" v-else-if="selectedProduct && selectedProduct.is_convert == 0">
									<label class="col-xs-4 control-label no-padding-right">Quantity </label>
									<div class="col-xs-8">
										<input type="number"  step="any" id="quantity" name="quantity" ref="quantity" class="form-control" placeholder="Quantity" v-model="selectedProduct.qty" v-on:input="productTotal"/>
									</div>
								</div>
								<div class="form-group" v-else>
									<label class="col-xs-4 control-label no-padding-right">Quantity </label>
									<div class="col-xs-8">
										<input type="number"  class="form-control" placeholder="Quantity" required />
									</div>
								</div>

								

								<div class="form-group">
									<label class="col-xs-4 control-label no-padding-right"> Total Amount </label>
									<div class="col-xs-8">
										<input type="text" v-if="selectedProduct" id="productTotal" name="productTotal" class="form-control" readonly v-model="selectedProduct.total"/>
										<input type="text" v-else  class="form-control" required/>
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
							<th style="width:20%;color:#000;">Product Name</th>
							<th style="width:8%;color:#000;">Purchase Rate</th>
							<th style="width:5%;color:#000;">Quantity</th>
							<th style="width:13%;color:#000;">Total Amount</th>
							<th style="width:20%;color:#000;">Action</th>
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


	<div class="col-xs-12 col-md-3 col-lg-3">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">Amount Details</h5>
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
												<label class="col-xs-12 control-label no-padding-right">Sub Total</label>
												<div class="col-xs-12">
													<input type="number" id="subTotal" name="subTotal" class="form-control" v-model="purchase.subtotal" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right"> Vat </label>
												<div class="col-xs-12">
													<input type="number" id="vatPercent" name="vatPercent" v-model="vatPercent" v-on:input="calculateTotal" style="width:50px;height:25px;" />
													<span style="width:20px;"> % </span>
													<input type="number" id="vat" name="vat" v-model="purchase.vat_amount" readonly style="width:140px;height:25px;" />
												</div>
											</div>
										</td>
									</tr>
								<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-6 control-label">Dis. Persent</label>
												<label class="col-xs-6 control-label">Dis. Amount</label>
											</div>
											<div class="form-group">
												<div class="col-xs-5">
													<input type="number" id="discountPercent" class="form-control" v-model="discountPercent" v-on:input="calculateTotal"/>
												</div>

												<label class="col-xs-1 control-label no-padding-right">%</label>

												<div class="col-xs-6">
													<input type="number" id="discount" class="form-control" v-model="purchase.discount_amount" v-on:input="calculateDiscountPercentage"/>
												</div>

											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Transport / Labour Cost</label>
												<div class="col-xs-12">
													<input type="number" id="transport_cost" name="transport_cost" class="form-control" v-model="purchase.transport_cost" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Total</label>
												<div class="col-xs-12">
													<input type="number" id="total" class="form-control" v-model="purchase.total" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Paid</label>
												<div class="col-xs-12">
													<input type="number" id="paid" class="form-control" v-model="purchase.paid" v-on:input="calculateTotal"/>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-6 control-label no-padding-right">Due</label>
												<label class="col-xs-6 control-label no-padding-right">Previous Due</label>
						
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<div class="col-xs-6">
													<input type="number" id="due" name="due" class="form-control" v-model="purchase.due" readonly />
												</div>
												<div class="col-xs-6">
													<input type="number" id="previousDue" name="previousDue" class="form-control" v-model="purchase.previousDue" readonly style="color:red;" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<div class="col-xs-6">
													<input type="button" class="btn btn-success" value="Purchase" v-on:click="savePurchase" v-bind:disabled="purchaseOnProgress == true ? true : false" style="background:#000;color:#fff;padding:3px;width:100%;">
												</div>
												<div class="col-xs-6">
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
    data() {
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
					previousDue     : 0.00,
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
				oldSupplierId   : null,
				oldPreviousDue  : 0,
				categories      : [],
				selectedCategory: null,
				products        : [],
				selectedProduct : {
					id            : '',
					display_text  : 'Select Product',
					name          : '',
					is_convert    : 0,
					unitQty       : 0,
					qty           : 0,
					quantity      : '',
					purchase_price: 0,
					total         : 0
				},
				cart: [],
				purchaseOnProgress: false
			}
		},
		
		async created(){
			this.getCategories();
			this.purchase.id= this.id;
			this.purchase.invoice_number = this.invoice;
			await this.getSuppliers();
			//this.getProducts();
			if(this.id != 0){
            	this.getPurchase();
        	}
		},
		methods:{
			
			async getSuppliers(){
				await axios.get('/get_supplierpharmacys').then(res => {
					this.suppliers = res.data;
				})
			},
			getCategories() {
				axios.get('/get_categories_medicine').then(res => {
					this.categories = res.data;
				})
			},
			getProducts(){
				if(this.selectedCategory !=null){
					axios.post('/get_medicines',{categoryId:this.selectedCategory.id}).then(res=>{
						this.products = res.data;
					})
				}else{
					this.products= [];
					this.selectedProduct =  {
						id            : '',
						display_text  : 'Select Product',
						name          : '',
						quantity      : '',
						is_convert    : 0,
						unitQty       : 0,
						qty           : 0,
						purchase_price: 0,
						total         : 0
					};
				}
			},
			onChangeSupplier(){
				if (this.selectedSupplier.id == null) {
					return;
				}

				if (this.purchase.id != 0 && this.oldSupplierId != parseInt(this.selectedSupplier.id)) {
					let changeConfirm = confirm('Changing supplier will set previous due to current due amount. Do you really want to change supplier?');
					if (changeConfirm == false) {
						return;
					}
				} else if (this.purchase.id != 0 && this.oldSupplierId == parseInt(this.selectedSupplier.id)) {
					this.purchase.previousDue = this.oldPreviousDue;
					return;
				}

				axios.post('/get_madicine_supplier_due', {
					supplierId: this.selectedSupplier.id
				}).then(res => {
					if (res.data.length > 0) {
						this.purchase.previousDue = res.data[0].due;
					} else {
						this.purchase.previousDue = 0;
					}
				})

				this.calculateTotal();

			},
			// onChangeProduct(){
				
			// 	this.$refs.quantity.focus();
			// },
			
			productTotal() {
				let unitQty = this.selectedProduct.unitQty ? this.selectedProduct.convert_quantity * this.selectedProduct.unitQty : 0;
				let pcsQty = this.selectedProduct.qty ? this.selectedProduct.qty : 0;

				this.selectedProduct.quantity = parseFloat(unitQty) + parseFloat(pcsQty);
				this.selectedProduct.total = this.selectedProduct.quantity * this.selectedProduct.purchase_price;
			},
			addToCart(){
				// let cartInd = this.cart.findIndex(p => p.productId == this.selectedProduct.id);
				// if(cartInd > -1){
				// 	alert('Product exists in cart');
				// 	return;
				// }
				if(this.selectedCategory == null){
					alert('Select Category');
					return;
				}

				let product = {
					productId     : this.selectedProduct.id,
					name          : this.selectedProduct.name,
					purchase_price: this.selectedProduct.purchase_price,
					quantity      : this.selectedProduct.quantity,
					total         : this.selectedProduct.total,
					quantity_text: `${Math.floor(this.selectedProduct.quantity / this.selectedProduct.convert_quantity)} ${this.selectedProduct.converter_name} ${this.selectedProduct.quantity % this.selectedProduct.convert_quantity} ${this.selectedProduct.unit_name}`
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
				this.selectedCategory = null;
				this.selectedProduct = {
					id            : '',
					display_text  : 'Select Product',
					name          : '',
					quantity      : '',
					unitQty       : 0,
					qty           : 0,
					purchase_price: 0,
					total         : 0
				}
			},

			calculateTotal() {
				this.purchase.subtotal = this.cart.reduce((prev, curr) => {
					return prev + parseFloat(curr.total);
				}, 0).toFixed(2);
				this.purchase.vat_amount = ((this.purchase.subtotal * parseFloat(this.vatPercent)) / 100).toFixed(2);
				this.purchase.discount_amount = ((parseFloat(this.purchase.subtotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
				this.purchase.total = ((parseFloat(this.purchase.subtotal) + parseFloat(this.purchase.vat_amount) + parseFloat(this.purchase.transport_cost)) - parseFloat(this.purchase.discount_amount)).toFixed(2);
				this.purchase.due = (parseFloat(this.purchase.total) - parseFloat(this.purchase.paid)).toFixed(2);
			},

			
			calculateDiscountPercentage(event){
				this.purchase.subtotal = this.cart.reduce((prev, curr) => { return prev + parseFloat(curr.total); }, 0).toFixed(2);
				this.purchase.vat_amount = ((this.purchase.subtotal * parseFloat(this.vatPercent)) / 100).toFixed(2);
				
				this.discountPercent = (parseFloat(this.purchase.discount_amount) / parseFloat(this.purchase.subtotal) * 100).toFixed(2);
				
				this.purchase.total = ((parseFloat(this.purchase.subtotal) + parseFloat(this.purchase.vat_amount) + parseFloat(this.purchase.transport_cost)) - parseFloat(this.purchase.discount_amount)).toFixed(2);
				
				
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

				//this.purchaseOnProgress = true;

				let data = {
					purchase: this.purchase,
					cartProducts: this.cart
				}

				

				let url = '/store-purchase-medicine';
				if(this.purchase.id != 0){
					console.log(this.purchase.id);
					url = '/update-purchase-medicine';
				}

				axios.post(url, data).then(async res=>{
					let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/purchase_medicine_invoice_print/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/purchase_medicine';
					
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
				axios.post('/get_purchase_medicine', {purchaseId: this.id,with_details: true}).then(res => {
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
					quantity_text : `${Math.floor(this.selectedProduct.quantity / this.selectedProduct.convert_quantity)} ${this.selectedProduct.converter_name} ${this.selectedProduct.quantity % this.selectedProduct.convert_quantity} ${this.selectedProduct.unit_name}`,
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