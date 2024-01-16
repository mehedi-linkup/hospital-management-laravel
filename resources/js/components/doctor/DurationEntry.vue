<template>
    <div>
        <form @submit.prevent="save">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Duration:</label>
                        <div class="col-md-7">
                            <input type="text" placeholder="7 Days" name="chief_complain" class="form-control" v-model="duration.duration" required>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="durations" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.duration }}</td>
                                <td>
                                    <a class="blue" href="javascript:" @click="editDuration(row)">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <a class="red" href="javascript:" @click="deleteDuration(row.id)">
                                        <i class="ace-icon fa fa-trash bigger-130"></i>
                                    </a>
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
export default {
    data () {
        return {
            duration: {
                id      : '',
                duration: ''
            },
            durations: [],

            columns: [
                { label: 'SL NO', field: 'sl', align: 'center'},
                { label: 'Duration', field: 'duration', align: 'center'},
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getDurations();
    },
    methods: {
        clearForm(){
            this.duration = {
                id   : '',
                duration: ''
            }
        },
        getDurations(){
            axios.get('/get_durations').then(res=>{
                this.durations = res.data;
            })
        },
        save(){

            let url = '/store-duration';
            if(this.duration.id != ''){
                url = '/update-duration';
            }

            axios.post(url, this.duration).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getDurations();
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
        editDuration(row){
            this.duration = {
                id      : row.id,
                duration: row.duration
            }
        },
        deleteDuration(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-duration', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getDurations();
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
                }
            })
        }
    }
}
</script>