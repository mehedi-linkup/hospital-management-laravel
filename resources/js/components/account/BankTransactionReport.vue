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
            <form class="form-inline" id="searchForm" @submit.prevent="getTransactions">
                <div class="form-group row">
					<label class="col-md-4" style="margin-top:2px;">Account</label>
                    <v-select v-bind:options="bankaccounts" v-model="selectedBankAccount" label="display_name"></v-select>
				</div>            
                <div class="form-group">
                    <label>Transaction Type</label>
                    <select class="form-control" v-model="filter.transactionType">
                        <option value="">All</option>
                        <option value="Received">Received</option>
                        <option value="Payment">Payment</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="date" class="form-control" v-model="filter.dateFrom">
                </div>

                <div class="form-group">
                    <input type="date" class="form-control" v-model="filter.dateTo">
                </div>

                <div class="form-group" style="margin-top: -5px;">
                    <input type="submit" value="Search">
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: transactions.length > 0 ? '' : 'none'}">
        <div class="col-md-12" style="margin-top:15px;margin-bottom:15px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="printContent">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Description</th>
                            <th>Transaction Date</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Bank Name</th>
                            <th>Note</th>
                            <th>Deposit</th>
                            <th>Withdraw</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(transaction,sl) in transactions" :key='sl'>
                            <td style="text-align:right">{{ sl + 1}}</td>
                            <td style="text-align:left;">{{ transaction.description }}</td>
                            <td>{{ transaction.transaction_date }}</td>
                            <td>{{ transaction.account_name }}</td>
                            <td>{{ transaction.account_number }}</td>
                            <td>{{ transaction.bank_name }}</td>
                            <td>{{ transaction.note }}</td>
                            <td style="text-align:right">{{ transaction.deposit }}</td>
                            <td style="text-align:right">{{ transaction.withdraw }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="text-align:right;font-weight:bold;">Total</td>
                            <td style="text-align:right;">{{ totalDeposit = this.transactions.reduce((prev, curr) => { return prev + parseFloat(curr.deposit)}, 0) }}</td>
                            <td style="text-align:right;">{{ totalWithdraw = this.transactions.reduce((prev, curr) => { return prev + parseFloat(curr.withdraw)}, 0) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row" style="display:none;padding-top: 15px;" v-bind:style="{display: transactions.length > 0 ? 'none' : ''}">
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
                filter: {
                    transactionType: '',
                    accountId: null,
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                },
                bankaccounts: [],
                selectedBankAccount: null,
                transactions: []
            }
        },
        created() {
            this.getBankAccount();
            this.getTransactions();
            this.getBranchInfo();
        },
        methods: {
            getBankAccount(){
                axios.get('/get_bankaccounts').then(res=>{
                    this.bankaccounts = res.data;
                })
            },
           
            getBranchInfo(){
            axios.get('/get_branch_info').then(res=>{
                this.branch = res.data;
            })
            },
            getTransactions() {
                if(this.selectedBankAccount != null){
                    this.filter.accountId = this.selectedBankAccount.id;
                } else {
                    this.filter.accountId = null;
                }
                axios.post('/get_banktransactionreports', this.filter).then(res => {
                    this.transactions = res.data;
                })
            },
            async print(){
                let dateText = '';
				if(this.filter.dateFrom != '' && this.filter.dateTo != ''){
					dateText = `Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
				}
                let accountText = '';
				if(this.selectedAccount != null && this.selectedAccount.id != ''){
					accountText = `<strong>Account: </strong> ${this.selectedAccount.display_name}`;
				}else{
					accountText = `<strong>Account: </strong> All`;

                }

                let typeText = '';
				if(this.filter.transactionType != null && this.filter.transactionType != ''){
					typeText = `<strong>TR. Type: </strong> ${this.filter.transactionType}`;
				}else{
                    typeText = `<strong>TR. Type: </strong> All`;
                }

           let reportContent = `
               <div class="container">
                <div class="row">
							<div class="col-xs-12 text-center">
								<h3>Inventory Supplier Payment Transaction Report</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4">
								${accountText}
							</div>
							<div class="col-xs-3">
								${typeText}
							</div>
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