<template>
    <div>
        <form @submit.prevent="saveFloor">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Floor Number:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="floor.floor_number" readonly required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Floor Name:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" placeholder="Floor Name" v-model="floor.floor_name" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Remarks:</label>
                        <div class="col-md-7">
                            <textarea class="form-control" rows="2" placeholder="Remarks"  v-model="floor.remark"></textarea>
                           
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <div class="col-md-7 col-md-offset-4">
                            <input type="submit" class="btn btn-success btn-sm" value="Save">
                        </div>
                    </div>
                </div>	
            </div>
        </form>

        <div class="row">
            <div class="col-sm-12 form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter">
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="floors" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.floor_number }}</td>
                                <td>{{ row.floor_name }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editFloor(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteFloor(row.id)">
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
            floor: {
                id          : '',
                floor_number : '',
                floor_name: '',
                remark      : '',
            },
            floors: [],

            columns: [
                { label: 'S/L', field: 'sl_no', align: 'center'},
                { label: 'Floor Number', field: 'floor_number', align: 'center'},
                { label: 'Floor Name', field: 'floor_name', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getFloorCode();
        this.getFloors();
    },
    methods: {
        clearForm(){
            this.floor = {
                 id          : '',
                 floor_number: this.getFloorCode(),
                 floor_name: '',
                 remark      : '',
            }
        },
        
        getFloors(){
            axios.get('/get_floors').then(res=>{
                this.floors = res.data;
            })
        },
        saveFloor(){
           
            let url = '/store-floor';
            if(this.floor.id != ''){
                url = '/update-floor';
            }

            axios.post(url, this.floor).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getFloors();
                this.getFloorCode();
                this.clearForm();
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
        },
        getFloorCode(){
            axios.get('/get_floor_code').then(res=>{
                this.floor.floor_number = res.data;
            })
        },
        editFloor(row){
            this.floor = {
                id          : row.id,
                floor_number: row.floor_number,
                floor_name  : row.floor_name,
                remark      : row.remark
            }
        },
        deleteFloor(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-floor', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getFloors();
                        
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