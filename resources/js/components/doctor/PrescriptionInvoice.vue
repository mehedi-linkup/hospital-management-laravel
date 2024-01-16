
<style>
    .cc_div {
        height: 100px;
    }
    
    .advice_div {
        height: 250px;
    }

    .test_div {
        height: 300px;
    }
</style>
<template>
    <div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="row">
                <div class="col-xs-12">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-xs-6">
                        <img :src="branch.logo" alt="Logo" style="height:80px;margin:0px;" /><br>
                        <strong style="font-size:15px;">{{branch.name}}</strong>
                    </div>
                    <div class="col-xs-1"></div>
                    <div class="col-xs-5" style="text-align: left;white-space:pre-line">
                        <strong style="font-size:18px;padding-bottom:10px">{{pres.doctor_name}}</strong><br>
                        {{ pres.doctor_education_level }}<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div style="border-bottom: 2px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <strong>Name:</strong> {{pres.patient_name}}
                    </div>
                
                    <div class="col-xs-3">
                        <strong>Age:</strong> {{pres.patient_age}}
                    </div>
                    <div class="col-xs-2">
                        <strong>Sex:</strong> {{pres.patient_gender}}
                    </div>
                    
                    <div class="col-xs-2">
                        <strong>Date:</strong> {{pres.prescription_date | dateFormat('DD-MM-YYYY')}}
                    </div>
                    <div class="col-xs-2">
                        <strong>ID:</strong> {{pres.patient_code}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div style="border-bottom: 2px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3" style="border-right: 1px solid #000">
                        <div class="cc_div">
                            <h5 style="border-bottom: 1px solid #000;font-weight: bold;">CC:-</h5>
                            <div>
                                <span v-for="(item, sl) in cart_complains" :key="sl">{{item}}, </span>
                            </div>
                        </div>

                        <div class="advice_div">
                            <h5 style="border-bottom: 1px solid #000;font-weight: bold;">Adv:-</h5>
                            <p v-for="(item, sl) in cart_advices" :key="sl">{{sl+1}}. {{item}}</p>
                        </div>
                        
                        <div class="test_div">
                            <h5 style="border-bottom: 1px solid #000;font-weight: bold;">Investigation:-</h5>
                            <p v-for="(item, sl) in cart_tests" :key="sl">{{sl+1}}. {{item.name}}</p>
                        </div>
                    </div>
                    <div class="col-xs-9">
                        <h5 style="font-weight: bold;font-family: 'FontAwesome';">Rx:-</h5>
                        <div v-for="(item, sl) in cart_medicines" style="margin-left: 30px;" :key="sl">
                            <p style="margin-bottom: 0;">{{sl+1}}. {{item.name}} </p>
                            <p style="margin-left: 30px;">{{item.doses}} &nbsp; &nbsp; <span style="font-weight: bold;">{{item.advice}} &nbsp; &nbsp; <span v-if="item.duration">({{item.duration}})</span></span></p>
                        </div>
                    </div>
                    
                </div>
                <div class="container" style="position:fixed;bottom:50px;width:100%;">
                    <div class="row">
                        <div class="col-xs-6">

                        </div>
                        <div class="col-xs-6 text-right" style="margin-top:20px">
                            <span style="text-decoration:overline;">Signature</span>
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
    props: ['id'],
    data () {
        return {
            pres          : {},
            cart_complains: [],
            cart_advices  : [],
            cart_tests    : [],
            cart_medicines: [],
            style         : null,
            branch        : {},
        }
    },
    created(){
        this.setStyle();
        this.getBranchInfo();
        this.getPrescription();
    },
    filters: {
        dateFormat(datetime, format){
            return moment(datetime).format(format);
        }
    },
    methods: {
        getBranchInfo(){
            axios.get('/get_branch_info').then(res=>{
                this.branch = res.data;
            })
        },
        getPrescription(){
            axios.post('/get_prescriptions', {id: this.id, with_details: true}).then(res=>{
                let prescription = res.data[0];

                this.pres.prescription_date      = prescription.prescription_date;
                this.pres.remark                 = prescription.remark;
                this.pres.blood_pressure         = prescription.blood_pressure;
                this.pres.body_weight            = prescription.body_weight;
                this.pres.body_height            = prescription.body_height;
                this.pres.patient_id             = prescription.patient_id;
                this.pres.patient_code           = prescription.patient_code;
                this.pres.patient_name           = prescription.patient_name;
                this.pres.patient_age            = prescription.patient_age;
                this.pres.patient_gender         = prescription.patient_gender;
                this.pres.doctor_name            = prescription.doctor_name;
                this.pres.doctor_education_level = prescription.doctor_education_level;

                prescription.chief_complains.forEach(item => {
                    this.cart_complains.push(item.chief_complain);
                })

                prescription.advices.forEach(item => {
                    this.cart_advices.push(item.advice);
                })

                prescription.tests.forEach(item => {
                    let cart = {
                        id: item.test_id,
                        name: item.test_name
                    }
                    this.cart_tests.push(cart);
                })

                prescription.medicines.forEach(item => {
                    let cart = {
                        id      : item.medicine_id,
                        name    : item.medicine_name,
                        doses   : item.doses,
                        duration: item.duration,
                        advice  : item.advice,
                    }
                    this.cart_medicines.push(cart);
                })
            })
        },
        setStyle() {
            this.style = document.createElement('style');
            this.style.innerHTML = `
                .cc_div {
                    height: 100px;
                }
                
                .advice_div {
                    height: 250px;
                }
            
                .test_div {
                    height: 300px;
                }

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
                    padding-bottom:25px;
                    border-bottom: 1px solid #ccc;
                    margin-bottom: 15px;
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
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }
            `;
            document.head.appendChild(this.style);
        },
        async print() {
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);

            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Presription</title>
                    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                    <style>
                        body, table{
                            font-size: 11px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <table style="width:100%;">
                            
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                ${invoiceContent}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                        <div style="width:100%;height:50px;">&nbsp;</div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                </body>
                </html>
            `);
            let invoiceStyle = printWindow.document.createElement('style');
            invoiceStyle.innerHTML = this.style.innerHTML;
            printWindow.document.head.appendChild(invoiceStyle);
            printWindow.moveTo(0, 0);

            printWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            printWindow.print();
            printWindow.close();
        }
    }
}
</script>