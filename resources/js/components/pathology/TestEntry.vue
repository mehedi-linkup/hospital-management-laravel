
<template>
    <div>
        <form @submit.prevent="saveTest">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-5 col-md-offset-1">

                    <div class="form-group clearfix">
                        <label class="control-label col-md-3">ID</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" v-model="test.test_code" required>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-3">Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" v-model="test.name" required>
                        </div>
                    </div>


                    <div class="form-group clearfix">
                        <label class="control-label col-md-3">Room No</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" v-model="test.room_number">
                        </div>
                    </div>
                </div>	

                <div class="col-md-5">

                    <div class="form-group clearfix">
                        <label class="control-label col-md-3">Price</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" v-model="test.price" required>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-3">Time</label>
                        <div class="col-md-3">
                            <input type="number" class="form-control" placeholder="Day" v-model="test.day">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control" placeholder="Hour" max="23" v-model="test.hour">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control" placeholder="Minute" max="59" v-model="test.minute">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-3">Remark</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" v-model="test.remark">
                        </div>
                    </div>
                    
                </div>	
                <div class="col-md-10 col-md-offset-1">
                    <Editor api-key="1m66cayxwezk4n2qxg1st7ybctw11sq6t6crzazkuunpk69f"
                        :init="{
                            plugins: 'lists link image table code help wordcount'
                        }"
                        placeholder="Template"
                        v-model="test.template"
                    />

                    <div class="form-group clearfix" style="float: right;">
                        <input type="submit" class="btn btn-success btn-sm" value="Save">
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="tests" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.test_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.room_number }}</td>
                                <td>{{ row.price }}</td>
                                <td>{{ row.delivery_time }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editTest(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteTest(row.id)">
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
import Editor from '@tinymce/tinymce-vue'
export default {
    props: ['role'],
    components: {
        Editor
    },
    data () {
        return {
            test: {
                id         : '',
                test_code  : '',
                name       : '',
                room_number: '',
                price      : '',
                day        : '',
                hour       : '',
                minute     : '',
                remark     : '',
                template   : '',
            },
            tests: [],

            columns: [
                { label: 'ID', field: 'test_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center'},
                { label: 'Room', field: 'room_number', align: 'center' },
                { label: 'Price', field: 'price', align: 'center' },
                { label: 'Delivery Time', field: 'delivery_time', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getTests();
        this.getTestCode();
    },
    methods: {
        clearForm(){
            this.test = {
                id         : '',
                test_code  : this.getTestCode(),
                name       : '',
                room_number: '',
                price      : '',
                day        : '',
                hour       : '',
                minute     : '',
                remark     : '',
                template   : '',
            }
        },
        getTestCode(){
            axios.get('/get_test_code').then(res=>{
                this.test.test_code = res.data;
            })
        },
        getTests(){
            axios.get('/get_tests').then(res=>{
                this.tests = res.data;
            })
        },
        saveTest(){

            let url = '/store-test';
            if(this.test.id != ''){
                url = '/update-test';
            }

            axios.post(url, this.test).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getTests();
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
        editTest(row){
            this.test = {
                id         : row.id,
                test_code  : row.test_code,
                name       : row.name,
                room_number: row.room_number,
                price      : row.price,
                day        : row.day,
                hour       : row.hour,
                minute     : row.minute,
                remark     : row.remark,
                template   : row.template,
            }
        },
        deleteTest(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-test', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getTests();
                        
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