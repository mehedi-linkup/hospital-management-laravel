
<style scoped>
 
.no-padding-right{
	padding: 0px !important;
}
.widget-box{
	border: 0px solid #fff !important;
}
.widget-header{
	border: 1px solid #ccc !important; 
	min-height: 26px !important; 
	background: #146C94 !important; 
	color:aliceblue !important; 
	font-weight: bolder !important;
}
.widget-title{
	line-height: 25px !important;
}

</style>
<template>
    <div class="col-md-12">
   <div class="row" style="margin-top:15px;">
      <div class="col-md-6">
         <div class="col-xs-12 col-md-12 col-lg-12" style="padding:0px">
            <div class="widget-box">
               <div class="widget-header">
                  <h5 class="widget-title">Payment Details</h5>
               </div>
               <div class="widget-body">
                  <div class="widget-main" style="padding-top:0px;padding-bottom: 0px;">
                     <div class="row">
                        <div class="col-xs-12 col-md-12  col-lg-12" style="background-color: #DBDFEA;padding: 8px;margin-bottom: 5px;">

                                       <div class="form-group row">
                                          <label class="col-xs-3 col-md-3 col-lg-3 control-label"> Code </label>
                                          <div class="col-xs-9 col-md-9  col-lg-9">
                                             <input class="form-control" type="text" v-model="releasebillpayment.releaseslip_code" readonly/>
                                          </div>
                                       </div>
                                    
                                       <div class="form-group row">
                                          <label class="col-xs-3 col-md-3 col-lg-3 control-label"> Date </label>
                                          <div class="col-xs-4 col-md-4  col-lg-4">
                                              <input class="form-control" type="date" v-model="releasebillpayment.slip_date" v-bind:disabled="role == 'u' ? true : false"/>
                                            </div>
                                            <label class="col-xs-1 col-md-1 col-lg-1 control-label"> Time </label>
                                          <div class="col-xs-4 col-md-4  col-lg-4">
                                             <input class="form-control" type="time" required  v-model="releasebillpayment.slip_time" v-bind:disabled="role == 'u' ? true : false"/>
                                          </div>
                                       </div>
                                    
                                       <div class="form-group row">
                                          <label class="col-xs-3 col-md-3 col-lg-3 control-label">Due</label>
                                          <div class="col-xs-9 col-md-9  col-lg-9">
                                             <span><strong> Tk. {{releasebillpayment.due}}</strong></span>
                                          </div>
                                       </div>
                                    
                                       <div class="form-group row">
                                          <label class="col-xs-3 col-md-3 col-lg-3 control-label">Payment</label>
                                          <div class="col-xs-9 col-md-9  col-lg-9">
                                             <input type="text"  class="form-control" v-model="releasebillpayment.paid" readonly/>
                                          </div>
                                       </div>
                                    
                                       <div class="form-group row">
                                          <label class="col-xs-3 col-md-3 col-lg-3 control-label">Discount</label>
                                          <div class="col-xs-9 col-md-9  col-lg-9">
                                             <input type="text"  class="form-control" v-model="releasebillpayment.discount" />
                                          </div>
                                       </div>
                                    
                                       <div class="form-group row">
                                          <label class="col-xs-3 col-md-3 col-lg-3 control-label">Note</label>
                                          <div class="col-xs-9 col-md-9  col-lg-9">
                                             <input type="text"  class="form-control" v-model="releasebillpayment.remark"/>
                                          </div>
                                       </div>
                                    
                                        <div class="form-group row">
                                            <div class="col-xs-4 col-xs-offset-8">
                                                <input
                                                type="submit"
                                                v-on:click="save"
                                                class="btn btn-primary btn-sm"
                                                value="Save"
                                                v-bind:disabled="progress ? true : false"
                                                style="color: #fff !important; margin-top: 0px; width: 100%;font-weight: bold;"
                                                />
                                            </div>
                                        </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xs-12 col-md-12 col-lg-12" style="padding:0px">
            <div class="widget-box">
               <div class="widget-header">
                  <h5 class="widget-title">Admission Details</h5>
               </div>
                  <div class="widget-body">
                     <div class="widget-main" style="padding-top:0px;padding-bottom: 0px;">
                        <div class="row" style="border:1px solid grey">
                              <div class="col-md-12">
                                 <div class="row" style="border:1px solid grey; padding:3px; margin-bottom: 5px;">
                                    <div class="col-xs-5">
                                       <strong>Floor:</strong> {{ roomSeat.floor_name }}<br>
                                       <strong>Doctor:</strong> {{ slipbill.doctor_text }}<br>
                                    </div>
                                    <div class="col-xs-4">
                                       <strong>Room:</strong> {{ roomSeat.room_name }}<br>
                                       <strong>Note:</strong> {{ slipbill.remark }}<br>
                                    </div>
                                    <div class="col-xs-3 text-right">
                                       <strong>Seat No:</strong> {{ roomSeat.seat_name }}<br>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="row head-1-border" style="border:1px solid grey; padding:3px;">
                                    <div class="col-xs-7">
                                       <strong>Patient Id:</strong> {{ slipbill.patient_code }}<br>
                                       <strong>Patient Name:</strong> {{ slipbill.patient_text }}<br>
                                       <strong>Address:</strong> {{ slipbill.patient_address }}<br>
                                       <strong>Mobile:</strong> {{ slipbill.patient_mobile }}
                                    </div>
                                    <div class="col-xs-5 text-right">
                                       <strong>Admission No:</strong> {{ slipbill.admission_code }}<br>
                                       <strong>Date:</strong> {{ slipbill.admission_date }}<br>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="col-xs-12 col-md-12 col-lg-12" style="padding:0px">
            <div class="widget-box">
               <div class="widget-header">
                  <h5 class="widget-title">Bill Details</h5>
               </div>
               <div class="widget-body">
                  <div class="widget-main" style="padding-top:0px;padding-bottom: 0px;">
                     
                        <div class="row" style="border: 1px solid grey;">
                           <div  class="col-xs-12">
                              <div class="col-xs-8">
                                 <strong>Details </strong>
                              </div>
                              <div class="col-xs-4 text-right">
                                 <strong>Amount(TK.)</strong><br>
                              </div>
                           </div>
                        </div>
                     <div class="row" style="border:1px solid grey">
                        
                        <div  class="col-xs-12">
                        <div class="col-xs-8">
                            Admission Fees:
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{ slipbill.admission_fees | decimal }}</strong><br>
                        </div>
                    </div>
                    <div v-for="(getBills,sl) in getBill" :key="sl"  class="col-xs-12">
                              <div class="col-xs-6">
                                 {{ getBills.name }}:
                              </div>
                              <div class="col-xs-4 text-right">
                                 {{ getBills.bill_amount | decimal }}
                              </div>
                              <div class="col-xs-2">
                              </div>
                    </div>
                        <div class="col-xs-12">
                              <div class="col-xs-6">
                                
                              </div>
                              <div class="col-xs-2 text-right">
                                  
                              </div>
                              <div class="col-xs-2 text-right">
                                  <div _d9283dsc></div> 
                              </div>
                              <div class="col-xs-2 text-right">
                                 <strong>{{ (getBillTotal?getBillTotal:0.00) | decimal}}</strong>
                              </div>
                        </div>
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            Pathology Bill:
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{ getTestBills | decimal }}</strong>
                        </div>
                    </div>
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            Pharmacy Bill:
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{ getpharmacyBills | decimal }}</strong>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-8">
                            Hospital Bill(Seat Bill- {{ (admission_days?admission_days:0) + (shift_days?shift_days:0) + (last_shift_days?last_shift_days:0)}} Days):
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong> {{(admissionSeatFirstBills + getSeatSheftBills + seatSheftLastBills) | decimal}}</strong>
                        </div>
                    </div>
                    <div v-for="(getOTBill,sl) in getOTBills" :key="'getOTBill'+sl"  class="col-xs-12">
                        <div class="col-xs-8">
                            OT Bill:
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{ (getOTBill.amount?getOTBill.amount:0.00)  | decimal}}</strong>
                        </div>
                    </div>
                    <div class="col-xs-12">
                            <div _d9283dsc></div>
                    </div>
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            <strong>Total Bill:</strong>
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{ ((slipbill.admission_fees?slipbill.admission_fees:0.00) + (getOTBillsTotal ?getOTBillsTotal:0.00) + (getpharmacyBills  ?getpharmacyBills :0.00) + (getTestBills  ?getTestBills :0.00) + (getBillTotal?getBillTotal :0.00) + admissionSeatFirstBills + getSeatSheftBills + seatSheftLastBills) | decimal }}</strong>
                        </div>
                    </div>
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            <strong>Total Paid:</strong>
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{  (slipbill.received_amount + getBillPaidTotal + getTestPaid + getPharmacyPaid) | decimal  }}</strong>
                        </div>
                    </div>
                    <div class="col-xs-12">
                            <div _d9283dsc></div>
                    </div>
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            <strong>Due:</strong>
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{(((slipbill.admission_fees?slipbill.admission_fees:0.00) + (getOTBillsTotal ?getOTBillsTotal:0.00) + (getpharmacyBills  ?getpharmacyBills :0.00) + (getTestBills  ?getTestBills :0.00) + (getBillTotal?getBillTotal :0.00) + admissionSeatFirstBills + getSeatSheftBills + seatSheftLastBills) - (slipbill.received_amount + getBillPaidTotal + getTestPaid + getPharmacyPaid)) | decimal  }}</strong>
                        </div>
                    </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</template>

