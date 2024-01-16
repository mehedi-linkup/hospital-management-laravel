<template>
    <div>
        <form @submit.prevent="save">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Doses:</label>
                        <div class="col-md-7">
                            <input type="text" placeholder="1+1+1" name="chief_complain" class="form-control" v-model="dose.doses" required>
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="doses" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.doses }}</td>
                                <td>
                                    <a class="blue" href="javascript:" @click="editDose(row)">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <a class="red" href="javascript:" @click="deleteDose(row.id)">
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
            dose: {
                id   : '',
                doses: ''
            },
            doses: [],

            columns: [
                { label: 'SL NO', field: 'sl', align: 'center'},
                { label: 'Doses', field: 'doses', align: 'center'},
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getDoses();
    },
    methods: {
        clearForm(){
            this.dose = {
                id   : '',
                doses: ''
            }
        },
        getDoses(){
            axios.get('/get_doses').then(res=>{
                this.doses = res.data;
            })
        },
        save(){

            let url = '/store-dose';
            if(this.dose.id != ''){
                url = '/update-dose';
            }

            axios.post(url, this.dose).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getDoses();
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
        editDose(row){
            this.dose = {
                id   : row.id,
                doses: row.doses
            }
        },
        deleteDose(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-dose', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getDoses();
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