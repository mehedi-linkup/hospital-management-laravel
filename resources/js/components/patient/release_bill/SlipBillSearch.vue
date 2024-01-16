
<template>
    <div id="purchaseInvoiceReport" class="row">
      <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="form-group" style="margin-top:10px;">
          <label class="col-sm-2 control-label no-padding-right" style="font-size:13px;width: 120px;"> Admission No : </label>
          <div class="col-sm-3">
            <v-select v-bind:options="admissions" label="admission_name" v-model="selectedAdmission"  placeholder="Select Admission"></v-select>
          </div>
        </div>
        <div class="form-group" style="margin-top:10px;">
          <label class="col-sm-1 control-label no-padding-right" style="font-size:13px;"> Release Date: </label>
          <div class="col-sm-2">
            <input type="date" v-model="date" class="form-control"></div>
        </div>
        <div class="form-group">
          <div class="col-sm-2">
            <input type="button" class="btn btn-primary" value="Show Report" v-on:click="viewSlipBill" style="margin-top:0px;width:120px;padding:0px 6px; margin-bottom: 5px;">
          </div>
        </div>
      </div>
  
    <SlipBill  v-bind:id="selectedAdmission.id !=null ?selectedAdmission.id : null" v-bind:date="date"  v-if="showSlipBill" />
  
</div>
</template>

<script>
import moment from 'moment';
import SlipBill from "../release_bill/SlipBill.vue";
export default {
    components: {
      SlipBill
    },
    data() {
      return {
        admissions: [],
        selectedAdmission: null,
        date: moment().format('YYYY-MM-DD'),
        showSlipBill: false
      }
    },
    created() {
      this.getAdmissions();
    },
    methods: {
      getAdmissions() {
        axios.post("/get_admissions",{status:'Admited'}).then(res => {
          this.admissions = res.data;
        })
      },
      async viewSlipBill(){

        this.showSlipBill = false;
        await new Promise(r => setTimeout(r, 500));
        this.showSlipBill = true;
      }
    }
    
}
</script>