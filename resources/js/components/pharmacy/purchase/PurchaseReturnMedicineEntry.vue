<style scoped>
.table-headrer-d{
	background: #146C94;
	color:#F6FFDE;
}
.table-headrer-d>th{
	font-weight: 400 !important;
}
.table-body-d:hover{
	background: #DBDFEA !important;
}

</style>
<template>
	<div class="row" id="purchaseReturn">
		<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
			<div class="form-group" style="margin-top:10px;">
				<label class="col-sm-1 col-sm-offset-1 control-label no-padding-right" for="purchaseInvoiceno"> Invoice no </label>
				<div class="col-sm-3">
					<v-select v-bind:options="invoices" @input="cart.length= 0" label="invoice_text" v-model="selectedInvoice" v-bind:disabled="purchaseReturn.id == 0 ? false : true"></v-select>
				</div>
				<div class="col-sm-2">
					<button class="btn btn-info btn-xs " style="width: 80px;margin-bottom: 7px;" @click="getPurchaseDetailsForReturn" v-bind:disabled="purchaseReturn.id == 0 ? false : true">View</button>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-12 col-lg-12" v-if="cart.length > 0" style="display:none" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
			<br>
			<div class="table-responsive">
				<br>
				<div class="col-md-6">
					Return date: <input type="date" v-model="purchaseReturn.return_date" v-bind:disabled="role == 'user' ? true : false">
					<br><br>
					Check Stock <input type="checkbox" v-model="checkStock">
				</div>
				<div class="col-md-6 text-right">
					<h4 style="margin:0px;padding:0px;">Supplier Information</h4>
					Name: {{ selectedInvoice.supplier_name }}<br>
					Address: {{ selectedInvoice.supplier_address }}<br>
					Mobile: {{ selectedInvoice.supplier_mobile }}
				</div>
				<table class="table table-bordered">
					<thead>
						<tr class="table-headrer-d">
							<th>Sl</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Amount</th>
							<th>Already returned quantity</th>
							<th>Already returned amount</th>
							<th>Return Quantity</th>
							<th>Return Rate</th>
							<th>Return Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(product, sl) in cart" :key="sl" class="table-body-d">
							<td>{{ sl + 1 }}</td>
							<td>{{ product.product_name }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.total_amount }}</td>
							<td>{{ product.returned_quantity }}</td>
							<td>{{ product.returned_amount }}</td>
							<td><input type="text" v-model="product.return_quantity" v-on:input="productReturnTotal(sl)"></td>
							<td><input type="text" v-model="product.return_rate" v-on:input="productReturnTotal(sl)"></td>
							<td>{{ product.return_amount }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5" style="text-align:right;padding-top:15px;">Note</td>
							<td colspan="2">
								<textarea style="width: 100%" v-model="purchaseReturn.note"></textarea>
							</td>
							<td>
								<button class="btn btn-success pull-left" v-on:click="savePurchaseReturn">Save</button>
							</td>
							<td>Total: {{ purchaseReturn.total_amount }}</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

</template>
<script>
import moment from 'moment';
export default {
    props: ['role','id'],
    data(){
			return {
				invoices: [],
				selectedInvoice: null,
				cart: [],
				purchaseReturn: {
					id          : '',
					purchase_id : '',
					supplier_id : '',
					return_date : moment().format('YYYY-MM-DD'),
					total_amount: 0.00,
					note        : ''
				},
				returnDetails: [],
				checkStock: true,
				saleOnProgress: false,
			}
		},
		created(){
			this.getPurchaseMedicines();
			this.purchaseReturn.id= this.id;
			if(this.id != 0) {
				this.getReturn();
			}
		},
		methods:{
			getPurchaseMedicines(){
				axios.get('/get_purchase_medicine').then(res=>{
					this.invoices = res.data;
				})
			},
			async getPurchaseDetailsForReturn(){
				if(this.selectedInvoice == null){
					alert('Select invoice');
					return;
				}
				await axios.post('/get_purchase_return_madicine_details', {purchaseId: this.selectedInvoice.id}).then(res=>{
					this.cart = res.data;
				})
			},
			async productReturnTotal(ind){
				if(this.checkStock) {
					let stock = await axios.post('/get_medicine_stock', { productId: this.cart[ind].item_id })
					.then(res => {
						return res.data;
					})
	
					let returnDetail = this.returnDetails.find(rd => rd.item_id == this.cart[ind].item_id);
					stock = +stock + +(returnDetail?.quantity ?? 0);
	
					if(stock < this.cart[ind].return_quantity) {
						alert('Unavailable stock');
						this.cart[ind].return_quantity = '';
						return;
					}
				}
				if(this.cart[ind].return_quantity > (this.cart[ind].PurchaseDetails_TotalQuantity - this.cart[ind].returned_quantity)){
					alert('Return quantity is not valid');
					this.cart[ind].return_quantity = '';
				}

				if(parseFloat(this.cart[ind].return_rate) > parseFloat(this.cart[ind].purchase_rate)){
					alert('Rate is not valid');
					this.cart[ind].return_rate = '';
				}
				this.cart[ind].return_amount = parseFloat(this.cart[ind].return_quantity) * parseFloat(this.cart[ind].return_rate);
				this.calculateTotal();
			},
			calculateTotal(){
				this.purchaseReturn.total_amount = this.cart.reduce((prev, cur) => {return prev + (cur.return_amount ? parseFloat(cur.return_amount) : 0.00)}, 0);
			},
			
			savePurchaseReturn(){
				let filteredCart = this.cart.filter(product => product.return_quantity > 0 && product.return_rate > 0);

				if(filteredCart.length == 0){
					alert('No products to return');
					return;
				}

				if(this.purchaseReturn.return_date == null || this.purchaseReturn.return_date == ''){
					alert('Enter date');
					return;
				}
				this.purchaseReturn.purchase_id = this.selectedInvoice.id;
				this.purchaseReturn.supplier_id = this.selectedInvoice.supplier_id;

				let data = {
					invoice: this.selectedInvoice,
					purchaseReturn: this.purchaseReturn,
					cart: filteredCart
				}

				let url = '/store-purchase-return-medicine';
				if(this.purchaseReturn.id != 0) {
					url = '/update-purchase-return-medicine';
				}

				axios.post(url, data).then(async res=>{
					let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/purchase_return_medicine_invoice/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/purchase_return_medicine';
					
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

			getReturn() {
				axios.post('/get_purchase_return_medicine', { purchaseReturnId: this.id,with_details: true }).then(async res => {
					let purchaseReturn = res.data[0];
					this.selectedInvoice = {
						id              : purchaseReturn.purchase_id ,
						invoice_number  : purchaseReturn.invoice_number,
						supplier_id     : purchaseReturn.supplier_id,
						invoice_text    : purchaseReturn.invoice_text,
						supplier_name   : purchaseReturn.supplier_name,
						supplier_address: purchaseReturn.supplier_address,
						supplier_mobile : purchaseReturn.supplier_mobile,
					}

					this.purchaseReturn.return_date = purchaseReturn.return_date;
					this.purchaseReturn.total_amount = purchaseReturn.total_amount;
					this.purchaseReturn.note = purchaseReturn.remark;

					await this.getPurchaseDetailsForReturn();

					this.purchaseReturnDetails = res.data[0].purchaseReturnDetails;
					
					this.cart.map(product => {
						let returnDetail = this.purchaseReturnDetails.find(rd => rd.item_id == product.item_id);
						product.return_quantity = returnDetail?.quantity;
						product.returned_quantity = +product.returned_quantity - (returnDetail?.quantity ?? 0);
						product.return_amount = returnDetail?.total_amount;
						product.returned_amount = +product.returned_amount - (returnDetail?.total_amount ?? 0);
						return product;
					})
				})
			}
		}
	}

</script>