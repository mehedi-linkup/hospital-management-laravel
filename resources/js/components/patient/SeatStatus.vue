

<style scoped>
.row-head{
        
        margin-top: 10px;
        margin-bottom:15px;
        border-bottom: 1px solid #b16767;
        padding-bottom: 15px;
}
.row-header{
    width: 85% !important;
    margin: 0px auto;
}
.label-check{
    font-size:15px;
    font-weight: 500;
    padding:5px;
}
.label-check-type{
    width: 75px; 
    height: 35px;
    border-radius: 5px;
}
.label-check-floor{
    background-color: #3C486B;
}
.label-check-room{
    background-color: #FFD3B0;
}
.label-check-available{
    background-color: #1F8A70;
}
.label-check-booked{
    background-color: #DF2E38
}
.label-check-oparation{
    background-color: #F79327;
}

.label-floor{
            width: 100%;
            background-color: #3C486B;
            color: white;
            border-radius: 5px;
            font-size:25px;
            padding:5px;
}
.label-room{
        margin-bottom: 5px; 
        margin-top: 10px;
        padding:5px;
        background-color: #FFD3B0;
        color:#000;
        font-size:18px;
        font-weight: 600;
        border-radius: 5px;
}
.label-room-ot{
        margin-bottom: 5px; 
        margin-top: 20px;
        padding:5px;
        background-color: #F79327;
        color:#000;
        font-size:18px;
        font-weight: 600;
        border-radius: 5px;
}

.label-floor-icon{
    font-size:25px;color:#fff;
}
.label-room-icon{
    font-size:25px;color:#B799FF;
}
.label-ot-icon{
    font-size:25px;color:#B70404;
}
.label-bed-icon-empty{
    font-size:25px;color:#ffffff
}
.label-bed-icon-fill{
    font-size:25px;color:#F9D949;
}

.bed-col-empty{
    padding:3px;
    border:2px solid #fff; 
    background-color: #1F8A70;
    text-align:center;
    border-radius: 0px 10px 0px 10px;
    transition: 0.03s;
    cursor: pointer;
}
.bed-col-empty:hover{
    background-color: #3c6b5f;
    box-shadow: -3px -3px 18px -7px #a7f0dd;
    -webkit-box-shadow: -3px -3px 18px -7px #a7f0dd;
    -moz-box-shadow: -3px -3px 18px -7px #a7f0dd;
    transform: rotate(3deg);
    -webkit-transform: rotate(3deg);
    -moz-transform: rotate(3deg);
}

.bed-col-fill{
    padding:3px;
    border:2px solid #fff;
    background-color: #DF2E38;
    text-align:center;
    border-radius: 0px 10px 0px 10px;
    transition: 0.03s;
    cursor: pointer;
}
.bed-col-fill:hover{
    background-color: #9c0e15;
    box-shadow: -3px -3px 18px -7px #a7f0dd;
    -webkit-box-shadow: -3px -3px 18px -7px #a7f0dd;
    -moz-box-shadow: -3px -3px 18px -7px #a7f0dd;
    transform: rotate(3deg);
    -webkit-transform: rotate(3deg);
    -moz-transform: rotate(3deg);
}

.label-bed{
    font-size:14px;
    padding-top:5px;
    font-weight:500;
    color:#fff
}

</style>
<template>
    <div>
        <form>
            <div class="row row-head">
                <div class="row-header">
                    <div class="col-md-1">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <label class="control-label text-center label-check" style="">
                            <div class="label-check-type label-check-floor"></div>
                            Floor
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <label class="control-label text-center label-check">
                            <div class="label-check-type label-check-room"></div>
                            Room
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <label class="control-label text-center label-check">
                            <div class="label-check-type label-check-available"></div>
                            Available
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <label class="control-label text-center label-check">
                            <div class="label-check-type label-check-booked"></div>
                            Booked
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <label class="control-label text-center label-check">
                            <div class="label-check-type label-check-oparation"></div>
                            OT
                        </label>
                    </div>          
                </div>
            </div>

            <div class="row row-head" v-for="(floor,sl) in floors" :key="'F'+sl">
                <div class="col-md-12">
                    <label class="control-label col-md-12 label-floor">
                        <span>
                            <i class="fa fa-building-o label-floor-icon"></i>
                        </span>
                        {{ floor.floor_name }}
                    </label>
                    <div class="row" v-if="floor.rooms.length > 0">
                        <div class="col-xs-4 col-sm-4 col-md-3" v-for="(room,sl) in floor.rooms" :key="'R'+sl">
                            <label class="control-label col-md-12 label-room">
                                <span>
                                    <i class="fa fa-circle label-room-icon"></i>
                                </span>
                                {{ room.room_number }}
                            </label>
                            <div v-if="room.beds.length > 0">
                                <span v-for="(bed,sl) in room.beds" :key="'B'+sl">
                                    <div class="col-xs-4 col-sm-4 col-md-3 bed-col-empty" v-if="bed.is_book==0">
                                        <span>
                                            <i class="fa fa-bed label-bed-icon-empty"></i>
                                        </span>
                                        <div class="label-bed">
                                            {{ bed.bed_number }}
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-3 bed-col-fill" v-if="bed.is_book==1" style="">
                                        <span>
                                            <i class="fa fa-bed label-bed-icon-fill"></i>
                                        </span>
                                        <div class="label-bed">
                                            {{ bed.bed_number }}
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="floor.ots.length > 0">
                        <div class="col-xs-4 col-sm-4 col-md-3" v-for="(ot,sl) in floor.ots" :key="'OT'+sl">
                            <label class="control-label col-md-12 label-room-ot">
                                <span>
                                    <i class="fa fa-circle label-ot-icon"></i>
                                </span>
                                {{ ot.room_number }}
                            </label>

                            <span v-for="(bed,sl) in ot.beds" :key="'OTB'+sl">
                                <div class="col-xs-4 col-sm-4 col-md-3 bed-col-empty" v-if="bed.is_book==0">
                                    <span>
                                        <i class="fa fa-bed label-bed-icon-empty"></i>
                                    </span>
                                    <div class="label-bed">
                                        {{ bed.bed_number }}
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-3 bed-col-fill" v-if="bed.is_book==1">
                                    <span>
                                        <i class="fa fa-bed label-bed-icon-fill"></i>
                                    </span>
                                    <div class="label-bed">
                                        {{ bed.bed_number }}
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import moment from 'moment';
export default {
    data() {
        return {
            floors: [],
        }
    },
    created() {
        this.getSeat();
    },
    methods: {
 
        getSeat() {
            axios.post('/get_seat_status',{with_room: true,with_bed: true,with_ot: true}).then(res => {
                this.floors = res.data;
            })
        }    
    }
}
</script>