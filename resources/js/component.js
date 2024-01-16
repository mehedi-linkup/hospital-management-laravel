require('./bootstrap');

window.Vue = require('vue').default;

// Register Vue Components
Vue.component('register', require('./components/Register.vue').default);
Vue.component('user-access', require('./components/UserAccess.vue').default);
Vue.component('user-activity', require('./components/UserActivity.vue').default);
Vue.component('agent-entry', require('./components/AgentEntry.vue').default);
Vue.component('floor-entry', require('./components/FloorEntry.vue').default);
Vue.component('room-entry', require('./components/RoomEntry.vue').default);
Vue.component('seat-entry', require('./components/SeatEntry.vue').default);
// Doctor Vue Components
Vue.component('doctor-entry', require('./components/doctor/DoctorEntry.vue').default);
Vue.component('cheif-complains-entry', require('./components/doctor/CheifComplainsEntry.vue').default);
Vue.component('advice-entry', require('./components/doctor/AdviceEntry.vue').default);
Vue.component('dose-entry', require('./components/doctor/DoseEntry.vue').default);
Vue.component('duration-entry', require('./components/doctor/DurationEntry.vue').default);

// Patient Vue Components
Vue.component('patient-entry', require('./components/patient/PatientEntry.vue').default);
Vue.component('patient-list', require('./components/patient/PatientList.vue').default);
Vue.component('outdoor-patient', require('./components/patient/OutdoorPatient.vue').default);
Vue.component('appointment-token', require('./components/patient/AppointmentToken.vue').default);
Vue.component('appointment-report', require('./components/patient/AppointmentReport.vue').default);
Vue.component('appointment-list', require('./components/doctor/AppointmentList.vue').default);
Vue.component('billtype-entry', require('./components/patient/BilltypeEntry.vue').default);
Vue.component('patient-admission', require('./components/patient/PatientAdmission.vue').default);
Vue.component('bill-entry', require('./components/patient/BillEntry.vue').default);
Vue.component('bill-invoice', require('./components/patient/BillInvoice.vue').default);
Vue.component('patient-seat-shift', require('./components/patient/PatientSeatShift.vue').default);
Vue.component('slip-bill', require('./components/patient/release_bill/SlipBill.vue').default);
Vue.component('release-bill', require('./components/patient/release_bill/ReleaseSlip.vue').default);
Vue.component('release-slip-edit', require('./components/patient/release_bill/SlipBillPaymentEdit.vue').default);
Vue.component('slip-bill-search', require('./components/patient/release_bill/SlipBillSearch.vue').default);
Vue.component('slip-bill-payment-search', require('./components/patient/release_bill/SlipBillPaymentSearch.vue').default);
Vue.component('release-slip-record', require('./components/patient/release_bill/ReleaseSlipRecord.vue').default);
Vue.component('seat-status', require('./components/patient/SeatStatus.vue').default);

////Pharmacy Vue Components
Vue.component('medicine-entry', require('./components/pharmacy/MedicineEntry.vue').default);
Vue.component('supplier-pharmacy-entry', require('./components/pharmacy/SupplierPharmacyEntry.vue').default);
Vue.component('brand-entry', require('./components/pharmacy/BrandEntry.vue').default);
Vue.component('generic-entry', require('./components/pharmacy/GenericEntry.vue').default);
Vue.component('category-medicine', require('./components/pharmacy/CategoryMedicineEntry.vue').default);
Vue.component('unit-medicine', require('./components/pharmacy/UnitMedicineEntry.vue').default);
Vue.component('purchase-medicine-entry', require('./components/pharmacy/purchase/PurchaseMedicineEntry.vue').default);
Vue.component('purchase-medicine-invoice', require('./components/pharmacy/purchase/PurchaseMedicineInvoice.vue').default);
Vue.component('purchase-medicine-invoice-search', require('./components/pharmacy/purchase/PurchaseMedicineInvoiceSearch.vue').default);
Vue.component('purchase-medicine-record', require('./components/pharmacy/purchase/PurchaseMedicineRecord.vue').default);
Vue.component('purchase-return-medicine-entry', require('./components/pharmacy/purchase/PurchaseReturnMedicineEntry.vue').default);
Vue.component('purchase-return-medicine-list', require('./components/pharmacy/purchase/PurchaseReturnMedicineList.vue').default);
Vue.component('purchase-return-medicine-invoice', require('./components/pharmacy/purchase/PurchaseReturnMedicineInvoice.vue').default);

Vue.component('damage-medicine-entry', require('./components/pharmacy/damage/DamageMedicineEntry.vue').default);
Vue.component('damage-medicine-list', require('./components/pharmacy/damage/DamageMedicineList.vue').default);

Vue.component('sale-medicine-entry', require('./components/pharmacy/sale/SaleMedicineEntry.vue').default);
Vue.component('sale-medicine-invoice', require('./components/pharmacy/sale/SaleMedicineInvoice.vue').default);
Vue.component('sale-medicine-record', require('./components/pharmacy/sale/SaleMedicineRecord.vue').default);
Vue.component('sale-medicine-invoice-search', require('./components/pharmacy/sale/SaleMedicineInvoiceSearch.vue').default);
Vue.component('supplier-payment-medicine', require('./components/pharmacy/SupplierPaymentMedicineEntry.vue').default);

