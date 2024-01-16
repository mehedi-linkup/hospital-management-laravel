
<template>
    <div>
        <form @submit.prevent="savePatient">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6">

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">ID:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="patient.patient_code" required>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Name:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="patient.name" required>
                        </div>
                    </div>


                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Mobile:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="patient.mobile" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Address:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="patient.address">
                        </div>
                    </div>
                </div>	

                <div class="col-md-6">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Gender:</label>
                        <div class="col-md-7">
                            <select class="form-control" v-model="patient.gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Date of Birth:</label>
                        <div class="col-md-7">
                            <input type="date" v-model="patient.date_of_birth" class="form-control" @change="dateOfBirthChange()" required>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Remark:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="patient.remark">
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="patients" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.patient_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.mobile }}</td>
                                <td>{{ row.gender }}</td>
                                <td>{{ row.date_of_birth }}</td>
                                <td>{{ row.age }}</td>
                                <td>{{ row.address }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editPatient(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deletePatient(row.id)">
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
            patient: {
                id           : '',
                patient_code : '',
                name         : '',
                mobile       : '',
                gender       : '',
                address      : '',
                remark       : '',
                date_of_birth: moment().format('YYYY-MM-DD'),
            },
            patients: [],

            columns: [
                { label: 'ID', field: 'patient_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center'},
                { label: 'Mobile', field: 'mobile', align: 'center' },
                { label: 'Gender', field: 'gender', align: 'center' },
                { label: 'Date of Birth', field: 'date_of_birth', align: 'center' },
                { label: 'Age', field: 'age', align: 'center' },
                { label: 'Address', field: 'address', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getPatients();
        this.getPatientCode();
    },
    methods: {
        dateOfBirthChange(){
            if(moment().diff(this.patient.date_of_birth) < 0){
                this.patient.date_of_birth = '';
                alert('Invalid date of birth')
                return;
            }
        },
        clearForm(){
            this.patient = {
                id           : '',
                patient_code : this.getPatientCode(),
                name         : '',
                mobile       : '',
                gender       : '',
                address      : '',
                remark       : '',
                date_of_birth: moment().format('YYYY-MM-DD'),
            }
        },
        getPatientCode(){
            axios.get('/get_patient_code').then(res=>{
                this.patient.patient_code = res.data;
            })
        },
        getPatients(){
            axios.get('/get_patients').then(res=>{
                this.patients = res.data;
            })
        },
        savePatient(){

            let url = '/store-patient';
            if(this.patient.id != ''){
                url = '/update-patient';
            }

            axios.post(url, this.patient).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getPatients();
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
        editPatient(row){
            this.patient = {
                id           : row.id,
                patient_code : row.patient_code,
                name         : row.name,
                mobile       : row.mobile,
                gender       : row.gender,
                address      : row.address,
                remark       : row.remark,
                date_of_birth: row.date_of_birth,
            }
        },
        deletePatient(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-patient', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getPatients();
                        
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