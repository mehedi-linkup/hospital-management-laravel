<style scoped>
.v-select{
		margin-bottom: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
	#branchDropdown .vs__actions button{
		display:none;
	}
	#branchDropdown .vs__actions .open-indicator{
		height:15px;
		margin-top:7px;
	}
</style>
<template>
    <div id="damages">
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-12">
            <form class="form-horizontal" @submit.prevent="getDamages">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"> Category </label>
                    <div class="col-sm-2">
                        <v-select style="display:inline-block;width:89%;" v-bind:options="categories" v-model="selectedCategory" label="name" v-on:input="getProducts"></v-select>
                        <a href="/category_entry_medicine" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                    </div>
                    <label class="col-sm-1 control-label no-padding-right"> Medicine </label>
                    <div class="col-sm-2">
						<v-select v-bind:options="products" label="display_text" v-model="selectedProduct" placeholder="Select Product"></v-select>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group" style="margin-top: -2px;">
					        <input type="submit" value="Search">
				        </div>
                    </div>
				</div>
				
                <!-- <div class="form-group">
				</div> -->
               
            </form>
        </div>
    </div>
    <div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: damages.length > 0 ? '' : 'none'}">
        <div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table 
				class="record-table"
				>
				<thead>
					<tr>
						<th>Damage Code</th>
						<th>Date</th>
						<th>Medicine Name</th>
						<th>Quantity</th>
						<th>Damage Rate</th>
						<th>Damage Amount</th>
					</tr>
				</thead>
				<tbody>
					<tr  v-for="(damage,sl) in damages" :key='sl'>
						<td>{{ damage.damage_code }}</td>
						<td>{{ damage.damage_date }}</td>
						<td>{{ damage.display_text }}</td>
						<td style="text-align:center;">{{ damage.quantity }}</td>
						<td style="text-align:right;">{{ damage.purchase_rate }}</td>
						<td style="text-align:right;">{{ damage.total_amount | decimal }}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr style="font-weight:bold;">
						<td colspan="3" style="text-align:right;">Total Quantity</td>
						<td style="text-align:right;">{{ damages.reduce((prev, curr) => { return prev + parseFloat(curr.quantity)}, 0)  }}</td>
						<td></td>
						<td style="text-align:right;">{{ (damages.reduce((prev, curr) => { return prev + parseFloat(curr.total_amount)}, 0))  | decimal}}</td>
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
	props: ['role', 'branch'],
    data(){
            return {
                
				products: [],
				selectedProduct: null,
				categories: [],
                selectedCategory: null,
                damages: [],
            }
        },
        created(){
			this.getCategories();
            this.getProducts();
            // this.getDamages();
            this.getBranchInfo();
        },

        filters: {
            decimal(value) {
                return value ==  null || value == undefined ? '0.00' : parseFloat(value).toFixed(2);
            }
        },
		
        methods: {
            getBranchInfo() {
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
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
						unitQty       : 0,
						qty           : 0,
						purchase_price: '',
						total         : ''
					};
				}
			},
            getDamages(){
                this.damages = [];
                    axios.post('/get_damages_medicine',{damageId:this.selectedProduct ? this.selectedProduct.id : ''}).then(res => {
                        this.damages = res.data;
                    })
                
            },
            async print(){
				let productText = '';
				if(this.selectedProduct != null && this.selectedProduct.id != ''){
					productText = `<strong>Product: </strong> ${this.selectedProduct.display_text}`;
				}

				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Damaga List</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${productText} 
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

				


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
        }
	}

</script>