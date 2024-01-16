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
                        <label>Patient</label>
                        <v-select v-bind:options="patients" v-model="selectedPatient" label="display_name"></v-select>
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

        <div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: prescriptions.length > 0 ? '' : 'none'}">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
            </div>
            <div class="col-md-12">
                <div class="table-responsive" id="reportContent">

                    <table 
                        class="record-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Tr. ID</th>
                                <th>Date</th>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Patient Age</th>
                                <th>Patient Gender</th>
                                <th>Patient Mobile</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>BP</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(prescription, sl) in prescriptions" :key="sl">
                                <td>{{ sl+1 }}</td>
                                <td>{{ prescription.prescription_code }}</td>
                                <td>{{ prescription.prescription_date | formatDateTime('DD-MM-YYYYY') }}</td>
                                <td>{{ prescription.patient_code}}</td>
                                <td>{{ prescription.patient_name}}</td>
                                <td>{{ prescription.patient_age}}</td>
                                <td>{{ prescription.patient_gender}}</td>
                                <td>{{ prescription.patient_mobile}}</td>
                                <td>{{ prescription.body_height}}</td>
                                <td>{{ prescription.body_weight }}</td>
                                <td>{{ prescription.blood_pressure }}</td>
                                <td>{{ prescription.remark }}</td>
                                <td style="text-align:center;">
                                    <a title="Prescription Invoice" v-bind:href="`/prescription_invoice/${prescription.id}`" target="_blank"><i class="fa fa-file"></i></a>
                                    <a title="Edit Prescription" v-bind:href="`/prescription/${prescription.id}`"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:" title="Delete Prescription" @click.prevent="deletePrescription(prescription.id)"><i class="fa fa-trash"></i></a>
                                </td>
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
    data () {
        return {
            dateFrom       : moment().format('YYYY-MM-DD'),
            dateTo         : moment().format('YYYY-MM-DD'),
            patients       : [],
            selectedPatient: null,
            prescriptions  : [],
            branch         : {},
        }
    },
    filters: {
        formatDateTime(dt, format) {
            return dt == '' || dt == null ? '' : moment(dt).format(format);
        }
    },
    created(){
        this.getSearchResult();
        this.getPatients();
        this.getBranchInfo();
    },
    methods: {
        getBranchInfo(){
            axios.get('/get_branch_info').then(res=>{
                this.branch = res.data;
            })
        },
        getPatients(){
            axios.get('/get_patients').then(res => {
                this.patients = res.data;
            })
        },
        getSearchResult(){
            let filter = {
                patient_id : this.selectedPatient != null ? this.selectedPatient.id : '',
                dateFrom : this.dateFrom,
                dateTo : this.dateTo,
            }

            axios.post('/get_prescriptions', filter).then(res=>{
                this.prescriptions = res.data;
            })
        },
        deletePrescription(id){
            Swal.fire({
                title: '<strong>Are you sure!</strong>',
                html: '<strong>Want to delete this?</strong>',
                showDenyButton: true,
                confirmButtonText: `Ok`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/delete-prescription', {id}).then(res=>{
                        let r = res.data;
                        Swal.fire({
                            icon: 'success',
                            title: r.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getSearchResult();
                        
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

            let patientText = '';
            if(this.selectedPatient != null && this.selectedPatient.Customer_Name != ''){
                patientText = `<strong>Patient: </strong> ${this.selectedPatient.Customer_Name}`;
            }

            let reportContent = `
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h3>Prescription Record</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            ${patientText}
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

            let rows = reportWindow.document.querySelectorAll('.record-table tr');
            rows.forEach(row => {
                row.lastChild.remove();
            })

            reportWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.print();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.close();
        }
    }
}
</script>