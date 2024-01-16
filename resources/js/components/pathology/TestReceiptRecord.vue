<style scoped>
    .v-select{
		margin-top:-2.5px;
        float: right;
        min-width: 180px;
        margin-left: 5px;
	}
</style>
<template>
	<div>
		<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
			<div class="col-md-12">
				<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
					<div class="form-group">
						<label>Search Type</label>
						<select class="form-control" v-model="searchType" @change="onChangeSearchType">
							<option value="">All</option>
							<option value="patient">By Patient</option>
							<option value="reference">By Reference</option>
							<option value="test">By Test</option>
							<option value="user">By User</option>
						</select>
					</div>

					<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'patient' && patients.length > 0 ? '' : 'none'}">
						<label style="margin-top:5px;">Patient</label>
						<v-select v-bind:options="patients" v-model="selectedPatient" label="display_text"></v-select>
					</div>

					<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'test' && tests.length > 0 ? '' : 'none'}">
						<label style="margin-top:5px;">Test</label>
						<v-select v-bind:options="tests" v-model="selectedTest" label="display_name"></v-select>
					</div>
					<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'test' && tests.length > 0 ? '' : 'none'}">
						<label style="margin-top:5px;">Status</label>
						<select class="form-control" v-model="statusType">
							<option value="">All</option>
							<option value="Complete">Complete</option>
							<option value="Delivery">Delivery</option>
						</select>
					</div>

					<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'reference' && references.length > 0 ? '' : 'none'}">
						<label style="margin-top:5px;">Reference</label>
						<v-select v-bind:options="references" v-model="selectedReference" label="display_name"></v-select>
					</div>

					<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' && users.length > 0 ? '' : 'none'}">
						<label style="margin-top:5px;">User</label>
						<v-select v-bind:options="users" v-model="selectedUser" label="name"></v-select>
					</div>

					<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
						<label>Record Type</label>
						<select class="form-control" v-model="recordType" @change="testReceipts = []">
							<option value="without_details">Without Details</option>
							<option value="with_details">With Details</option>
						</select>
					</div>

					<div class="form-group">
						<input type="date" class="form-control" v-model="dateFrom">
					</div>

					<div class="form-group">
						<input type="date" class="form-control" v-model="dateTo">
					</div>

					<div class="form-group" style="margin-top: -5px;">
						<input type="submit" value="Search">
					</div>
				</form>
			</div>
		</div>

		<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: testReceipts.length > 0 ? '' : 'none'}">
			<div class="col-md-12" style="margin-bottom: 10px;">
				<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
			</div>
			<div class="col-md-12">
				<div class="table-responsive" id="reportContent">
					<table 
						class="record-table" 
						v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'with_details'" 
						style="display:none" 
						v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'with_details' ? '' : 'none'}"
						>
						<thead>
							<tr>
								<th>Invoice No.</th>
								<th>Bill Date</th>
								<th>Patient Name</th>
								<th>Ref. Name</th>
								<th>Delivery Date</th>
								<th>Delivery Time</th>
								<th>Test Name</th>
								<th>Total</th>
								<th>Is Complete</th>
								<th>Is Delivery</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody v-for="(testReceipt,sl) in testReceipts" :key='sl'>
								<tr>
									<td>{{ testReceipt.invoice_number }}</td>
									<td>{{ testReceipt.bill_date }}</td>
									<td>{{ testReceipt.display_text }}</td>
									<td>{{ testReceipt.reference_text }}</td>
									<td>{{ testReceipt.testreceiptDetails[0].delivery_date }}</td>
									<td>{{ testReceipt.testreceiptDetails[0].delivery_time }}</td>
									<td>{{ testReceipt.testreceiptDetails[0].display_name }}</td>
									<td style="text-align:right;">{{ testReceipt.testreceiptDetails[0].amount.toFixed(2) }}</td>
									<td style="text-align:center;">
										<a title="No" href="javascript:" style="color: orange;" @click="completeChange(testReceipt.testreceiptDetails[0].id, 1)" v-if="testReceipt.testreceiptDetails[0].is_completed == 0"><i class="fa fa-clock-o"></i></a>
										<a title="Yes" href="javascript:" style="color: green;" v-else @click="completeChange(testReceipt.testreceiptDetails[0].id, 0)"><i class="fa fa-check"></i></a>
									</td>
									<td style="text-align:center;">
										<a title="No" href="javascript:" style="color: orange;" @click="deliveryChange(testReceipt.testreceiptDetails[0].id, 1)" v-if="testReceipt.testreceiptDetails[0].is_delivered == 0"><i class="fa fa-clock-o"></i></a>
										<a title="Yes" href="javascript:" style="color: green;" v-else @click="deliveryChange(testReceipt.testreceiptDetails[0].id, 0)"><i class="fa fa-check"></i></a>
									</td>
									<td style="text-align:center;">
										<a v-if="testReceipt.testreceiptDetails[0].is_completed == 1 && testReceipt.testreceiptDetails[0].is_delivered == 0" title="Investigation" class="btn btn-success btn-xs" href="javascript:" @click="showModal(testReceipt.testreceiptDetails[0])">Investigation</a>
										<a v-if="testReceipt.testreceiptDetails[0].is_completed == 1 && testReceipt.testreceiptDetails[0].report" title="Report" class="btn btn-info btn-xs" v-bind:href="'/test_receipt_report_print/'+ testReceipt.testreceiptDetails[0].id" target="_blank">Report</a>
									</td>
								</tr>
								<tr v-for="(product, sl) in testReceipt.testreceiptDetails.slice(1)" :key='sl'>
									<td colspan="4" v-bind:rowspan="testReceipt.testreceiptDetails.length - 1" v-if="sl == 0"></td>
									<td>{{ product.delivery_date }}</td>
									<td>{{ product.delivery_time }}</td>
									<td>{{ product.display_name }}</td>
									<td style="text-align:right;">{{ product.amount.toFixed(2) }}</td>
									<td style="text-align:center;">
										<a title="No" href="javascript:" style="color: orange;" @click="completeChange(product.id, 1)" v-if="product.is_completed == 0"><i class="fa fa-clock-o"></i></a>
										<a title="Yes" href="javascript:" style="color: green;" v-else @click="completeChange(product.id, 0)"><i class="fa fa-check"></i></a>
									</td>
									<td style="text-align:center;">
										<a title="No" href="javascript:" style="color: orange;" @click="deliveryChange(product.id, 1)" v-if="product.is_delivered == 0"><i class="fa fa-clock-o"></i></a>
										<a title="Yes" href="javascript:" style="color: green;" v-else @click="deliveryChange(product.id, 0)"><i class="fa fa-check"></i></a>
									</td>
									<td style="text-align:center;">
										<a v-if="product.is_completed == 1 && product.is_delivered == 0" title="Investigation" class="btn btn-success btn-xs" href="javascript:" @click="showModal(product)">Investigation</a>
										<a v-if="product.is_completed == 1 && product.report" title="Report" class="btn btn-info btn-xs" v-bind:href="'/test_receipt_report_print/'+ product.id" target="_blank">Report</a>
									</td>
								</tr>
								<tr style="font-weight:bold;">
									<td colspan="7" style="font-weight:normal;"><strong>Note: </strong>{{ testReceipt.remark }}</td>
									
									<td style="text-align:right;">
										Total: {{ testReceipt.total }}<br>
										Paid: {{ testReceipt.paid }}<br>
										Due: {{ testReceipt.due }}
									</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
						</tbody>
					</table>

					<table 
						class="record-table" 
						v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'without_details'" 
						style="display:none" 
						v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}"
						>
						<thead>
							<tr>
								<th>Invoice No.</th>
								<th>Bill Date</th>
								<th>Patient Name</th>
								<th>Ref. Name</th>
								<th>Sub Total</th>
								<th>VAT</th>
								<th>Discount</th>
								<th>Other`s Cost</th>
								<th>Total</th>
								<th>Paid</th>
								<th>Due</th>
								<th>Admitted Staus</th>
								<th>Note</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(testReceipt,sl) in testReceipts" :key='sl'>
								<td>{{ testReceipt.invoice_number }}</td>
								<td>{{ testReceipt.bill_date }}</td>
								<td>{{ testReceipt.display_text }}</td>
								<td>{{ testReceipt.reference_text }}</td>
								<td style="text-align:right;">{{ testReceipt.subtotal }}</td>
								<td style="text-align:right;">{{ testReceipt.vat_amount }}</td>
								<td style="text-align:right;">{{ testReceipt.discount_amount }}</td>
								<td style="text-align:right;">{{ testReceipt.others }}</td>
								<td style="text-align:right;">{{ testReceipt.total }}</td>
								<td style="text-align:right;">{{ testReceipt.paid }}</td>
								<td style="text-align:right;">{{ testReceipt.due }}</td>
								<td style="text-align:right;">{{ testReceipt.admission_status  }}</td>
								<td style="text-align:left;">{{ testReceipt.remark }}</td>
								<td style="text-align:center;">
									<a title="Invoice" v-bind:href="'/test_receipt_invoice_print/'+ testReceipt.id" target="_blank"><i class="fa fa-file-text"></i></a>
									<span v-if="role != 'User'">
									<a :href="'/test_receipt/'+testReceipt.id" title="Edit"><i class="fa fa-edit"></i></a>
									<a href="javascript:" title="Delete" @click.prevent="deletePurchase(testReceipt.id)"><i class="fa fa-trash"></i></a>
									</span>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr style="font-weight:bold;">
								<td colspan="4" style="text-align:right;">Total</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr)=>{return prev + parseFloat(curr.subtotal)}, 0) }}</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr)=>{return prev + parseFloat(curr.vat_amount)}, 0) }}</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr)=>{return prev + parseFloat(curr.discount_amount)}, 0) }}</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr)=>{return prev + parseFloat(curr.others)}, 0) }}</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr)=>{return prev + parseFloat(curr.total)}, 0) }}</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr)=>{return prev + parseFloat(curr.paid)}, 0) }}</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr)=>{return prev + parseFloat(curr.due)}, 0) }}</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tfoot>
					</table>

					<table 
						class="record-table" 
						v-if="searchTypesForDetails.includes(searchType)"  
						style="display:none;" 
						v-bind:style="{display: searchTypesForDetails.includes(searchType) ? '' : 'none'}"
						>
						<thead>
							<tr>
								<th>Invoice No.</th>
								<th>Date</th>
								<th>Patient Name</th>
								<th>Delivery Date</th>
								<th>Delivery Time</th>
								<th>Test Name</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<tr  v-for="(testReceipt,sl) in testReceipts" :key='sl'>
								<td>{{ testReceipt.invoice_number }}</td>
								<td>{{ testReceipt.bill_date }}</td>
								<td>{{ testReceipt.display_text }}</td>
								<td>{{ testReceipt.delivery_date }}</td>
								<td>{{ testReceipt.delivery_time }}</td>
								<td>{{ testReceipt.display_name }}</td>
								<td style="text-align:right;">{{ testReceipt.amount }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr style="font-weight:bold;">
								<td colspan="6" style="text-align:right;">Total Amount</td>
								<td style="text-align:right;">{{ testReceipts.reduce((prev, curr) => { return prev + parseFloat(curr.amount)}, 0) }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>

		<div class="modal fade in" tabindex="-1" style="overflow: auto;" :style="{display: modal_show ? 'block' : 'none'}">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title text-center">{{test_name}}</h3>
					</div>
					<div class="modal-body">
						<Editor api-key="1m66cayxwezk4n2qxg1st7ybctw11sq6t6crzazkuunpk69f"
							:init="{
								plugins: 'lists link image table code help wordcount',
								height: 400,
							}"
							placeholder="Investigation"
							v-model="investigation"
						/>
					</div>
					<div class="modal-footer">
						<button type="button" @click="closeModal()" class="btn btn-secondary">Close</button>
						<button type="button" class="btn btn-primary" @click="investigationSave()">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment';
import Editor from '@tinymce/tinymce-vue'
export default {
    props: ['role'],
	components: {
        Editor
    },
    data(){
			return {
				searchType: '',
				statusType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				
				patients: [],
				selectedPatient: null,

				tests: [],
				selectedTest: null,

				users: [],
				selectedUser: null,

				references: [],
				selectedReference: null,

				testReceipts: [],

				searchTypesForRecord : ['', 'user', 'patient', 'reference'],
				searchTypesForDetails: ['test'],

				test_update_id: '',
				test_name    : '',
				investigation: '',
				modal_show   : false,
			}
		},
        created(){
            this.getBranchInfo();
        },
		methods: {
			showModal(data){
				this.test_update_id = data.id;
				this.test_name      = data.display_name;
				this.investigation  = data.investigation;
				this.modal_show     = true;
			},
			closeModal(){
				this.test_update_id = '';
				this.test_name      = '';
				this.investigation  = '';
				this.modal_show     = false;
			},
			investigationSave(){
				if(this.investigation == ''){
					alert('Investigation Required!');
					return;
				}
				axios.post('/test-investigation',{id: this.test_update_id, investigation: this.investigation}).then(res=>{
					let r = res.data;
					this.closeModal();
					this.getTestRecieptRecord();
					Swal.fire({
						icon: 'success',
						title: r.message,
						showConfirmButton: false,
						timer: 3000
					})
				}).catch(error => {
					let e = error.response.data;

					if(e.hasOwnProperty('message')){
						if(e.hasOwnProperty('errors')){
							Object.entries(e.errors).forEach(([key, val])=>{
								this.$toaster.error(val[0]);
							})
						}else{
							this.$toaster.error(e.message);
						}
					}else{
						this.$toaster.error(e);
					}
				})
			},
			onChangeSearchType(){
				this.testReceipts = [];
				if(this.searchType == 'test'){
					this.getTests();
				} 
				else if(this.searchType == 'user'){
					this.getUsers();
				}
				else if(this.searchType == 'reference'){
					this.getReferences();
				}
				else if(this.searchType == 'patient'){
					this.getPatients();
				}
			},
            getBranchInfo(){
                axios.get('/get_branch_info').then(res=>{
                    this.branch = res.data;
                })
            },
			getTests(){
                axios.get('/get_tests').then(res=>{
                    this.tests = res.data;         
                })
        	},

			getPatients(){
				axios.get('/get_patients').then(res=>{
				this.patients = res.data;
				})
        	},
			
			getUsers(){
				axios.get('/get_users').then(res => {
					this.users = res.data;
				})
			},
			getReferences(){
				axios.get('/get_agents').then(res=>{
					this.references = res.data;
				})
        	},

			getSearchResult(){
				if(this.searchType != 'user'){
					this.selectedUser = null;
				}

				if(this.searchType != 'test'){
					this.selectedTest = null;
				}

				if(this.searchType != 'reference'){
					this.selectedReference = null;
				}

				if(this.searchType != 'patient'){
					this.selectedPatient = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)) {
					this.getTestRecieptRecord();
				} else {
					this.getTestRecieptDetails();
				}
			},
			getTestRecieptRecord(){
				let filter = {
					userId: this.selectedUser == null ? '' : this.selectedUser.id,
					patient_id: this.selectedPatient == null ? '' : this.selectedPatient.id,
					reference_id: this.selectedReference == null ? '' : this.selectedReference.id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

                if(this.recordType == 'with_details'){
                    filter.with_details = true;
                }

				let url = '/get_test_receipt';
				

				axios.post(url, filter)
				.then(res => {
						this.testReceipts = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			getTestRecieptDetails(){
				let filter = {
					testreceiptsId: this.selectedTest == null ? '' : this.selectedTest.id,
					statusType: this.statusType == null || this.statusType == '' ? '' : this.statusType,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_test_receipt_details', filter)
				.then(res => {
					this.testReceipts = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},

			deleteTestReceipt(testReceiptId){
				Swal.fire({
					title: '<strong>Are you sure!</strong>',
					html: '<strong>Want to delete this?</strong>',
					showDenyButton: true,
					confirmButtonText: `Ok`,
					denyButtonText: `Cancel`,
				}).then((result) => {
					if (result.isConfirmed) {
						axios.post('/delete-test-receipt',{id: testReceiptId}).then(res=>{
							let r = res.data;
							Swal.fire({
								icon: 'success',
								title: r.message,
								showConfirmButton: false,
								timer: 3000
							})
							this.getTestRecieptRecord();
						}).catch(error => {
							let e = error.response.data;

							if(e.hasOwnProperty('message')){
								if(e.hasOwnProperty('errors')){
									Object.entries(e.errors).forEach(([key, val])=>{
										this.$toaster.error(val[0]);
									})
								}else{
									this.$toaster.error(e.message);
								}
							}else{
								this.$toaster.error(e);
							}
						})
					}
				})
			},
			completeChange(id, status){
				Swal.fire({
					title: '<strong>Are you sure!</strong>',
					html: '<strong>Want to change this?</strong>',
					showDenyButton: true,
					confirmButtonText: `Ok`,
					denyButtonText: `Cancel`,
				}).then((result) => {
					if (result.isConfirmed) {
						axios.post('/test-receipt-complete-change',{id, status}).then(res=>{
							let r = res.data;
							Swal.fire({
								icon: 'success',
								title: r.message,
								showConfirmButton: false,
								timer: 3000
							})
							this.getTestRecieptRecord();
						}).catch(error => {
							let e = error.response.data;

							if(e.hasOwnProperty('message')){
								if(e.hasOwnProperty('errors')){
									Object.entries(e.errors).forEach(([key, val])=>{
										this.$toaster.error(val[0]);
									})
								}else{
									this.$toaster.error(e.message);
								}
							}else{
								this.$toaster.error(e);
							}
						})
					}
				})
			},
			deliveryChange(id, status){
				Swal.fire({
					title: '<strong>Are you sure!</strong>',
					html: '<strong>Want to change this?</strong>',
					showDenyButton: true,
					confirmButtonText: `Ok`,
					denyButtonText: `Cancel`,
				}).then((result) => {
					if (result.isConfirmed) {
						axios.post('/test-receipt-delivery-change',{id, status}).then(res=>{
							let r = res.data;
							Swal.fire({
								icon: 'success',
								title: r.message,
								showConfirmButton: false,
								timer: 3000
							})
							this.getTestRecieptRecord();
						}).catch(error => {
							let e = error.response.data;

							if(e.hasOwnProperty('message')){
								if(e.hasOwnProperty('errors')){
									Object.entries(e.errors).forEach(([key, val])=>{
										this.$toaster.error(val[0]);
									})
								}else{
									this.$toaster.error(e.message);
								}
							}else{
								this.$toaster.error(e);
							}
						})
					}
				})
			},
			async print(){
				let dateText = '';
				if(this.dateFrom != '' && this.dateTo != ''){
					dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let userText = '';
				if(this.selectedUser != null && this.selectedUser.id != '' && this.searchType == 'user'){
					userText = `<strong>Sold by: </strong> ${this.selectedUser.name}`;
				}

				let patientText = '';
				if(this.selectedPatient != null && this.selectedPatient.id != '' && this.searchType == 'patient'){
					patientText = `<strong>Supplier: </strong> ${this.selectedPatient.display_text}<br>`;
				}

				let statueText = '';
				if(this.statusType != null && this.statusType != ''){
					statueText = `<strong>Status: </strong> ${this.statusType}`;
				}
				let testText = '';
				if(this.selectedTest != null && this.selectedTest.id != '' && this.searchType == 'test'){
					testText = `<strong>Test: </strong> ${this.selectedTest.name}`;
				}

				let refText = '';
				if(this.selectedReference != null && this.selectedReference.id != '' && this.searchType == 'reference'){
					refText = `<strong>Category: </strong> ${this.selectedReference.name}`;
				}


				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Purchase Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4">
								${userText} ${patientText} ${testText} ${refText}
							</div>
							<div class="col-xs-2">
								${statueText}
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
							</div>
						</div>
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
						.record-table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				if(this.searchTypesForRecord.includes(this.searchType)) {
					let rows = reportWindow.document.querySelectorAll('.record-table tr');
					rows.forEach(row => {
						row.lastChild.remove();
					})
				}


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}

}
</script>