<style scoped>
    .balance-section{
        width: 100%;
        min-height: 150px;
        background-color: #f0f1d3;
        border: 1px solid #cfcfcf;
        text-align: center;
        padding: 25px 10px;
        border-radius: 5px;
    }

    .balance-section h3{
        margin: 0;
        padding: 0;
    }

    .account-section{
        display: flex;
        border: 1px solid #cfcfcf;
        border-radius: 5px;
        overflow:hidden;
        margin-bottom: 20px;
    }

    .account-section h3{
        margin: 10px 0;
        padding: 0;
    }

    .account-section .col1{
        background-color: #247195;
        color: white;
        flex: 1;
        padding-left: 25px;
        display: flex;
        align-items: center; 
    }
    .account-section .col2{
        background-color: #def1f8;
        flex: 2;
        padding: 10px;
        align-items: center; 
        text-align:center;
    }

    
</style>
<template>
    <div id="cashView">
    <div class="row">
        <div class="col-md-4">
            <div class="balance-section">
                <i class="fa fa-money fa-3x"></i>
                <h3>Cash Balance</h3>
                <h1>BDT {{ cashBalance | decimal }}</h1>
            </div>
        </div>

        <div class="col-md-4">
            <div class="balance-section">
                <i class="fa fa-bank fa-3x"></i>
                <h3>Bank Balance</h3>
                
                <h1>BDT {{ totalbankBalance | decimal }}</h1>
            </div>
        </div>

        <div  class="col-md-4">
            <div class="balance-section">
                <i class="fa fa-dollar fa-3x"></i>
                <h3>Total Balance</h3>
                <h1>BDT {{ (cashBalance + totalbankBalance) | decimal }}</h1>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 25px;">
       
        <div v-for="(balance,sl) in bankBalance" :key="sl" class="col-md-3 col-xs-6">
            <div class="account-section">
                <div class="col1">
                    <i class="fa fa-dollar fa-4x"></i>
                </div>
                <div class="col2">
                    {{ balance.account_name }}<br>
                    {{ balance.account_number }}<br>
                    {{ balance.bank_name }}<br>
                    <h3>BDT {{ balance.bank_balance | decimal }}</h3>
                </div>
            </div>
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
                    cashBalance: 0.00,
                    bankBalance: 0.00,
                    totalbankBalance: 0.00,
                    showTable: false
                
            }
        },
        filters: {
       
        decimal(value) {
				return value == null ? '0.00' : parseFloat(value).toFixed(2);
			}
        },
        created() {
            this.getReport();
        },
        methods: {
            getReport(){
				axios.get('/get_cash_view').then(res => {
					this.cashBalance = res.data.cashBalance;
					this.bankBalance = res.data.bankBalance;
					this.totalbankBalance = this.bankBalance.reduce((prev, curr) => { return prev + parseFloat(curr.bank_balance)}, 0);
				})
			}
        
        }
}
</script>