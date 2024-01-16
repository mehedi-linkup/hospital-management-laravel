
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-10 col-md-offset-1">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Instrument  Entry</h4>
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
                                            <label class="col-xs-4 control-label no-padding-right"> Instrument Code </label>
                                            <div class="col-xs-8">
                                                <input type="text" name="employee_code" class="form-control" v-model="instrument.instrument_code" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Instrument Name </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Instrument Name" class="form-control" v-model="instrument.name" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Category </label>
                                            <div class="col-xs-7">
                                                <v-select :options="categories" label="name" v-model="selectedCategory"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/category_entry_inventory" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Unit </label>
                                            <div class="col-xs-7">
                                                <v-select :options="units" label="name" v-model="selectedUnit"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/unit_entry_inventory" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                         <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Re-order Level </label>
                                            <div class="col-xs-8">
                                                <input type="number" placeholder="Re-order Level" class="form-control" v-model="instrument.reorder_level" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Purchase Price </label>
                                            <div class="col-xs-8">
                                                <input type="number" step="0.01" placeholder="Purchase Price"  class="form-control" v-model="instrument.purchase_price" required/>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="instruments" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.instrument_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.category_name }}</td>
                                <td>{{ row.unit_name }}</td>
                                <td>{{ row.reorder_level }}</td>
                                <td>{{ row.purchase_price }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editInstrument(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteInstrument(row.id)">
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
            instrument: {
                id              : '',
                instrument_code   : '',
                category_id     : '',
                unit_id         : '',
                name            : '',
                purchase_price  : '',
                reorder_level   : 0,
            },

            instruments      : [],

            categories      : [],
            selectedCategory: null,          

            units       : [],
            selectedUnit: null,

            columns: [
                { label: 'Medicine Code', field: 'medicine_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center' },
                { label: 'Category', field: 'category_name', align: 'center' },
                { label: 'Unit', field: 'unit_name', align: 'center' },
                { label: 'Re-order Level', field: 'reorder_level', align: 'center' },
                { label: 'Purchase Price', field: 'purchase_price', align: 'center' },
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
        this.getUnits();
        this.getInstrumentCode();
        this.getInstrument();
    },
    methods: {

        getCategories(){
            axios.get('/get_categories_inventory').then(res=>{
                this.categories = res.data;
            })
        },

        getUnits(){
            axios.get('/get_units_inventory').then(res=>{
                this.units = res.data;
            })
        },

        getInstrument(){
            axios.get('/get_instruments').then(res=>{
                this.instruments = res.data;
            })
        },
        getInstrumentCode(){
            axios.get('/get_instrument_code').then(res=>{
                this.instrument.instrument_code = res.data;
            })
        },
       

        save(){

            if(this.selectedCategory == null){
                alert('Select Category');
                return;
            }
            
            if(this.selectedUnit == null){
                alert('Select Unit');
                return;
            }
           

            this.progress = true;

            this.instrument.category_id = this.selectedCategory.id;
            this.instrument.unit_id = this.selectedUnit.id;


            let url = '/store-instrument';

            if(this.instrument.id != ''){
                url = '/update-instrument';
            }
            
            let fd = new FormData();
            fd.append('instruments', JSON.stringify(this.instrument));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getInstrumentCode();
                this.getInstrument();
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
        
            this.instrument = {
                id             : '',
                instrument_code: '',
                category_id    : '',
                unit_id        : '',
                name           : '',
                purchase_price : '',
                reorder_level  : 0,
            };
           this.selectedCategory = null;
           this.selectedUnit     = null;
        },
        
     
        editInstrument(row){
             
            
            this.selectedCategory = {
                id  : row.category_id,
                name: row.category_name
            }

          
            this.selectedUnit = {
                id  : row.unit_id,
                name: row.unit_name
            }
             
          
            this.instrument = {
                id              : row.id,
                instrument_code : row.instrument_code,
                name            : row.name,
                purchase_price  : row.purchase_price,
                reorder_level   : row.reorder_level
            }

        },
        deleteInstrument(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-instrument', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getInstrumentCode();
                        this.getInstrument();
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