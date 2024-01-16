<template>
    <div id="sales" class="row">
        <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> Invoice no </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" v-model="testreceipt.invoice_number" readonly />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> Ref. By </label>
                    <div class="col-xs-2">
                        <v-select :options="references" label="display_name" v-model="selectedReference"></v-select>
                    </div>
                    <div class="col-xs-1" style="padding:0;margin-left: -7px;">
                        <a href="/agent_entry" target="_blank" class="add-button" style="width:40px;"><i class="fa fa-plus"></i></a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> Date </label>
                    <div class="col-sm-3">
                        <input class="form-control" type="date" v-model="testreceipt.bill_date" v-bind:disabled="role == 'User' ? true : false"/>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-9 col-lg-9">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Test Information</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label no-padding-right"> Patient </label>
                                    <div class="col-xs-8">
                                        <v-select v-bind:options="patients" v-model="selectedPatient" label="display_text"></v-select>
                                    </div>
                                    <div class="col-xs-1" style="padding: 0px;margin-left: -10px;">
                                        <a href="/patient_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="form-group">
								<label class="col-xs-3 control-label no-padding-right"> Name </label>
                                    <div class="col-xs-9">
                                        <input type="text" placeholder="Name" class="form-control" v-model="selectedPatient.name" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
								<label class="col-xs-3 control-label no-padding-right"> Mobile No </label>
                                    <div class="col-xs-9">
                                        <input type="text" placeholder="Mobile No" class="form-control" v-model="selectedPatient.mobile"  readonly/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-3 control-label no-padding-right"> Address </label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" v-model="selectedPatient.address" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <form v-on:submit.prevent="addToCart">
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> Test </label>
                                        <div class="col-xs-8">
                                            <v-select v-bind:options="tests" v-model="selectedTest" label="display_name" @input="getTestsDateTime()"></v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding: 0; margin-left: -10px;">
                                            <a href="/test_entry" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> Room </label>
                                        <div class="col-xs-9">
                                            <input type="text" placeholder="Room" v-model="selectedTest.room_number" class="form-control" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> Price </label>
                                        <div class="col-xs-9">
                                            <input type="number" step="0.01" placeholder="Price" v-model="selectedTest.price" class="form-control" required/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> Delivery At </label>
                                        <div class="col-xs-5">
                                            <input type="date" class="form-control" v-model="delivery_date" />
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="time" class="form-control" v-model="delivery_time" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> </label>
                                        <div class="col-xs-9">
                                            <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                <div class="table-responsive">
                    <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Test</th>
                                <th>Room</th>
                                <th>Delivery At</th>
                                <th>Delivery Time</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                            <tr v-for="(product, sl) in cart" :key="sl">
                                <td>{{ sl + 1 }}</td>
                                <td>{{ product.display_name }}</td>
                                <td>{{ product.room_number }}</td>
                                <td>{{ product.delivery_date }}</td>
                                <td>{{ product.delivery_time }}</td>
                                <td>{{ product.price }}</td><td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
                            </tr>

                            <tr>
                                <td colspan="6"></td>
                            </tr>

                            <tr style="font-weight: bold;">
                                <td colspan="4">Note</td>
                                <td colspan="2">Total</td>
                            </tr>

                            <tr>
                                <td colspan="4"><textarea style="width: 100%;font-size:13px;" v-model="testreceipt.note" placeholder="Note"></textarea></td>
                                <td colspan="2" style="padding-top: 15px;font-size:18px;">{{ testreceipt.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-3 col-lg-3">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Amount Details</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label no-padding-right">Sub Total</label>
                                                    <div class="col-xs-12">
                                                        <input type="number" class="form-control" v-model="testreceipt.subtotal" readonly/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label no-padding-right">Vat</label>

                                                    <div class="col-xs-4">
                                                        <input type="number" class="form-control" v-model="vatPercent" v-on:input="calculateTotal"/>
                                                    </div>

                                                    <label class="col-xs-1 control-label no-padding-right">%</label>

                                                    <div class="col-xs-7">
                                                        <input type="number" class="form-control"  v-model="testreceipt.vat_amount" readonly/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label no-padding-right">Discount</label>

                                                    <div class="col-xs-4">
                                                        <input type="number" class="form-control"  v-model="discountPercent" v-on:input="calculateTotal"/>
                                                    </div>

                                                    <label class="col-xs-1 control-label no-padding-right">%</label>

                                                    <div class="col-xs-7">
                                                        <input type="number" class="form-control" v-model="testreceipt.discount_amount" v-on:input="calculateDiscountPercentage"/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label no-padding-right">Others</label>
                                                    <div class="col-xs-12">
                                                        <input type="number" class="form-control" v-model="testreceipt.others"/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label no-padding-right">Total</label>
                                                    <div class="col-xs-12">
                                                        <input type="number" class="form-control" readonly  v-model="testreceipt.total"/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label no-padding-right">Paid</label>
                                                    <div class="col-xs-12">
                                                        <input type="number" id="paid" class="form-control" v-model="testreceipt.paid" v-on:input="calculateTotalDue"/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label class="col-xs-12 control-label">Due</label>
                                                    <div class="col-xs-12">
                                                        <input type="number" class="form-control" v-model="testreceipt.due" readonly/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="col-xs-6">
                                                        <input type="button" class="btn btn-default btn-sm" value="Save" v-on:click="saveTestReceipt" v-bind:disabled="purchaseOnProgress == true ? true : false" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <a class="btn btn-info btn-sm" href="/test_receipt" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">New</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
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
    props: ['role','code','id'],
    data(){
        return{
            testreceipt: {
                id              : '',
                invoice_number  : '',
                bill_date       : moment().format('YYYY-MM-DD'),
                patient_id      : '',
                reference_id    : '',
                subtotal        : 0.00,
                vat_percent     : 0.00,
                vat_amount      : 0.00,
                discount_amount : 0.00,
                discount_percent: 0.00,
                others          : 0.00,
                total           : 0.00,
                paid            : 0.00,
                due             : 0.00,
                note            : ''
            },
            vatPercent: 0.00,
            discountPercent: 0.00,
            branches: [],
            
            patients: [],
            selectedPatient: {
                id          : null,
                display_text: 'Select Patient',
                name      : '',
                mobile      : '',
                address     : ''
            },

            references       : [],
            selectedReference: {
                id          : null,
                display_name: 'Select Reference',
            },

            oldSupplierId: null,
            tests        : [],
            delivery_date: '',
            delivery_time: '',
            selectedTest : {
                id           : '',
                name         : '',
                room_number  : '',
                display_name : 'Select Test',
                price        : '',
                total        : ''
            },
            cart: [],
            purchaseOnProgress: false
        }
    },
    async created(){
        this.testreceipt.id= this.id;
        this.testreceipt.invoice_number = this.code;
        await  this.getPatients();
        this.getTests();
        
        this.getReferences();
        // this.getProducts();
        if(this.id != 0){
            this.getTestReciept();
        }
    },
    methods:{
        async  getPatients(){
            await axios.get('/get_patients').then(res=>{
            this.patients = res.data;
            })
        },
        getReferences(){
            axios.get('/get_agents').then(res=>{
                this.references = res.data;
            })
        },
        getTests(){
            axios.get('/get_tests').then(res=>{
                this.tests = res.data;         
            })
        },
        getTestsDateTime(){
            if(this.selectedTest!=null){
                let now = moment();
                let future = now.add(this.selectedTest.get_min, 'minutes');
                this.delivery_date = future.format("YYYY-MM-DD");
                this.delivery_time = future.format("HH:MM");
            }else{
                this.clearSelectedProduct();
            }
        },
       
        calculateTotalDue(){
				this.testreceipt.due =  (+this.testreceipt.total - +this.testreceipt.paid).toFixed(2);
		},
        addToCart(){

            let cartTest = {
                productId    : this.selectedTest.id,
                display_name : this.selectedTest.display_name,
                room_number : this.selectedTest.room_number,
                price        : this.selectedTest.price,
                delivery_date: this.delivery_date,
                delivery_time: this.delivery_time
            }
            let cartInd = this.cart.findIndex(p => p.productId == cartTest.productId);
            if(cartInd > -1){
                this.cart.splice(cartInd, 1);
            }
            this.cart.unshift(cartTest);
            this.clearSelectedProduct();
            this.calculateTotal();
        },
        async removeFromCart(ind){
            
            this.cart.splice(ind, 1);
            this.calculateTotal();
        },
        clearSelectedProduct(){
            this.selectedTest = {
                id           : '',
                name         : '',
                room_number  : '',
                display_name : 'Select Test',
                price        : '',
                total        : ''
            }
            this.delivery_date= '';
            this.delivery_time= '';
        },
        calculateTotal(){
            this.testreceipt.subtotal = this.cart.reduce((prev, curr) => { return prev + parseFloat(curr.price); }, 0).toFixed(2);
            //alert(this.testreceipt.subtotal);
            this.testreceipt.vat_amount = ((this.testreceipt.subtotal * parseFloat(this.vatPercent)) / 100).toFixed(2);
            
            this.testreceipt.discount_amount = ((parseFloat(this.testreceipt.subtotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
            
            this.testreceipt.total = ((parseFloat(this.testreceipt.subtotal) + parseFloat(this.testreceipt.vat_amount) + parseFloat(this.testreceipt.others)) - parseFloat(this.testreceipt.discount_amount)).toFixed(2);
            this.testreceipt.paid= this.testreceipt.total;
            this.testreceipt.due= this.testreceipt.total - this.testreceipt.paid;
        },
        calculateDiscountPercentage(){
            this.testreceipt.subtotal = this.cart.reduce((prev, curr) => { return prev + parseFloat(curr.price); }, 0).toFixed(2);
            this.testreceipt.vat_amount = ((this.testreceipt.subtotal * parseFloat(this.vatPercent)) / 100).toFixed(2);
            
            this.discountPercent = (parseFloat(this.testreceipt.discount_amount) / parseFloat(this.testreceipt.subtotal) * 100).toFixed(2);
            
            this.testreceipt.total = ((parseFloat(this.testreceipt.subtotal) + parseFloat(this.testreceipt.vat_amount) + parseFloat(this.testreceipt.others)) - parseFloat(this.testreceipt.discount_amount)).toFixed(2);
            this.testreceipt.paid= this.testreceipt.total;
            this.testreceipt.due= this.testreceipt.total - this.testreceipt.paid;
        },
        saveTestReceipt(){
            if(this.selectedPatient.id == null){
                alert('Select Patient');
                return;
            }

            if(this.testreceipt.bill_date == ''){
                alert('Enter Test date');
                return;
            }

            if(this.cart.length == 0){
                alert('Cart is empty');
                return;
            }

            this.testreceipt.reference_id     = this.selectedReference ? this.selectedReference.id : '';
            this.testreceipt.patient_id       = this.selectedPatient.id;
            this.testreceipt.vat_percent      = this.vatPercent;
            this.testreceipt.discount_percent = this.discountPercent;

            //this.purchaseOnProgress = true;

            let data = {
                testreceipts: this.testreceipt,
                cartTests: this.cart
            }

            

            let url = '/store-testreceipt';
            if(this.testreceipt.id != 0){
                url = '/update-testreceipt';
            }

            axios.post(url, data).then(async res=>{
                let conf = confirm('Do you want to view invoice?');
                if(conf){
                    window.open('/test_receipt_invoice_print/'+res.data.id, '_blank');
                    await new Promise(r => setTimeout(r, 1000));
                }

                window.location = '/test_receipt';
                
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

        getTestReciept(){
            axios.post('/get_test_receipt', {testreceiptsId: this.id, with_details: true}).then(res => {
                let gettestreceipts = res.data[0];
                this.selectedReference.id           = gettestreceipts.reference_id;
                this.selectedReference.display_name = gettestreceipts.reference_text;
                this.selectedPatient.id             = gettestreceipts.patient_id;
                this.selectedPatient.display_text   = gettestreceipts.display_text;
                this.selectedPatient.name         = gettestreceipts.patient_name;
                this.selectedPatient.mobile         = gettestreceipts.patient_mobile;
                this.selectedPatient.address        = gettestreceipts.patient_address;
                this.testreceipt.invoice_number     = gettestreceipts.invoice_number;
                this.testreceipt.bill_date          = gettestreceipts.bill_date;
                this.testreceipt.patient_id         = gettestreceipts.patient_id;
                this.testreceipt.subtotal           = gettestreceipts.subtotal;
                this.testreceipt.vat_amount         = gettestreceipts.vat_amount;
                this.testreceipt.vat_percent        = gettestreceipts.vat_percent;
                this.testreceipt.discount_amount    = gettestreceipts.discount_amount;
                this.testreceipt.others             = gettestreceipts.others;
                this.testreceipt.total              = gettestreceipts.total;
                this.testreceipt.paid               = gettestreceipts.paid;
                this.testreceipt.due                = gettestreceipts.due;
                this.testreceipt.note               = gettestreceipts.remark;

                this.oldPatientId = gettestreceipts.patient_id;

                //this.vatPercent = (this.purchases.vat_amount * 100) / this.purchases.subtotal;
                //console.log(purchases.supplier_id);
                
                gettestreceipts.testreceiptDetails.forEach(item => {
                let cart = {
                id           : item.id,
                productId    : item.test_id,
                display_name : item.display_name,
                room_number  : item.room_number,
                price        : item.amount,
                delivery_date: item.delivery_date,
                delivery_time: item.delivery_time,
                }
                this.cart.push(cart);
            })
            })
        }
    
    }
}
</script>