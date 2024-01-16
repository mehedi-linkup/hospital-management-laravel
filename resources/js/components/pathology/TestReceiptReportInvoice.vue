
<template>
    <div class="col-md-8 col-md-offset-2">
        <div class="row" style="margin-top:15px;">
            <div class="col-md-12">
                <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
            </div>
                <div  id="reportContent">
            <div class="col-md-12">
                <div class="row" style="display:none">
                    <div class="col-xs-12 text-center">
                        <div _h098asdh>
                            Test Reciept Report
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        <strong>Patient Name:</strong> {{ testreceiptreport.display_text }}<br>
                        <strong>Test Reciept by:</strong> {{ testreceiptreport.user_name }}<br>
                        <strong>Reference by:</strong> {{ testreceiptreport.reference_id !=null ?  testreceiptreport.reference_text : "N/A"  }} <br>
                        
                    </div>
                    <div class="col-xs-5 text-right">
                        <strong>Age:</strong> {{ testreceiptreport.age }}<br>
                        <strong>Date:</strong>  {{ testreceiptreport.bill_date}}
                    </div>
                </div>
                 
                 <div class="row" style="margin-top: 25px;">
                    <div class="col-xs-12 text-center">
                        <div _h09r8arr>
                            Report of {{ testreceiptreport.test_name }}
                        </div> 
                    </div>
                </div>
                <div class="row">
                   <div class="col-xs-12">
                       <div style="font-size: 15px;" v-html="testreceiptreport.report"></div>
                   </div>
               </div>
               <div class="row" style="margin-bottom:5px;padding-bottom:6px; margin-top: 100px;">
                                <div class="col-xs-6">
                                    <span style="text-decoration:overline;">Received by</span>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span style="text-decoration:overline;">Authorized by</span>
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
    data(){
        return {
            branch: {},
            testreceiptreport: [],
        }
    },
    filters: {
        formatDateTime(dt) {
            return moment(dt).format('DD-MM-YYYY h:mm:ss a');
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
            axios.post('/get_test_receipt_details', {testreceiptsReportId:this.id,statusType:'Complete'}).then( res => {
                this.testreceiptreport  = res.data[0];
                console.log(res.data);
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
                div[_h09r8arr]{
                    /*background-color:#e0e0e0;*/
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                    border-top: 1px solid #454545;
                    border-bottom: 1px solid #454545;
                }
                div[_d9283dsc]{
                    padding-bottom:0px;
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
        async print(){
           

            let reportContent = `
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            ${document.querySelector('#reportContent').innerHTML}
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
                div[_h09r8arr]{
                    /*background-color:#e0e0e0;*/
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                    border-top: 1px solid #454545;
                    border-bottom: 1px solid #454545;
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