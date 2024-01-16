
<template>
    <div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="row">
                <div class="col-xs-12">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row" style="text-align: center;">
                    <div class="col-xs-12">
                        <strong>Doctor:</strong> {{ serial.doctor_name }}<br>
                        <strong>Date:</strong> {{ serial.appointment_date | dateFormat('DD-MM-YYYY') }}<br>
                        <strong>Time:</strong> {{ serial.appointment_time | timeFormat("hh:mm A") }}<br>
                        <strong>Tr. ID:</strong> {{ serial.token_number }}<br>
                    </div>

                    <div class="col-xs-12">
                        <h1>{{ serial.serial_number }}</h1>
                    </div>
                    <div class="col-xs-12">
                        <strong>Patient:</strong> {{ serial.patient_name }}<br>
                        <strong>Age:</strong> {{ serial.patient_age }}
                    </div>

                    <div class="col-xs-12">
                        <strong>Note: </strong>
                        <p style="white-space: pre-line">{{ serial.remark }}</p>
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
            serial: {},
            style: null,
            branch: {},
        }
    },
    created(){
        this.setStyle();
        this.getAppointment();
        this.getBranchInfo();
    },
    filters: {
        timeFormat(time, format){
            return moment(time, "HH:mm").format(format);
        },
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
        getAppointment() {
            axios.post('/get_appointments', { id: this.id }).then(res => {
                this.serial = res.data[0];
            })
        },
        setStyle() {
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
                <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                <div style="text-align:center;">
                    <img src="${this.branch.logo}" alt="Logo" style="height:80px;margin:0px;" /><br>
                    <strong style="font-size:15px;">${this.branch.name}</strong>
                </div>
                ${invoiceContent}
            `);

            let invoiceStyle = printWindow.document.createElement('style');
            invoiceStyle.innerHTML = this.style.innerHTML;
            printWindow.document.head.appendChild(invoiceStyle);
            printWindow.moveTo(0, 0);

            printWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            printWindow.print();
            await new Promise(resolve => setTimeout(resolve, 1000));
            printWindow.close();
        }
    }
}
</script>