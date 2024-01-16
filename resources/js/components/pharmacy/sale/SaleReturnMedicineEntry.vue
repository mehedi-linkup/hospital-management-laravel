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
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
			<div class="form-group" style="margin-top:10px;">
				<label class="col-sm-1 control-label no-padding-right" for="purchaseInvoiceno"> Patient </label>
				<div class="col-sm-3">
					<v-select v-bind:options="patients" @input="cart.length= 0" label="display_text" v-model="selectedPatient" v-bind:disabled="saleReturn.id == 0 ? false : true" v-on:input="getSaleMedicines"></v-select>
				</div>
				<label class="col-sm-1 control-label no-padding-right" for="purchaseInvoiceno"> Invoice no </label>
				<div class="col-sm-3">
					<v-select v-bind:options="invoices" @input="cart.length= 0" label="invoice_text" v-model="selectedInvoice" v-bind:disabled="saleReturn.id == 0 ? false : true"></v-select>
				</div>
				<div class="col-sm-2">
					<button class="btn btn-info btn-xs " style="width: 80px;margin-bottom: 7px;" @click="getSaleDetailsForReturn" v-bind:disabled="saleReturn.id == 0 ? false : true">View</button>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-12 col-lg-12" v-if="cart.length > 0" style="display:none" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
			<br>
			<div class="table-responsive">
				<br>
				<div class="col-md-6">
					Return date: <input type="date" v-model="saleReturn.return_date" v-bind:disabled="role == 'user' ? true : false">
					<br><br>
					Invoice Discount: {{ selectedInvoice.discount_amount }}
				</div>
				<div class="col-md-6 text-right">
					<h4 style="margin:0px;padding:0px;">Patient Information</h4>
					Name: {{ selectedInvoice.patient_name }}<br>
					Address: {{ selectedInvoice.patient_address }}<br>
					Mobile: {{ selectedInvoice.patient_mobile }}
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
								<textarea style="width: 100%" v-model="saleReturn.note"></textarea>
							</td>
							<td>
								<button class="btn btn-success pull-left" v-on:click="saveSaleReturn">Save</button>
							</td>
							<td>Total: {{ saleReturn.total_amount }}</td>
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
				patients:[],
				selectedPatient:null,
				invoices: [],
				selectedInvoice: null,
				cart: [],
				saleReturn: {
					id          : '',
					sale_id : '',
					patient_id : '',
					return_date : moment().format('YYYY-MM-DD'),
					total_amount: 0.00,
					note        : ''
				},
				returnDetails: [],
				saleOnProgress: false,
			}
		},
		created(){
			this.getPatients();
			this.getSaleMedicines();
			this.saleReturn.id= this.id;
			if(this.id != 0) {
				this.getReturn();
			}
		},
		methods:{
			getSaleMedicines(){
				this.invoices= [];
				this.selectedInvoice = null;
				if(this.selectedPatient !=null){
				axios.post('/get_sale_medicine',{patient_id:this.selectedPatient.id}).then(res=>{
					this.invoices = res.data;
				})
				}else{
					this.invoices= [];
					this.selectedInvoice = null;
				}
			},

			getPatients(){
				axios.get('/get_patients').then(res=>{
					this.patients = res.data;
					})
				},
			async getSaleDetailsForReturn(){
				if(this.selectedInvoice == null){
					alert('Select invoice');
					return;
				}
				await axios.post('/get_sale_return_madicine_details', {saleId: this.selectedInvoice.id}).then(res=>{
					this.cart = res.data;
				})
			},

			async productReturnTotal(ind){
				
				if(this.cart[ind].return_quantity > (this.cart[ind].quantity - this.cart[ind].returned_quantity)){
					alert('Return quantity is not valid');
					this.cart[ind].return_amount = 0;
					this.cart[ind].return_quantity = '';
					return;
				}

				if(parseFloat(this.cart[ind].return_rate) > parseFloat(this.cart[ind].sale_rate)){
					alert('Rate is not valid');
					this.cart[ind].return_rate = '';
				}
				this.cart[ind].return_amount = parseFloat(this.cart[ind].return_quantity) * parseFloat(this.cart[ind].return_rate);
				this.calculateTotal();
			},
			calculateTotal(){
				this.saleReturn.total_amount = this.cart.reduce((prev, cur) => {return prev + (cur.return_amount ? parseFloat(cur.return_amount) : 0.00)}, 0);
			},
			
			saveSaleReturn(){
				let filteredCart = this.cart.filter(product => product.return_quantity > 0 && product.return_rate > 0);
				
				if(filteredCart.length == 0){
					alert('No products to return');
					return;
				}
				if(this.saleReturn.return_date == null || this.saleReturn.return_date == ''){
					alert('Enter date');
					return;
				}
				this.saleReturn.sale_id = this.selectedInvoice.id;
				this.saleReturn.patient_id = this.selectedInvoice.patient_id;

				let data = {
					invoice: this.selectedInvoice,
					saleReturn: this.saleReturn,
					cart: filteredCart
				}

				let url = '/store-sale-return-medicine';
				if(this.saleReturn.id != 0) {
					url = '/update-sale-return-medicine';
				}

				axios.post(url, data).then(async res=>{
					let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/sale_return_medicine_invoice/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/sale_return_medicine';
					
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
				axios.post('/get_sale_return_medicine', { saleReturnId: this.id,with_details: true }).then(async res => {
					let saleReturn = res.data[0];
					this.selectedInvoice = {
						id              : saleReturn.sale_id ,
						invoice_number  : saleReturn.invoice_number,
						patient_id     : saleReturn.patient_id,
						invoice_text    : saleReturn.invoice_text,
						supplier_name   : saleReturn.supplier_name,
						discount_amount   : saleReturn.discount_amount,
						supplier_address: saleReturn.supplier_address,
						supplier_mobile : saleReturn.supplier_mobile,
					}
					this.selectedPatient = {
						id          : saleReturn.patient_id,
						display_text: saleReturn.display_name
					}

					this.saleReturn.return_date = saleReturn.return_date;
					this.saleReturn.total_amount = saleReturn.total_amount;
					this.saleReturn.note = saleReturn.remark;

					await this.getSaleDetailsForReturn();

					this.saleReturnDetails = res.data[0].saleReturnDetails;
					
					this.cart.map(product => {
						let returnDetail = this.saleReturnDetails.find(rd => rd.medicine_id == product.medicine_id);
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