<template>
    <div>
        <form @submit.prevent="saveRoom">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Floor Number:</label>
                        <div class="col-xs-7 col-sm-7 col-md-7">
							<v-select v-bind:options="floors" label="floor" class="select" v-model="selectedFloor"></v-select>
						</div>
                        <div class="col-xs-1 col-sm-1 col-md-1" style="padding: 0;">
                            <a href="/floor_entry" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Floor">
                                <i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Room Number:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" placeholder="Room Number" v-model="room.room_number" required>
                        </div>
                    </div>
                  
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Remarks:</label>
                        <div class="col-md-7">
                            <textarea class="form-control" rows="2" placeholder="Remarks"  v-model="room.remark"></textarea>
                           
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Is OT:</label>
                        <div class="col-md-7">
                            <input type="checkbox" v-model="room.is_operation">
                        
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="rooms" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.room_name }}</td>
                                <td>{{ row.is_operation == true ? "Yes" : "No" }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editRoom(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteRoom(row.id)">
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
            room: {
                id          : '',
                room_number : '',
                floor_number: '',
                is_operation: 0,
                remark      : '',
            },
            rooms: [],
            floors: [],
            selectedFloor: [],

            columns: [
                { label: 'S/L', field: 'sl_no', align: 'center'},
                { label: 'Room Number', field: 'room_name', align: 'center'},
                { label: 'Is_OT', field: 'is_operation', align: 'center' },
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created(){
        this.getFloors();
        this.getRooms();
    },
    methods: {
        clearForm(){
            this.room = {
                 id          : '',
                room_number : '',
                floor_number: '',
                is_operation: 0,
                remark      : '',
            }
        },

         
        getFloors(){
            axios.get('/get_floors').then(res=>{
                this.floors = res.data;
            })
        },
        
        getRooms(){
            axios.get('/get_rooms').then(res=>{
                this.rooms = res.data;
            })
        },
        saveRoom(){

            if(this.selectedFloor ==null){
                alert('Select Floor');
            }
            this.room.floor_number=this.selectedFloor.id;
            
            let url = '/store-room';
            if(this.room.id != ''){
                url = '/update-room';
            }

            axios.post(url, this.room).then(res=>{
                let r = res.data;
                this.$toaster.success(r.message);
                this.getRooms();
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
        editRoom(row){
            this.room = {
                id          : row.id,
                room_number : row.room_number,
                floor_number: row.floor_number,
                is_operation: row.is_operation,
                remark      : row.remark
            }
            this.selectedFloor = {
                id   : row.floor_number,
                floor: row.floor
            }

        },
        deleteRoom(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-room', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getRooms();
                        
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