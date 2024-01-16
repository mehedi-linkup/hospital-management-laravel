<?php

use App\Http\Controllers\AccountsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\OutdoorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\HrPayrollController;
use App\Http\Controllers\InventroyController;
use App\Http\Controllers\PathologyController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\OthersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    Route::middleware('access')->group(function () {
        Route::get('/patient_entry', [PatientController::class, 'patientEntry'])->name('patient_entry');
        Route::get('/patient_list', [PatientController::class, 'patientList'])->name('patient_list');
        Route::get('/outdoor_patient', [OutdoorController::class, 'outdoorPatient'])->name('outdoor_patient');
        Route::get('/appointment_report', [OutdoorController::class, 'appointmentReport'])->name('appointment_report');
        Route::get('/billtype_entry', [OutdoorController::class, 'billtypeEntry'])->name('billtype_entry');
        Route::get('/agent_entry', [AdministrationController::class, 'agentEntry'])->name('agent_entry');
        Route::get('/room_entry', [AdministrationController::class, 'roomEntry'])->name('room_entry');
        Route::get('/floor_entry', [AdministrationController::class, 'floorEntry'])->name('floor_entry');
        Route::get('/seat_entry', [AdministrationController::class, 'seatEntry'])->name('seat_entry');
        Route::get('/doctor_entry', [DoctorController::class, 'doctorEntry'])->name('doctor_entry');

        Route::get('/medicine_entry', [PharmacyController::class, 'medicineEntry'])->name('medicine_entry');
        Route::get('/brand_entry', [PharmacyController::class, 'brandEntry'])->name('brand_entry');
        Route::get('/generic_entry', [PharmacyController::class, 'genericEntry'])->name('generic_entry');
        Route::get('/category_entry_medicine', [PharmacyController::class, 'categoryEntryMedicine'])->name('category_entry_medicine');
        Route::get('/unit_entry_medicine', [PharmacyController::class, 'unitEntryMedicine'])->name('unit_entry_medicine');
        Route::get('/supplier_pharmacy_entry', [PharmacyController::class, 'supplierPharmacyEntry'])->name('supplier_pharmacy_entry');
        Route::get('/purchase_medicine', [PharmacyController::class, 'purchaseMedicineEntry'])->name('purchase_medicine');
        Route::get('/purchase_medicine_invoice', [PharmacyController::class, 'purchaseMedicineInvoiceSearch'])->name('purchase_medicine_invoice');
        Route::get('/purchase_medicine_record', [PharmacyController::class, 'purchaseMedicineRecord'])->name('purchase_medicine_record');
        Route::get('/damage_medicine', [PharmacyController::class, 'damageMedicineEntry'])->name('damage_medicine');
        Route::get('/damage_medicine_list', [PharmacyController::class, 'damageMedicineList'])->name('damage_medicine_list');
        Route::get('/purchase_return_medicine', [PharmacyController::class, 'purchaseReturnMedicineEntry'])->name('purchase_return_medicine');
        Route::get('/purchase_return_medicine_record', [PharmacyController::class, 'purchaseReturnMedicineRecord'])->name('purchase_return_medicine_record');
        Route::get('/sale_medicine', [PharmacyController::class, 'saleMedicineEntry'])->name('sale_medicine');
        Route::get('/sale_medicine_record', [PharmacyController::class, 'saleMedicineRecord'])->name('sale_medicine_record');
        Route::get('/sale_medicine_invoice', [PharmacyController::class, 'saleMedicineInvoiceSearch'])->name('sale_medicine_invoice');
        Route::get('/sale_return_medicine', [PharmacyController::class, 'saleReturnMedicineEntry'])->name('sale_return_medicine');
        Route::get('/sale_return_medicine_record', [PharmacyController::class, 'saleReturnMedicineRecord'])->name('sale_return_medicine_record');
        Route::get('/medicine_current_stock', [PharmacyController::class, 'stockMedicine'])->name('medicine_current_stock');
        Route::get('/supplier_payment_medicine', [PharmacyController::class, 'supplierPaymentMedicine'])->name('supplier_payment_medicine');
        
        Route::get('/category_entry_inventory', [InventroyController::class, 'categoryEntryInventory'])->name('category_entry_inventory');
        Route::get('/unit_entry_inventory', [InventroyController::class, 'unitEntryInventory'])->name('unit_entry_inventory');
        Route::get('/instrument_entry', [InventroyController::class, 'instrumentEntry'])->name('instrument_entry');
        Route::get('/supplier_inventory_entry', [InventroyController::class, 'supplierInventoryEntry'])->name('supplier_inventory_entry');
        Route::get('/purchase_inventory', [InventroyController::class, 'purchaseOrderInventoryEntry'])->name('purchase_inventory');
        Route::get('/damage_inventory', [InventroyController::class, 'damageInventoryEntry'])->name('damage_inventory');
        Route::get('/damage_inventory_list', [InventroyController::class, 'damageInventoryList'])->name('damage_inventory_list');
        Route::get('/purchase_inventory_record', [InventroyController::class, 'purchaseInventoryRecord'])->name('purchase_inventory_record');
        Route::get('/purchase_invoice_search', [InventroyController::class, 'purchaseInventoryInvoiceSearch'])->name('purchase_invoice_search');
        Route::get('/purchase_return_inventory', [InventroyController::class, 'purchaseInventoryReturn'])->name('purchase_return_inventory');
        Route::get('/purchase_return_inventory_invoice/{id}', [InventroyController::class, 'purchaseInventoryReturnInvoice'])->name('purchase_inventory_returns_invoice');
        Route::get('/purchase_return_inventory_record', [InventroyController::class, 'purchaseReturnInventoryRecord'])->name('purchase_return_inventory_record');
        Route::get('/issue_inventory', [InventroyController::class, 'issueInventoryEntry'])->name('issue_inventory');
        Route::get('/issue_invoice_search', [InventroyController::class, 'issueInventoryInvoiceSearch'])->name('issue_invoice_search');
        Route::get('/issue_inventory_record', [InventroyController::class, 'issueInventoryRecord'])->name('issue_inventory_record');
        Route::get('/current_stock', [InventroyController::class, 'stockInventory'])->name('current_stock_inventory');
        Route::get('/supplier_payment_inventory', [InventroyController::class, 'supplierPaymentInventory'])->name('supplier_payment_inventory');
        Route::get('/supplier_due_list', [InventroyController::class, 'supplierDueList'])->name('supplier_due_list');
        
        Route::get('/designation_entry', [HrPayrollController::class, 'designationEntry'])->name('designation_entry');
        Route::get('/department_entry', [HrPayrollController::class, 'departmentEntry'])->name('department_entry');
        Route::get('/employee_entry', [HrPayrollController::class, 'employeeEntry'])->name('employee_entry');
        Route::get('/employee_list', [HrPayrollController::class, 'employeeList'])->name('employee_list');
        Route::get('/employee_active_list', [HrPayrollController::class, 'employeeActiveList'])->name('employee_active_list');
        Route::get('/employee_deactive_list', [HrPayrollController::class, 'employeeDeactiveList'])->name('employee_deactive_list');
        Route::get('/salary_payment', [HrPayrollController::class, 'salaryPayment'])->name('salary_payment');
        Route::get('/salary_payment_report', [HrPayrollController::class, 'salaryPaymentReport'])->name('salary_payment_report');
        Route::get('/month_entry', [HrPayrollController::class, 'monthEntry'])->name('month_entry');
        Route::get('/test_entry', [PathologyController::class, 'testEntry'])->name('test_entry');
        
        Route::get('/driver_entry', [OthersController::class, 'driverEntry'])->name('driver_entry');
        Route::get('/ambulance_entry', [OthersController::class, 'ambulanceEntry'])->name('ambulance_entry');
        Route::get('/ambulance_bill', [OthersController::class, 'ambulanceBillEntry'])->name('ambulance_bill');
        Route::get('/ot_schedule_entry', [OthersController::class, 'otScheduleEntry'])->name('ot_schedule_entry');
        Route::get('/ot_schedule_pending_list', [OthersController::class, 'otSchedulePendingList'])->name('ot_schedule_pending_list');
        Route::get('/ot_schedule_complete_list', [OthersController::class, 'otScheduleCompleteList'])->name('ot_schedule_complete_list');
        
        Route::get('/account_entry', [AccountsController::class, 'accountEntry'])->name('account_entry');
        Route::get('/bank_account_entry', [AccountsController::class, 'bankaccountEntry'])->name('bank_account_entry');
        Route::get('/bank_transaction_entry', [AccountsController::class, 'banktransactionEntry'])->name('bank_transaction_entry');
        Route::get('/cash_transaction_entry', [AccountsController::class, 'cashtransactionEntry'])->name('cash_transaction_entry');
        Route::get('/cash_transaction_report', [AccountsController::class, 'cashtransactionReport'])->name('cash_transaction_report');
        Route::get('/bank_transaction_report', [AccountsController::class, 'banktransactionReport'])->name('bank_transaction_report');
        Route::get('/cash_ledger_report', [AccountsController::class, 'cashLedgerReport'])->name('cash_ledger_report');
        Route::get('/bank_ledger_report', [AccountsController::class, 'bankLedgerReport'])->name('bank_ledger_report');
        Route::get('/cash_view_report', [AccountsController::class, 'cashViewReport'])->name('cash_view_report');
        
        Route::match(['get', 'post'],'/database_backup', [CommonController::class, 'databaseBackup'])->name('database_backup');
        Route::get('/patient_admission', [OutdoorController::class, 'patientAdmission'])->name('patient_admission');
        Route::get('/seat_shift', [OutdoorController::class, 'patientSeatShift'])->name('seat_shift');
        Route::get('/bill_entry', [OutdoorController::class, 'billEntry'])->name('bill_entry');
        Route::get('/slip_bill_search', [OutdoorController::class, 'slipBillSearch'])->name('slip_bill_search');
        Route::get('/slip_bill_payment_search', [OutdoorController::class, 'slipBillPaymentSearch'])->name('slip_bill_payment_search');
        Route::get('/release_slip_record', [OutdoorController::class, 'releaseSlipRecord'])->name('release_slip_record');
        Route::get('/seat_status', [OutdoorController::class, 'seatStatus'])->name('seat_status');
        
        Route::get('/test_receipt', [PathologyController::class, 'testReceipt'])->name('test_receipt');
        Route::get('/test_receipt_record', [PathologyController::class, 'testReceiptRecord'])->name('test_receipt_record');
    });

    Route::get('/', [CommonController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [CommonController::class, 'dashboard']);
    Route::get('/module/{module}', [CommonController::class, 'module'])->name('module');
    Route::get('/get_mother_api_content', [CommonController::class, 'getMotherApiContent']);
    Route::get('/get_branch_info', [CommonController::class, 'getBranchInfo']);
    Route::post('/branch_change', [CommonController::class, 'branchChange']);

    //user
    Route::get('/get_users', [CommonController::class, 'getUsers']);
    Route::get('/user_activity', [CommonController::class, 'userActivity'])->name('user_activity');
    Route::post('/get_user_activity', [CommonController::class, 'getUserActivity']);
    Route::post('/delete_user_activity', [CommonController::class, 'deleteUserActivity']);
    Route::get('/user_access/{id}', [CommonController::class, 'userAccess'])->name('user_access');
    Route::post('/add_user_access', [CommonController::class, 'addUserAccess']);
    Route::get('/get_user_access/{id}', [CommonController::class, 'getUserAccess']);

    //patient
    Route::post('/store-patient', [PatientController::class, 'patientStore']);
    Route::post('/update-patient', [PatientController::class, 'patientUpdate']);
    Route::post('/delete-patient', [PatientController::class, 'patientDelete']);
    Route::get('/get_patient_code', [PatientController::class, 'getPatientCode']);
    Route::match(['get', 'post'],'/get_patients', [PatientController::class, 'getPatients']);

    //outdoor
   
    //appointment
    Route::get('/get_appointment_tr_id', [OutdoorController::class, 'getAppointmentTrId']);
    Route::post('/get_appointment_serial_number', [OutdoorController::class, 'getAppointmentSerialNumber']);
    Route::post('/add-appointment', [OutdoorController::class, 'addAppointment']);
    Route::post('/update-appointment', [OutdoorController::class, 'updateAppointment']);
    Route::post('/delete-appointment', [OutdoorController::class, 'appointmentDelete']);
    Route::post('/get_appointments', [OutdoorController::class, 'getAppointments']);
    Route::get('/appointment_token/{id}', [OutdoorController::class, 'appointmentToken']);
    Route::get('/doctor_appointment_list', [DoctorController::class, 'appointmentList'])->name('doctor_appointment_list');

    /////admisson
    Route::match(['get', 'post'],'/get_admissions', [OutdoorController::class, 'getAdmissions']);
    Route::post('/store-admission', [OutdoorController::class, 'admissionStore']);
    Route::post('/update-admission', [OutdoorController::class, 'admissionUpdate']);
    Route::post('/delete-admission', [OutdoorController::class, 'admissionDelete']);
    /////Seat Shift
    Route::post('/store-seatshift', [OutdoorController::class, 'seatShiftStore']);
    Route::post('/delete-seat-shift', [OutdoorController::class, 'seatShiftDelete']);
    Route::post('/update-seatshift', [OutdoorController::class, 'seatShiftUpdate']);
    Route::match(['get', 'post'],'/get_seat_shift', [OutdoorController::class, 'getSeatShift']);
    Route::match(['get', 'post'],'/get_admission_seat_shift', [OutdoorController::class, 'getAdmissionsSeat']);
    ///bills
    Route::post('/store-bill', [OutdoorController::class, 'billStore']);
    Route::post('/update-bill', [OutdoorController::class, 'billUpdate']);
    Route::post('/delete-bill', [OutdoorController::class, 'billDelete']);
    Route::match(['get', 'post'],'/get_bills', [OutdoorController::class, 'getBills']);
    Route::get('/bill_invoice_print/{id}', [OutdoorController::class, 'billInvoice']);
    
    ////slip 
    Route::get('/release_slip/{id}', [OutdoorController::class, 'releaseSlipEdit']);
    Route::match(['get', 'post'],'/get_slip_bill', [OutdoorController::class, 'getSlipBill']);
    Route::match(['get', 'post'],'/get_release_slip', [OutdoorController::class, 'getReleaseSlip']);
    Route::get('/get_release_slip_code', [OutdoorController::class, 'getReleaseSlipCode']);
    Route::post('/store-release-slip', [OutdoorController::class, 'releaseSlipStore']);
    Route::post('/update-release-slip', [OutdoorController::class, 'releaseSlipUpdate']);
    Route::post('/delete-release-slip', [OutdoorController::class, 'releaseSlipDelete']);
    Route::get('/release_slip_print/{id}', [OutdoorController::class, 'releaseSlipInvoice']);
    Route::match(['get', 'post'],'/get_seat_status', [OutdoorController::class, 'getseatStatus']);

    //prescription
    Route::get('/prescription', [DoctorController::class, 'prescription'])->name('prescription');
    Route::get('/prescription/{id}', [DoctorController::class, 'prescriptionEdit'])->name('prescription_edit');
    Route::get('/prescription_invoice/{id}', [DoctorController::class, 'prescriptionInvoice']);
    Route::post('/prescription-store', [DoctorController::class, 'prescriptionStore']);
    Route::post('/prescription-update', [DoctorController::class, 'prescriptionUpdate']);
    Route::post('/delete-prescription', [DoctorController::class, 'prescriptionDelete']);
    Route::match(['get', 'post'],'/get_prescriptions', [DoctorController::class, 'getPrescriptions']);
    Route::get('/prescription_record', [DoctorController::class, 'prescription_record'])->name('prescription_record');

    ////billtype Entry
    Route::post('/store-billtype', [OutdoorController::class, 'billtypeStore']);
    Route::post('/update-billtype', [OutdoorController::class, 'billtypeUpdate']);
    Route::post('/delete-billtype', [OutdoorController::class, 'billtypeDelete']);
    Route::match(['get', 'post'],'/get_billtypes', [OutdoorController::class, 'getBilltypes']);
    
    //// agent Entry
    Route::post('/store-agent', [AdministrationController::class, 'agentStore']);
    Route::post('/update-agent', [AdministrationController::class, 'agentUpdate']);
    Route::post('/delete-agent', [AdministrationController::class, 'agentDelete']);
    Route::get('/get_agent_code', [AdministrationController::class, 'getAgentCode']);
    Route::match(['get', 'post'],'/get_agents', [AdministrationController::class, 'getAgents']);
    ////Room Entry
    Route::post('/store-room', [AdministrationController::class, 'roomStore']);
    Route::post('/update-room', [AdministrationController::class, 'roomUpdate']);
    Route::post('/delete-room', [AdministrationController::class, 'roomDelete']);
    Route::match(['get', 'post'],'/get_rooms', [AdministrationController::class, 'getRooms']);
    ////Floor Entry
    Route::post('/store-floor', [AdministrationController::class, 'floorStore']);
    Route::post('/update-floor', [AdministrationController::class, 'floorUpdate']);
    Route::post('/delete-floor', [AdministrationController::class, 'floorDelete']);
    Route::get('/get_floor_code', [AdministrationController::class, 'getFloorCode']);
    Route::match(['get', 'post'],'/get_floors', [AdministrationController::class, 'getFloors']);
    ////Seat Entry
    Route::post('/store-seat', [AdministrationController::class, 'seatStore']);
    Route::post('/update-seat', [AdministrationController::class, 'seatUpdate']);
    Route::post('/delete-seat', [AdministrationController::class, 'seatDelete']);
    Route::match(['get', 'post'],'/get_seats', [AdministrationController::class, 'getSeats']);

    
    Route::get('/company_profile', [AdministrationController::class, 'companyProfile'])->name('company_profile');
    Route::post('/store-companyprofile', [AdministrationController::class, 'companyProfileStore']);
    Route::post('/update-companyprofile', [AdministrationController::class, 'companyProfileUpdate']);
    Route::match(['get', 'post'],'/get_companies', [AdministrationController::class, 'getCompanies']);
    Route::match(['get', 'post'],'/get_branches', [AdministrationController::class, 'getBranches']);
    Route::match(['get', 'post'],'/get_branches_code', [AdministrationController::class, 'getBranchCode']);
    Route::post('/store-branch', [AdministrationController::class, 'branchStore']);
    Route::post('/update-branch', [AdministrationController::class, 'branchUpdate']);
    Route::post('/delete-branch', [AdministrationController::class, 'branchDelete']);

    ///Doctor Mudule
    //////Doctor Entry
    Route::post('/store-doctor', [DoctorController::class, 'doctorStore']);
    Route::post('/update-doctor', [DoctorController::class, 'doctorUpdate']);
    Route::post('/delete-doctor', [DoctorController::class, 'doctorDelete']);
    Route::get('/get_doctor_code', [DoctorController::class, 'getDoctorCode']);
    Route::match(['get', 'post'],'/get_doctors', [DoctorController::class, 'getDoctors']);

    ////Cheif Complain Entry
    Route::get('/cheif_complain_entry', [DoctorController::class, 'cheifComplainEntry'])->name('cheif_complain_entry');
    Route::post('/store-cheif-complain', [DoctorController::class, 'cheifComplainStore']);
    Route::post('/update-cheif-complain', [DoctorController::class, 'cheifComplainUpdate']);
    Route::post('/delete-cheif-complain', [DoctorController::class, 'cheifComplainDelete']);
    Route::match(['get', 'post'],'/get_cheif_complains', [DoctorController::class, 'getCheifComplains']);

    ////advice Entry
    Route::get('/advice_entry', [DoctorController::class, 'adviceEntry'])->name('advice_entry');
    Route::post('/store-advice', [DoctorController::class, 'adviceStore']);
    Route::post('/update-advice', [DoctorController::class, 'adviceUpdate']);
    Route::post('/delete-advice', [DoctorController::class, 'adviceDelete']);
    Route::match(['get', 'post'],'/get_advices', [DoctorController::class, 'getAdvices']);
    
    ////dose Entry
    Route::get('/dose_entry', [DoctorController::class, 'doseEntry'])->name('dose_entry');
    Route::post('/store-dose', [DoctorController::class, 'doseStore']);
    Route::post('/update-dose', [DoctorController::class, 'doseUpdate']);
    Route::post('/delete-dose', [DoctorController::class, 'doseDelete']);
    Route::match(['get', 'post'],'/get_doses', [DoctorController::class, 'getDoses']);
    
    ////duration Entry
    Route::get('/duration_entry', [DoctorController::class, 'durationEntry'])->name('duration_entry');
    Route::post('/store-duration', [DoctorController::class, 'durationStore']);
    Route::post('/update-duration', [DoctorController::class, 'durationUpdate']);
    Route::post('/delete-duration', [DoctorController::class, 'durationDelete']);
    Route::match(['get', 'post'],'/get_durations', [DoctorController::class, 'getDurations']);
    
    ////brand
    Route::post('/store-brand', [PharmacyController::class, 'brandStore']);
    Route::post('/update-brand', [PharmacyController::class, 'brandUpdate']);
    Route::post('/delete-brand', [PharmacyController::class, 'brandDelete']);
    Route::match(['get', 'post'],'/get_brands', [PharmacyController::class, 'getBrands']);

    ////Generic
    Route::post('/store-generic', [PharmacyController::class, 'genericStore']);
    Route::post('/update-generic', [PharmacyController::class, 'genericUpdate']);
    Route::post('/delete-generic', [PharmacyController::class, 'genericDelete']);
    Route::match(['get', 'post'],'/get_generics', [PharmacyController::class, 'getGenerics']);

    ////Medicine Entry
    Route::post('/store-medicine', [PharmacyController::class, 'medicineStore']);
    Route::post('/update-medicine', [PharmacyController::class, 'medicineUpdate']);
    Route::post('/delete-medicine', [PharmacyController::class, 'medicineDelete']);
    Route::match(['get', 'post'],'/get_medicines', [PharmacyController::class, 'getMedicines']);
    Route::get('/get_medicine_code', [PharmacyController::class, 'getMedicineCode']);
    
    ////Category for Medicine
    Route::post('/store-category-medicine', [PharmacyController::class, 'categoryStoreMedicine']);
    Route::post('/update-category-medicine', [PharmacyController::class, 'categoryUpdateMedicine']);
    Route::post('/delete-category-medicine', [PharmacyController::class, 'categoryDeleteMedicine']);
    Route::match(['get', 'post'],'/get_categories_medicine', [PharmacyController::class, 'getCategoriesMedicine']);
    
    ////Unit for Medicine
    Route::post('/store-unit-medicine', [PharmacyController::class, 'unitStoreMedicine']);
    Route::post('/update-unit-medicine', [PharmacyController::class, 'unitUpdateMedicine']);
    Route::post('/delete-unit-medicine', [PharmacyController::class, 'unitDeleteMedicine']);
    Route::match(['get', 'post'],'/get_units_medicine', [PharmacyController::class, 'getUnitsMedicine']);
    
    /// Medicine Purchase
    Route::get('/purchase_medicine/{id}', [PharmacyController::class, 'purchaseOrderMedicineEdit']);
    Route::get('/purchase_medicine_invoice_print/{id}', [PharmacyController::class, 'purchaseMedicineInvoice']);
    Route::post('/store-purchase-medicine', [PharmacyController::class, 'purchaseMedicineStore']);
    Route::post('/update-purchase-medicine', [PharmacyController::class, 'purchaseMedicineUpdate']);
    Route::match(['get', 'post'],'/get_madicine_supplier_due', [PharmacyController::class, 'getMadicineSupplierDue']);
    Route::match(['get', 'post'],'/get_purchase_medicine', [PharmacyController::class, 'getPurchaseMedicine']);
    Route::match(['get', 'post'],'/get_purchase_medicine_details', [PharmacyController::class, 'getPurchaseMedicineDetails']);
    Route::post('/delete-purchase-medicine', [PharmacyController::class, 'purchaseMedicinetDelete']);
    Route::get('/check_purchase_medicine_return/{id}', [PharmacyController::class, 'checkPurchaseMedicineReturn']);
    
    /// Medicine Purhcase Return
    Route::get('/purchase_return_medicine/{id}', [PharmacyController::class, 'purchaseReturnMedicineEdit']);
    Route::match(['get', 'post'],'/get_purchase_return_madicine_details', [PharmacyController::class, 'getPurchaseReturnMedicineDetails']);
    Route::match(['get', 'post'],'/get_return_madicine_details', [PharmacyController::class, 'getReturnMedicineDetails']);
    Route::post('/store-purchase-return-medicine', [PharmacyController::class, 'purchaseReturnMedicineStore']);
    Route::post('/update-purchase-return-medicine', [PharmacyController::class, 'purchaseReturnMedicineUpdate']);
    Route::get('/purchase_return_medicine_invoice/{id}', [PharmacyController::class, 'purchaseReturnMedicineInvoice']);
    Route::post('/delete-purchase-return-medicine', [PharmacyController::class, 'purchaseReturnMedicinetDelete']);
    Route::match(['get', 'post'],'/get_purchase_return_medicine', [PharmacyController::class, 'getPurchaseReturnMedicine']);
    
    /// Medicine Sale
    Route::get('/sale_medicine/{id}', [PharmacyController::class, 'saleMedicineEdit']);
    Route::post('/store-sale-medicine', [PharmacyController::class, 'saleMedicineStore']);
    Route::post('/update-sale-medicine', [PharmacyController::class, 'saleMedicineUpdate']);
    Route::post('/delete-sale-medicine', [PharmacyController::class, 'saleMedicineDelete']);
    Route::get('/sale_medicine_invoice_print/{id}', [PharmacyController::class, 'saleMedicineInvoice']);
    Route::match(['get', 'post'],'/get_sale_medicine', [PharmacyController::class, 'getSaleMedicine']);
    Route::match(['get', 'post'],'/get_sale_medicine_details', [PharmacyController::class, 'getSaleMedicineDetails']);
    Route::match(['get', 'post'],'/get_madicine_patient_due', [PharmacyController::class, 'getMadicinePatientDue']);
    
    ////// Medicine Sale Return
    Route::get('/sale_return_medicine/{id}', [PharmacyController::class, 'saleReturnMedicineEdit']);
    Route::post('/store-sale-return-medicine', [PharmacyController::class, 'saleReturnMedicineStore']);
    Route::post('/update-sale-return-medicine', [PharmacyController::class, 'saleReturnMedicineUpdate']);
    Route::post('/delete-sale-return-medicine', [PharmacyController::class, 'saleReturnMedicinetDelete']);
    Route::get('/sale_return_medicine_invoice/{id}', [PharmacyController::class, 'saleReturnMedicineInvoice']);
    Route::match(['get', 'post'],'/get_sale_return_medicine', [PharmacyController::class, 'getSaleReturnMedicine']);
    Route::match(['get', 'post'],'/get_sale_return_madicine_details', [PharmacyController::class, 'getSaleReturnMedicineDetails']);
    Route::match(['get', 'post'],'/get_sale_return_madicine_record_details', [PharmacyController::class, 'getSaleReturnMedicineRecordDetails']);
    
    /// Medicine Stock
    Route::match(['get', 'post'],'/get_current_stock_medicine', [PharmacyController::class, 'getCurrentStockMedicine']);
    Route::match(['get', 'post'],'/get_total_stock_medicine', [PharmacyController::class, 'getTotalStockMedicine']);

    ////Category for Inventory
    Route::post('/store-category-inventory', [InventroyController::class, 'categoryStoreInventory']);
    Route::post('/update-category-inventory', [InventroyController::class, 'categoryUpdateInventory']);
    Route::post('/delete-category-inventory', [InventroyController::class, 'categoryDeleteInventory']);
    Route::match(['get', 'post'],'/get_categories_inventory', [InventroyController::class, 'getCategoriesInventory']);

    ////Unit for Inventory
    Route::post('/store-unit-inventory', [InventroyController::class, 'unitStoreInventory']);
    Route::post('/update-unit-inventory', [InventroyController::class, 'unitUpdateInventory']);
    Route::post('/delete-unit-inventory', [InventroyController::class, 'unitDeleteInventory']);
    Route::match(['get', 'post'],'/get_units_inventory', [InventroyController::class, 'getUnitsInventory']);

    ////Instrument Inventory
    Route::post('/store-instrument', [InventroyController::class, 'instrumentStore']);
    Route::post('/update-instrument', [InventroyController::class, 'instrumentUpdate']);
    Route::post('/delete-instrument', [InventroyController::class, 'instrumentDelete']);
    Route::match(['get', 'post'],'/get_instruments', [InventroyController::class, 'getInstruments']);
    Route::get('/get_instrument_code', [InventroyController::class, 'getInstrumentCode']);

    ////Instrument inventory purchase order inventory
    Route::get('/get_purchase_order_inventory_code', [InventroyController::class, 'getPurchaseOrderInventoryCode']);
    Route::post('/store-purchase-inventory', [InventroyController::class, 'purchaseInventoryStore']);
    Route::post('/update-purchaseinventory', [InventroyController::class, 'purchaseInventoryUpdate']);
    Route::post('/delete-purchaseinventory', [InventroyController::class, 'purchaseInventorytDelete']);
    Route::match(['get', 'post'],'/get_instrument_stock', [InventroyController::class, 'getInstrumentStock']);
    Route::match(['get', 'post'],'/get_purchase_inventory', [InventroyController::class, 'getPurchaseOrderInventory']);
    Route::match(['get', 'post'],'/get_purchase_inventory_details', [InventroyController::class, 'getPurchaseInventoryDetails']);
    Route::get('/purchase_inventory/{id}', [InventroyController::class, 'purchaseOrderInventoryEdit']);
    Route::get('/purchase_invoice_print/{id}', [InventroyController::class, 'purchaseOrderInventoryInvoice']);
    Route::get('/check_purchase_inventroy_return/{id}', [InventroyController::class, 'checkPurchaseInventroyReturn']);
    
    /// Instrument inventory purchase Return
    Route::get('/purchase_return_inventory/{id}', [InventroyController::class, 'purchaseReturnInventoryEdit']);
    Route::match(['get', 'post'],'/get_purchase_return_inventory', [InventroyController::class, 'getPurchaseReturnInventory']);
    Route::match(['get', 'post'],'/get_purchase_return_inventory_details', [InventroyController::class, 'getPurchaseReturnInventoryDetails']);
    Route::post('/purchase_return_inventory_store', [InventroyController::class, 'purchaseReturnInventoryStore']);
    Route::post('/purchase_return_inventory_update', [InventroyController::class, 'purchaseReturnInventoryUpdate']);
    Route::post('/purchase-return-inventory-delete', [InventroyController::class, 'purchaseReturnInventoryDelete']);
    // Route::get('/purchase_return_inventory_invoice/{id}', [InventroyController::class, 'purchaseReturnInventoryInvoice']);
    Route::get('/purchase_inventory_returns_records', [InventroyController::class, 'purchaseReturnInventoryRecords']);

    //////Issue for Inventory
    Route::post('/store-issue-inventory', [InventroyController::class, 'issueInventoryStore']);
    Route::post('/update-issue-inventory', [InventroyController::class, 'issueInventoryUpdate']);
    Route::match(['get', 'post'],'/get_issue_inventory', [InventroyController::class, 'getIssueInventory']);
    Route::match(['get', 'post'],'/get_issue_inventory_details', [InventroyController::class, 'getIssueInventoryDetails']);
    Route::post('/delete-issue-inventory', [InventroyController::class, 'issueInventorytDelete']);
    Route::get('/check_issue_inventroy_return/{id}', [InventroyController::class, 'checkIssueInventroyReturn']);
    Route::get('/issue_inventory/{id}', [InventroyController::class, 'issueOrderInventoryEdit']);
    Route::get('/issue_invoice_print/{id}', [InventroyController::class, 'issueInventoryInvoice']);
    
    /////srock
    Route::match(['get', 'post'],'/get_current_stock_inventory', [InventroyController::class, 'getCurrentStockInventory']);
    Route::match(['get', 'post'],'/get_total_stock_inventory', [InventroyController::class, 'getTotalStockInventory']);
    
    ////Damage for Inventory
    Route::match(['get', 'post'],'/get_damages_inventory', [InventroyController::class, 'getDamageInventory']);
    Route::post('/store-damage-inventory', [InventroyController::class, 'damageInventorytStore']);
    Route::post('/update-damage-inventory', [InventroyController::class, 'damageInventorytUpdate']);
    Route::post('/delete-damage-inventory', [InventroyController::class, 'dagameInventorytDelete']);

    ////Supplier for Inventory
    Route::post('/store-supplierinventory', [InventroyController::class, 'supplierInventoryStore']);
    Route::post('/delete-supplierinventory', [InventroyController::class, 'supplierInventoryDelete']);
    Route::match(['get', 'post'],'/get_supplierinventorys', [InventroyController::class, 'getsupplierInventorys']);
    Route::get('/get_supplier_inventory_code', [InventroyController::class, 'getSupplierInventoryCode']);
    
    ////Supplier for Pharmacy
    Route::post('/store-supplierpharmacy', [PharmacyController::class, 'supplierPharmacyStore']);
    Route::post('/update-supplierpharmacy', [PharmacyController::class, 'supplierPharmacyUpdate']);
    Route::post('/delete-supplierpharmacy', [PharmacyController::class, 'supplierPharmacyDelete']);
    Route::match(['get', 'post'],'/get_supplierpharmacys', [PharmacyController::class, 'getsupplierPharmacys']);
    Route::get('/get_supplier_pharmacy_code', [PharmacyController::class, 'getSupplierPharmacyCode']);
    Route::match(['get', 'post'],'/get_medicine_stock', [PharmacyController::class, 'getMedicineStock']);
    
    Route::match(['get', 'post'],'/get_damages_medicine', [PharmacyController::class, 'getDamageMedicine']);
    Route::post('/store-damage-medicine', [PharmacyController::class, 'damageMedicineStore']);
    Route::post('/update-damage-medicine', [PharmacyController::class, 'damageMedicineUpdate']);
    Route::post('/delete-damage-medicine', [PharmacyController::class, 'damageMedicineDelete']);

    ///////HR PayRoll Module
    ////Designation
    Route::post('/store-designation', [HrPayrollController::class, 'designationStore']);
    Route::post('/update-designation', [HrPayrollController::class, 'designationUpdate']);
    Route::post('/delete-designation', [HrPayrollController::class, 'designationDelete']);
    Route::match(['get', 'post'],'/get_designations', [HrPayrollController::class, 'getDesignations']);
    
    ////Department
    Route::post('/store-department', [HrPayrollController::class, 'departmentStore']);
    Route::post('/update-department', [HrPayrollController::class, 'departmentUpdate']);
    Route::post('/delete-department', [HrPayrollController::class, 'departmentDelete']);
    Route::match(['get', 'post'],'/get_departments', [HrPayrollController::class, 'getDepartments']);

    ////Month
    Route::post('/store-month', [HrPayrollController::class, 'monthStore']);
    Route::post('/update-month', [HrPayrollController::class, 'monthUpdate']);
    Route::post('/delete-month', [HrPayrollController::class, 'monthDelete']);
    Route::match(['get', 'post'], '/get_months', [HrPayrollController::class, 'getMonths']);

    ////Employee
    Route::post('/store-employee', [HrPayrollController::class, 'employeeStore']);
    Route::post('/update-employee', [HrPayrollController::class, 'employeeUpdate']);
    Route::post('/delete-employee', [HrPayrollController::class, 'employeeDelete']);
    Route::match(['get', 'post'],'/get_employees', [HrPayrollController::class, 'getEmployees']);
    Route::get('/get_employee_code', [HrPayrollController::class, 'getEmployeeCode']);
    
    /////salary_payment
    Route::post('/store-salary-payment', [HrPayrollController::class, 'salaryPaymentStore']);
    Route::post('/update-salary-payment', [HrPayrollController::class, 'salaryPaymentUpdate']);
    Route::post('/delete-salary-payment', [HrPayrollController::class, 'salaryPaymentDelete']);
    Route::match(['get', 'post'],'/get_salary_payment', [HrPayrollController::class, 'getSalaryPayment']);
    Route::match(['get', 'post'],'/get_salary_details', [HrPayrollController::class, 'getSalaryDetails']);
    Route::match(['get', 'post'],'/check_payment_month', [HrPayrollController::class, 'checkPaymentMonth']);

    /////Others Module
    //driver
    Route::post('/store-driver', [OthersController::class, 'driverStore']);
    Route::post('/update-driver', [OthersController::class, 'driverUpdate']);
    Route::post('/delete-driver', [OthersController::class, 'driverDelete']);
    Route::match(['get', 'post'],'/get_drivers', [OthersController::class, 'getDrivers']);
    Route::get('/get_driver_code', [OthersController::class, 'getDriverCode']);

    //ambulance
    Route::post('/store-ambulance', [OthersController::class, 'ambulanceStore']);
    Route::post('/update-ambulance', [OthersController::class, 'ambulanceUpdate']);
    Route::post('/delete-ambulance', [OthersController::class, 'ambulanceDelete']);
    Route::match(['get', 'post'],'/get_ambulances', [OthersController::class, 'getAmbulances']);
    Route::get('/get_ambulance_code', [OthersController::class, 'getAmbulanceCode']);
    
    //ambulance bill
    Route::post('/store-ambulance-bill', [OthersController::class, 'ambulanceBillStore']);
    Route::post('/update-ambulance-bill', [OthersController::class, 'ambulanceBillUpdate']);
    Route::post('/delete-ambulance-bill', [OthersController::class, 'ambulanceBillDelete']);
    Route::match(['get', 'post'],'/get_ambulancesbill', [OthersController::class, 'getAmbulancesbill']);
    Route::get('/ambulancebill_invoice_print/{id}', [OthersController::class, 'ambulanceBillInvoice']);
    ////OT Schedule
    Route::match(['get', 'post'],'/get_ot_room_status', [OthersController::class, 'getOtRoomStatus']);
    Route::post('/store-ot-schedule', [OthersController::class, 'otScheduleStore']);
    Route::post('/update-ot-schedule', [OthersController::class, 'otScheduleUpdate']);
    Route::post('/delete-ot-schedule', [OthersController::class, 'otScheduleDelete']);
    Route::match(['get', 'post'],'/get_ot_schedule', [OthersController::class, 'getOtSchedule']);
    Route::post('/pending-complete-schedule', [OthersController::class, 'pendingCompleteSchedule']);
    Route::get('/get_schedule_code', [OthersController::class, 'getScheduleCode']);
    //test
    Route::get('/get_test_code', [PathologyController::class, 'getTestCode']);
    Route::post('/store-test', [PathologyController::class, 'testStore']);
    Route::post('/update-test', [PathologyController::class, 'testUpdate']);
    Route::post('/delete-test', [PathologyController::class, 'testDelete']);
    Route::match(['get', 'post'],'/get_tests', [PathologyController::class, 'getTests']);

    //test receipt
    Route::post('/store-testreceipt', [PathologyController::class, 'testreceiptStore']);
    Route::post('/update-testreceipt', [PathologyController::class, 'testReceiptUpdate']);
    Route::post('/delete-test-receipt', [PathologyController::class, 'testReceiptDelete']);
    Route::post('/test-investigation', [PathologyController::class, 'testInvestigation']);
    Route::post('/test-receipt-complete-change', [PathologyController::class, 'testReceiptCompleteChange']);
    Route::post('/test-receipt-delivery-change', [PathologyController::class, 'testReceiptDeliveryChange']);
    Route::get('/test_receipt/{id}', [PathologyController::class, 'testReceiptEdit']);
    Route::get('/test_receipt_report_print/{id}', [PathologyController::class, 'testReceiptReportInvoice']);
    Route::get('/test_receipt_invoice_print/{id}', [PathologyController::class, 'testReceiptInvoice']);
    Route::match(['get', 'post'],'/get_test_receipt', [PathologyController::class, 'getTestReceipt']);
    Route::match(['get', 'post'],'/get_test_receipt_details', [PathologyController::class, 'getTestReceiptDetails']);

    ///Accounts Mudule
    /////transaction Accounts
    Route::post('/store-account', [AccountsController::class, 'accountStore']);
    Route::post('/update-account', [AccountsController::class, 'accountUpdate']);
    Route::post('/delete-account', [AccountsController::class, 'accountDelete']);
    Route::match(['get', 'post'],'/get_accounts', [AccountsController::class, 'getAccounts']);
    Route::get('/get_account_code', [AccountsController::class, 'getAccountCode']);

    /////transaction Bank Accounts
    Route::post('/store-bankaccount', [AccountsController::class, 'bankaccountStore']);
    Route::post('/update-bankaccount', [AccountsController::class, 'bankaccountUpdate']);
    Route::post('/delete-bankaccount', [AccountsController::class, 'bankaccountDelete']);
    Route::match(['get', 'post'],'/get_bankaccounts', [AccountsController::class, 'getBankAccounts']);

    /////transaction Bank Accounts
    Route::post('/store-banktransaction', [AccountsController::class, 'banktransactionStore']);
    Route::post('/update-banktransaction', [AccountsController::class, 'banktransactionUpdate']);
    Route::post('/delete-banktransaction', [AccountsController::class, 'banktransactionDelete']);
    Route::match(['get', 'post'],'/get_banktransactions', [AccountsController::class, 'getBankTransactions']);
    Route::get('/get_bank_transaction_code', [AccountsController::class, 'getBankTransactionCode']);

    /////transaction Cash Accounts
    Route::post('/store-cashtransaction', [AccountsController::class, 'cashtransactionStore']);
    Route::post('/update-cashtransaction', [AccountsController::class, 'cashtransactionUpdate']);
    Route::post('/delete-cashtransaction', [AccountsController::class, 'cashtransactionDelete']);
    Route::match(['get', 'post'],'/get_cashtransactions', [AccountsController::class, 'getCashTransactions']);
    Route::match(['get', 'post'],'/get_banktransactionreports', [AccountsController::class, 'getBankTransactionsReport']);
    Route::get('/get_cash_transaction_code', [AccountsController::class, 'getCashTransactionCode']);
    
    Route::match(['get', 'post'],'/get_banktransactionreports', [AccountsController::class, 'getBankTransactionsReport']);
    Route::match(['get', 'post'],'/get_cash_ledger', [AccountsController::class, 'getCashLedgerReport']);
    Route::match(['get', 'post'],'/get_bank_ledger', [AccountsController::class, 'getBankLedgerReport']);
    Route::match(['get', 'post'],'/get_cash_view', [AccountsController::class, 'getCashViewReport']);
    /////Suppliers payment Inventory Accounts
    Route::post('/store-supplierpayment', [InventroyController::class, 'supplierPaymentInventoryStore']);
    Route::post('/update-supplierpayment', [InventroyController::class, 'supplierPaymentInventoryUpdate']);
    Route::post('/delete-supplierpayment', [InventroyController::class, 'supplierPaymentDeleteInventory']);
    Route::match(['get', 'post'],'/get_supplierpaymentinventorys', [InventroyController::class, 'getSupplierPaymentInventory']);
    Route::get('/get_supplier_payment_inventory_code', [InventroyController::class, 'getSupplierPaymentInventoryCode']);
    Route::match(['get', 'post'],'/get_supplier_due', [InventroyController::class, 'getSupplierDue']);
   
    /////Suppliers payment Medicine Accounts
    Route::post('/store-supplierpayment-medicine', [PharmacyController::class, 'supplierPaymentMedicineStore']);
    Route::post('/update-supplierpayment-medicine', [PharmacyController::class, 'supplierPaymentMedicineUpdate']);
    Route::post('/delete-supplierpayment-medicine', [PharmacyController::class, 'supplierPaymentDeleteMedicine']);
    Route::match(['get', 'post'],'/get_supplierpaymentsmedicine', [PharmacyController::class, 'getSupplierPaymentMedicine']);
    Route::get('/get_supplier_payment_medicine_code', [PharmacyController::class, 'getSupplierPaymentMedicineCode']);

});
