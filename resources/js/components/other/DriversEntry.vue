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
                <div class="col-xs-10 col-md-7 col-lg-7 col-md-offset-1">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Driver Information</h4>
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
                                            <label class="col-xs-3 control-label no-padding-right"> Driver Code </label>
                                            <div class="col-xs-9">
                                                <input type="text" name="employee_code" class="form-control" v-model="driver.driver_code" readonly />
                                            </div>
                                            
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Name" name="name" class="form-control" v-model="driver.name" />
                                            </div>
                                        </div>
                                        
                                       
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Mobile No. </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Mobile" class="form-control" name="Mobile No." v-model="driver.mobile" autocomplete="off" />
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Address </label>
                                            <div class="col-xs-9">
                                                <textarea name="Address" id="" class="form-control" cols="5" rows="3" v-model="driver.address" placeholder="Address"></textarea>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Remarks </label>
                                            <div class="col-xs-9">
                                                <textarea name="Remarks" id="" class="form-control" cols="5" rows="3" v-model="driver.remark" placeholder="Remarks"></textarea>
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

                <div class="col-xs-3 col-md-3 col-lg-3">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Image</h4>
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
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <div style="margin-left:15px; width: 205px; height: 233px; border: 1px solid #ccc; overflow: hidden;">
                                                <img id="driverImage" v-if="imageUrl == '' || imageUrl == null" src="/images/no_image_2.jpg" style="padding:15px;width: 205px; height: 220px;" />
                                                <img id="driverImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl" style="padding:15px;width: 205px; height: 233px;" />
                                            </div>
                                            <div style="text-align: center;">
                                                <label class="custom-file-upload">
                                                    <input type="file" name="image" @change="previewImage" />
                                                    Select Image
                                                </label>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="drivers" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.driver_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.mobile }}</td>
                                <td>{{ row.address }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <img id="driverImage" v-if="row.image == '' || row.image == null" src="/images/no_image_2.jpg" style="height: 50px; width: 50px;" />
                                    <img id="driverImage" v-if="row.image != '' && row.image != null" v-bind:src="row.image" style="height: 50px; width: 50px;" />
                                </td>

                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editDriver(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteDriver(row.id)">
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
            driver: {
                id         : '',
                driver_code: '',
                name       : '',
                mobile     : '',
                address    : '',
                remark    : '',
            },

            drivers     : [],
            imageUrl    : '',
            selectedFile: null,
            columns     : [
                { label: 'Driver Code', field: 'driver_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center' },
                { label: 'Mobile', field: 'mobile', align: 'center' },
                { label: 'Address', field: 'address', align: 'center' },
                { label: 'Remarks', field: 'remarks', align: 'center' },
                { label: 'Image', field: 'image', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
   
    created(){
        this.getDriverCode();
        this.getDriver();
    },
    methods: {
        
        getDriver(){
            axios.get('/get_drivers').then(res=>{
                this.drivers = res.data;
            })
        },
        getDriverCode(){
            axios.get('/get_driver_code').then(res=>{
                this.driver.driver_code = res.data;
            })
        },
       


        previewImage(event){
				if(event.target.files.length > 0){
					this.selectedFile = event.target.files[0];
					this.imageUrl     = URL.createObjectURL(this.selectedFile);
				} else {
					this.selectedFile = null;
					this.imageUrl     = '';
				}
		},
        save(){

           

            this.progress = true;

            let url = '/store-driver';

            if(this.driver.id != ''){
                url = '/update-driver';
            }
                let fd = new FormData();
            fd.append('image', this.selectedFile);
            fd.append('drivers', JSON.stringify(this.driver));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getDriver();
                this.getDriverCode();
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
        
            this.driver = {
                id         : '',
                driver_code: '',
                name       : '',
                mobile     : '',
                address    : '',
                remark     : ''
            };
           this.selectedFile        = null;
           this.imageUrl = null;
        },
        
     
        editDriver(row){
          
    
                if(row.image == null || row.image == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = row.image;
				}
          
            this.driver = {
                id         : row.id,
                driver_code: row.driver_code,
                name       : row.name,
                mobile     : row.mobile,
                address    : row.address,
                remark     : row.remark,
            }

        },
        deleteDriver(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-driver', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getDriverCode();
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