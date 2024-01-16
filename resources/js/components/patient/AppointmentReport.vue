
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
                <form class="form-inline" @submit.prevent="getSearchResult">
                    
                    <div class="form-group">
                        <label>Doctor</label>
                        <v-select :options="doctors" v-model="selectedDoctor" label="display_name"></v-select>
                    </div>

                    <div class="form-group">
                        <label>Patient</label>
                        <v-select :options="patients" v-model="selectedPatient" label="display_name"></v-select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" v-model="status">
                            <option value="">All</option>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
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

        <div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: results.length > 0 ? '' : 'none'}">
            <div class="col-md-12">
                <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
            </div>
            <div class="col-md-12">
                <div class="table-responsive" id="reportContent">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Tr. ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Serial Number</th>
                                <th>Patient Name</th>
                                <th>Patient Mobile</th>
                                <th>Patient Age</th>
                                <th>Patient Gender</th>
                                <th>Doctor</th>
                                <th>Fee</th>
                                <th>Reference</th>
                                <th>Remark</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, sl) in results" :key="sl">
                                <td>{{ sl + 1 }}</td>
                                <td>{{ row.token_number }}</td>
                                <td>{{ row.appointment_date }}</td>
                                <td>{{ row.appointment_time }}</td>
                                <td>{{ row.serial_number }}</td>
                                <td>{{ row.patient_name }}</td>
                                <td>{{ row.patient_mobile }}</td>
                                <td>{{ row.patient_age }}</td>
                                <td>{{ row.patient_gender }}</td>
                                <td>{{ row.doctor_display_name }}</td>
                                <td>{{ row.fees }}</td>
                                <td>{{ row.reference_display_name }}</td>
                                <td>{{ row.remark }}</td>
                                <td>{{ row.status }}</td>
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
    data(){
        return {
            dateFrom: moment().format('YYYY-MM-DD'),
            dateTo: moment().format('YYYY-MM-DD'),
            status: '',
            doctors: [],
            selectedDoctor: null,
            patients: [],
            selectedPatient: null,
            results: [],
            branch: {},
        }
    },
    filters: {
        formatDateTime(dt) {
            return dt == '' || dt == null ? '' : moment(dt).format('DD-MM-YYYY h:mm:ss a');
        }
    },
    created(){
        this.getDoctors();
        this.getPatients();
        this.getBranchInfo();
    },
    methods: {
        getBranchInfo(){
            axios.get('/get_branch_info').then(res=>{
                this.branch = res.data;
            })
        },
        getDoctors(){
            axios.get('/get_doctors').then(res => {
                this.doctors = res.data;
            })
        },
        getPatients(){
            axios.get('/get_patients').then(res => {
                this.patients = res.data;
            })
        },
        getSearchResult(){
            let filter = {
                dateFrom 	: this.dateFrom,
                dateTo 		: this.dateTo,
                status 		: this.status,
                doctor_id 	: this.selectedDoctor == null ? null : this.selectedDoctor.id,
                patient_id 	: this.selectedPatient == null ? null : this.selectedPatient.id,
            }

            axios.post('/get_appointments', filter).then( res => {
                this.results = res.data;
            });
        },
        async print(){
            let dateText = '';
            if(this.dateFrom != '' && this.dateTo != ''){
                dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
            }

            let reportContent = `
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h3>User Activity</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
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

            reportWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.print();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.close();
        }
    }
}
</script>