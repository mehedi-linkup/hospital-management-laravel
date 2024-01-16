
<template>
    <div>
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
        <div class="col-md-12">
            <form class="form-inline" id="searchForm" @submit.prevent="getDues">
                <div class="form-group row">
                    <label class="col-md-4" style="margin-top:2px;"> Supplier </label>
                        <v-select :options="suppliers" v-model="selectedSupplier" label="display_name"></v-select>
                </div>
                <div class="form-group" style="margin-left: 20px; margin-top: -5px;">
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
                            <th>Supplier Id</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Owner Name</th>
                            <th>Due Amount</th>
                        </tr>
				    </thead>
                    <tbody>
                        <tr v-for="(data,sl) in dues" :key="sl">
                            <td>{{ data.supplier_code }}</td>
                            <td>{{ data.name }}</td>
                            <td>{{ data.address }}</td>
                            <td>{{ data.mobile }}</td>
                            <td>{{ data.owner_name }}</td>
                            <td style="text-align:right">{{ data.dueAmount | decimal }}</td>
                        </tr>
					<tr>
						<td colspan="5" style="text-align:right">Total: </td>
						<td style="text-align:right">{{ totalDue | decimal}}</td>
					</tr>
				</tbody>
				<tbody v-if="dues.length == 0">
					<tr>
						<td colspan="6">No records found</td>
					</tr>
				</tbody>
                </table>
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
                dues          : [],
                showTable       : false,
                suppliers       : [],
                selectedSupplier: null,
                totalDue: 0.00
                
            }
        },
        filters: {
       
       decimal(value) {
               return value == null ? '0.00' : parseFloat(value).toFixed(2);
           }
       },
        created() {
            this.getSuppliers();
            this.getBranchInfo();
        },
        methods: {
            getSuppliers(){
                axios.get('/get_supplierinventorys').then(res=>{
                    this.suppliers = res.data;
                })
            },
            getDues(){
				// if(this.selectedSupplier == null){
				// 	alert('Select Supplier');
				// 	// console.log(this.selectedSupplier);
				// 	return;
				// }

                let data = {
					usefor: "Instrument",
					supplierId: this.selectedSupplier == null ? null : this.selectedSupplier.id
				}

				axios.post('/get_supplier_due', data).then(res => {
					this.dues = res.data.getDues.filter(d => parseFloat(d.dueAmount) != 0);
					this.totalDue = this.dues.reduce((prev, cur) => { return prev + parseFloat(cur.dueAmount) }, 0);
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