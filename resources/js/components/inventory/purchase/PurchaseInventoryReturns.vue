<style>
	.v-select{
		margin-bottom: 5px;
		width: 250px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .selected-tag{
		margin: 0px;
	}
</style>
<template>
    <div class="row" id="purchaseReturn">
        <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
            <div class="form-group" style="margin-top:10px;">
                <label class="col-sm-1 col-sm-offset-1 control-label no-padding-right" for="purchaseInvoiceno"> Invoice no </label>
                <div class="col-sm-3">
                    <v-select v-bind:options="invoices" label="invoice_text" v-model="selectedInvoice" v-bind:disabled="purchaseReturn.id == 0 ? false : true"></v-select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-info btn-xs" style="width: 100px;" @click="getPurchaseDetailsForReturn" v-bind:disabled="purchaseReturn.id == 0 ? false : true">View</button>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-12 col-lg-12" v-if="cart.length > 0" style="display:none" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
            <br>
            <div class="table-responsive">
                <br>
                <div class="col-md-6">
                    Return date: <input type="date" v-model="purchaseReturn.return_date" v-bind:disabled="userType == 'u' ? true : false">
                    <br><br>
                    Check Stock <input type="checkbox" v-model="checkStock">
                </div>
                <div class="col-md-6 text-right">
                    <h4 style="margin:0px;padding:0px;">Supplier Information</h4>
                    Name: {{ selectedInvoice.Supplier_Name }}<br>
                    Address: {{ selectedInvoice.Supplier_Address }}<br>
                    Mobile: {{ selectedInvoice.Supplier_Mobile }}
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
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
                        <tr v-for="(product, sl) in cart" :key="sl">
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
    props: ['role', 'id'],
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
				userType: '<?php echo $this->session->userdata("accountType");?>',
				returnDetails: [],
				checkStock: true,
			}
		},
		created(){
			this.getPurchases();
			this.purchaseReturn.id= this.id;
			if(this.purchaseReturn.id != 0){
				this.getReturn();
			}
		},
		methods:{
			getPurchases(){
				axios.get('/get_purchase_inventory').then(res=>{
					this.invoices = res.data;
				})
					
			},
			async getPurchaseDetailsForReturn(){
				if(this.selectedInvoice == null){
					alert('Select invoice');
					return;
				}
				await axios.post('/get_purchase_inventory_details', {purchaseId: this.selectedInvoice.id}).then(res=>{
					this.cart = res.data;
				})
			},
			async productReturnTotal(ind){
				if(this.checkStock) {
					let stock = await axios.post('/get_instrument_stock', { productId: this.cart[ind].item_id })
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
				if(this.cart[ind].return_quantity > (this.cart[ind].quantity - this.cart[ind].returned_quantity)){
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

				let url = '/purchase_return_inventory_store';
				if(this.purchaseReturn.id != 0) {
					url = '/purchase_return_inventory_update';
				}

				axios.post(url, data).then(async res=>{
					let r = res.data;
					
					if(r.id != 0 || r.id != ''){
						let conf = confirm('Success. Do you want to view invoice?');
						if(conf){
							window.open('/purchase_return_inventory_invoice/'+r.id, '_blank');
							await new Promise(r => setTimeout(r, 1000));
							window.location = '/purchase_return_inventory';
						} else {
							window.location = '/purchase_return_inventory';
						}
					}
				})
			},

			getReturn() {
				axios.post('/get_purchase_return_inventory', { purchaseReturnId: this.id,with_details: true }).then(async res => {
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