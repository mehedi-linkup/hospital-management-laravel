@php 
 $role = auth()->user()->role;
 $permissions = auth()->user()->permissions;
 $module = session()->has('module') ? session('module') : '';
 $branch_id = session()->has('branch_id') ? session('branch_id') : auth()->user()->branch_id;
 $all_access_role = ['Super Admin', 'Admin'];
@endphp

@if($module == 'Dashboard' || $module == '')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'FrontDesk')}}">
            <i class="menu-icon fa fa-hospital-o"></i>
            <span class="menu-text"> Front Desk</span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'Doctor')}}">
            <i class="menu-icon fa fa-user-md"></i>
            <span class="menu-text"> Doctor Module </span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'Pathology')}}">
            <i class="menu-icon fa fa-stethoscope"></i>
            <span class="menu-text"> Pathology Module </span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'Inventory')}}">
            <i class="menu-icon fa fa-cubes"></i>
            <span class="menu-text"> Inventory Module </span>
        </a>
    </li>
    
    <li>
        <a href="{{route('module', 'Accounts')}}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Accounts Module </span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'HRPayroll')}}">
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text"> HR & Payroll </span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'Pharmacy')}}">
            <i class="menu-icon fa fa-medkit"></i>
            <span class="menu-text"> Pharmacy Module </span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'Reports')}}">
            <i class="menu-icon fa fa-calendar-check-o"></i>
            <span class="menu-text"> Reports Module </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Others')}}">
            <i class="menu-icon fa fa-snowflake-o"></i>
            <span class="menu-text"> Others Module </span>
        </a>
    </li>

    <li>
        <a href="{{route('module', 'Administration')}}">
            <i class="menu-icon fa fa-cogs"></i>
            <span class="menu-text"> Administration </span>
        </a>
    </li>
    
    <li>
        <a href="#">
            <i class="menu-icon fa fa-bar-chart"></i>
            <span class="menu-text"> Business Monitor </span>
        </a>
    </li>
