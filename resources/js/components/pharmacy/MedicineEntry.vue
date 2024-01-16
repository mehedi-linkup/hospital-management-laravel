
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-10 col-md-offset-1">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Medicine Entry</h4>
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
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Medicine Code </label>
                                            <div class="col-xs-9">
                                                <input type="text" name="employee_code" class="form-control" v-model="medicine.medicine_code" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Medicine Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Medicine Name" class="form-control" v-model="medicine.name" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Category </label>
                                            <div class="col-xs-8">
                                                <v-select :options="categories" label="name" v-model="selectedCategory"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/category_entry_medicine" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Generic </label>
                                            <div class="col-xs-8">
                                                <v-select :options="generics" label="name" v-model="selectedGeneric"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/generic_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Brand </label>
                                            <div class="col-xs-8">
                                                <v-select :options="brands" label="name" v-model="selectedBrand"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/brand_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Unit </label>
                                            <div class="col-xs-8">
                                                <v-select :options="units" label="name" v-model="selectedUnit"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/unit_entry_medicine" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                         <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Re-order Level </label>
                                            <div class="col-xs-8">
                                                <input type="number" placeholder="Re-order Level" class="form-control" v-model="medicine.reorder_level" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Purchase Price </label>
                                            <div class="col-xs-8">
                                                <input type="number" step="0.01" placeholder="Purchase Price"  class="form-control" v-model="medicine.purchase_price" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Sale Price </label>
                                            <div class="col-xs-8">
                                                <input type="number" step="0.01" placeholder="Sale Price" class="form-control" v-model="medicine.sale_price" required/>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Is Convert </label>
                                            <div class="col-xs-8">
                                                <input type="checkbox" v-model="medicine.is_convert">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="display:none;" v-bind:style="{display:medicine.is_convert == true ? '' : 'none'}">
                                            <label class="col-xs-4 control-label no-padding-right"> Converter Name </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Converter Name" class="form-control" v-model="medicine.converter_name" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group row" style="display:none;" v-bind:style="{display:medicine.is_convert == true ? '' : 'none'}">
                                            <label class="col-xs-4 control-label no-padding-right"> Converter Quantity </label>
                                            <div class="col-xs-8">
                                                <input type="number" step="any"  placeholder="Converter Quantity" class="form-control" v-model="medicine.convert_quantity" autocomplete="off" />
                                            </div>
                                        </div>
                                        <br />
                                        <div class="form-group row">
                                            <div class="col-xs-4 col-xs-offset-8">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary btn-sm"
                                                    value="Save"
                                                    v-bind:disabled="progress ? true : false"
                                                    style="color: #fff !important; margin-top: 0px; width: 100%; padding: 5px; font-weight: bold;"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </form>
        <br />
        <div class="row">
            <div class="col-sm-12 form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="medicines" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.medicine_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.category_name }}</td>
                                <td>{{ row.generic_name }}</td>
                                <td>{{ row.brand_name }}</td>
                                <td>{{ row.unit_name }}</td>
                                <td>{{ row.is_convert ? "Yes" : "No"}}</td>
                                <td>{{ row.is_convert ? row.converter_name: 'N/A' }}</td>
                                <td>{{ row.convert_quantity }}</td>
                                <td>{{ row.reorder_level }}</td>
                                <td>{{ row.purchase_price }}</td>
                                <td>{{ row.sale_price }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editMedicine(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteMedicine(row.id)">
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
    props: ['role'],
    data () {
        return {
            medicine: {
                id              : '',
                medicine_code   : '',
                brand_id        : '',
                category_id     : '',
                generic_id      : '',
                unit_id         : '',
                name            : '',
                is_convert      : true,
                converter_name  : '',
                convert_quantity: '',
                purchase_price  : '',
                sale_price      : '',
                reorder_level   : 0,
            },

            medicines      : [],

            categories      : [],
            selectedCategory: null,

            generics       : [],
            selectedGeneric: null,

            brands       : [],
            selectedBrand: null,

            units       : [],
            selectedUnit: null,

            columns: [
                { label: 'Medicine Code', field: 'medicine_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center' },
                { label: 'Category', field: 'category_name', align: 'center' },
                { label: 'Generic', field: 'generic_name', align: 'center' },
                { label: 'Brand', field: 'brand_name', align: 'center' },
                { label: 'Unit', field: 'unit_name', align: 'center' },
                { label: 'Is Convert', field: ' is_convert', align: 'center' },
                { label: 'Converter Name', field: 'converter_name', align: 'center' },
                { label: 'Converter Quantity', field: 'convert_quantity', align: 'center' },
                { label: 'Re-order Level', field: 'reorder_level', align: 'center' },
                { label: 'Purchase Price', field: 'purchase_price', align: 'center' },
                { label: 'Sale Price', field: 'sale_price', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
   
    created(){
        this.getCategories();
        this.getGenerics();
        this.getBrands();
        this.getUnits();
        this.getMedicineCode();
        this.getMedicine();
    },
    methods: {

        getCategories(){
            axios.get('/get_categories_medicine').then(res=>{
                this.categories = res.data;
            })
        },

        getGenerics(){
            axios.get('/get_generics').then(res=>{
                this.generics = res.data;
            })
        },

        getBrands(){
            axios.get('/get_brands').then(res=>{
                this.brands = res.data;
            })
        },

        getUnits(){
            axios.get('/get_units_medicine').then(res=>{
                this.units = res.data;
            })
        },

        getMedicine(){
            axios.get('/get_medicines').then(res=>{
                this.medicines = res.data;
            })
        },
        getMedicineCode(){
            axios.get('/get_medicine_code').then(res=>{
                this.medicine.medicine_code = res.data;
            })
        },
       

        save(){

            if(this.selectedCategory == null){
                alert('Select Category');
                return;
            }
            
            if(this.selectedGeneric == null){
                alert('Select Generic');
                return;
            }
            if(this.selectedBrand == null){
                alert('Select Brand');
                return;
            }
            if(this.selectedUnit == null){
                alert('Select Unit');
                return;
            }
           

            this.progress = true;

            this.medicine.brand_id = this.selectedBrand.id;
            this.medicine.generic_id = this.selectedGeneric.id;
            this.medicine.category_id = this.selectedCategory.id;
            this.medicine.unit_id = this.selectedUnit.id;


            let url = '/store-medicine';

            if(this.medicine.id != ''){
                url = '/update-medicine';
            }
            
            let fd = new FormData();
            fd.append('medicines', JSON.stringify(this.medicine));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getMedicineCode();
                this.getMedicine();
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
        clear(){
        
            this.medicine = {
                id              : '',
                medicine_code   : '',
                brand_id        : '',
                category_id     : '',
                generic_id      : '',
                unit_id         : '',
                name            : '',
                is_convert      : true,
                converter_name  : '',
                convert_quantity: '',
                purchase_price  : '',
                sale_price      : '',
                reorder_level   : 0,
            };
           this.selectedCategory = null;
           this.selectedGeneric  = null;
           this.selectedBrand    = null;
           this.selectedUnit     = null;
        },
        
     
        editMedicine(row){
             
            this.selectedBrand = {
                id  : row.brand_id,
                name: row.brand_name
            }
            this.selectedCategory = {
                id  : row.category_id,
                name: row.category_name
            }

            this.selectedGeneric = {
                id  : row.generic_id,
                name: row.generic_name
            }
            this.selectedUnit = {
                id  : row.unit_id,
                name: row.unit_name
            }
             
          
            this.medicine = {
                id              : row.id,
                medicine_code   : row.medicine_code,
                name            : row.name,
                is_convert      : row.is_convert,
                converter_name  : row.converter_name,
                convert_quantity: row.convert_quantity,
                purchase_price  : row.purchase_price,
                sale_price      : row.sale_price,
                reorder_level   : row.reorder_level
            }

        },
        deleteMedicine(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-medicine', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getMedicine();
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
        }
    }
}
</script>