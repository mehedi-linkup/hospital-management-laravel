<template>
    <div>
        <form @submit.prevent="saveAgent">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">ID:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="agent.agent_code" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Name:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="agent.name" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Mobile:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="agent.mobile" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Address:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="agent.address">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Commission (%):</label>
                        <div class="col-md-7">
                            <input type="number" step="0.01" class="form-control" v-model="agent.commission_percent" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Remark:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="agent.remark">
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="agents" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row }">
                            <tr>
                                <td>{{ row.agent_code }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.mobile }}</td>
                                <td>{{ row.address }}</td>
                                <td>{{ row.commission_percent }} %</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editAgent(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteAgent(row.id)">
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
            agent: {
                id                : '',
                agent_code        : '',
                name              : '',
                mobile            : '',
                address           : '',
                commission_percent: '',
                remark            : '',
            },
            agents: [],

            columns: [
                { label: 'ID', field: 'agent_code', align: 'center'},
                { label: 'Name', field: 'name', align: 'center'},
                { label: 'Mobile', field: 'mobile', align: 'center' },
                { label: 'Address', field: 'address', align: 'center' },
                { label: 'Commission', field: 'commission_percent', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getAgents();
        this.getAgentCode();
    },
    methods: {
        clearForm(){
            this.agent = {
                id                : '',
                agent_code        : this.getAgentCode(),
                name              : '',
                mobile            : '',
                address           : '',
                commission_percent: '',
                remark            : '',
            }
        },
        getAgentCode(){
            axios.get('/get_agent_code').then(res=>{
                this.agent.agent_code = res.data;
            })
        },
        getAgents(){
            axios.get('/get_agents').then(res=>{
                this.agents = res.data;
            })
        },
        saveAgent(){

            let url = '/store-agent';
            if(this.agent.id != ''){
                url = '/update-agent';
            }

            axios.post(url, this.agent).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getAgents();
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
        editAgent(row){
            this.agent = {
                id                : row.id,
                agent_code        : row.agent_code,
                name              : row.name,
                mobile            : row.mobile,
                address           : row.address,
                commission_percent: row.commission_percent,
                remark            : row.remark,
            }
        },
        deleteAgent(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-agent', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getAgents();
                        
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