</ul>
@elseif($module == 'FrontDesk')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'FrontDesk')}}" class="module_title">
            <span> Front Desk </span>
        </a>
    </li>
    @if (array_search("outdoor_patient", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('outdoor_patient')}}">
            <i class="menu-icon fa fa-user-circle-o"></i>
            <span class="menu-text"> Outdoor Patient </span>
        </a>
    </li>
    @endif
    @if (array_search("patient_admission", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('patient_admission')}}">
            <i class="menu-icon fa fa-user-circle-o"></i>
            <span class="menu-text"> Patient Admission</span>
        </a>
    </li>
    @endif
    @if (array_search("patient_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('patient_entry')}}">
            <i class="menu-icon fa fa-user-plus"></i>
            <span class="menu-text"> Patient Entry</span>
        </a>
    </li>
    @endif
    @if (array_search("patient_list", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('patient_list')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Patient List</span>
        </a>
    </li>
    @endif
    @if (array_search("bill_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('bill_entry')}}">
            <i class="menu-icon fa fa-file-text-o"></i>
            <span class="menu-text"> Bill Entry</span>
        </a>
    </li>
    @endif
    @if (array_search("seat_shift", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('seat_shift')}}">
            <i class="menu-icon fa fa-exchange"></i>
            <span class="menu-text"> Seat Shift</span>
        </a>
    </li>
    @endif
    @if (array_search("seat_status", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('seat_status')}}">
            <i class="menu-icon fa fa-list-alt"></i>
            <span class="menu-text"> Seat Status</span>
        </a>
    </li>
    @endif
    @if (
        array_search("slip_bill_search", $permissions) > -1
        || array_search("slip_bill_payment_search", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Patient Release </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("slip_bill_search", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('slip_bill_search')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Release Slip Search
                    </a>
                </li>
            @endif
            @if (array_search("slip_bill_payment_search", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('slip_bill_payment_search')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Release Slip Payment
                    </a>
                </li>
            @endif
            @if (array_search("release_slip_record", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('release_slip_record')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Release Slip Record
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    @if (
        array_search("billtype_entry", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Settings </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("billtype_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('billtype_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Bill Type Entry
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    @if (
        array_search("appointment_report", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Reports </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("appointment_report", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('appointment_report')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Appointment Report
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'Doctor')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Doctor')}}" class="module_title">
            <span> Doctor Module </span>
        </a>
    </li>
    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="{{route('prescription')}}">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Prescription Entry</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="{{route('prescription_record')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Prescription Record</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="{{route('dose_entry')}}">
            <i class="menu-icon fa fa-check-circle-o"></i>
            <span class="menu-text"> Dose Entry</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="{{route('duration_entry')}}">
            <i class="menu-icon fa fa-clock-o"></i>
            <span class="menu-text"> Duration Entry</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="{{route('cheif_complain_entry')}}">
            <i class="menu-icon fa fa-creative-commons"></i>
            <span class="menu-text"> Cheif Complains</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="{{route('advice_entry')}}">
            <i class="menu-icon fa fa-adn"></i>
            <span class="menu-text">Advice Entry</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="{{route('doctor_appointment_list')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text">Appointment List</span>
        </a>
    </li>
    @endif

    @if (auth()->user()->role == 'Doctor')
    <li>
        <a href="#">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Prescription List</span>
        </a>
    </li>
    @endif
    @if (array_search("doctor_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('doctor_entry')}}">
            <i class="menu-icon fa fa-user-md"></i>
            <span class="menu-text"> Doctor Entry </span>
        </a>
    </li>
    @endif
    @if (
        array_search("", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Reports </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="#">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Report
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'Pathology')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Pathology')}}" class="module_title">
            <span> Pathology Module </span>
        </a>
    </li>
    @if (array_search("test_receipt", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('test_receipt')}}">
            <i class="menu-icon fa fa-cubes"></i>
            <span class="menu-text">Test Receipt</span>
        </a>
    </li>
    @endif
    @if (array_search("test_receipt_record", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('test_receipt_record')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Test Receipt Record</span>
        </a>
    </li>
    @endif
    @if (array_search("test_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('test_entry')}}">
            <i class="menu-icon fa fa-stethoscope"></i>
            <span class="menu-text"> Test Entry </span>
        </a>
    </li>
    @endif
    @if (
        array_search("", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Reports </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="#">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Report
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'Inventory')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Inventory')}}" class="module_title">
            <span> Inventory Module </span>
        </a>
    </li>
    @if (array_search("issue_inventory", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('issue_inventory')}}">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Issue Entry </span>
        </a>
    </li>
    @endif
    @if (array_search("issue_inventory_record", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('issue_inventory_record')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Issue Record</span>
        </a>
    </li>
    @endif
    @if (array_search("issue_inventory_record", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('issue_invoice_search')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Issue Invoice </span>
        </a>
    </li>
    @endif
    @if (array_search("purchase_inventory", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('purchase_inventory')}}">
            <i class="menu-icon fa fa-shopping-cart"></i>
            <span class="menu-text"> Purchase Entry </span>
        </a>
    </li>
    @endif
    @if (array_search("purchase_inventory_record", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('purchase_inventory_record')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Purchase Record</span>
        </a>
    </li>
    @endif
    @if (array_search("purchase_invoice_search", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('purchase_invoice_search')}}">
            <i class="menu-icon fa fa-search"></i>
            <span class="menu-text"> Purchase Invoice</span>
        </a>
    </li>
    @endif
    @if (array_search("purchase_return_inventory", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('purchase_return_inventory')}}">
            <i class="menu-icon fa fa-rotate-right"></i>
            <span class="menu-text"> Purchase Returns</span>
        </a>
    </li>
    @endif
    @if (array_search("purchase_return_inventory_record", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('purchase_return_inventory_record')}}">
            <i class="menu-icon fa fa-history"></i>
            <span class="menu-text"> Pur. Return Record</span>
        </a>
    </li>
    @endif
    @if (
        array_search("damage_inventory", $permissions) > -1
        || array_search("", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Damage Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("damage_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a  href="{{route('damage_inventory')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Damage Entry
                    </a>
                </li>
            @endif
            @if (array_search("damage_inventory_list", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('damage_inventory_list')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Damage List
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    @if (array_search("supplier_payment_inventory", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('supplier_payment_inventory')}}" style="font-size: 10px;">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Supplier Due Collection </span>
        </a>
    </li>
    @endif
    @if (array_search("supplier_due_list", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('supplier_due_list')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Due List</span>
        </a>
    </li>
    @endif
    @if (array_search("instrument_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('instrument_entry')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Instrument Entry</span>
        </a>
    </li>
    @endif
    @if (array_search("current_stock_inventory", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('current_stock_inventory')}}">
            <i class="menu-icon fa fa-cubes"></i>
            <span class="menu-text"> Stock Report</span>
        </a>
    </li>
    @endif
    @if (
        array_search("category_entry_inventory", $permissions) > -1
        || array_search("unit_entry_inventory", $permissions) > -1
        || array_search("supplier_inventory_entry", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-cog"></i>
            <span class="menu-text"> Settings </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        
        <ul class="submenu">
            @if (array_search("supplier_inventory_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('supplier_inventory_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Supplier Inventory Entry
                    </a>
                </li>
            @endif
        </ul>
        <ul class="submenu">
            @if (array_search("category_entry_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('category_entry_inventory')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Inventory Category
                    </a>
                </li>
            @endif
        </ul>
        <ul class="submenu">
            @if (array_search("unit_entry_inventory", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('unit_entry_inventory')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Inventory Unit
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    @if (
        array_search("", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Reports </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="#">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Report
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'Accounts')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Accounts')}}" class="module_title">
            <span> Accounts Module </span>
        </a>
    </li>
    @if (array_search("cash_transaction_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('cash_transaction_entry')}}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Cash Transection </span>
        </a>
    </li>
    @endif
    @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="#">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Commission Payment </span>
        </a>
    </li>
    @endif
    @if (array_search("bank_transaction_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('bank_transaction_entry')}}">
            <i class="menu-icon fa fa-bank"></i>
            <span class="menu-text"> Bank Transection</span>
        </a>
    </li>
    @endif
    @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="#">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Due Collection </span>
        </a>
    </li>
    @endif
  
    @if (array_search("cash_view_report", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('cash_view_report')}}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Cash View </span>
        </a>
    </li>
    @endif
    @if (
        array_search("bank_account_entry", $permissions) > -1
        || array_search("account_entry", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Account Head </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("account_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('account_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Transaction Accounts
                    </a>
                </li>
            @endif
            @if (array_search("bank_account_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('bank_account_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Bank Accounts
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    @if (
        array_search("cash_transaction_report", $permissions) > -1
        || array_search("bank_transaction_report", $permissions) > -1
        || array_search("cash_ledger_report", $permissions) > -1
        || array_search("bank_ledger_report", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Reports </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("cash_transaction_report", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('cash_transaction_report')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Cash Transaction Report
                    </a>
                </li>
            @endif
            @if (array_search("bank_transaction_report", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('bank_transaction_report')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Bank Transaction Report
                    </a>
                </li>
            @endif
            @if (array_search("cash_ledger_report", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('cash_ledger_report')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Cash Ledger
                    </a>
                </li>
            @endif
            @if (array_search("bank_ledger_report", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('bank_ledger_report')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Bank Ledger
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'HRPayroll')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'HRPayroll')}}" class="module_title">
            <span>HR & Payroll</span>
        </a>
    </li>
    @if (array_search("salary_payment", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('salary_payment')}}">
            <i class="menu-icon fa fa-money"></i>
            <span class="menu-text"> Salary Payment </span>
        </a>
    </li>
    @endif
    @if (array_search("employee_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('employee_entry')}}">
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text"> Add Employee </span>
        </a>
    </li>
    @endif
    @if (array_search("designation_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('designation_entry')}}">
            <i class="menu-icon fa fa-binoculars"></i>
            <span class="menu-text"> Add Designation </span>
        </a>
    </li>
    @endif
    @if (array_search("department_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('department_entry')}}">
            <i class="menu-icon fa fa-plus-square"></i>
            <span class="menu-text"> Add Department </span>
        </a>
    </li>
    @endif
    @if (array_search("month_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('month_entry')}}">
            <i class="menu-icon fa fa-calendar"></i>
            <span class="menu-text"> Add Month </span>
        </a>
    </li>
    @endif

    @if (
        array_search("employee_list", $permissions) > -1
        || array_search("salary_payment_report", $permissions) > -1
        || array_search("employee_active_list", $permissions) > -1
        || array_search("employee_deactive_list", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Report </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <ul class="submenu">
            @if (array_search("employee_list", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('employee_list')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    All Employee List
                </a>
            </li>
            @endif
            @if (array_search("employee_active_list", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a  href="{{route('employee_active_list')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Active Employee List
                </a>
            </li>
            @endif
            @if (array_search("employee_deactive_list", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('employee_deactive_list')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Deactive Employee List
                </a>
            </li>
            @endif
            @if (array_search("salary_payment_report", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('salary_payment_report')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Salary Payment Report
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'Pharmacy')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Pharmacy')}}" class="module_title">
            <span>Pharmacy Module</span>
        </a>
    </li>

 
   
    
    @if (
        array_search("sale_medicine", $permissions) > -1
        || array_search("sale_medicine_record", $permissions) > -1
        || array_search("sale_medicine_invoice", $permissions) > -1
        || array_search("sale_return_medicine", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Sale Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("sale_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a  href="{{route('sale_medicine')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Sale Entry
                    </a>
                </li>
            @endif
            @if (array_search("sale_medicine_record", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('sale_medicine_record')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Sale Record
                    </a>
                </li>
            @endif
            @if (array_search("sale_medicine_invoice", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('sale_medicine_invoice')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Sale Invoice
                    </a>
                </li>
            @endif
            @if (array_search("sale_return_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('sale_return_medicine')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Sale Return Entry
                    </a>
                </li>
            @endif
            @if (array_search("sale_return_medicine_record", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('sale_return_medicine_record')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Sale Return Record
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    
    @if (
        array_search("purchase_medicine", $permissions) > -1
        || array_search("purchase_medicine_record", $permissions) > -1
        || array_search("purchase_medicine_invoice", $permissions) > -1
        || array_search("purchase_return_medicine", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Purchase Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("purchase_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a  href="{{route('purchase_medicine')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Purchase Entry
                    </a>
                </li>
            @endif
            
            @if (array_search("purchase_medicine_record", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a  href="{{route('purchase_medicine_record')}}" >
                        <i class="menu-icon fa fa-caret-right"></i>
                        Purchase Record
                    </a>
                </li>
            @endif
            @if (array_search("purchase_medicine_invoice", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('purchase_medicine_invoice')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Purchase Invoice
                    </a>
                </li>
            @endif
            @if (array_search("purchase_return_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a  href="{{route('purchase_return_medicine')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Purchase Return Entry
                    </a>
                </li>
            @endif
            @if (array_search("purchase_return_medicine_record", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a  href="{{route('purchase_return_medicine_record')}}" >
                        <i class="menu-icon fa fa-caret-right"></i>
                        Purchase Return Record
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    @if (
        array_search("damage_medicine", $permissions) > -1
        || array_search("", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file"></i>
            <span class="menu-text"> Damage Info </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("damage_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a  href="{{route('damage_medicine')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Damage Entry
                    </a>
                </li>
            @endif
            @if (array_search("damage_medicine_list", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('damage_medicine_list')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Damage List
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
    @if (array_search("supplier_payment_medicine", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('supplier_payment_medicine')}}" style="font-size: 10px;">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Supplier Due Collection </span>
        </a>
    </li>
    @endif
    @if (array_search("medicine_current_stock", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('medicine_current_stock')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> Stock </span>
        </a>
    </li>
    @endif
    @if (
        array_search("category_entry_medicine", $permissions) > -1
        || array_search("medicine_entry", $permissions) > -1
        || array_search("supplier_pharmacy_entry", $permissions) > -1
        || array_search("unit_entry_medicine", $permissions) > -1
        || array_search("brand_entry", $permissions) > -1
        || array_search("generic_entry", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-cog"></i>
            <span class="menu-text"> Settings </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            @if (array_search("medicine_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('medicine_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Medicine Entry
                    </a>
                </li>
            @endif
            @if (array_search("supplier_pharmacy_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('supplier_pharmacy_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Medicine Supplier Entry
                    </a>
                </li>
            @endif
            @if (array_search("category_entry_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('category_entry_medicine')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Medicine Category
                    </a>
                </li>
            @endif
            @if (array_search("unit_entry_medicine", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('unit_entry_medicine')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Medicine Unit
                    </a>
                </li>
            @endif
            @if (array_search("brand_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('brand_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Brand Entry
                    </a>
                </li>
            @endif
            @if (array_search("generic_entry", $permissions) > -1 || in_array($role, $all_access_role))
                <li>
                    <a href="{{route('generic_entry')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Generic Entry
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'Others')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Others')}}" class="module_title">
            <span>Others Module</span>
        </a>
    </li>
    @if (array_search("", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="#">
            <i class="menu-icon fa fa-usd"></i>
            <span class="menu-text"> ICU </span>
        </a>
    </li>
    @endif

    @if (
        array_search("ambulance_bill", $permissions) > -1
        || array_search("ambulance_entry", $permissions) > -1
        || array_search("driver_entry", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-ambulance"></i>
            <span class="menu-text">Ambulance </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <ul class="submenu">
            @if (array_search("ambulance_bill", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('ambulance_bill')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Ambulance Bill
                </a>
            </li>
            @endif
            @if (array_search("ambulance_entry", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('ambulance_entry')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Ambulance Entry
                </a>
            </li>
            @endif
            @if (array_search("driver_entry", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('driver_entry')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Driver Entry
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if (
        array_search("ot_schedule_entry", $permissions) > -1
        || array_search("ot_schedule_pending_list", $permissions) > -1
        || array_search("ot_schedule_complete_list", $permissions) > -1
        || in_array($role, $all_access_role)
    )
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-bed"></i>
            <span class="menu-text"> Operation Theater </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <ul class="submenu">
            @if (array_search("ot_schedule_entry", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('ot_schedule_entry')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Schedule Entry
                </a>
            </li>
            @endif
            @if (array_search("ot_schedule_pending_list", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('ot_schedule_pending_list')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Pending Schedule
                </a>
            </li>
            @endif
            @if (array_search("ot_schedule_complete_list", $permissions) > -1 || in_array($role, $all_access_role))
            <li>
                <a href="{{route('ot_schedule_complete_list')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Complete Schedule
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
@elseif($module == 'Administration')
<ul class="nav nav-list">
    <li class="active">
        <a href="{{route('dashboard')}}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="{{route('module', 'Administration')}}" class="module_title">
            <span>Administration</span>
        </a>
    </li>
    @if (array_search("agent_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('agent_entry')}}">
            <i class="menu-icon fa fa-user"></i>
            <span class="menu-text"> Agent Entry </span>
        </a>
    </li>
    @endif
    @if (array_search("floor_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('floor_entry')}}">
            <i class="menu-icon fa fa-building-o"></i>
            <span class="menu-text"> Floor Entry </span>
        </a>
    </li>
    @endif
    @if (array_search("room_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('room_entry')}}">
            <i class="menu-icon fa fa-bank"></i>
            <span class="menu-text"> Room Entry </span>
        </a>
    </li>
    @endif
    @if (array_search("seat_entry", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('seat_entry')}}">
            <i class="menu-icon fa fa-bed"></i>
            <span class="menu-text"> Seat Entry </span>
        </a>
    </li>
    @endif
    @if (in_array($role, $all_access_role) && $branch_id == 1)
    <li>
        <a href="{{route('company_profile')}}">
            <i class="menu-icon fa fa-bank"></i>
            <span class="menu-text"> Company Profile </span>
        </a>
    </li>
    @endif
    @if (in_array($role, $all_access_role))
    <li>
        <a href="{{route('register')}}">
            <i class="menu-icon fa fa-user-plus"></i>
            <span class="menu-text"> Create User </span>
        </a>
    </li>
    @endif
    @if ($role == 'Super Admin' && $branch_id == 1)
    <li>
        <a href="{{route('user_activity')}}">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text"> User Activity </span>
        </a>
    </li>
    @endif
    @if (array_search("database_backup", $permissions) > -1 || in_array($role, $all_access_role))
    <li>
        <a href="{{route('database_backup')}}">
            <i class="menu-icon fa fa-database"></i>
            <span class="menu-text"> Database Backup </span>
        </a>
    </li>
    @endif
</ul>
@endif