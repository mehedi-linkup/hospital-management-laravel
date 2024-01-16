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
        <div class="col-md-8">
            <form class="form-horizontal" @submit.prevent="addDamage">
                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Code </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Code" class="form-control" v-model="damage.damage_code" required readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Date </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="date" placeholder="Date" class="form-control" v-model="damage.damage_date" required/>
                    </div>
				</div>
				
                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Category </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <v-select style="display:inline-block;width:93%;" v-bind:options="categories" v-model="selectedCategory" label="name" v-on:input="getProducts"></v-select>
                        <a href="/category_entry_medicine" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                    </div>
                    <!-- <div class="col-xs-1" style="padding: 0;">
                    </div> -->
				</div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Product </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-xs-5">
                        <v-select style="display: inline-block;width:93%;" v-bind:options="products" v-model="selectedProduct" label="display_text" ></v-select>
                        <a href="/medicine_entry" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                    </div>
                    <!-- <div class="col-xs-1" style="padding: 0;">
                    </div> -->
                </div>

                 <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Damage Rate </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="number" step="0.01" placeholder="Rate" class="form-control" v-model="damage.purchase_rate" required v-on:input="calculateTotal"/>
                    </div>
                </div>
				
                <div class="form-group" v-if="selectedProduct && selectedProduct.is_convert ==  1">
                    <label class="col-xs-6 control-label no-padding-right"> {{ selectedProduct.converter_name ? selectedProduct.converter_name : "Unit" }} </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-xs-2">
                        <input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="" ref="quantity" v-model="damage.unitQty" v-on:input="calculateTotal" />
                    </div>
                    <label class="col-xs-1 control-label no-padding-right"> Qty. </label>
                    <div class="col-xs-2">
                        <input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Quantity" v-model="damage.qty" v-on:input="calculateTotal" />
                    </div>
                </div>

				<div class="form-group" v-else>
                    <label class="col-sm-6 control-label no-padding-right"> Quantity </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="number" placeholder="quantity" class="form-control" v-model="damage.quantity" required v-on:input="calculateTotal"/>
                    </div>
				</div>
            

				<div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Damage Amount </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="number" placeholder="Amount" class="form-control" v-model="damage.total_amount" required disabled />
                    </div>
				</div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Description </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" placeholder="Description" v-model="damage.remark"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"></label>
                    <label class="col-sm-1 control-label no-padding-right"></label>
                    <div class="col-sm-5">
                        <button type="submit" class="btn btn-sm btn-success">
                            Submit
                            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <h1 style="display: none;" v-bind:style="{display: productStock !== '' ? '' : 'none'}">Stock : {{productStock}}</h1>
        </div>
    </div>
    <div class="row">
            <div class="col-sm-12 form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="damages" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.damage_code }}</td>
                                <td>{{ row.damage_date }}</td>
                                <td>{{ row.display_text }}</td>
                                <td>{{ row.quantity }}</td>
                                <td>{{ row.purchase_rate }}</td>
                                <td>{{ row.total_amount }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editDamage(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteDamage(row.id)">
                                            <i class="ace-icon fa fa-trash bigger-130"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </datatable>
                    <datatable-pager class="datatable-pagination" v-model="page" type="abbreviated"></datatable-pager>
                </div>
            </div>
        </div>
</div>

</template>
<script>
import moment from 'moment';
export default {
    props: ['role','code', 'branch'],
    data(){
            return {
                damage: {
                    id           : 0,
                    damage_code  : '',
                    damage_date  : moment().format('YYYY-MM-DD'),
                    item_id      : '',
                    quantity     : 0,
                    qty          : 0,
                    unitQty      : '',
                    purchase_rate: '',
                    total_amount : 0,
                    remark       : '',
                },
                categories: [],
                selectedCategory: {
                    name: 'Select Category'
                },
				products: [],
				selectedProduct: {
                    id            : '',
                    display_text  : 'Select Product',
                    name          : '',
                    quantity      : 0,
                    qty           : 0,
                    purchase_price: '',
                    convert_quantity: 0,
                    converter_name: '',
                    total         : ''
                },
                productStock : '',
                productStockOld : 0,
                damages: [],
				columns: [
                    { label: 'Code', field: 'damage_code', align: 'center', filterable: false },
                    { label: 'Date', field: 'damage_date', align: 'center' },
                    { label: 'Product Name', field: 'display_text', align: 'center' },
                    { label: 'Quantity', field: 'quantity', align: 'center' },
                    { label: 'Damage Rate', field: 'purchase_rate', align: 'center' },
                    { label: 'Damage Amount', field: 'total_amount', align: 'center' },
                    { label: 'Description', field: 'remark', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page    : 1,
                per_page: 10,
                filter  : '',
                progress: false,
            }
        },
        created(){
            this.getCategories();
			this.damage.damage_code  = this.code;
            this.getProducts();
            this.getDamages();
        },
		watch:{
			selectedProduct(p){
				this.productStock = '';

                if(p != null){
                    this.damage.purchase_rate = p.purchase_price;

                    let amount = +this.damage.purchase_rate * +this.damage.quantity;
                    this.damage.total_amount = isNaN(amount) ? 0 : amount;

                    axios.post('/get_medicine_stock', {productId: p.id}).then(res => {
                        this.productStock = res.data;

                        if(this.damage.id != 0 && this.damage.item_id == p.id){
                            this.productStock += this.productStockOld;
                        }

                    })
                }
			}
		},
        methods: {
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
				} else {
					this.products= [];
					this.selectedProduct = {
                        id            : '',
                        display_text  : 'Select Product',
                        name          : '',
                        quantity      : 0,
                        qty           : 0,
                        purchase_price: '',
                        convert_quantity: 0,
                        converter_name: '',
                        total         : ''
                    }
				}
			},
			addDamage(){
				if(this.selectedProduct == null){
					alert('Select Medicine');
					return;
				}

				if(+this.damage.quantity > +this.productStock){
					alert('Stock unavailable');
					return;
				}

				this.damage.item_id = this.selectedProduct.id;

                let url = '/store-damage-medicine';
                if(this.damage.id != 0){
                    url = '/update-damage-medicine';
                }

				let fd = new FormData();
            	fd.append('damages', JSON.stringify(this.damage));
				axios.post(url, fd).then(res=>{
					this.progress = false;
					this.$toaster.success(res.data.message);
					this.resetForm();
					this.getProducts();
					this.getDamages();
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

            editDamage(row){
                
                this.productStockOld = row.quantity;

				this.selectedProduct = {
					id              : row.item_id,
					purchase_price  : row.purchase_rate,
					display_text    : row.display_text,
					convert_quantity: row.product_convert_quantity,
					is_convert      : row.product_is_convert,
            	}

                this.selectedCategory = {
                    id     : row.category_id,
                    name   : row.category_name,
                    use_for: row.category_use_for
                }
                
                
                let unitQty = parseInt(row.quantity / this.selectedProduct.convert_quantity);
                let qty = parseInt(row.quantity % this.selectedProduct.convert_quantity);

                this.damage = {
                    id           : row.id,
                    item_id      : row.item_id,
                    damage_code  : row.damage_code,
                    damage_date  : row.damage_date,
                    quantity     : row.quantity,
                    purchase_rate: row.purchase_rate,
                    total_amount : row.total_amount,
                    remark       : row.remark,
                    qty          : row.product_is_convert == 1 ? qty : 0 ,
                    unitQty      : row.product_is_convert == 1 ? unitQty : ''
                }
                
                
            },

            calculateTotal(){
                if(this.selectedProduct.is_convert == 1 || this.selectedProduct.is_convert == '1') {
                    let unitQtyTotal = this.damage.unitQty * this.selectedProduct.convert_quantity;
                    this.damage.quantity = parseInt(unitQtyTotal) + parseFloat(this.damage.qty);
                } else {
                    this.damage.unitQty = '';
                    this.damage.qty =0;
                }
                let total_amount = +this.damage.purchase_rate * +this.damage.quantity;
                this.damage.total_amount = isNaN(total_amount) ? 0 : total_amount;

                // console.log(this.damage)
            },

            deleteDamage(id){
                Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: 'Want to delete this?',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/delete-damage-medicine', {id}).then(res=>{
                            let r = res.data;
                            Swal.fire({
                                icon: 'success',
                                title: r.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            this.resetForm();
                            this.getProducts();
                            this.getDamages();
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

            getDamages(){
                axios.get('/get_damages_medicine').then(res => {
                    this.damages = res.data;
                })
            },

			resetForm(){

                this.damage = {
                    id           : 0,
                    damage_code  : '',
                    damage_date  : moment().format('YYYY-MM-DD'),
                    item_id      : '',
                    quantity     : 0,
                    qty          : 0,
                    unitQty      : '',
                    purchase_rate: '',
                    total_amount : 0,
                    remark       : '',
                },

				this.selectedProduct = {
                    id            : '',
                    display_text  : 'Select Product',
                    name          : '',
                    quantity      : 0,
                    qty           : 0,
                    purchase_price: '',
                    convert_quantity: 0,
                    converter_name: '',
                    total         : ''
                },
                
                this.selectedCategory     = null;
				this.productStock         = '';
				this.productStockOld      = 0;
			}
        }
	}

</script>