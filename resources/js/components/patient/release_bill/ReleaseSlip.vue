
<template>
    <div class="col-md-8 col-md-offset-2">
        <div class="row" style="margin-top:15px;">
            <div class="col-md-12">
                <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
            </div>
                <div  id="reportContent">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div _h098asdh>
                            Release Slip Invoice
                        </div>
                    </div>
                </div>
                <div class="row head-1-border" style="border:1px solid grey; padding:3px;">
                    <div class="col-xs-7">
                        <strong>Patient Id:</strong> {{ slipbill.patient_code }}<br>
                        <strong>Patient Name:</strong> {{ slipbill.patient_text }}<br>
                        <strong>Address:</strong> {{ slipbill.patient_address }}<br>
                        <strong>Mobile:</strong> {{ slipbill.patient_mobile }}
                    </div>
                    <div class="col-xs-5 text-right">
                        <strong>Release Slip No:</strong> {{ getReleaseSlip.releaseslip_code}}<br>
                        <strong>Admission No:</strong> {{ slipbill.admission_code }}<br>
                        <strong>Date:</strong> {{ getReleaseSlip.slip_date }}<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div _d9283dsc></div>
                    </div>
                </div>
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
                <div class="row">
                    <div class="col-xs-12 text-center">
                            <h5 style="text-decoration: underline;"><strong>Payment Details</strong></h5>
                    </div>
                </div>

                <div class="row" style="margin-left:50px; margin-right:50px;">
                    <div  class="col-xs-12" style="border: 1px solid grey;">
                        <div class="col-xs-8">
                                <strong>Details </strong>
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>Amount(TK.)</strong><br>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-left:50px; margin-right:50px;border:1px solid grey">
                    
                    <div  class="col-xs-12">
                              <div class="col-xs-8">
                                 Admission Fees:
                              </div>
                              <div class="col-xs-4 text-right">
                                 <strong>{{ slipbill.admission_fees | decimal }}</strong><br>
                              </div>
                        </div>
                        <template>
                           <div v-for="(getOthersBills,index) in getBill" :key="'getOthersBills'+index"  class="col-xs-12">
                                 <div class="col-xs-6">
                                    {{ getOthersBills.name }}:
                                 </div>
                                 <div class="col-xs-4 text-right">
                                    {{ getOthersBills.bill_amount | decimal }}
                                 </div>
                                 <div class="col-xs-2">
                                 </div>
                           </div>
                        </template>
                        
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
                        <template>
                           <div v-for="(getOTBill,sl) in getOTBills" :key="'getOTBill'+sl"  class="col-xs-12">
                                 <div class="col-xs-8">
                                    OT Bill:
                                 </div>
                                 <div class="col-xs-4 text-right">
                                    <strong>{{ getOTBill.amount  | decimal}}</strong>
                                 </div>
                           </div>
                        </template>
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
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            <strong>(-) Discount:</strong>
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{(getReleaseSlip.discount?getReleaseSlip.discount:0.00) | decimal  }}</strong>
                        </div>
                    </div>
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            <strong>(-) Paid:</strong>
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{(getReleaseSlip.amount?getReleaseSlip.amount:0.00) | decimal  }}</strong>
                        </div>
                    </div>
                    <div class="col-xs-12">
                            <div _d9283dsc></div>
                    </div>
                    <div  class="col-xs-12">
                        <div class="col-xs-8">
                            <strong>Final Due:</strong>
                        </div>
                        <div class="col-xs-4 text-right">
                            <strong>{{((getReleaseSlip.due?getReleaseSlip.due:0.00) - (getReleaseSlip.amount?getReleaseSlip.amount:0.00)-(getReleaseSlip.discount?getReleaseSlip.discount:0.00)) | decimal  }}</strong>
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
    props: ['id','date'],
    data(){
        return {
            branch                 : {},
            slipbill               : [],
            getReleaseSlip         : [],
            roomSeat               : [],
            getBill                : [],
            getBillTotal           : 0,
            getOTBills             : [],
            getOTBillsTotal        : 0,
            getTestBills           : 0,
            getpharmacyBills       : 0,
            releasebillpayment       : 0,
            getSeatSheftBills      : 0,
            seatSheftLastBills     : 0,
            admissionSeatFirstBills: 0,
            getBillPaidTotal       : 0,
            getTestPaid            : 0,
            getPharmacyPaid        : 0,
            admission_days         : 0,
            shift_days             : 0,
            last_shift_days        : 0,
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
    },
    methods: {
        
        getBranchInfo(){
            axios.get('/get_branch_info').then(res=>{
                this.branch = res.data;
            })
        },
        

        getSearchResult(){
            axios.post('/get_slip_bill', {admissionId:this.id,date:this.date}).then( res => {
                this.slipbill  = res.data.admmission[0];
                //console.log(this.slipbill);
                this.roomSeat  = res.data.getRoom[0];
                this.getReleaseSlip  = res.data.getReleaseSlip[0];
                console.log(this.getReleaseSlip);
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
               
                
            });
            
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
        },
        convertNumberToWords(amountToWord) {
            var words = new Array();
            words[0] = '';
            words[1] = 'One';
            words[2] = 'Two';
            words[3] = 'Three';
            words[4] = 'Four';
            words[5] = 'Five';
            words[6] = 'Six';
            words[7] = 'Seven';
            words[8] = 'Eight';
            words[9] = 'Nine';
            words[10] = 'Ten';
            words[11] = 'Eleven';
            words[12] = 'Twelve';
            words[13] = 'Thirteen';
            words[14] = 'Fourteen';
            words[15] = 'Fifteen';
            words[16] = 'Sixteen';
            words[17] = 'Seventeen';
            words[18] = 'Eighteen';
            words[19] = 'Nineteen';
            words[20] = 'Twenty';
            words[30] = 'Thirty';
            words[40] = 'Forty';
            words[50] = 'Fifty';
            words[60] = 'Sixty';
            words[70] = 'Seventy';
            words[80] = 'Eighty';
            words[90] = 'Ninety';
            var amount = amountToWord == null ? '0.00' : amountToWord.toString();
            var atemp = amount.split(".");
            var number = atemp[0].split(",").join("");
            var n_length = number.length;
            var words_string = "";
            if (n_length <= 9) {
                var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                var received_n_array = new Array();
                for (var i = 0; i < n_length; i++) {
                    received_n_array[i] = number.substr(i, 1);
                }
                for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                    n_array[i] = received_n_array[j];
                }
                for (var i = 0, j = 1; i < 9; i++, j++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        if (n_array[i] == 1) {
                            n_array[j] = 10 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        }
                    }
                }
                var value = "";
                for (var i = 0; i < 9; i++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        value = n_array[i] * 10;
                    } else {
                        value = n_array[i];
                    }
                    if (value != 0) {
                        words_string += words[value] + " ";
                    }
                    if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Crores ";
                    }
                    if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Lakhs ";
                    }
                    if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Thousand ";
                    }
                    if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                        words_string += "Hundred and ";
                    } else if (i == 6 && value != 0) {
                        words_string += "Hundred ";
                    }
                }
                words_string = words_string.split("  ").join(" ");
            }
            return words_string + ' only';
        },
        async print(){
           

            let reportContent = `
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            ${document.querySelector('#reportContent').innerHTML}
                        </div>
                    </div>
                   
                </div>
                <div class="container" style="width:95%;margin-top:80px;">
                    <div class="row" style="margin-bottom:5px;padding-bottom:6px;">
                                <div class="col-xs-6">
                                    <span style="text-decoration:overline;">Received by</span><br><br>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span style="text-decoration:overline;">Authorized by</span>
                                </div>
                    </div>
                    <div style="position:fixed;left:0;bottom:15px;width:100%;">
                                <div class="row" style="font-size:12px;">
                                    <div class="col-xs-6">
                                        Print Date: ${moment().format('DD-MM-YYYY h:mm a')}, Printed by: ${this.slipbill.user_name}
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        Developed by: Link-Up Technologoy, Contact no: 01911978897
                                    </div>
                                </div>
                   </div>
                </div>
            `;

            var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
            reportWindow.document.write(`
                <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-2"><img src="${this.branch.logo}" alt="Logo" style="height:80px;" /></div>
                        <div class="col-xs-10" style="padding-top:20px;">
                            <strong style="font-size:18px;">${this.branch.name}</strong><br>
                            <p style="white-space: pre-line;">${this.branch.address}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                        </div>
                    </div>
                </div>
            `);

            reportWindow.document.head.innerHTML += `
                <style>
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
                </style>
            `;
            reportWindow.document.body.innerHTML += reportContent;

            reportWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.print();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.close();
        }
    }
}
</script>