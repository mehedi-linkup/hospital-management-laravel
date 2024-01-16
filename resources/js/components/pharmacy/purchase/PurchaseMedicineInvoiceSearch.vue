
<template>
    <div id="purchaseInvoiceReport" class="row">
  <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
    <div class="form-group" style="margin-top:10px;">
      <label class="col-sm-1 col-sm-offset-2 control-label no-padding-right"> Invoice no </label>
      <label class="col-sm-1 control-label no-padding-right"> : </label>
      <div class="col-sm-3">
        <v-select v-bind:options="invoices" label="invoice_text" v-model="selectedInvoice" v-on:input="viewInvoice" placeholder="Select Invoice"></v-select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-2">
        <input type="button" class="btn btn-primary" value="Show Report" v-on:click="viewInvoice" style="margin-top:0px;width:150px;display: none;">
      </div>
    </div>
  </div>
  
    <br>
    <Purchasemedicineinvoice  v-bind:id="selectedInvoice.id" v-if="showInvoice" />
  
</div>
</template>

<script>
import moment from 'moment';
import Purchasemedicineinvoice from "../purchase/PurchaseMedicineInvoice.vue";
export default {
    components: {
      Purchasemedicineinvoice
    },
    data() {
      return {
        invoices: [],
        selectedInvoice: null,
        showInvoice: false
      }
    },
    created() {
      this.getPurchases();
    },
    methods: {
      getPurchases() {
        axios.post("/get_purchase_medicine").then(res => {
          this.invoices = res.data;
        })
      },
      async viewInvoice(){

        this.showInvoice = false;
        await new Promise(r => setTimeout(r, 500));
        this.showInvoice = true;
      }
    }
    
}
</script>