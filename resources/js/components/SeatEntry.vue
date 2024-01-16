
<style scoped>

</style>
<template>
    <div>
        <form @submit.prevent="saveSeat">
            <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Room Number:</label>
                        <div class="col-xs-7">
                            <v-select :options="rooms" label="room_name" v-model="selectedRoom" class="select"></v-select>
                        </div>
                        <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                            <a href="/room_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Seat Number:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" placeholder="Floor Number" v-model="seat.bed_number" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Seat Rent</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" placeholder="Seat Rent" v-model="seat.amount" required>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Remarks:</label>
                        <div class="col-md-7">
                            <textarea class="form-control" rows="2" placeholder="Remarks"  v-model="seat.remark"></textarea>
                           
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-7 col-md-offset-4">
                            <input type="submit" class="btn btn-success btn-sm"  v-bind:disabled="progress ? true : false" value="Save">
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
                    <datatable class="table table-hover table-bordered" :columns="columns" :data="seats" :filter="filter" :per-page="per_page">
                        <template slot-scope="{ row,index }">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ row.room_name }}</td>
                                <td>{{ row.bed_number }}</td>
                                <td>{{ row.amount }}</td>
                                <td>{{ row.remark }}</td>
                                <td>
                                    <span v-if="role != 'User'">
                                        <a class="blue" href="javascript:" @click="editSeat(row)">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        <a class="red" href="javascript:" @click="deleteSeat(row.id)">
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
            seat: {
                id        : '',
                bed_number: '',
                room_id   : '',
                amount    : '',
                remark    : '',
            },
            seats: [],
            rooms: [],
            selectedRoom: null,
            columns: [
                { label: 'S/L', field: 'sl_no', align: 'center'},
                { label: 'Room Number', field: 'room_name', align: 'center' },
                { label: 'Seat Number', field: 'bed_number', align: 'center'},
                { label: 'Seat Rent', field: 'amount', align: 'center'},
                { label: 'Remark', field: 'remark', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            progress: false
        }
    },
    created(){
        this.getSeats();
        this.getRooms();
    },
    methods: {
        clearForm(){
            this.seat = {
                id        : '',
                bed_number: '',
                room_id   : '',
                amount    : '',
                remark    : '',
            }
            this.rooms =  [];
            this.selectedRoom =  null;

        },
        
        getRooms(){
            axios.post('/get_rooms',{is_operation:''}).then(res=>{
                this.rooms = res.data;
            })
        },
        getSeats(){
            axios.get('/get_seats').then(res=>{
                this.seats = res.data;
            })
        },
        saveSeat(){

            if(this.selectedRoom == null){
                alert('Select Room Number');
                return;
            }

            this.progress = true;

            this.seat.room_id = this.selectedRoom.id;
            
            let url = '/store-seat';
            if(this.seat.id != ''){
                url = '/update-seat';
            }

            axios.post(url, this.seat).then(res=>{
                let r = res.data;
                if(r.success == '0'){
                    this.progress = false;
                    this.$toaster.error(r.message);
                }else{
                    this.progress = false;
                    this.$toaster.success(r.message);
                    this.clearForm();
                    this.getSeats();
                    this.getRooms();
                }
            }).catch(error => {
                this.progress = false;
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
        editSeat(row){
            this.seat = {
                id        : row.id,
                bed_number: row.bed_number,
                amount    : row.amount,
                remark    : row.remark
            }
            this.selectedRoom = {
                id       : row.room_id,
                room_name: row.room_name
            }
            
        },
        deleteSeat(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-seat', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                         this.clearForm();
                         this.getSeats();
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