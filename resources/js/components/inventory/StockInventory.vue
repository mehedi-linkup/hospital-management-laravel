
<template>
    <div id="stock">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
			<div class="form-group" style="margin-top:10px;">
				<label class="col-sm-1 col-sm-offset-1 control-label no-padding-right"> Select Type </label>
				<div class="col-sm-2">
					<v-select v-bind:options="searchTypes" v-model="selectedSearchType" label="text" v-on:input="onChangeSearchType"></v-select>
				</div>
			</div>
	
			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'category'">
				<div class="col-sm-2" style="margin-left:15px;">
					<v-select v-bind:options="categories" v-model="selectedCategory" label="name"></v-select>
				</div>
			</div>
	
			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'product'">
				<div class="col-sm-2" style="margin-left:15px;">
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
				</div>
			</div>

			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value != 'current'">
				<div class="col-sm-2" style="margin-left:15px;">
					<input type="date" class="form-control" v-model="date">
				</div>
			</div>
	
			<div class="form-group">
				<div class="col-sm-2"  style="margin-left:15px;">
					<input type="button" class="btn btn-primary" value="Show Report" v-on:click="getStock" style="margin-top:0px;border:0px;height:28px;">
				</div>
			</div>
		</div>
	</div>
	<div class="row" v-if="searchType != null" style="display:none" v-bind:style="{display: searchType == null ? 'none' : ''}">
		<div class="col-md-12">
			<a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive" id="stockContent">
				<table class="table table-bordered" v-if="searchType == 'current'" style="display:none" v-bind:style="{display: searchType == 'current' ? '' : 'none'}">
					<thead>
						<tr>
							<th>Product Id</th>
							<th>Product Name</th>
							<th>Category</th>
							<th>Current Quantity</th>
							<th>Rate</th>
							<th>Stock Value</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(product,sl) in stock" :key="sl">
							<td>{{ product.product_code }}</td>
							<td>{{ product.product_name }}</td>
							<td>{{ product.category_name }}</td>
							<td>{{ product.current_quantity }} {{ product.unit_name }}</td>
							<td>{{ product.purchase_price | decimal }}</td>
							<td>{{ product.stock_value | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="5" style="text-align:right;">Total Stock Value</th>
							<th>{{ totalStockValue | decimal }}</th>
						</tr>
					</tfoot>
				</table>

				<table class="table table-bordered" 
						v-if="searchType != 'current' && searchType != null" 
						style="display:none;" 
						v-bind:style="{display: searchType != 'current' && searchType != null ? '' : 'none'}">
					<thead>
						<tr>
							<th>Product Id</th>
							<th>Product Name</th>
							<th>Category</th>
							<th>Purchased Quantity</th>
							<th>Purchase Returned Quantity</th>
							<th>Damaged Quantity</th>
							<th>Issue Quantity</th>
							<th>Current Quantity</th>
							<th>Rate</th>
							<th>Stock Value</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(product,sl) in stock" :key="sl">
							<td>{{ product.instrument_code  }}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.category_name }}</td>
							<td>{{ product.purchased_quantity }}</td>
							<td>{{ product.purchased_return_quantity }}</td>
							<td>{{ product.damaged_quantity }}</td>
							<td>{{ product.sold_quantity }}</td>
							<td>{{ product.current_quantity }} {{ product.Uunit_name }}</td>
							<td>{{ product.purchase_price | decimal }}</td>
							<td>{{ product.stock_value | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="9" style="text-align:right;">Total Stock Value</th>
							<th>{{ totalStockValue | decimal }}</th>
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
				searchTypes: [
					{text: 'Current Stock', value: 'current'},
					{text: 'Total Stock', value: 'total'},
					{text: 'Category Wise Stock', value: 'category'},
					{text: 'Product Wise Stock', value: 'product'},
					//{text: 'Brand Wise Stock', value: 'brand'}
				],
				selectedSearchType: {
					text: 'select',
					value: ''
				},
				searchType: null,
				date: moment().format('YYYY-MM-DD'),
				categories: [],
				selectedCategory: null,
				products: [],
				selectedProduct: null,
				selectionText: '',

				stock: [],
				totalStockValue: 0.00
			}
		},
		filters: {
			decimal(value) {
				return value == null ? '0.00' : parseFloat(value).toFixed(2);
			}
		},
		created(){
			this.getBranchInfo();
		},
		methods:{
			getStock(){
				this.searchType = this.selectedSearchType.value;
				let url = '';
				let parameters = {};

				if(this.searchType == 'current'){
					url = '/get_current_stock_inventory';
				} else {
					url = '/get_total_stock_inventory';
					parameters.date = this.date;
				}
				
				this.selectionText = "";

				if(this.searchType == 'category' && this.selectedCategory == null){
					alert('Select a category');
					return;
				} else if(this.searchType == 'category' && this.selectedCategory != null) {
					parameters.categoryId = this.selectedCategory.id;
					this.selectionText = "Category: " + this.selectedCategory.name;
				}
				
				if(this.searchType == 'product' && this.selectedProduct == null){
					alert('Select a product');
					return;
				} else if(this.searchType == 'product' && this.selectedProduct != null) {
					parameters.productId = this.selectedProduct.id;
					this.selectionText = "product: " + this.selectedProduct.display_text;
				}

				


				axios.post(url, parameters).then(res => {
					if(this.searchType == 'current'){
						this.stock = res.data.stock.filter((pro)=> pro.current_quantity != 0);
					}else{
						this.stock = res.data.stock;
					}
					this.totalStockValue = res.data.totalValue;
				})
			},
			getBranchInfo(){
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
                })
            },
			onChangeSearchType(){
				if(this.selectedSearchType.value == 'category' && this.categories.length == 0){
					this.getCategories();
				}  else if(this.selectedSearchType.value == 'product' && this.products.length == 0){
					this.getProducts();
				}
			},
			getCategories(){
				axios.get('/get_categories_inventory').then(res => {
					this.categories = res.data;
				})
			},
			getProducts(){
				axios.post('/get_instruments', {isService: 'false'}).then(res => {
					this.products =  res.data;
				})
			},
			
			async print(){
				let reportContent = `
					<div class="container-fluid">
						<h4 style="text-align:center">${this.selectedSearchType.text} Report</h4 style="text-align:center">
						<h6 style="text-align:center">${this.selectionText}</h6>
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#stockContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}, left=0, top=0`);
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

				reportWindow.document.body.innerHTML += reportContent;

				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}

}
</script>