<script>
import moment from 'moment';
export default {
    props: ['id','date','role'],
    data(){
        return {
            releasebillpayment: {
                id              : "",
                releaseslip_code: '',
                slip_date       : this.date,
                slip_time       : '',
                due             : 0,
                paid            : 0,
                discount        : '',
                admission_id    : '',
                doctor_id       : '',
                patient_id      : '',
                room_id         : '',
                bed_id          : '',
                remark          : ''
            },
            branch           : {},
            slipbill               : [],
            roomSeat               : [],
            getBill                : [],
            getBillTotal           : 0,
            getOTBills             : [],
            getOTBillsTotal        : 0,
            getTestBills           : 0,
            getpharmacyBills       : 0,
            getSeatSheftBills      : 0,
            seatSheftLastBills     : 0,
            admissionSeatFirstBills: 0,
            getBillPaidTotal       : 0,
            getTestPaid            : 0,
            getPharmacyPaid        : 0,
            admission_days         : 0,
            shift_days             : 0,
            last_shift_days        : 0,
            progress: false
        }
    },
   
    filters: {
        formatDateTime(dt) {
            return moment(dt).format('DD-MM-YYYY h:mm:ss a');
        },
        decimal(value) {
				return value == null ? '0.00' : parseFloat(value).toFixed(2);
			}
    },
    created(){
        this.setStyle();
        this.getSearchResult();
        this.getBranchInfo();
        if(this.editId != 0){
            	this.getReleaseSlip();
        }
    },
    methods: {
        
        getReleaseSlipCode(){
            axios.get('/get_release_slip_code').then(res=>{
                this.releasebillpayment.releaseslip_code = res.data;
            })
        },
        getBranchInfo(){
            axios.get('/get_branch_info').then(res=>{
                this.branch = res.data;
            })
        },
        
        getSearchResult(){
            axios.post('/get_slip_bill', {admissionId:this.id,status: 'Admitted',date:this.date}).then( res => {
               this.slipbill  = res.data.admmission[0];
                console.log(this.slipbill);
                this.roomSeat  = res.data.getRoom[0];
                this.getBill  = res.data.getBills;
                this.getBillTotal  = res.data.getBills.reduce((prev, curr)=>{return prev + parseFloat(curr.bill_amount)}, 0)
                this.getOTBills  = res.data.getOTSBills;
                this.getOTBillsTotal  = res.data.getOTSBills.reduce((prev, curr)=>{return prev + parseFloat(curr.amount)}, 0);
                this.getTestBills  = res.data.getTestBills.reduce((prev, curr)=>{return prev + parseFloat(curr.test_amount)}, 0);
                this.getpharmacyBills  = res.data.getpharmacyBills.reduce((prev, curr)=>{return prev + parseFloat(curr.sale_amount)}, 0);
                this.getSeatSheftBills  =  res.data.getSeatSheftBills.reduce((prev, curr)=>{return prev + parseFloat(curr.bed_amount)}, 0);
                //// Paid
                this.getBillPaidTotal  = res.data.getTestBillPaid.reduce((prev, curr)=>{return prev + parseFloat(curr.paid_amount)}, 0)
                this.getPharmacyPaid  = res.data.getpharmacyBills.reduce((prev, curr)=>{return prev + parseFloat(curr.paid_amount)}, 0);
                this.getTestPaid  = res.data.getTestBills.reduce((prev, curr)=>{return prev + parseFloat(curr.paid_amount)}, 0);
                this.getSeatSheftBills  =  res.data.getSeatSheftBills.reduce((prev, curr)=>{return prev + parseFloat(curr.bed_amount)}, 0);
                this.admissionSeatFirstBills  =  res.data.admissionSeatFirstBills.reduce((prev, curr)=>{return prev + parseFloat(curr.bed_amount)}, 0);
                this.seatSheftLastBills  =  res.data.seatSheftLastBills.reduce((prev, curr)=>{return prev + parseFloat(curr.bed_amount)}, 0);
                
                this.shift_days  =  res.data.getSeatSheftBills.reduce((prev, curr)=>{return prev + parseFloat(curr.sheft_days)}, 0);
                this.admission_days  =  res.data.admissionSeatFirstBills.reduce((prev, curr)=>{return prev + parseFloat(curr.admission_days)}, 0);
                this.last_shift_days  =  res.data.seatSheftLastBills.reduce((prev, curr)=>{return prev + parseFloat(curr.last_shift_days)}, 0);

                this.releasebillpayment.paid  = (((this.slipbill.admission_fees?this.slipbill.admission_fees:0.00) + 
                (this.getOTBillsTotal ?this.getOTBillsTotal:0.00) 
                + (this.getpharmacyBills?this.getpharmacyBills :0.00) 
                + (this.getTestBills?this.getTestBills :0.00) 
                + (this.getBillTotal?this.getBillTotal :0.00) 
                + this.admissionSeatFirstBills + this.getSeatSheftBills 
                + this.seatSheftLastBills) - (this.slipbill.received_amount + this.getBillPaidTotal 
                + this.getTestPaid + this.getPharmacyPaid)).toFixed(2);
                this.releasebillpayment.due  = (((this.slipbill.admission_fees?this.slipbill.admission_fees:0.00) + 
                (this.getOTBillsTotal ?this.getOTBillsTotal:0.00) 
                + (this.getpharmacyBills?this.getpharmacyBills :0.00) 
                + (this.getTestBills?this.getTestBills :0.00) 
                + (this.getBillTotal?this.getBillTotal :0.00) 
                + this.admissionSeatFirstBills + this.getSeatSheftBills 
                + this.seatSheftLastBills) - (this.slipbill.received_amount + this.getBillPaidTotal 
                + this.getTestPaid + this.getPharmacyPaid)).toFixed(2);
                
            });
            this.getReleaseSlipCode();
        },

        save(){
            
            this.progress = true;

            //console.log(this.slipbill.patient_id);
            this.releasebillpayment.patient_id   = this.slipbill.patient_id;
            this.releasebillpayment.doctor_id    = this.slipbill.doctor_id;
            this.releasebillpayment.admission_id = this.slipbill.id;
            this.releasebillpayment.room_id      = this.slipbill.room_id;
            this.releasebillpayment.bed_id       = this.slipbill.bed_id;
            
            let url = '/store-release-slip';
            if(this.releasebillpayment.id != ''){
                url = '/update-release-slip';
            }

            let data = {
					releasebillpayment: this.releasebillpayment
				}

            axios.post(url, data).then(async res=>{
                let conf = confirm('Do you want to view invoice?');
					if(conf){
						window.open('/release_slip_print/'+res.data.id, '_blank');
						await new Promise(r => setTimeout(r, 1000));
					}

					window.location = '/slip_bill_payment_search';
               
            }).catch(error=>{
                this.progress = false;
                let e = error.response.data;
                if(e.hasOwnProperty('message')){
                    this.$toaster.error(e.message);
                }else{
                    Object.entries(e).forEach(([key, val])=>{
                        this.$toaster.error(val[0]);
                    })
                }
            })
        },

        async getReleaseSlip(){
				await axios.post('/get_release_slip', {releaseSlipId: this.id,with_details: true}).then(res=>{
					let sales = res.data[0];
					this.sales.salesDate = sales.order_date;
					this.sales.patientId = sales.patient_id;
					this.sales.subTotal = sales.subtotal;
					this.sales.discount = sales.discount_amount;
					this.discountPercent = sales.discount_percent;
					this.sales.vat = sales.vat_amount;
					this.vatPercent = sales.vat_percent;
					this.sales.transportCost = sales.transport_cost;
					this.sales.total = sales.total;
					this.sales.paid = sales.paid;
					this.sales.due = sales.due;
					this.sales.note = sales.remark;

					

				})
			},

        setStyle(){
            this.style = document.createElement('style');
            this.style.innerHTML = `
                div[_h098asdh]{
                    /*background-color:#e0e0e0;*/
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                    border-top: 1px dotted #454545;
                    border-bottom: 1px dotted #454545;
                }
                div[_d9283dsc]{
                    padding-bottom:5px;
                    border-bottom: 1px solid #ccc;
                    margin-bottom: 5px;
                }
                table[_a584de]{
                    width: 100%;
                    text-align:center;
                }
                table[_a584de] thead{
                    font-weight:bold;
                }
                table[_a584de] td{
                    padding: 3px;
                    border: 1px solid #ccc;
                }
                table[_a584de] th{
                    text-align:center;
                    padding: 3px;
                    border: 1px solid #ccc;
                }
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }
            `;
            document.head.appendChild(this.style);
        }
        
    }
}
</script>