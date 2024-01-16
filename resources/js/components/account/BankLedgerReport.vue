<style scoped>

    #searchForm select {
        padding: 0;
        border-radius: 4px;
    }

    #searchForm .form-group {
        margin-right: 5px;
    }

    #searchForm * {
        font-size: 13px;
    }
</style>
<template>
    <div>
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
        <div class="col-md-12">
            <form class="form-inline" id="searchForm" @submit.prevent="getReport">
                <div class="form-group row">
					<label class="col-md-4" style="margin-top:2px;">Account</label>
                    <v-select v-bind:options="bankaccounts" v-model="selectedBankAccount" label="display_name"></v-select>
				</div>
                <div class="form-group">
                    <input type="date" class="form-control" v-model="dateFrom">
                </div>

                <div class="form-group">
                    <input type="date" class="form-control" v-model="dateTo">
                </div>

                <div class="form-group" style="margin-top: -5px;">
                    <input type="submit" value="Search" style="background-color: #30A2FF;border: 1px solid #30A2FF;color:#fff">
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: showTable ? '' : 'none'}">
        <div class="col-md-12" style="margin-top:15px;margin-bottom:15px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="printContent">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align:center">Date</th>
                            <th style="text-align:center">Description</th>
                            <th style="text-align:center">Deposit</th>
                            <th style="text-align:center">withdraw</th>
                            <th style="text-align:center">Balance</th>
                        </tr>
				    </thead>
				<tbody>
					<tr>
						<td></td>
						<td style="text-align:left;">Previous Balance</td>
						<td colspan="2"></td>
						<td style="text-align:right;">{{ previousBalance }}</td>
					</tr>
					<tr v-for="(row,sl) in ledger" :key="sl">
						<td>{{ row.date }}</td>
						<td style="text-align:left;">{{ row.description }}</td>
						<td style="text-align:right;">{{ row.in_amount }}</td>
						<td style="text-align:right;">{{ row.out_amount }}</td>
						<td style="text-align:right;">{{ row.balance }}</td>
					</tr>
				</tbody>
				<tbody v-if="ledger.length == 0">
					<tr>
						<td colspan="5">No records found</td>
					</tr>
				</tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row" style="display:none;padding-top: 15px;" v-bind:style="{display: ledger.length > 0 ? 'none' : ''}">
        <div class="col-md-12 text-center">
            No records found
        </div>
    </div>
</div>
</template>
<script>
import moment from 'moment';
export default {
    props: ['role'],
    data() {
            return {
                dateFrom           : moment().format('YYYY-MM-DD'),
                dateTo             : moment().format('YYYY-MM-DD'),
                transactionType    : '',
                accountId          : '',
                ledger             : [],
                previousBalance    : 0.00,
                showTable          : false,
                bankaccounts       : [],
                selectedBankAccount: null,
                
            }
        },
        created() {
            this.getBankAccount();
            this.getBranchInfo();
        },
        methods: {

            getBankAccount(){
                axios.get('/get_bankaccounts').then(res=>{
                    this.bankaccounts = res.data;
                })
            },
            getReport(){

                if(this.selectedBankAccount==null){
                    alert('Select Bank');

                }

				let data = {
					fromDate: this.dateFrom,
					toDate: this.dateTo,
					accountId: this.selectedBankAccount.id,
				}

				axios.post('/get_bank_ledger', data).then(res => {
					this.ledger = res.data.ledger;
					this.previousBalance =  res.data.previousBalance;
                    console.log(res.data.previousBalance);
					this.showTable = true;
				})
			},
           
            getBranchInfo(){
            axios.get('/get_branch_info').then(res=>{
                this.branch = res.data;
            })
            },
            
            async print(){
                let dateText = '';
				if(this.dateFrom != '' && this.dateTo != ''){
					dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
				}
            

           let reportContent = `
               <div class="container">
                <div class="row">
							<div class="col-xs-12 text-center">
								<h3>Cash Legder Report</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 text-right">
								${dateText}
							</div>
						</div>
                   <div class="row">
                       <div class="col-xs-12">
                           ${document.querySelector('#printContent').innerHTML}
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