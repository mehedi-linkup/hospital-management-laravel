<style scoped>

#brandImage {
		height: 100%;
		width: 100%;
	}
    #driver .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 30px;
        margin-left: 50px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#driver .custom-file-upload:hover{
		background-color: #41add6;
	}
    #driver .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 20px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#driver .custom-file-upload:hover{
		background-color: #41add6;
	}
    #driver input[type="file"] {
		display: none;
	}
    #driverImage{
		height: 100%;
	}


</style>
<template>
    <div id="driver">
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-10 col-md-6 col-lg-6 col-md-offset-3">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Ambulance Information</h4>
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
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Ambulacne Code </label>
                                            <div class="col-xs-9">
                                                <input type="text" class="form-control" v-model="ambulance.vehicle_code" readonly />
                                            </div>
                                            
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Reg No. </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Reg No." class="form-control" v-model="ambulance.reg_no" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Driver </label>
                                            <div class="col-xs-8">
                                                <v-select :options="drivers" name="designation_id" label="display_name" v-model="selectedDriver"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -7px;">
                                                <a href="/driver_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Remarks </label>
                                            <div class="col-xs-9">
                                                <textarea name="Remarks" id="" class="form-control" cols="5" rows="3" v-model="ambulance.remark" placeholder="Remarks"></textarea>
                                            </div>
                                        </div>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="ambulances" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.vehicle_code }}</td>
                                <td>{{ row.reg_no }}</td>
                                <td>{{ row.display_name }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editAmbulance(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteAmbulance(row.id)">
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
            ambulance: {
                id          : '',
                vehicle_code: '',
                reg_no      : '',
                driver_id   : '',
                remark      : '',
            },

            ambulances    : [],
            drivers       : [],
            selectedDriver: null,
            columns       : [
                { label: 'Ambulance Code', field: 'vehicle_code', align: 'center'},
                { label: 'Reg No', field: 'reg_no', align: 'center' },
                { label: 'Driver Name', field: 'display_name', align: 'center' },
                { label: 'Remarks', field: 'remarks', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
   
    created(){
        this.getAmbulanceCode();
        this.getAmbulance();
        this.getDriver();
    },
    methods: {
        
        getDriver(){
            axios.get('/get_drivers').then(res=>{
                this.drivers = res.data;
            })
        },
        
        getAmbulance(){
            axios.get('/get_ambulances').then(res=>{
                this.ambulances = res.data;
            })
        },
        getAmbulanceCode(){
            axios.get('/get_ambulance_code').then(res=>{
                this.ambulance.vehicle_code = res.data;
            })
        },
       
        save(){

           if(this.selectedDriver == null){
                alert('Select Driver');
                return;
            }

            this.progress = true;


            this.ambulance.driver_id = this.selectedDriver.id;

            let url = '/store-ambulance';

            if(this.ambulance.id != ''){
                url = '/update-ambulance';
            }
                let fd = new FormData();
            fd.append('ambulances', JSON.stringify(this.ambulance));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getAmbulanceCode();
                this.getAmbulance();
                this.getDriver();
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
        
            this.ambulance = {
                id          : '',
                vehicle_code: '',
                reg_no      : '',
                driver_id   : '',
                remark      : '',
            };
        },
        
     
        editAmbulance(row){
           this.selectedDriver = {
                id          : row.driver_id,
                display_name: row.display_name,
            }
          
            this.ambulance = {
                id          : row.id,
                vehicle_code: row.vehicle_code,
                reg_no      : row.reg_no,
                remark      : row.remark,
            }
        },
        deleteAmbulance(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-ambulance', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                         this.clear();
                         this.getAmbulanceCode();
                         this.getAmbulance();
                         this.getDriver();
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