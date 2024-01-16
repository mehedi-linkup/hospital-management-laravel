
<template>
    <div>
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-10 col-md-offset-1">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Medicine Supplier Information</h4>
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
                                            <label class="col-xs-4 control-label no-padding-right"> Supplier Code </label>
                                            <div class="col-xs-8">
                                                <input type="text" name="employee_code" class="form-control" v-model="supplierpharmacy.supplier_code" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Name </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Name" class="form-control" v-model="supplierpharmacy.name" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Owner Name </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Owner Name" class="form-control" v-model="supplierpharmacy.owner_name" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Mobile </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Mobile" class="form-control" v-model="supplierpharmacy.mobile" required />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                         <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Address </label>
                                            <div class="col-xs-8">
                                                <input type="text" placeholder="Address" class="form-control" v-model="supplierpharmacy.address" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-4 control-label no-padding-right"> Remarks </label>
                                            <div class="col-xs-8">
                                                <textarea placeholder="Remarks" class="form-control" v-model="supplierpharmacy.remark" rows="2"></textarea>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="supplierpharmacys" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.supplier_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.owner_name }}</td>
                                <td>{{ row.mobile }}</td>
                                <td>{{ row.address }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editSupplierPharmacy(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteSupplierPharmacy(row.id)">
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
            supplierpharmacy: {
                id           : '',
                supplier_code: '',
                name         : '',
                owner_name   : '',
                mobile       : '',
                address      : '',
                remark       : '',
            },

            supplierpharmacys: [],

            columns: [
                { label: 'Supplier Code', field: 'supplier_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center' },
                { label: 'Owner Name', field: 'owner_name', align: 'center' },
                { label: 'Mobile', field: 'unit_name', align: 'center' },
                { label: 'Address', field: 'address', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
   
    created(){;
        this.getSupplierPharmacyCode();
        this.getSupplierPharmacy();
    },
    methods: {

        getSupplierPharmacy(){
            axios.get('/get_supplierpharmacys').then(res=>{
                this.supplierpharmacys = res.data;
            })
        },
        getSupplierPharmacyCode(){
            axios.get('/get_supplier_pharmacy_code').then(res=>{
                this.supplierpharmacy.supplier_code = res.data;
            })
        },
       

        save(){
            this.progress = true;

            let url = '/store-supplierpharmacy';

            if(this.supplierpharmacy.id != ''){
                url = '/update-supplierpharmacy';
            }
            
            let fd = new FormData();
            fd.append('supplierpharmacys', JSON.stringify(this.supplierpharmacy));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getSupplierPharmacyCode();
                this.getSupplierPharmacy();    
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
            this.supplierpharmacy = {
                id           : '',
                supplier_code: '',
                name         : '',
                owner_name   : '',
                mobile       : '',
                address      : '',
                remark       : '',
            };
        },
        
     
        editSupplierPharmacy(row){
             
            
          
            this.supplierpharmacy = {
                id           : row.id,
                supplier_code: row.supplier_code,
                name         : row.name,
                owner_name   : row.owner_name,
                mobile       : row.mobile,
                address      : row.address,
                remark       : row.remark
            }

        },
        deleteSupplierPharmacy(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-supplierpharmacy', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getSupplierPharmacyCode();
                        this.getSupplierPharmacy();
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