Vue.component('sale-return-medicine-entry', require('./components/pharmacy/sale/SaleReturnMedicineEntry.vue').default);
Vue.component('sale-return-medicine-list', require('./components/pharmacy/sale/SaleReturnMedicineList.vue').default);
Vue.component('sale-return-medicine-invoice', require('./components/pharmacy/sale/SaleReturnMedicineInvoice.vue').default);
Vue.component('stock-medicine', require('./components/pharmacy/StockMedicine.vue').default);
////Inventory Vue Components
Vue.component('category-inventory', require('./components/inventory/CategoryInventoryEntry.vue').default);
Vue.component('unit-inventory', require('./components/inventory/UnitInventoryEntry.vue').default);
Vue.component('instrument-entry', require('./components/inventory/InstrumentEntry.vue').default);
Vue.component('purchase-order-inventory-entry', require('./components/inventory/purchase/PurchaseOrderInventoryEntry.vue').default);
Vue.component('purchase-inventory-invoice-search', require('./components/inventory/purchase/PurchaseInventoryInvoiceSearch.vue').default);
Vue.component('purchase-inventory-invoice', require('./components/inventory/purchase/PurchaseInventoryInvoice.vue').default);
Vue.component('purchase-inventory-record', require('./components/inventory/purchase/PurchaseInventoryRecord.vue').default);

Vue.component('purchase-inventory-returns', require('./components/inventory/purchase/PurchaseInventoryReturns.vue').default);
Vue.component('purchase-return-inventory-list', require('./components/inventory/purchase/PurchaseReturnInventoryList.vue').default);
Vue.component('purchase-return-inventory-invoice', require('./components/inventory/purchase/PurchaseReturnInventoryInvoice.vue').default);
Vue.component('damage-inventory-entry', require('./components/inventory/damage/DamageInventoryEntry.vue').default);
Vue.component('damage-inventory-list', require('./components/inventory/damage/DamageInventoryList.vue').default);
Vue.component('issue-inventory-entry', require('./components/inventory/issue/IssueInventoryEntry.vue').default);
Vue.component('issue-inventory-invoice', require('./components/inventory/issue/IssueInventoryInvoice.vue').default);
Vue.component('issue-inventory-invoice-search', require('./components/inventory/issue/IssueInventoryInvoiceSearch.vue').default);
Vue.component('issue-inventory-record', require('./components/inventory/issue/IssueInventoryRecord.vue').default);
Vue.component('stock-inventory', require('./components/inventory/StockInventory.vue').default);
Vue.component('supplier-payment-inventory', require('./components/inventory/SupplierPaymentInventoryEntry.vue').default);
Vue.component('supplier-due-report', require('./components/inventory/SupplierDueReport.vue').default);


Vue.component('supplier-inventory-entry', require('./components/inventory/SupplierInventoryEntry.vue').default);
Vue.component('company-profile', require('./components/CompanyProfile.vue').default);

// HR & Payroll Vue Components
Vue.component('department-entry', require('./components/HR-Payroll/DepartmentEntry.vue').default);
Vue.component('designation-entry', require('./components/HR-Payroll/DesignationEntry.vue').default);
Vue.component('month-entry', require('./components/HR-Payroll/MonthEntry.vue').default);
Vue.component('employee-entry', require('./components/HR-Payroll/EmployeeEntry.vue').default);
Vue.component('employee-list', require('./components/HR-Payroll/EmployeeList.vue').default);
Vue.component('employee-active-list', require('./components/HR-Payroll/EmployeeActiveList.vue').default);
Vue.component('employee-deactive-list', require('./components/HR-Payroll/EmployeeDeactiveList.vue').default);
Vue.component('salary-payment', require('./components/HR-Payroll/SalaryPayment.vue').default);
Vue.component('salary-payment-report', require('./components/HR-Payroll/SalaryPaymentReport.vue').default);

// Others Vue Components
Vue.component('ambulance-entry', require('./components/other/AmbulancesEntry.vue').default);
Vue.component('ambulance-bill-entry', require('./components/other/AmbulanceBillEntry.vue').default);
Vue.component('ambulance-bill-invoice', require('./components/other/AmbulanceBillInvoice.vue').default);
Vue.component('drivers-entry', require('./components/other/DriversEntry.vue').default);
Vue.component('ot-schedule-entry', require('./components/other/OtScheduleEntry.vue').default);
Vue.component('ot-schedule-pending-list', require('./components/other/OtSchedulePendingList.vue').default);
Vue.component('ot-schedule-complete-list', require('./components/other/OtScheduleCompleteList.vue').default);

// Accounts Vue Components
Vue.component('accounts-entry', require('./components/account/AccountsEntry.vue').default);
Vue.component('bank-accounts-entry', require('./components/account/BankAccountsEntry.vue').default);
Vue.component('bank-transaction-entry', require('./components/account/BankTransactionEntry.vue').default);
Vue.component('cash-transaction-entry', require('./components/account/CashTransactionEntry.vue').default);
Vue.component('cash-transaction-report', require('./components/account/CashTransactionReport.vue').default);
Vue.component('bank-transaction-report', require('./components/account/BankTransactionReport.vue').default);
Vue.component('cash-ledger-report', require('./components/account/CashLedgerReport.vue').default);
Vue.component('bank-ledger-report', require('./components/account/BankLedgerReport.vue').default);
Vue.component('cash-view-report', require('./components/account/CashViewReport.vue').default);

//pathology
Vue.component('test-entry', require('./components/pathology/TestEntry.vue').default);
Vue.component('test-receipt', require('./components/pathology/TestReceipt.vue').default);
Vue.component('test-receipt-invoice', require('./components/pathology/TestReceiptInvoice.vue').default);
Vue.component('test-receipt-report-invoice', require('./components/pathology/TestReceiptReportInvoice.vue').default);
Vue.component('test-receipt-record', require('./components/pathology/TestReceiptRecord.vue').default);

//prescription
Vue.component('prescription', require('./components/doctor/Prescription.vue').default);
Vue.component('prescription-invoice', require('./components/doctor/PrescriptionInvoice.vue').default);
Vue.component('prescription-record', require('./components/doctor/PrescriptionRecord.vue').default);

