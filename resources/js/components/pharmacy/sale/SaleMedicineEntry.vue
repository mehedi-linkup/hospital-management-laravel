<style scoped>
 
.no-padding-right{
	padding: 0px !important;
}
.widget-box{
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
</style>
<template>
    <div id="sales" class="row">

	<div class="col-xs-12 col-md-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header" >
				<h5 class="widget-title" >Sales Information</h5>
				
			</div>

			<div class="widget-body">
				<div class="widget-main" style="padding-top: 0px;">

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #DBDFEA;padding: 8px;margin-bottom: 5px;">
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group row">
									<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Patient </label>
									<div class="col-xs-8 col-sm-8 col-md-8">
										<v-select v-bind:options="patients" label="display_name" v-model="selectedPatient" v-on:input="patientOnChange" class="select"></v-select>
									</div>
									<div class="col-xs-1 col-sm-1 col-md-1" style="padding: 0;">
										<a href="/patient_entry" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Customer"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">	
								<div class="form-group row">
									<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Mobile </label>
									<div class="col-xs-9 col-sm-9 col-md-9">
										<input type="text" v-if="selectedPatient" id="mobileNo" placeholder="Mobile No" class="form-control" v-model="selectedPatient.mobile" disabled />
										<input v-else type="text" placeholder="Mobile No" class="form-control" disabled />
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group row">
									<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Address </label>
									<div class="col-xs-9 col-sm-9 col-md-9">
										<textarea v-if="selectedPatient" style="height: 28px;" id="address" placeholder="Address" class="form-control" v-model="selectedPatient.address" disabled></textarea>
										<textarea v-else class="form-control"  style="height: 28px;" disabled></textarea>
									</div>
								</div>
							</div>
							
						</div>

						<div class="col-xs-10 col-sm-10 col-md-10" style="background-color: #acbac5;padding: 8px;border-radius: 5px;">
							<form v-on:submit.prevent="addToCart">
								<div class="col-xs-12 col-sm-4 col-md-4">
									<div class="form-group row">
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right">Category</label>
										<div class="col-xs-8 col-sm-8 col-md-8">
										<v-select v-bind:options="categories" v-model="selectedCategory" label="name" v-on:input="getProducts" class="select"></v-select>
										</div>
										<div class="col-xs-1" style="padding: 0;">
											<a href="/category_entry_medicine" title="Add New Category" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-5 col-md-5">
									<div class="form-group row">
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Product </label>
										<div class="col-xs-8 col-sm-8 col-md-8">
											<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="productOnChange" class="select"></v-select>
										</div>
										<div class="col-xs-1" style="padding: 0;">
											<a href="/medicine_entry" title="Add New Medicine" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
										</div>
									</div>
								</div>
								
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="form-group row">
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Rate </label>
										<div class="col-xs-9 col-sm-9 col-md-9">
											<input type="number" v-if="selectedProduct" id="salesRate" placeholder="Rate" step="0.01" class="form-control" v-model="selectedProduct.sale_price" v-on:input="productTotal"/>
											<input type="number" v-else class="form-control" placeholder="Rate"/>
										</div>
									</div>
								</div>
								<!-- <div class="form-group">
									<label class="col-xs-3 control-label no-padding-right"> Quantity </label>
									<div class="col-xs-9">
										<input type="number" step="0.01" id="quantity" placeholder="Qty" class="form-control" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" autocomplete="off" required/>
									</div>
								</div> -->

								<div class="col-xs-12 col-sm-4 col-md-4">
									<div class="form-group row"  v-if="selectedProduct && selectedProduct.is_convert== 1">
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> {{ selectedProduct.converter_name ? selectedProduct.converter_name : "Unit" }} </label>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Qty" ref="quantity" v-model="selectedProduct.unitQty" v-on:input="productTotal"/>
										</div>
										<label class="col-xs-1 control-label no-padding-right"> {{ selectedProduct.unit_name ? selectedProduct.unit_name : "Unit" }} </label>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<input type="number" step="any"  class="form-control" placeholder="Qty" v-model="selectedProduct.qty" v-on:input="productTotal" />
										</div>
									</div>
									<div class="form-group row"  v-else-if="selectedProduct && selectedProduct.is_convert== 0">
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Quantity </label>
										<div class="col-xs-9 col-sm-9 col-md-9">
											<input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Qty" ref="quantity" v-model="selectedProduct.qty" v-on:input="productTotal"/>
										</div>
									</div>
									<div class="form-group row"  v-else>
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Quantity </label>
										<div class="col-xs-9 col-sm-9 col-md-9">
											<input type="number" step="any"  id="quantity" name="quantity" class="form-control" placeholder="Qty"/>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-5 col-md-5">
									<div class="form-group row">
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Discount</label>
										<div class="col-xs-7 col-sm-7 col-md-7" style="width:70%" v-if="selectedProduct">
											<input type="text" id="productDiscount" v-model="productDiscountPercent" placeholder="(%)" style="width:60px;height:25px;" v-on:input="calculateDiscountAmount" />
											<span style="width:20px;"> % </span>
											<input type="text" id="productDiscount" v-model="discountAmount" placeholder="Discount" style="width:85px;height:25px;" v-on:input="calculateDiscountPercent" />
										</div>
										<div class="col-xs-7" style="width:70%" v-else>
												<input type="number" class="form-control" placeholder="(%)" style="width:60px;height:25px;"/>
												<span style="width:20px;"> % </span>
												<input type="number" class="form-control" placeholder="Discount" style="width:85px;height:25px;"/>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="form-group row">
										<label class="col-xs-3 col-sm-3 col-md-3 control-label no-padding-right"> Amount </label>
										<div class="col-xs-9 col-sm-9 col-md-9">
											<input type="text" v-if="selectedProduct" id="productTotal" placeholder="Amount" class="form-control" v-model="selectedProduct.total" readonly />
											<input type="text" v-else placeholder="Amount" class="form-control" readonly />
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="form-group row">
										<label class="col-xs-3 control-label no-padding-right"> </label>
										<div class="col-xs-9">
											<button type="submit" class="btn btn-success btn-xs pull-right">Add to Cart</button>
										</div>
									</div>
								</div>
							</form>

						</div>
						<div class="col-xs-12 col-sm-2 col-md-2" style="background-color: #acbac5;padding: 8px;border-radius: 5px;box-sizing:border-box;border:3px solid #fff;border-top-style: none;height:105px">
							
								<div style="display:none;height:50px;" v-bind:style="{display:sales.isService == 'true' ? 'none' : ''}">
									<div  style="display:none;text-align:center;" v-bind:style="{color: productStock > 0 ? 'green' : 'red', display: selectedProduct.id == '' ? 'none' : ''}">
														{{ productStockText }}
									</div>
									<input type="text" id="productStock"  v-model="quantityText" readonly style="border:none;font-size:15px;width:100%;text-align:center;color:green;padding:3px;background: none !important;"><br>
								</div>
								<input type="password" ref="productPurchaseRate" v-model="selectedProduct.purchase_price" v-on:mousedown="toggleProductPurchaseRate" v-on:mouseup="toggleProductPurchaseRate"  readonly title="Purchase rate (click & hold)" style="font-size:12px;width:100%;text-align: center;">
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
					<thead>
						<tr class="">
							<th style="width:5%;color:#000;">Sl</th>
							<th style="width:12%;color:#000;">Product Code</th>
							<th style="width:20%;color:#000;">Product Name</th>
							<th style="width:17%;color:#000;">Quantity</th>
							<th style="width:11%;color:#000;">Rate</th>
							<th style="width:11%;color:#000;">Sale Amount</th>
							<th style="width:17%;color:#000;">Discount</th>
							<th style="width:12%;color:#000;">Total Amount</th>
							<th style="width:8%;color:#000;">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart" :key="sl">
							<td>{{ sl + 1 }}</td>
							<td>{{ product.productCode }}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.salesRate }}</td>
							<td>{{ product.salesRate * product.quantity }}</td>
							<td>{{ product.discount }}</td>
							<td>{{ product.total }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>

						<tr>
							<td colspan="9"></td>
						</tr>

						<tr style="font-weight: bold;">
							<td colspan="6">Note</td>
							<td colspan="3">Total</td>
						</tr>
						<tr>
							<td colspan="6"><textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="sales.note"></textarea></td>
							<td colspan="3" style="padding-top: 15px;font-size:18px;">{{ sales.total }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="col-xs-12 col-md-3 col-lg-3">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">Invoice Details</h5>
				
			</div>

			<div class="widget-body">
				<div class="widget-main" style="padding-top:0px;padding-bottom: 0px;">
					<div class="row">
						<div class="col-xs-12" style="background-color: #DBDFEA;padding: 8px;margin-bottom: 5px;">
							<div class="table-responsive">
								<table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-5 control-label">Invoice No.</label>
												<div class="col-xs-7">
													<input type="text" id="invoice_number" class="form-control" v-model="sales.invoice_number" readonly />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-5 control-label"> Date </label>
												<div class="col-xs-7">
													<input class="form-control" id="salesDate" type="date" v-model="sales.salesDate" v-bind:disabled="role == 'u' ? true : false"/>
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
	<div class="col-xs-12 col-md-3 col-lg-3">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">Amount Details</h5>
				
			</div>
			<div class="widget-body">
				<div class="widget-main" style="padding-top:0px;">
					<div class="row">
						<div class="col-xs-12" style="background-color: #DBDFEA;padding: 8px;margin-bottom: 5px;">
							<div class="table-responsive">
								<table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-5 control-label">Sub Total</label>
												<div class="col-xs-7">
													<input type="number" id="subTotal" class="form-control" v-model="sales.subTotal" readonly />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-5 control-label"> Vat </label>
												<div class="col-xs-7">
													<input type="number" id="vatPercent" name="vatPercent" v-model="vatPercent" v-on:input="calculateTotal" style="width:50px;height:25px;" />
													<span style="width:20px;"> % </span>
													<input type="number" id="vat" name="vat" v-model="sales.vat" v-on:input="calculateTotal" style="width:50px;height:25px;" />
												</div>
											</div>
										</td>
									</tr>
									

									<tr>
										<td>
											<div class="form-group" style="padding-top:5px;padding-bottom: 5px;">
												<label class="col-xs-5 control-label">Discount</label>
												<div class="col-xs-7">
													<input type="number" id="discountPercent"  v-model="discountPercent" v-on:input="calculateTotal" style="width:50px;height:25px;"/>
													
													<span style="width:20px;"> % </span>
													<input type="number" id="discount" v-model="sales.discount" v-on:input="calculateTotal" style="width:50px;height:25px;"/>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group" style="padding-top:5px;">
												<label class="col-xs-5 control-label">Other`s`</label>
												<div class="col-xs-7">
													<input type="number" class="form-control" v-model="sales.transportCost" v-on:input="calculateTotal"/>
												</div>
											</div>
										</td>
									</tr>

									<tr style="display:none;">
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label">Round Of</label>
												<div class="col-xs-12">
													<input type="number" id="roundOf" class="form-control" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-5 control-label">Total</label>
												<div class="col-xs-7">
													<input type="number" id="total" class="form-control" v-model="sales.total" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-5 control-label">Paid</label>
												<div class="col-xs-7">
													<input type="number" id="paid" class="form-control" v-model="sales.paid" v-on:input="calculateTotal"/>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-xs-6 control-label" style="display: none;">Previous Due</label>
												
											</div>
											<div class="form-group">
												<label class="col-xs-5 control-label">Due</label>
												<div class="col-xs-7">
													<input type="number" id="due" class="form-control" v-model="sales.due" readonly/>
												</div>
												<div class="col-xs-6" style="display: none;">
													<input type="number" id="previousDue" class="form-control" v-model="sales.previousDue" readonly style="color:red;"  />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<div class="col-xs-6">
													<input type="button" class="btn btn-default btn-sm" value="Sale" v-on:click="saveSales" v-bind:disabled="saleOnProgress ? true : false" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">
												</div>
												<div class="col-xs-6">
													<a class="btn btn-info btn-sm" href="/sale_medicine" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">New Sale</a>
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
			return {
				sales:{
					id             : '',
					invoice_number : '',
					salesDate      : moment().format('YYYY-MM-DD'),
					patientId      : '',
					subTotal       : 0.00,
					discountper: 0.00,
					discount       : 0.00,
					vatpercent     : 0.00,
					vat            : 0.00,
					transportCost  : 0.00,
					total          : 0.00,
					paid           : 0.00,
					previousDue    : 0.00,
					due            : 0.00,
					note           : '',
				},
				vatPercent: 0,
				discountPercent: 0,
				cart: [],
				branches: [],
				selectedBranch: {
					brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
					Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
				},
				patients: [],
				selectedPatient: {
					id          : null,
					display_text: 'Select Patient',
					mobile      : '',
					address     : ''
            	},
				oldPatientId: null,
				oldPreviousDue: 0,
				categories: [],
				selectedCategory: null,
				products: [],
				selectedProduct: {
					id              : null,
					display_text    : 'Select Product',
					name            : '',
					unit_name       : '',
					is_convert    : 0,
					quantity        : 0,
					purchase_price  : '',
					sale_price      : 0.00,
					discount_percent: 0.00,
					discount_amount : 0.00,
					total           : 0.00,
					unitQty         : 0,
					qty             : 0
				},
				productPurchaseRate: '',
				productStockText: '',
				productStock: '',
				productDiscountPercent: 0,
				discountAmount: 0,
				quantityText: '',
				saleOnProgress: false,
				sales_due_on_update : 0,
				userType: '<?php echo $this->session->userdata("accountType");?>',
				searchVal: "",
			}
		},
		
		async created(){
			this.sales.id= this.id;
			this.sales.invoice_number = this.invoice;
			this.getPatients();
			this.getCategories();
			if(this.id != 0){
            	this.getSales();
        	}
		},
		
		methods:{

			getCategories() {
				axios.get('/get_categories_medicine').then(res => {
					this.categories = res.data;
				})
			},
			
			getPatients(){
				axios.get('/get_patients').then(res=>{
					this.patients = res.data;
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
								id              : '',
								display_text    : 'Select Product',
								name            : '',
								unit_name       : '',
								quantity        : 0,
								purchase_price  : '',
								is_convert    : 0,
								sale_price      : 0.00,
								discount_percent: 0.00,
								discount_amount : 0.00,
								total           : 0.00,
								unitQty         : 0,
								qty             : 0
						};
					}
			},

			productTotal(){
				let unitQty = this.selectedProduct.unitQty ? this.selectedProduct.convert_quantity * this.selectedProduct.unitQty : 0;
				let pcsQty = this.selectedProduct.qty ? this.selectedProduct.qty : 0;
				
				this.selectedProduct.quantity = parseFloat(unitQty) + parseFloat(pcsQty);
				this.selectedProduct.total = (parseFloat(this.selectedProduct.quantity) * parseFloat(this.selectedProduct.sale_price)).toFixed(2);
				this.productDiscountPercent = 0; 
				this.discountAmount = 0;
			},
			
			async patientOnChange(){
				if(this.selectedPatient == null){
					return;
				}

				if(this.sales.id != 0 && this.oldPatientId != parseInt(this.selectedPatient.id)){
					let changeConfirm = confirm('Changing Patient will set previous due to current due amount. Do you really want to change Patient?');
					if(changeConfirm == false){
						return;
					}
				} else if(this.sales.id != 0 && this.oldPatientId == parseInt(this.selectedPatient.id)){
					this.sales.previousDue = this.oldPreviousDue;
					return;
				}
				await this.getPatientDue();
				
				this.calculateTotal();
			},

			calculateDiscountAmount(){
				//alert('ok');
				let totalamount = (parseFloat(this.selectedProduct.quantity) * parseFloat(this.selectedProduct.sale_price)).toFixed(2);
				this.discountAmount = (totalamount) * (+this.productDiscountPercent/100);
				this.selectedProduct.total = totalamount - +this.discountAmount;
			},
			calculateDiscountPercent(){
				//alert('ok');
				let totalamount = (parseFloat(this.selectedProduct.quantity) * parseFloat(this.selectedProduct.sale_price)).toFixed(2);

				let netAmount = totalamount - +this.discountAmount;
				let netAmount2 = +this.discountAmount / (totalamount);
				
				this.productDiscountPercent = (netAmount2) * 100;
				this.selectedProduct.total = netAmount.toFixed(2);
			},
			async getPatientDue() {
				await axios.post('/get_madicine_patient_due',{patientId: this.selectedPatient.id}).then(res=>{
					if(res.data.length > 0){
						this.sales.previousDue = res.data[0].due;
					} else {
						this.sales.previousDue = 0;
					}
				})
			},
			async productOnChange(){

				if (this.selectedProduct == null) {
					this.selectedProduct = {
							id              : '',
							display_text    : 'Select Product',
							name            : '',
							unit_name       : '',
							quantity        : 0,
							purchase_price  : '',
							is_convert    : 0,
							sale_price      : 0.00,
							discount_percent: 0.00,
							discount_amount : 0.00,
							total           : 0.00,
							unitQty         : 0,
							qty             : 0
					}
					return true
				}

				if(this.selectedProduct.id != '' || this.selectedProduct.id != 0){
					this.productStock = await axios.post('/get_medicine_stock', {productId: this.selectedProduct.id}).then(res => {
						return res.data;
					})

					
						this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";
						this.quantityText = this.selectedProduct.convert_quantity == 0 ? `${this.productStock} ${this.selectedProduct.unit_name}`: `${Math.floor(this.productStock / this.selectedProduct.convert_quantity)} ${this.selectedProduct.converter_name} ${this.productStock % this.selectedProduct.convert_quantity} ${this.selectedProduct.unit_name}`;
					this.$refs.quantity.focus();
				}
			},
			toggleProductPurchaseRate(){
				//this.productPurchaseRate = this.productPurchaseRate == '' ? this.selectedProduct.purchase_price : '';
				this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' : 'text';
			},
			addToCart(){

				this.selectedProduct.discount_amount = this.discountAmount ? this.discountAmount : 0;
				this.selectedProduct.discount_percent = this.productDiscountPercent ? this.productDiscountPercent : 0;
				
				let product = {
					productId       : this.selectedProduct.id,
					productCode     : this.selectedProduct.medicine_code,
					name            : this.selectedProduct.name,
					salesRate       : this.selectedProduct.sale_price,
					quantity        : this.selectedProduct.quantity,
					converter_name  : this.selectedProduct.converter_name,
					convert_quantity: this.selectedProduct.convert_quantity,
					discount        : this.selectedProduct.discount_amount,
					discount_percent: this.selectedProduct.discount_percent,
					total           : this.selectedProduct.total,
					purchase_rate   : this.selectedProduct.purchase_price,
					quantity_text   : `${Math.floor(this.selectedProduct.quantity / this.selectedProduct.convert_quantity)} ${this.selectedProduct.converter_name} ${this.selectedProduct.quantity % this.selectedProduct.convert_quantity} ${this.selectedProduct.unit_name}`
				}

				if(product.productId == ''){
					alert('Select Product');
					return;
				}

				if(product.quantity == 0 || product.quantity == ''){
					alert('Enter quantity');
					return;
				}

				if(product.salesRate == 0 || product.salesRate == ''){
					alert('Enter sales rate');
					return;
				}
				if(this.selectedCategory == null){
					alert('Select Category');
					return;
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
				this.clearProduct();
				this.calculateTotal();
			},
			removeFromCart(ind){
				this.cart.splice(ind, 1);
				this.calculateTotal();
			},
			clearProduct(){
				
				this.selectedProduct = {
					id: '',
					display_text: 'Select Product',
					Product_Name: '',
					unit_name: '',
					quantity: 0,
					purchase_price: '',
					sale_price: 0.00,
					discount_percent: 0.00,
					discount_amount : 0.00,
					total: 0.00,
					unitQty: 0,
					qty: 0
				}
				this.discountAmount         = 0;
				this.productDiscountPercent = 0;
				this.productStock           = '';
				this.productStockText       = '';
				this.quantityText           = '';
			},
			
			clearPatient(){
				this.selectedPatient = {
					id          : null,
					display_text: 'Select Patient',
					name      : '',
					mobile      : '',
					address     : ''
				}
		
			},
			calculateTotal(){
				this.sales.subTotal = this.cart.reduce((prev, curr) => { return prev + parseFloat(curr.total)}, 0).toFixed(2);
				if(event.target.id == 'vatPercent'){
					this.sales.vat = ((parseFloat(this.sales.subTotal) * parseFloat(this.vatPercent)) / 100).toFixed(2);
				}else{
					this.vatPercent = ((parseFloat(this.sales.vat) / parseFloat(this.sales.subTotal)) * 100).toFixed(2);

				}
				if(event.target.id == 'discountPercent'){
					this.sales.discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
				} else {
					this.discountPercent = (parseFloat(this.sales.discount) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}
				this.sales.total = ((parseFloat(this.sales.subTotal) + parseFloat(this.sales.vat) + parseFloat(this.sales.transportCost)) - parseFloat(this.sales.discount)).toFixed(2);
				this.sales.due = (parseFloat(this.sales.total) - parseFloat(this.sales.paid)).toFixed(2);
			},
			async saveSales(){
				if(this.selectedPatient.id == ''){
					alert('Select Customer');
					return;
				}
				if(this.cart.length == 0){
					alert('Cart is empty');
					return;
				}

				this.sales.discountper = this.discountPercent ? this.discountPercent : 0 ;
				this.sales.vatpercent = this.vatPercent ? this.vatPercent : 0;
				this.saleOnProgress = true;

				let url = "/store-sale-medicine";
				if(this.sales.id != 0){
					url = "/update-sale-medicine";
					this.sales.previousDue = parseFloat((this.sales.previousDue - this.sales_due_on_update)).toFixed(2);
				}

				
				this.sales.patientId = this.selectedPatient.id;

				let data = {
					sales: this.sales,
					cart: this.cart
				}

				axios.post(url, data).then(async res=>{
					let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/sale_medicine_invoice_print/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/sale_medicine';
					
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
			async getSales(){
				await axios.post('/get_sale_medicine', {salesId: this.id,with_details: true}).then(res=>{
					let sales = res.data[0];
					this.sales.salesDate = sales.order_date;
					this.sales.patientId = sales.patient_id;
					this.sales.subTotal = sales.subtotal;
					this.sales.discount = sales.discount_amount;
					this.discountPercent = sales.discount_percent;
					this.sales.vat = sales.vat_amount;
					this.vatPercent = sales.vat_percent;
					this.sales.transportCost = sales.transport_cost;
					this.sales.total = sales.total;
					this.sales.paid = sales.paid;
					this.sales.due = sales.due;
					this.sales.note = sales.remark;

					this.oldPatientId = sales.patient_id;

					this.selectedPatient = {
						id          : sales.patient_id,
						display_name: sales.display_name,
						mobile      : sales.patient_mobile,
						address     : sales.patient_address,
					}
					
					sales.saleDetails.forEach(product => {
						let cartProduct = {
							productCode     : product.code,
							productId       : product.medicine_id,
							name            : product.product_name,
							salesRate       : product.sale_rate,
							quantity        : product.quantity,
							converter_name  : product.converter_name,
							discount        : product.discount_amount,
							discount_percent: product.discount_percent,
							convert_quantity: product.convert_quantity,
							total           : product.total_amount,
							purchase_rate   : product.purchase_rate,
							quantity_text   : `${Math.floor(product.quantity / product.convert_quantity)} ${product.converter_name} ${product.quantity % product.convert_quantity} ${product.unit_name}`
						}

						this.cart.push(cartProduct);
					})

				})
			}
		}
	}

</script>