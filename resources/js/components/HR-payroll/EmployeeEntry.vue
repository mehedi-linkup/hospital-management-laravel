<style scoped>
label{
    font-size: 12px !important;
}
#brandImage {
		height: 100%;
		width: 100%;
	}
    #employee .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#employee .custom-file-upload:hover{
		background-color: #41add6;
	}
    #employee .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 20px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#employee .custom-file-upload:hover{
		background-color: #41add6;
	}
    #employee input[type="file"] {
		display: none;
	}
    #employeeImage{
		height: 100%;
	}


</style>
<template>
    <div id="employee">
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-lg-10">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Employee Information</h4>
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
                                            <label class="col-xs-3 control-label no-padding-right"> Employee Code </label>
                                            <div class="col-xs-3">
                                                <input type="text" name="employee_code" class="form-control" v-model="employee.employee_code" readonly />
                                            </div>
                                            <label class="col-xs-2 control-label no-padding-right"> BIO ID </label>
                                            <div class="col-xs-4">
                                                <input type="text" name="bio_id" placeholder="BIO ID" class="form-control" v-model="employee.bio_id" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Department </label>
                                            <div class="col-xs-8">
                                                <v-select :options="departments" name="department_id" label="name" v-model="selectedDepartment"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/department_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Designation </label>
                                            <div class="col-xs-8">
                                                <v-select :options="designations" name="designation_id" label="name" v-model="selectedDesignation"></v-select>
                                            </div>
                                            <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                                <a href="/designation_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Name" name="name" class="form-control" v-model="employee.name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Father`s Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Father`s Name" name="father_name" class="form-control" v-model="employee.father_name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Mother`s Name </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Mother`s Name" name="mother_name" class="form-control" v-model="employee.mother_name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Mobile No. </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Mobile" class="form-control" name="mobile_number" v-model="employee.mobile_number" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Email </label>
                                            <div class="col-xs-9">
                                                <input type="text" placeholder="Email" class="form-control" name="email" v-model="employee.email" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Gender </label>
                                            <div class="col-xs-3">
                                                <select class="form-control" name="gender" v-model="employee.gender">
                                                    <option value="">Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <label class="col-xs-3 control-label no-padding-right">Merital Status</label>
                                            <div class="col-xs-3">
                                                <select class="form-control" name="merital_status" v-model="employee.merital_status">
                                                    <option value="">Merital Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Divorce">Divorce</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Activation </label>
                                            <div class="col-xs-9">
                                                <select class="form-control" name="gender" v-model="employee.status">
                                                    <option value="">Select Activation</option>
                                                    <option value="a">Active</option>
                                                    <option value="d">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Date of birth </label>
                                            <div class="col-xs-9">
                                                <input type="date" class="form-control" name="birth_date" v-model="employee.birth_date" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Present Address </label>
                                            <div class="col-xs-9">
                                                <textarea name="present_address" id="" class="form-control" cols="5" rows="1" v-model="employee.present_address" placeholder="Present Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right">Permanent Address </label>
                                            <div class="col-xs-9">
                                                <textarea name="permanent_address" id="" class="form-control" cols="5" rows="1" v-model="employee.permanent_address" placeholder="Permanent Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Joining Date</label>
                                            <div class="col-xs-9">
                                                <input type="date" class="form-control" name="joining_date" v-model="employee.joining_date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xs-3 control-label no-padding-right"> Salary Range </label>
                                            <div class="col-xs-9">
                                                <input type="number" step="any" name="salary_range" placeholder="Salary Range" class="form-control" v-model="employee.salary_range" autocomplete="off" />
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

                <div class="col-xs-12 col-md-2 col-lg-2">
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
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div style="width: 140px; height: 160px; border: 1px solid #ccc; overflow: hidden;">
                                                <img id="employeeImage" v-if="imageUrl == '' || imageUrl == null" src="/images/no_image.jpg" style="height: 160px; width: 140px;" />
                                                <img id="employeeImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl" style="height: 160px; width: 140px;" />
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
                <div class="form-group">
                    <label for="">Status</label>
                    <select class="form-control" name="gender" v-model="selectedStatus" @change="getEmployee">
                                <option value="" selected>All</option>
                                <option value="a">Active</option>
                                <option value="d">Deactive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="employees" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.employee_code }}</td>
                                <td>{{ row.bio_id }}</td>
                                <td>{{ row.department_name }}</td>
                                <td>{{ row.designation_name }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.father_name }}</td>
                                <td>{{ row.mother_name }}</td>
                                <td>{{ row.mobile_number }}</td>
                                <td>{{ row.email }}</td>
                                <td>{{ row.gender }}</td>
                                <td>{{ row.merital_status }}</td>
                                <td>{{ row.present_address }}</td>
                                <td>{{ row.permanent_address }}</td>
                                <td>{{ row.salary_range }}</td>
                                <td>
                                    <img id="employeeImage" v-if="row.image == '' || row.image == null" src="/images/no_image.jpg" style="height: 50px; width: 50px;" />
                                    <img id="employeeImage" v-if="row.image != '' && row.image != null" v-bind:src="row.image" style="height: 50px; width: 50px;" />
                                </td>
                                <td v-if="row.status == 'a'" style="color:darkgreen"><b>Active</b></td>
                                <td v-if="row.status == 'd'" style="color:darkred"><b>Deactive</b></td>

                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editEmployee(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteEmployee(row.id)">
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
           
            employee: {
                id               : '',
                employee_code    : '',
                bio_id           : '',
                department_id    : '',
                designation_id   : '',
                joining_date     : moment().format('YYYY-MM-DD'),
                birth_date       : moment().format('YYYY-MM-DD'),
                name             : '',
                father_name      : '',
                mother_name      : '',
                mobile_number    : '',
                email            : '',
                status            : '',
                gender           : '',
                merital_status   : '',
                present_address  : '',
                permanent_address: '',
                salary_range     : '',
            },

            employees      : [],

            departments       : [],
            selectedDepartment: null,

            designations       : [],
            selectedDesignation: null,

           
            imageUrl    : '',
            selectedStatus: null,
            selectedFile: null,
            columns            : [
                { label: 'Emp. Code', field: 'employee_code', align: 'center'},
                { label: 'Bio ID', field: 'bio_id', align: 'center' },
                { label: 'Department', field: 'department_id', align: 'center' },
                { label: 'Designation', field: 'designation_id', align: 'center' },
                { label: 'Name', field: 'name', align: 'center' },
                { label: 'Father`s Name', field: 'father_name', align: 'center' },
                { label: 'Mother`s Name', field: 'mother_name', align: 'center' },
                { label: 'Mobile', field: 'mobile_number', align: 'center' },
                { label: 'Email', field: 'email', align: 'center' },
                { label: 'Gender', field: 'gender', align: 'center' },
                { label: 'Merital Status', field: 'merital_status', align: 'center' },
                { label: 'Present Address', field: 'present_address', align: 'center' },
                { label: 'Permanent Address', field: 'permanent_address', align: 'center' },
                { label: 'Salary Range', field: 'salary_range', align: 'center' },
                { label: 'Image', field: 'image', align: 'center' },
                { label: 'Status', field: 'status', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
   
    created(){
        this.getDepartments();
        this.getDesignations();
        this.getEmployeeCode();
        this.getEmployee();
    },
    methods: {
         getDepartments(){
            axios.get('/get_departments').then(res=>{
                this.departments = res.data;
            })
        },
        getEmployee(){
            axios.post('/get_employees',{status:this.selectedStatus}).then(res=>{
                this.employees = res.data;
            })
        },
        getEmployeeCode(){
            axios.get('/get_employee_code').then(res=>{
                this.employee.employee_code = res.data;
            })
        },
        getDesignations(){
            axios.get('/get_designations').then(res=>{
                this.designations = res.data;
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

            if(this.selectedDepartment == null){
                alert('Select Department');
                return;
            }
            if(this.selectedDesignation == ''){
                alert('Select Designation');
                return;
            }
           

            this.progress = true;

            this.employee.department_id = this.selectedDepartment.id;
            this.employee.designation_id = this.selectedDesignation.id;


            let url = '/store-employee';

            if(this.employee.id != ''){
                url = '/update-employee';
            }
                let fd = new FormData();
            fd.append('image', this.selectedFile);
            fd.append('employees', JSON.stringify(this.employee));
            axios.post(url, fd).then(res=>{
                this.progress = false;
                this.$toaster.success(res.data.message);
                this.clear();
                this.getDepartments();
                this.getDesignations();
                this.getEmployee();
                this.getEmployeeCode();
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
        
            this.employee = {
                id               : '',
                employee_code    : '',
                bio_id           : '',
                department_id    : '',
                designation_id   : '',
                joining_date     : moment().format('YYYY-MM-DD'),
                birth_date       : moment().format('HH:mm'),
                name             : '',
                father_name      : '',
                mother_name      : '',
                mobile_number    : '',
                email            : '',
                status           : '',
                gender           : '',
                merital_status   : '',
                present_address  : '',
                permanent_address: '',
                salary_range     : '',
            };
           this.departments         = [];
           this.selectedDepartment  = null;
           this.designations        = [];
           this.selectedDesignation = null;
           this.selectedFile        = null;
           this.imageUrl = null;
        },
        
     
        editEmployee(row){
          
    
            this.selectedDepartment = {
                id  : row.department_id,
                name: row.department_name,
            }
            this.selectedDesignation = {
                id  : row.designation_id,
                name: row.designation_name,
            }
                if(row.image == null || row.image == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = row.image;
				}
          
            this.employee = {
                id               : row.id,
                employee_code    : row.employee_code,
                bio_id           : row.bio_id,
                joining_date     : row.joining_date,
                birth_date       : row.birth_date,
                name             : row.name,
                father_name      : row.father_name,
                mother_name      : row.mother_name,
                mobile_number    : row.mobile_number,
                email            : row.email,
                gender           : row.gender,
                status           : row.status,
                merital_status   : row.merital_status,
                present_address  : row.present_address,
                permanent_address: row.permanent_address,
                salary_range     : row.salary_range,
            }

        },
        deleteEmployee(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-employee', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.clear();
                        this.getDepartments();
                        this.getDesignations();
                        this.getEmployeeCode();
                        this.getEmployee();
                        
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