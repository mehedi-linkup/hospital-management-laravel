
<template>
    <div>
        <form @submit.prevent="saveDoctor">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">ID:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="doctor.doctor_code" required>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Name:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="doctor.name" required>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Mobile:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="doctor.mobile" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Address:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="doctor.address">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Fees:</label>
                        <div class="col-md-7">
                            <input type="number" step="1" class="form-control" v-model="doctor.fees" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Commission (%):</label>
                        <div class="col-md-7">
                            <input type="number" step="0.01" class="form-control" v-model="doctor.commission_percent" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Remark:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="doctor.remark">
                        </div>
                    </div>
                </div>	

                <div class="col-md-6">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Education Level:</label>
                        <div class="col-md-7">
                            <textarea class="form-control" v-model="doctor.education_level" rows="10" required></textarea>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="doctors" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.doctor_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.mobile }}</td>
                                <td>{{ row.address }}</td>
                                <td>{{ row.fees }}</td>
                                <td>{{ row.commission_percent }} %</td>
                                <td style="white-space: pre-line;">{{ row.education_level }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editDoctor(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteDoctor(row.id)">
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
            doctor: {
                id                : '',
                doctor_code       : '',
                name              : '',
                mobile            : '',
                address           : '',
                fees              : '',
                commission_percent: '',
                education_level   : '',
                remark            : '',
            },
            doctors: [],

            columns: [
                { label: 'ID', field: 'doctor_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center'},
                { label: 'Mobile', field: 'mobile', align: 'center' },
                { label: 'Address', field: 'address', align: 'center' },
                { label: 'Fees', field: 'fees', align: 'center' },
                { label: 'Commission', field: 'commission_percent', align: 'center' },
                { label: 'Education Level', field: 'education_level', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getDoctors();
        this.getDoctorCode();
    },
    methods: {
        clearForm(){
            this.doctor = {
                id                : '',
                doctor_code       : this.getDoctorCode(),
                name              : '',
                mobile            : '',
                address           : '',
                fees              : '',
                commission_percent: '',
                education_level   : '',
                remark            : '',
            }
        },
        getDoctorCode(){
            axios.get('/get_doctor_code').then(res=>{
                this.doctor.doctor_code = res.data;
            })
        },
        getDoctors(){
            axios.get('/get_doctors').then(res=>{
                this.doctors = res.data;
            })
        },
        saveDoctor(){

            let url = '/store-doctor';
            if(this.doctor.id != ''){
                url = '/update-doctor';
            }

            axios.post(url, this.doctor).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getDoctors();
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
        editDoctor(row){
            this.doctor = {
                id                : row.id,
                doctor_code       : row.doctor_code,
                name              : row.name,
                mobile            : row.mobile,
                address           : row.address,
                fees              : row.fees,
                commission_percent: row.commission_percent,
                education_level   : row.education_level,
                remark            : row.remark,

            }
        },
        deleteDoctor(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-doctor', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getDoctors();
                        
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